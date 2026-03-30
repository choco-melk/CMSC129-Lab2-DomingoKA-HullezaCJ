<div class="project">
    <h3>{{ $project->title }}</h3>
    <p>{{ $project->description }}</p>
    <p><strong>Assigned to:</strong> {{ $project->assigned_to }}</p>
    @if($project->due_date)
        <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($project->due_date)->format('M j, Y') }}</p>
    @endif
    @if($project->thumbnail)
        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Project image">
    @endif
    <div class="actions" style="margin-top:.5rem">
        <a class="button secondary" href="{{ route('projects.edit', $project) }}">Edit</a>
        <a class="button secondary" href="{{ route('projects.confirm-delete', $project) }}">Delete</a>
    </div>
</div>
