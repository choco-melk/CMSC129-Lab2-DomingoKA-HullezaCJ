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

        $projects = $query->get();

        return view('projects.index', compact('projects'));
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
            'collaborators'   => 'required|array|min:1',
            'collaborators.*' => 'in:Clyde,Jave,Keith,Neyro,Mark',
            'thumbnail'       => 'nullable|image|max:5120',
            'due_date'        => 'nullable|date',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('projects', 'public');
        }

        Project::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => implode(',', $data['collaborators']),
            'thumbnail'   => $thumbnailPath,
            'due_date'    => $data['due_date'] ?? null,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
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
            'collaborators'   => 'required|array|min:1',
            'collaborators.*' => 'in:Clyde,Jave,Keith,Neyro,Mark',
            'thumbnail'       => 'nullable|image|max:5120',
            'due_date'        => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $project->thumbnail = $request->file('thumbnail')->store('projects', 'public');
        }

        $project->update([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => implode(',', $data['collaborators']),
            'thumbnail'   => $project->thumbnail,
            'due_date'    => $data['due_date'] ?? null,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function confirmDelete(Project $project)
    {
        return view('projects.confirm_delete', compact('project'));
    }

    public function destroy(Project $project)
    {
        // Soft delete
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project moved to trash.');
    }

    public function trash()
    {
        $projects = Project::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('projects.trash', compact('projects'));
    }

    public function restore(Project $project)
    {
        $project->restore();
        return redirect()->route('projects.trash')->with('success', 'Project restored successfully.');
    }

    public function forceDelete(Project $project)
    {
        // permanently delete and clean up the file
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }
        $project->forceDelete();
        return redirect()->route('projects.trash')->with('success', 'Project permanently deleted.');
    }
}