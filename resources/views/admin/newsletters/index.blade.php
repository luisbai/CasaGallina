@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-boletines-index">
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-header clearfix">
                    <div class="float-left mt-1">Boletines</div>

                    <div class="float-right">
                        <a href="/admin/boletines/create" class="btn btn-secondary btn-sm">Nuevo boletín</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered" id="boletines-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($boletines as $boletin)
                                <tr>
                                    <td class="fecha">{{ $boletin->boletin_fecha }}</td>
                                    <td>
                                        <a href="/admin/boletines/{{ $boletin->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="#" class="btn btn-sm btn-danger delete-record" data-record-id="{{ $boletin->id }}">Eliminar</a>
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