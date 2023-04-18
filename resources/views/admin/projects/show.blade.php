@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="">
            <a class="btn btn-primary mt-3 mb-3" href="{{ route('admin.projects.index') }}"> Go Back</a>
            <div class="card card-body">
                <div class="d-flex">
                    <div>
                        <span class="badge rounded-pill type-pill mb-3"
                            style="background-color: {{ $project->type?->color }}">
                            {{ $project->type?->label }}
                        </span>
                        <h2>{{ $project->title }}</h2>
                        <p>{{ $project->text }}</p>
                    </div>
                    <div class="ms-5">
                        <img src="{{ $project->getImageUri() }}" alt="{{ $project->title }}">
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
