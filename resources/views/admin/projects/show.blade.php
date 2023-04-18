@extends('layouts.app')


@section('content')
    <div class="container">
        <a class="btn btn-primary mt-3 mb-3" href="{{ route('admin.projects.index') }}"> Go Back</a>
        <h2>{{ $project->title }}</h2>
        <div>
            <p class="fw-semibold">
                {{ $project->type?->label }}
            </p>
        </div>
        <p>{{ $project->text }}</p>
        {{-- <img src="{{ $project->image }}" alt="Project Image"> --}}
        <div class="col-12">
            <img src="{{ $project->getImageUri() }}" alt="{{ $project->title }}">
        </div>
        {{-- @dump($project); --}}
    </div>
@endsection
