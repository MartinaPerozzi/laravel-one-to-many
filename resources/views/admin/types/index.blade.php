@extends('layouts.app')

@section('actions')
    <div class="container mt-4 mb-3">
        <a class="btn btn-primary" href="{{ route('admin.types.create') }}">Create new Type</a>
        {{-- <a class="btn btn-primary" href="{{ route('admin.projects.trash') }}">Trashcan</a> --}}

    </div>
@endsection
@section('content')
    <div class="container">
        <h1 class="mb-3">Types</h1>
        <table class="table">
            <thead>
                <tr>
                    {{-- ID --}}
                    <th scope="col">
                        <a {{-- Operatore ternario per gestire SORT&ORDER --}}
                            href="{{ route('admin.types.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Id</a>

                        @if ($sort == 'id')
                            {{-- se si sceglie di gestire a partire dall'id quindi sort=id appare la freccia e cambia rotazione se ascendente o discendente --}}
                            <a
                                href="{{ route('admin.types.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                                <i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>

                    {{-- TYPE --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.types.index') }}?sort=id&order={{ $sort == 'type_id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Type</a>

                        @if ($sort == 'type_id')
                            {{-- se si sceglie di gestire a partire dall'id quindi sort=id appare la freccia e cambia rotazione se ascendente o discendente --}}
                            <a
                                href="{{ route('admin.types.index') }}?sort=type&order={{ $sort == 'type_id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                                <i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- TEXT --}}
                    <th scope="col"><a
                            href="{{ route('admin.types.index') }}?sort=color&order={{ $sort == 'color' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Color</a>

                        @if ($sort == 'color')
                            <a
                                href="{{ route('admin.types.index') }}?sort=text&order={{ $sort == 'color' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- CREATED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.types.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Created</a>

                        @if ($sort == 'created_at')
                            <a
                                href="{{ route('admin.types.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- UPDATED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.types.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Updated</a>

                        @if ($sort == 'updated_at')
                            <a
                                href="{{ route('admin.types.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>

                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($types as $type)
                    <tr>
                        <th scope="row">{{ $type->id }}</th>
                        <td>
                            <span class="badge rounded-pill" style="background-color: {{ $type?->color }}">
                                {{ $type?->label }}
                            </span>
                            {{-- @dump($project->type) --}}
                        </td>
                        <td>{{ $type->color }}</td>
                        <td>{{ $type->updated_at }}</td>

                        <td>{{ $type->created_at }}</td>

                        <td>
                            <a href="{{ route('admin.types.show', $type) }}"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.types.edit', $type) }}"><i class="fa-solid fa-pen ms-3"></i></a>
                            <a type="button" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $type->id }}">
                                <i class="fa-solid fa-trash-can ms-3 text-primary"></i>
                            </a>
                        </td>
                    </tr>

                @empty
                @endforelse

            </tbody>
        </table>
        {{-- PAGINATION --}}
        {{ $types->links() }}
    </div>

    {{-- MODALE --}}
    @foreach ($types as $type)
        <!-- Modal -->
        <div class="modal fade" id="delete-modal-{{ $type->id }}" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="delete-modal-{{ $type->id }}-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-modal-{{ $type->id }}-label">Conferma eliminazione</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        Sei sicuro di voler eliminare il tipo <strong>{{ $type->label }}</strong> con ID
                        <strong> {{ $type->id }}</strong>? <br>
                        L'operazione non è reversibile!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <form action="{{ route('admin.types.destroy', $type) }}" method="POST" class="">
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
