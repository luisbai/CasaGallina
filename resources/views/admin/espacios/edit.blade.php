@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-espacios-edit">
        <input type="hidden" id="espacio-id" value="{{ $espacio->id }}">
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-header">
                    <div class="float-left mt-1">Editar Espacio</div>
                    <div class="float-right">
                        <a href="/admin/espacios" class="btn btn-sm btn-secondary">Volver a espacios</a>
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
                    <form action="/admin/espacios/{{ $espacio->id }}" class="form-horizontal" method="POST" enctype="multipart/form-data" id="admin-espacios-edit-form">
                        @csrf
                        {{ method_field('PUT') }}
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" placeholder="Nombre del espacio de colaboración" class="form-control" value="{{ $espacio->nombre }}" required>
                                </div>
                                <div class="form-group">
                                    <label>URL</label>
                                    <input type="text" name="url" placeholder="URL del espacio de colaboración" class="form-control" value="{{ $espacio->url }}">
                                </div>
                                <div class="form-group">
                                    <label>Categoría</label>
                                    <select name="status" class="form-control" required>
                                        <option disabled selected>Seleccionar categoría</option>
                                        <option value="activo" {{ ($espacio->status == 'activo' ? 'selected' : '') }}>Aliado</option>
                                        <option value="finalizado" {{ ($espacio->status == 'finalizado' ? 'selected' : '') }}>Iniciativas afines</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ubicación</label>
                                    <input type="text" name="ubicacion" id="ubicacion-input" placeholder="Dirección del lugar" class="form-control" autocomplete="new-password" value="{{ $espacio->ubicacion }}" required>
                                    <input type="hidden" name="ubicacion_lat" id="ubicacion-lat" value="{{ $espacio->ubicacion_lat }}" required>
                                    <input type="hidden" name="ubicacion_long" id="ubicacion-long" value="{{ $espacio->ubicacion_long }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Imagen Predeterminada</label>
                                    <input type="file" name="multimedia_id" class="form-control">
                                </div>
                                @isset ($espacio->multimedia)
                                    <div class="espacio-multimedia">
                                        <img src="/storage/cache/{{ $espacio->multimedia->filename }}" alt="">
                                    </div>
                                @endisset
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <label>Estrategias Asignadas</label>
                                        </div>
                                        <div class="col-md-5 text-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-estrategias">Agregar Estrategia</button>
                                        </div>
                                    </div>
                                </div>
                                @isset ($espacio->estrategias)
                                    <table class="table table-sm table-bordered table-espacios-estrategias w-100">
                                        <thead>
                                            <tr>
                                                <th width="80%">Nombre</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($espacio->estrategias as $estrategia)
                                                <tr>
                                                    <td width="80%">{{ $estrategia->titulo }}</td>
                                                    <td><button type="button" class="btn btn-sm btn-danger" data-action="eliminar-estrategia" data-estrategia-id="{{ $estrategia->id }}">Eliminar</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endisset
                            </div>
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Actualizar Espacio</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGklE-iy0n4O0x8SxRtDy4Q_lr7Cx2WPA&libraries=places"></script>
@endsection