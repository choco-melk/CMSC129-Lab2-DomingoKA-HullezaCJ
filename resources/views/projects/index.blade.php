@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="header">
        <h1>Project management</h1>
        <div style="display:flex; gap:8px;">
            <a class="button secondary" href="{{ route('projects.trash') }}">🗑 Trash</a>
            <a class="button" href="{{ route('projects.create') }}">New Project</a>
        </div>
    </div>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('projects.index') }}"
          style="margin-bottom:20px; display:flex; gap:8px; flex-wrap:wrap; align-items:center;">

        <input type="text" name="search"
               placeholder="Search title or description…"
               value="{{ request('search') }}"
               style="flex:1; min-width:180px;">

        <select name="status"
                style="border:1px solid #d1d5db; padding:10px; border-radius:4px;">
            <option value="">All statuses</option>
            @foreach($statusLabels as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <select name="assignee"
                style="border:1px solid #d1d5db; padding:10px; border-radius:4px;">
            <option value="">All assignees</option>
            @foreach($collaborators as $name)
                <option value="{{ $name }}" @selected(request('assignee') === $name)>
                    {{ $name }}
                </option>
            @endforeach
        </select>

        <select name="due"
                style="border:1px solid #d1d5db; padding:10px; border-radius:4px;">
            <option value="">Any due date</option>
            <option value="overdue"   @selected(request('due') === 'overdue')>Overdue</option>
            <option value="this_week" @selected(request('due') === 'this_week')>Due this week</option>
            <option value="no_date"   @selected(request('due') === 'no_date')>No due date</option>
        </select>

        <button type="submit" class="button">Search</button>

        @if(request('search') || request('status') || request('assignee') || request('due'))
            <a class="button secondary" href="{{ route('projects.index') }}">Clear</a>
        @endif
    </form>

    {{-- Results count --}}
    <p style="color:#6b7280; font-size:0.875rem; margin-bottom:12px;">
        Showing {{ $projects->firstItem() ?? 0 }}–{{ $projects->lastItem() ?? 0 }}
        of {{ $projects->total() }} project(s)
    </p>

    @if($projects->isEmpty())
        <p>No projects found.</p>
    @endif

    @foreach($projects as $project)
        @include('components.project-card', ['project' => $project, 'statusLabels' => $statusLabels])
    @endforeach

    {{-- Pagination links --}}
    <div style="margin-top:20px;">
        {{ $projects->links() }}
    </div>
@endsection
