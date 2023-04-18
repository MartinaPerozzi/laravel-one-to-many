@extends('layouts.app')

@section('content')
    <section class="container form-contain">

        <div class="">
            <h2 class="my-4">{{ $type->id ? 'Edit - ' . $type->label : 'Add a New Type' }}
            </h2>

            <a href="{{ route('admin.types.index') }}" class="btn btn-primary">
                Go To Type List
            </a>
        </div>

        <div class="my-5">
            <div class="body-form card p-3">

                @if ($type->id)
                    <form method="POST" action="{{ route('admin.types.update', $type) }}" enctype="multipart/form-data">
                        @method('put')
                    @else
                        <form method="POST" action="{{ route('admin.types.store') }}" enctype="multipart/form-data">
                @endif
                @csrf
                {{-- Name e validazione- rivedere sempre --}}
                <div class="input-container d-flex">
                    {{-- Left side --}}
                    <div class="d-flex flex-column">
                        {{-- title --}}
                        <div class="title-container">
                            <label for="label" class="form-label">
                                Label
                            </label>
                            <input type="text" name="label" id="label"
                                class="@error('label') is-invalid @enderror form-control"
                                value="{{ old('label', $type->label) }}">
                            @error('label')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Text --}}
                        <div class="text-container mt-1">
                            <label for="color" class="form-label">
                                Color
                            </label>
                            <input type="color" class="mt-4" id="color" name="color"
                                class="@error('color') is-invalid @enderror form-control"
                                value="{{ old('color', $type->color) }}">
                            @error('color')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <span>{{ $type->color }}</span>
                        </div>

                        {{-- Button --}}
                        <div class="align-self-end">
                            <button type="submit" class="btn btn-primary mt-4">
                                Salva
                            </button>
                        </div>
                    </div>

                </div>

                </form>

                <div id="color-type" class="preview-type" style="background_color:{{ $type->color }}">
                    <div id="type-prev"></div>
                </div>
            </div>

        </div>
    </section>
@endsection
