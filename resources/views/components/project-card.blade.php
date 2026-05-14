@php
    $badgeColors = [
        'active'      => 'background:#dcfce7; color:#166534;',
        'in_progress' => 'background:#dbeafe; color:#1e40af;',
        'completed'   => 'background:#f3f4f6; color:#374151;',
        'on_hold'     => 'background:#fef9c3; color:#854d0e;',
    ];
    $badge = $badgeColors[$project->status] ?? '';
    $label = $statusLabels[$project->status] ?? $project->status;
@endphp

<div class="project">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6px;">
        <h3 style="margin:0;">
            <a href="{{ route('projects.show', $project) }}"
               style="text-decoration:none; color:inherit;">
                {{ $project->title }}
            </a>
        </h3>
        <span style="display:inline-block; padding:2px 10px; border-radius:12px;
                     font-size:0.78rem; font-weight:600; white-space:nowrap; {{ $badge }}">
            {{ $label }}
        </span>
    </div>

    <p style="margin:0 0 6px;">{{ Str::limit($project->description, 120) }}</p>

    <p style="margin:0 0 4px;">
        <strong>Assigned to:</strong>
        {{ implode(', ', $project->assigned_to_array) ?: '—' }}
    </p>

    @if($project->due_date)
        <p style="margin:0 0 4px;">
            <strong>Due:</strong>
            {{ \Carbon\Carbon::parse($project->due_date)->format('M j, Y') }}
        </p>
    @endif

    @if($project->thumbnail)
        <img src="{{ asset('storage/' . $project->thumbnail) }}"
             alt="Project thumbnail"
             style="max-height:110px; max-width:170px; margin-top:8px; border:1px solid #d1d5db;">
    @endif

    <div class="actions" style="margin-top:10px;">
        <a class="button secondary" href="{{ route('projects.show', $project) }}">View</a>
        <a class="button secondary" href="{{ route('projects.edit', $project) }}">Edit</a>
        <a class="button secondary" href="{{ route('projects.confirm-delete', $project) }}"
           style="border-color:#fca5a5; color:#b91c1c;">Delete</a>
    </div>
</div>