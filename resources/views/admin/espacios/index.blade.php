@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-espacios-index">
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-header clearfix">
                    <div class="float-left mt-1">Espacios de Colaboración</div>

                    <div class="float-right">
                        <a href="/admin/espacios/create" class="btn btn-secondary btn-sm">Nuevo Espacio</a>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-bordered" id="espacios-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($espacios as $espacio)
                                <tr>
                                    <td>{{ $espacio->nombre }}</td>
                                    <td>{{ \App\Models\Espacio::$categorias[$espacio->status] }}</td>
                                    <td>
                                        <a href="/admin/espacios/{{ $espacio->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="#" class="btn btn-sm btn-danger delete-record" data-record-id="{{ $espacio->id }}">Eliminar</a>
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