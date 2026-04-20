@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-boletines-edit">
        <div class="col-md-7">
            <div class="card card-default">
                <div class="card-header">
                    <div class="float-left mt-1">Editar Boletín</div>
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
                    <form action="/admin/boletines/{{ $boletin->id }}" class="form-horizontal" method="POST" enctype="multipart/form-data" id="admin-boletines-edit-form">
                        @csrf
                        {{ method_field('PUT') }}
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="text" name="boletin_fecha" placeholder="Fecha del boletin" class="form-control datepicker" autocomplete="new-password" data-toggle="datetimepicker" data-target=".datepicker" value="{{ $boletin->boletin_fecha }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Documento (EN)</label>
                                    <input type="file" name="multimedia_en_id" class="form-control" >
                                </div>
                                @isset ($boletin->multimedia_en)
                                    <div class="boletines-multimedia">
                                         <a href="/storage/cache/{{ $boletin->multimedia_en->filename }}" target="_blank"><i class="fa fa-file-pdf-o"></i> Ver Boletín</a>
                                    </div>
                                @endisset

                                <div class="form-group">
                                    <label>Documento (ES)</label>
                                    <input type="file" name="multimedia_es_id" class="form-control" >
                                </div>
                                @isset ($boletin->multimedia_es)
                                    <div class="boletines-multimedia">
                                         <a href="/storage/cache/{{ $boletin->multimedia_es->filename }}" target="_blank"><i class="fa fa-file-pdf-o"></i> Ver Boletín</a>
                                    </div>
                                @endisset
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
@endsection