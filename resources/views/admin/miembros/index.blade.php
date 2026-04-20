@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-miembros-index">
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-header clearfix">
                    <div class="float-left mt-1">Miembros del Equipo</div>

                    <div class="float-right">
                        <a href="/admin/miembros/create" class="btn btn-secondary btn-sm">Nuevo miembro</a>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-bordered" id="miembros-table">
                        <thead>
                            <tr>
                                <th>Órden</th>
                                <th>Nombre</th>
                                <th>Titulo</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($miembros as $miembro)
                                <tr>
                                    <td>{{ $miembro->orden }}</td>
                                    <td>{{ $miembro->nombre }}</td>
                                    <td>{{ $miembro->titulo }}</td>
                                    <td>{{ ucfirst($miembro->tipo) }}</td>
                                    <td>
                                        <a href="/admin/miembros/{{ $miembro->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="#" class="btn btn-sm btn-danger delete-record" data-record-id="{{ $miembro->id }}">Eliminar</a>
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