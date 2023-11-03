@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-primary my-3">Torna alla lista Progetti</a>
        <h1>Modifica un Progetto</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <h4>Correggi i seguenti errori per proseguire:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data"
            class="mt-5">
            @method('PUT')
            @csrf

            {{-- TITOLO --}}
            <div class="col-12 mt-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" value="{{ old('title') ?? $project->title }}" />
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- TIPO --}}
            <div class="col-12 mt-3">
                <label for="type_id" class="form-label">Tipo</label>
                <select class="form-select" name="type_id" id="type_id">
                    <option value="">Nessun Tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->label }}</option>
                    @endforeach
                </select>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- TECNOLOGIE --}}
            <div class="col-12 mt-3">
                <div class="form-check @error('technologies') is-invalid @enderror">
                    @foreach ($technologies as $technology)
                        <div class="check-container">
                            <input type="checkbox" name="technologies[]" id="technologies-{{ $technology->id }}"
                                value="{{ $technology->id }}" class="form-check-control"
                                @if (in_array($technology->id, old('technologies', $technology_ids))) checked @endif>
                            <label for="technologies-{{ $technology->id }}">{{ $technology->label }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- URL --}}
            <div class="col-12 mt-3">
                <label for="url" class="form-label">Url Progetto</label>
                <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url"
                    value="{{ old('url') ?? $project->url }}" />
                @error('url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- IMMAGINE COVER --}}
            <div class="col-12 mt-3">
                <div class="row">
                    <div class="col-8">
                        <label for="cover_image" class="form-label">Immagine Cover</label>
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                            id="cover_image" name="cover_image" value="{{ old('cover_image') }}">
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4 position-relative">
                        @if ($project->cover_image)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <i class="fa-solid fa-trash"></i>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                        <img src="{{ asset('/storage/' . $project->cover_image) }}" class="img-fluid"
                            id="cover_image_preview" alt="">
                    </div>
                </div>

            </div>

            {{-- DESCRIZIONE --}}
            <div class="col-12 mt-3">
                <label for="content" class="form-label">Descrizione</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content') ?? $project->content }}"</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success my-3">Salva</button>
        </form>
    </div>

    @if ($project->cover_image)
        <form action="{{ route('admin.projects.delete-image', $project) }}" method="POST" id="delete-image-form">
            @method('DELETE')
            @csrf
        </form>
    @endif
@endsection

@section('scripts')
    <script type="text/javascript">
        const inputFileElement = document.getElementById('cover_image')
        const coverImagePreview = document.getElementById('cover_image_preview')

        if (!coverImagePreview.getAttribute('src') || coverImagePreview.getAttribute('src') ==
            "http://127.0.0.1:8000/storage") {
            coverImagePreview.src = "https://placehold.co/400"
        }

        inputFileElement.addEventListener('chaneg', function() {
            const [file] = this.files;
            coverImagePreview.src = URL.createObjectURL(file);
        })
    </script>

    @if ($project->cover_image)
        <script>
            const deleteImageButton = document.getElementById('delete-image-button')
            const deleteImageForm = document.getElementById('delete-image-form')
            deleteImageButton.addEventListener('click', function() {
                deleteImageForm.submit();
            })
        </script>
    @endif
@endsection
