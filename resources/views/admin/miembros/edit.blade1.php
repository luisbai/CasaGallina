@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-miembros-edit">
        <input type="hidden" id="miembro-id" value="{{ $miembro->id }}">
        <div class="col-md-7">
            <div class="card card-default">
                <div class="card-header">
                    <div class="float-left mt-1">Editar Miembro</div>
                    <div class="float-right">
                        <a href="/admin/miembros" class="btn btn-sm btn-secondary">Volver a miembros</a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="/admin/miembros/{{ $miembro->id }}" class="form-horizontal" method="POST" enctype="multipart/form-data" id="admin-miembros-edit-form">
                        @csrf
                        {{ method_field('PUT') }}
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" placeholder="Nombre del miembro" class="form-control" value="{{ $miembro->nombre }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input type="text" name="titulo" placeholder="Titulo del miembro" class="form-control" value="{{ $miembro->titulo }}">
                                </div>
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input type="text" name="titulo_en" placeholder="Titulo del miembro (EN)" class="form-control" value="{{ $miembro->titulo_en }}">
                                </div>
                                <div class="form-group">
                                    <label>Biografia</label>
                                    <div id="biografia"></div>
                                    <input type="hidden" name="biografia" id="biografia-input"  value="{{ $miembro->biografia }}">
                                </div>
                                <div class="form-group">
                                    <label>Biografia (EN)</label>
                                    <div id="biografia-en"></div>
                                    <input type="hidden" name="biografia_en" id="biografia-en-input"  value="{{ $miembro->biografia_en }}">
                                </div>
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select name="tipo" class="form-control" required>
                                        <option disabled selected>Seleccionar status</option>
                                        <option value="equipo" {{ ($miembro->tipo == 'equipo' ? 'selected' : '') }}>Equipo</option>
                                        <option value="presidente" {{ ($miembro->tipo == 'presidente' ? 'selected' : '') }}>Presidente</option>
                                        <option value="directivos" {{ ($miembro->tipo == 'directivos' ? 'selected' : '') }}>Mesa Directiva</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Actualizar Miembro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-estrategias">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Estrategia</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-estrategias">
                    <thead>
                        <tr>
                            <th>Titulo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pre_scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDidLQwu4nR98OYNftI9lx7phCzdQK9vKg&libraries=places"></script>
@endsection