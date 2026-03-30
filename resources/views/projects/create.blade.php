@extends('layouts.app')

@section('title', 'New Project')

@section('content')
    <div class="header">
        <h1>Create Project</h1>
        <a class="button secondary" href="{{ route('projects.index') }}">Back</a>
    </div>

    @include('projects.form', ['project' => new App\Models\Project(), 'collaborators' => $collaborators, 'actionRoute' => route('projects.store'), 'method' => 'POST'])
@endsection
