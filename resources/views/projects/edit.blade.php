@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="header">
        <h1>Edit Project</h1>
        <a class="button secondary" href="{{ route('projects.index') }}">Back</a>
    </div>

    @include('projects.form', ['project' => $project, 'collaborators' => $collaborators, 'actionRoute' => route('projects.update', $project), 'method' => 'PUT'])
@endsection
