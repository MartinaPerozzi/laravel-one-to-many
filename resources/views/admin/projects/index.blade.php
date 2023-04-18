@extends('layouts.app')

@section('actions')
    <div class="container mt-4 mb-3">
        <a class="btn btn-primary" href="{{ route('admin.projects.create') }}"><i
                class="fa-solid fa-circle-plus  text-white me-2"></i>Create
            new Project</a>
        <a class="btn btn-primary" href="{{ route('admin.types.index') }}"><i
                class="fa-solid fa-diamond text-white me-2"></i>Types</a>
        <a class="btn btn-primary" href="{{ route('admin.projects.trash') }}"><i
                class="fa-solid fa-trash-can  text-white me-2"></i>Trashcan</a>

    </div>
@endsection
@section('content')
    <div class="container">
        <h1 class="mb-3">Projects</h1>
        <table class="table">
            <thead>
                <tr>
                    {{-- ID --}}
                    <th scope="col">
                        <a {{-- Operatore ternario per gestire SORT&ORDER --}}
                            href="{{ route('admin.projects.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Id</a>

                        @if ($sort == 'id')
                            {{-- se si sceglie di gestire a partire dall'id quindi sort=id appare la freccia e cambia rotazione se ascendente o discendente --}}
                            <a
                                href="{{ route('admin.projects.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                                <i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- TITLE --}}
                    <th scope="col"><a
                            href="{{ route('admin.projects.index') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Title</a>

                        @if ($sort == 'title')
                            <a
                                href="{{ route('admin.projects.index') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- TYPE --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.projects.index') }}?sort=type_id&order={{ $sort == 'type_id' && $order != 'desc' ? 'desc' : 'asc' }}">
                            Type
                            @if ($sort == 'type_id')
                                <i
                                    class="bi bi-caret-down-fill d-inline-block @if ($order == 'desc') rotate-180 @endif"></i>
                            @endif
                        </a>
                    </th>
                    {{-- TEXT --}}
                    <th scope="col"><a
                            href="{{ route('admin.projects.index') }}?sort=text&order={{ $sort == 'text' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Abstract</a>

                        @if ($sort == 'text')
                            <a
                                href="{{ route('admin.projects.index') }}?sort=text&order={{ $sort == 'text' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- CREATED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.projects.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Created</a>

                        @if ($sort == 'created_at')
                            <a
                                href="{{ route('admin.projects.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- UPDATED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.projects.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Updated</a>

                        @if ($sort == 'updated_at')
                            <a
                                href="{{ route('admin.projects.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>

                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->title }}</td>
                        <td>
                            <span class="badge rounded-pill" style="background-color: {{ $project->type?->color }}">
                                {{ $project->type?->label }}
                            </span>
                            {{-- @dump($project->type) --}}
                        </td>
                        <td>{{ $project->getAbstract() }}</td>
                        <td>{{ $project->created_at }}</td>
                        <td>{{ $project->getUpdatedAttribute() }}</td>
                        <td>
                            <a href="{{ route('admin.projects.show', $project) }}"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.projects.edit', $project) }}"><i class="fa-solid fa-pen ms-3"></i></a>
                            <a type="button" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $project->id }}">
                                <i class="fa-solid fa-trash-can ms-3 text-primary"></i>
                            </a>
                        </td>
                    </tr>

                @empty
                @endforelse

            </tbody>
        </table>
        {{-- PAGINATION --}}
        {{ $projects->links() }}
    </div>

    {{-- MODALE --}}
    @foreach ($projects as $project)
        <!-- Modal -->
        <div class="modal fade" id="delete-modal-{{ $project->id }}" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="delete-modal-{{ $project->id }}-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-modal-{{ $project->id }}-label">Conferma eliminazione</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        Sei sicuro di voler spostare nel cestino il progetto: <strong>{{ $project->title }}</strong> con ID
                        <strong> {{ $project->id }}</strong>? <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="">
                            @method('delete')
                            @csrf

                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
