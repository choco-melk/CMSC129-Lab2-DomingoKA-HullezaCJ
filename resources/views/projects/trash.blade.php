@extends('layouts.app')

@section('title', 'Trash')

@section('content')
    <div class="header">
        <h1>Trash</h1>
        <a class="button secondary" href="{{ route('projects.index') }}">← Back to Projects</a>
    </div>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if($projects->isEmpty())
        <p>Trash is empty.</p>
    @else
        <p style="color:#6b7280; margin-bottom:16px;">
            Items here are soft-deleted. Restore them or permanently delete them.
        </p>
    @endif

    @foreach($projects as $project)
        <div class="project" style="opacity:0.75; border-left: 4px solid #fca5a5;">

            <h3 style="margin:0 0 4px;">{{ $project->title }}</h3>
            <p style="margin:0 0 4px;">{{ $project->description }}</p>
            <p style="margin:0; font-size:0.85rem; color:#6b7280;">
                <strong>Deleted:</strong>
                {{ \Carbon\Carbon::parse($project->deleted_at)->format('M j, Y g:i A') }}
            </p>

            <div class="actions" style="margin-top:10px; display:flex; gap:8px;">

                {{-- Restore --}}
                <form action="{{ route('projects.restore', $project) }}" method="POST">
                    @csrf
                    <button type="submit" class="button">Restore</button>
                </form>

                {{-- Permanently delete --}}
                <form action="{{ route('projects.force-delete', $project) }}" method="POST"
                      onsubmit="return confirm('Permanently delete \'{{ addslashes($project->title) }}\'? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button secondary" style="border-color:#fca5a5; color:#b91c1c;">
                        Delete Forever
                    </button>
                </form>

            </div>
        </div>
    @endforeach
@endsection