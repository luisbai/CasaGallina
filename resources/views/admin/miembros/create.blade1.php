@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-miembros-edit">
        <div class="col-md-7">
            <div class="card card-default">
                <div class="card-header">
                    <div class="float-left mt-1">Nuevo Miembro</div>
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
                    <form action="/admin/miembros" class="form-horizontal" method="POST" id="admin-miembros-edit-form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" placeholder="Nombre del miembro" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input type="text" name="titulo" placeholder="Titulo del miembro" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input type="text" name="titulo_en" placeholder="Titulo del miembro (EN)" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Biografia</label>
                                    <div id="biografia"></div>
                                    <input type="hidden" name="biografia" id="biografia-input">
                                </div>
                                <div class="form-group">
                                    <label>Biografia (EN)</label>
                                    <div id="biografia-en"></div>
                                    <input type="hidden" name="biografia_en" id="biografia-en-input">
                                </div>
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select name="tipo" class="form-control" required>
                                        <option disabled selected>Seleccionar status</option>
                                        <option value="equipo">Equipo</option>
                                        <option value="presidente">Presidente</option>
                                        <option value="directivos">Mesa Directiva</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Crear Miembro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pre_scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDidLQwu4nR98OYNftI9lx7phCzdQK9vKg&libraries=places"></script>
@endsection