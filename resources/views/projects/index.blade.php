@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="header">
        <h1>Project management</h1>
        <a class="button" href="{{ route('projects.create') }}">New Project</a>
    </div>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if($projects->isEmpty())
        <p>No projects yet.</p>
    @endif

    @foreach($projects as $project)
        @include('components.project-card', ['project' => $project])
    @endforeach
@endsection
