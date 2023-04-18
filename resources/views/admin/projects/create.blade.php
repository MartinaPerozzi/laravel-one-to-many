@extends('layouts.app')
{{-- TO DO --}}
@section('content')
    <section class="container form-contain">

        <div class="">
            <h2 class="my-4">{{ $project->id ? 'Edit - ' . $project->title : 'Add a New Project' }}
            </h2>

            <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">
                Go To List
            </a>
        </div>

        <div class="my-5">
            <div class="body-form card p-3">

                @if ($project->id)
                    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
                        @method('put')
                    @else
                        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
                @endif
                @csrf
                <div class="input-container d-flex">
                    {{-- Left side --}}
                    <div class="d-flex flex-column">

                        {{-- title --}}
                        <div class="title-container">
                            <label for="title" class="form-label">
                                Title
                            </label>
                            <input type="text" name="title" id="title"
                                class="@error('title') is-invalid @enderror form-control"
                                value="{{ old('title', $project->title) }}">
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Text --}}
                        <div class="text-container mt-1">
                            <label for="text" class="form-label">
                                Text
                            </label>
                            <textarea name="text" id="text" class="@error('description') is-invalid @enderror form-control">{{ old('text', $project->text) }}</textarea>
                            @error('text')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- Image --}}
                        <div class="image-container mt-1">
                            <div class="">
                                <label for="image" class="form-label">
                                    Image
                                </label>
                                <input type="file" name="image" id="image"
                                    class="@error('image') is-invalid @enderror form-control"
                                    value="{{ old('image', $project->image) }}">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- SELECT --}}
                        <div>
                            <div class="">
                                <label for="image" class="form-label">
                                    Type
                                </label>
                                <select name="type_id" id="type_id"
                                    class="form-select @error('type_id') is-invalid @enderror">
                                    @foreach ($types as $type)
                                        <option @if (old('type_id', $project->$type) == $type->id) selected @endif
                                            value="{{ $type->id }}">{{ $type->label }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- Button --}}
                        <div class="align-self-end">
                            <button type="submit" class="btn btn-primary mt-4">
                                Salva
                            </button>
                        </div>
                    </div>
                    {{-- Right Side Image Preview --}}
                    <div class="d-flex flex-column">
                        <div class="image-upload border p-2">
                            <img src="{{ $project->getImageUri() }}" alt="{{ $project->title }}" id="image_preview">
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const imageEl = document.getElementById('image');
        const imagePreviewEl = document.getElementById('image_preview');
        const imagePlaceholder = imagePreviewEl.src;
        imageEl.addEventListener(
            'change', () => {
                if (imageEl.files && imageEl.files[0]) {
                    const reader = new FileReader();
                    reader.readAsDataURL(imageEl.files[0]);
                    reader.onload = e => {
                        imagePreviewEl.src = e.target.result;
                    }
                } else {
                    imagePreviewEl.src = imagePlaceholder;
                }
            });
    </script>
@endsection
