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
            'Mark',
        ];
    }

    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'collaborators' => 'required|array|min:1',
            'collaborators.*' => 'in:Clyde,Jave,Keith,Neyro,Mark',
            'thumbnail' => 'nullable|image|max:5120',
            'due_date' => 'nullable|date',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('projects', 'public');
        }

        Project::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => implode(',', $data['collaborators']),
            'thumbnail' => $thumbnailPath,
            'due_date' => $data['due_date'] ?? null,
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'collaborators' => 'required|array|min:1',
            'collaborators.*' => 'in:Clyde,Jave,Keith,Neyro,Mark',
            'thumbnail' => 'nullable|image|max:5120',
            'due_date' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $project->thumbnail = $request->file('thumbnail')->store('projects', 'public');
        }

        $project->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => implode(',', $data['collaborators']),
            'thumbnail' => $project->thumbnail,
            'due_date' => $data['due_date'] ?? null,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function confirmDelete(Project $project)
    {
        return view('projects.confirm_delete', compact('project'));
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
