@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-espacios-edit">
        <div class="col-md-7">
            <div class="card card-default">
                <div class="card-header">
                    <div class="float-left mt-1">Nuevo Espacio</div>
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
                    <form action="/admin/espacios" class="form-horizontal" method="POST" enctype="multipart/form-data" id="admin-espacios-edit-form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" placeholder="Nombre del espacio de colaboración" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>URL</label>
                                    <input type="text" name="url" placeholder="URL del espacio de colaboración" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Categoría</label>
                                    <select name="status" class="form-control" required>
                                        <option disabled selected>Seleccionar categoría</option>
                                        <option value="activo">Aliado</option>
                                        <option value="finalizado">Iniciativas afines</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ubicación</label>
                                    <input type="text" name="ubicacion" id="ubicacion-input" placeholder="Dirección del lugar" class="form-control" autocomplete="new-password" required>
                                    <input type="hidden" name="ubicacion_lat" id="ubicacion-lat" required>
                                    <input type="hidden" name="ubicacion_long" id="ubicacion-long" required>
                                </div>
                                <div class="form-group">
                                    <label>Imagen Predeterminada</label>
                                    <input type="file" name="multimedia_id" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Crear Espacio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pre_scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGklE-iy0n4O0x8SxRtDy4Q_lr7Cx2WPA&libraries=places"></script>
@endsection