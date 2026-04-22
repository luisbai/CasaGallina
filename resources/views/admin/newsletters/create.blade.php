@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-boletines-edit">
        <div class="col-md-7">
            <div class="card card-default">
                <div class="card-header">
                    <div class="float-left mt-1">Nuevo Boletin</div>
                    <div class="float-right">
                        <a href="/admin/boletines" class="btn btn-sm btn-secondary">Volver a boletines</a>
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
                    <form action="/admin/boletines" class="form-horizontal" method="POST" id="admin-boletines-edit-form" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="text" name="boletin_fecha" placeholder="Fecha del boletin" class="form-control datepicker" autocomplete="new-password" data-toggle="datetimepicker" data-target=".datepicker" required>
                                </div>
                                <div class="form-group">
                                    <label>Documento (EN)</label>
                                    <input type="file" name="multimedia_en_id" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Documento (ES)</label>
                                    <input type="file" name="multimedia_es_id" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Crear Boletin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection