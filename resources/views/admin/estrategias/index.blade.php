@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-estrategias-index">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header clearfix">
                    <div class="float-left mt-1">Estrategias</div>

                    <div class="float-right">
                        <a href="/admin/estrategias/create" class="btn btn-secondary btn-sm">Nueva Estrategia</a>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-bordered" id="estrategias-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Órden</th>
                                <th>Titulo</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estrategias as $estrategia)
                                <tr>
                                    <td>
                                        @if ($estrategia->status == 'public')
                                            <span class="badge badge-primary">Pública</span>
                                        @elseif ($estrategia->status == 'private')
                                            <span class="badge badge-secondary">Acceso sólo con link</span>
                                        @endif
                                    </td>
                                    <td>{{ $estrategia->orden }}</td>
                                    <td><a href="/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}" target="_blank">{{ $estrategia->titulo }}</a></td>
                                    <td class="fecha">{{ $estrategia->created_at }}</td>
                                    <td>
                                        <a href="/admin/estrategias/{{ $estrategia->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="#" class="btn btn-sm btn-danger delete-record" data-record-id="{{ $estrategia->id }}">Eliminar</a>
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