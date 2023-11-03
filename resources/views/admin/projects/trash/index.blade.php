@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container mt-3">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary my-3"><i
                class="fa-solid fa-arrow-left"></i> Torna alla Lista</a>
        <h1>Lista Progetti Cestinati</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Tecnologie</th>
                    <th scope="col">Url</th>
                    <th scope="col">Deleted At</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->title }}</td>
                        <td>{!! $project->getTypeBadge() !!}</td>
                        <td>{!! $project->getTechnologyBadges() !!}</td>
                        <td>{{ $project->url }}</td>
                        <td>
                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                data-bs-target="#restore-modal-{{ $project->id }}"><i class="fa-solid fa-recycle"></i></a>
                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                data-bs-target="#delete-modal-{{ $project->id }}">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nessun Progetto nel database</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $projects->links('pagination::bootstrap-5') }}
@endsection

@section('modals')
    @foreach ($projects as $project)
        {{-- MODALE DELATE --}}
        <div class="modal fade" id="delete-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Elimina elemento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        Vuoi davvero eliminare <strong>definitivamente</strong> il progetto
                        "{{ $project->title }}"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <form action="{{ route('admin.projects.trash.force-destroy', $project) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODALE RESTORE --}}
        <div class="modal fade" id="restore-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ripristina elemento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        Vuoi davvero ripristinare il progetto
                        "{{ $project->title }}"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <form action="{{ route('admin.projects.trash.restore', $project) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <button class="btn btn-success">Ripristina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
