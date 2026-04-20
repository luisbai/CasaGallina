@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-publicaciones-index">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header clearfix">
                    <div class="float-left mt-1">Publicaciones</div>

                    <div class="float-right">
                        <a href="/admin/publicaciones/create" class="btn btn-secondary btn-sm">Nueva Publicación</a>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-bordered" id="publicaciones-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Órden</th>
                                <th>Titulo</th>
                                <th>Tipo</th>
                                <th>Fecha de Creación</th>
                                <th>Descargas</th>
                                <th>Vistas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($publicaciones as $publicacion)
                                <tr>
                                    <td>
                                        @if ($publicacion->status == 'public')
                                            <span class="badge badge-primary">Pública</span>
                                        @elseif ($publicacion->status == 'private')
                                            <span class="badge badge-secondary">Solo link</span>
                                        @endif
                                    </td>
                                    <td>{{ $publicacion->orden }}</td>
                                    <td><a href="/publicacion/{{ \Str::slug($publicacion->titulo) }}/{{ $publicacion->id }}" target="_blank">{!! $publicacion->titulo !!}</a></td>
                                    <td>
                                        @if ($publicacion->tipo == 'impreso')
                                            <span class="badge badge-info">Impreso</span>
                                        @elseif ($publicacion->tipo == 'digital')
                                            <span class="badge badge-warning">Digital</span>
                                        @endif
                                    </td>
                                    <td>{{ $publicacion->created_at->diffForHumans() }}</td>
                                    <td>{{ $publicacion->downloads }}</td>
                                    <td>{{ $publicacion->views }}</td>
                                    <td>
                                        <a href="/admin/publicaciones/{{ $publicacion->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="#" class="btn btn-sm btn-danger delete-record" data-record-id="{{ $publicacion->id }}">Eliminar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

