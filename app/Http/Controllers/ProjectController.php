<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    private function collaborators(): array
    {
        return [
            'Clyde', 
            'Jave', 
            'Keith', 
            'Neyro', 
            'Mark'
            ];
    }

    private function statusLabels(): array
    {
        return [
            'active'      => 'Active',
            'in_progress' => 'In Progress',
            'completed'   => 'Completed',
            'on_hold'     => 'On Hold',
        ];
    }

    public function index(Request $request)
    {
        $query = Project::orderBy('created_at', 'desc');

        // Search across title and description
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter by assigned collaborator
        if ($assignee = $request->input('assignee')) {
            $query->where('assigned_to', 'ilike', "%{$assignee}%");
        }

        // Filter by due date range
        if ($due = $request->input('due')) {
            $today = now()->toDateString();
            match ($due) {
                'overdue'   => $query->where('due_date', '<', $today)->whereNotNull('due_date'),
                'this_week' => $query->whereBetween('due_date', [$today, now()->addDays(7)->toDateString()]),
                'no_date'   => $query->whereNull('due_date'),
                default     => null,
            };
        }

        // Paginate — 10 per page, keeps search params in pagination links
        $projects = $query->paginate(10)->withQueryString();

        $collaborators  = $this->collaborators();
        $statusLabels   = $this->statusLabels();

        return view('projects.index', compact('projects', 'collaborators', 'statusLabels'));
    }

    public function create()
    {
        $collaborators = $this->collaborators();
        return view('projects.create', compact('collaborators'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'status'          => 'required|in:active,in_progress,completed,on_hold',
            'collaborators'   => 'required|array|min:1',
            'collaborators.*' => 'in:Clyde,Jave,Keith,Neyro,Mark',
            'thumbnail'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'due_date'        => 'nullable|date',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')
                                     ->store('projects', 'public');
        }

        Project::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
            'assigned_to' => implode(',', $data['collaborators']),
            'thumbnail'   => $thumbnailPath,
            'due_date'    => $data['due_date'] ?? null,
        ]);

        return redirect()->route('projects.index')
                         ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $statusLabels = $this->statusLabels();
        return view('projects.show', compact('project', 'statusLabels'));
    }

    public function edit(Project $project)
    {
        $collaborators = $this->collaborators();
        return view('projects.edit', compact('project', 'collaborators'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'status'          => 'required|in:active,in_progress,completed,on_hold',
            'collaborators'   => 'required|array|min:1',
            'collaborators.*' => 'in:Clyde,Jave,Keith,Neyro,Mark',
            'thumbnail'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'due_date'        => 'nullable|date',
        ]);

        // Handle thumbnail removal
        if ($request->boolean('remove_thumbnail') && $project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
            $project->thumbnail = null;
        }

        // Handle new thumbnail upload
        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $project->thumbnail = $request->file('thumbnail')
                                          ->store('projects', 'public');
        }

        $project->update([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
            'assigned_to' => implode(',', $data['collaborators']),
            'thumbnail'   => $project->thumbnail,
            'due_date'    => $data['due_date'] ?? null,
        ]);

        return redirect()->route('projects.index')
                         ->with('success', 'Project updated successfully.');
    }

    public function confirmDelete(Project $project)
    {
        return view('projects.confirm_delete', compact('project'));
    }

    public function destroy(Project $project)
    {
        $project->delete(); // soft delete only, keep the file
        return redirect()->route('projects.index')
                         ->with('success', 'Project moved to trash.');
    }

    public function trash()
    {
        $projects = Project::onlyTrashed()
                           ->orderBy('deleted_at', 'desc')
                           ->get();
        return view('projects.trash', compact('projects'));
    }

    public function restore(Project $project)
    {
        $project->restore();
        return redirect()->route('projects.trash')
                         ->with('success', 'Project restored successfully.');
    }

    public function forceDelete(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }
        $project->forceDelete();
        return redirect()->route('projects.trash')
                         ->with('success', 'Project permanently deleted.');
    }
}