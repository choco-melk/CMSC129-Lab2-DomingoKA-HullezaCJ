@extends('layouts.app')

@section('title', $project->title)

@section('content')
    <div class="header">
        <h1>{{ $project->title }}</h1>
        <a class="button secondary" href="{{ route('projects.index') }}">← Back</a>
    </div>

    <div class="project" style="margin-bottom:20px;">

        {{-- Status badge --}}
        @php
            $badgeColors = [
                'active'      => 'background:#dcfce7; color:#166534;',
                'in_progress' => 'background:#dbeafe; color:#1e40af;',
                'completed'   => 'background:#f3f4f6; color:#374151;',
                'on_hold'     => 'background:#fef9c3; color:#854d0e;',
            ];
            $badge = $badgeColors[$project->status] ?? '';
        @endphp

        <span style="display:inline-block; padding:2px 10px; border-radius:12px; font-size:0.8rem; font-weight:600; {{ $badge }}">
            {{ $statusLabels[$project->status] ?? $project->status }}
        </span>

        <p style="margin-top:12px;">{{ $project->description ?? '—' }}</p>

        <p>
            <strong>Assigned to:</strong>
            {{ implode(', ', $project->assigned_to_array) ?: '—' }}
        </p>

        <p>
            <strong>Due Date:</strong>
            {{ $project->due_date
                ? \Carbon\Carbon::parse($project->due_date)->format('M j, Y')
                : 'No due date' }}
        </p>

        <p>
            <strong>Created:</strong>
            {{ $project->created_at->format('M j, Y g:i A') }}
        </p>

        @if($project->thumbnail)
            <div style="margin-top:12px;">
                <strong>Thumbnail:</strong><br>
                <img src="{{ asset('storage/' . $project->thumbnail) }}"
                     alt="Project thumbnail"
                     style="max-width:300px; max-height:200px; margin-top:8px; border:1px solid #d1d5db; border-radius:4px;">
            </div>
        @endif

        <div class="actions" style="margin-top:16px;">
            <a class="button secondary" href="{{ route('projects.edit', $project) }}">Edit</a>
            <a class="button secondary" href="{{ route('projects.confirm-delete', $project) }}"
               style="border-color:#fca5a5; color:#b91c1c;">Delete</a>
        </div>
    </div>
@endsection