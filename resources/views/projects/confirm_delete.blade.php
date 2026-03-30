@extends('layouts.app')

@section('title', 'Confirm Delete')

@section('content')
    <div class="header">
        <h1>Confirm Delete</h1>
        <a class="button secondary" href="{{ route('projects.index') }}">Back</a>
    </div>

    <div class="message" style="background:#fff4f4; border-color:#fecaca; color:#b91c1c;">
        <p>Are you sure you want to delete the project <strong>{{ $project->title }}</strong>?</p>
        <p>This action cannot be undone.</p>
    </div>

    <form action="{{ route('projects.destroy', $project) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="button">Delete</button>
        <a class="button secondary" href="{{ route('projects.index') }}">Cancel</a>
    </form>
@endsection
