@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="admin-publicaciones-edit">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="float-left mt-1">Nueva Publicación</div>
                    <div class="float-right">
                        <a href="/admin/publicaciones" class="btn btn-sm btn-secondary">Volver a publicaciones</a>
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
                    <form action="/admin/publicaciones" class="form-horizontal" method="POST" enctype="multipart/form-data" id="admin-publicaciones-edit-form">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option disabled selected>Seleccionar Opción</option>
                                        <option value="public">Indexada</option>
                                        <option value="private">Acceso sólo con link</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Publicación</label>
                                    <input type="file" name="publicacion_multimedia" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select name="tipo" class="form-control" required>
                                        <option disabled selected>Seleccionar Opción</option>
                                        <option value="impreso">Impreso</option>
                                        <option value="digital">Digital</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Número de Páginas</label>
                                    <input type="text" name="numero_paginas" placeholder="Número de Páginas de la publicación" class="form-control" value="" required>
                                </div>

                                <div class="form-group">
                                    <label>Thumbnail Publicación</label>
                                    <input type="file" name="publicacion_thumbnail" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Previsualización</label>
                                    <select name="previsualizacion" class="form-control" required>
                                        <option disabled selected>Seleccionar Opción</option>
                                        <option value="1">Activada</option>
                                        <option value="0">Desactivada</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                

                                
                                
                                <div class="form-group">
                                    <label>Título</label>
                                    <input type="text" name="titulo" placeholder="Título de la publicación" class="form-control tinymce" id="input-titulo" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_1_titulo" placeholder="Campo Opcional 1 Título" class="form-control"">
                                    <textarea name="campo_opcional_1" rows="3"  placeholder="Campo Opcional 1" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_5_titulo" placeholder="Campo Opcional 5 Título" class="form-control">
                                    <textarea name="campo_opcional_5" rows="3"  placeholder="Campo Opcional 5" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Coordinación Editorial</label>
                                    <textarea name="coordinacion_editorial" rows="3"  placeholder="Coordinación Editorial" class="form-control"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Diseño</label>
                                    <input type="text" name="diseno" placeholder="Diseño" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Textos</label>
                                    <input type="text" name="textos" placeholder="Textos" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_2_titulo" placeholder="Campo Opcional 2 Título" class="form-control">
                                    <textarea name="campo_opcional_2" rows="3"  placeholder="Campo Opcional 2" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_6_titulo" placeholder="Campo Opcional 6 Título" class="form-control">
                                    <textarea name="campo_opcional_6" rows="3"  placeholder="Campo Opcional 6" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_7_titulo" placeholder="Campo Opcional 7 Título" class="form-control">
                                    <textarea name="campo_opcional_7" rows="3"  placeholder="Campo Opcional 7" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Sinopsis</label>
                                    <textarea name="sinopsis" rows="5"  placeholder="Sinopsis de la publicación" class="form-control tinymce" id="input-sinopsis" data-height="300"></textarea>
                                </div>

                                
                                <div class="form-group">
                                    <label>Fecha Publicación </label>
                                    <div>
                                        <input type="text" name="fecha_publicacion" placeholder="Fecha" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_3_titulo" placeholder="Campo Opcional 3 Título" class="form-control">
                                    <textarea name="campo_opcional_3" rows="3"  placeholder="Campo Opcional 3" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_4_titulo" placeholder="Campo Opcional 4 Título" class="form-control">
                                    <textarea name="campo_opcional_4" rows="3"  placeholder="Campo Opcional 4" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">                        

                                <div class="form-group">
                                    <label>Título (EN)</label>
                                    <input type="text" name="titulo_en" placeholder="Título de la publicación (EN)" class="form-control tinymce" id="input-titulo-en" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_1_en_titulo" placeholder="Campo Opcional 1 Título (EN)" class="form-control">
                                    <textarea name="campo_opcional_1_en" rows="3"  placeholder="Campo Opcional 1 (EN)" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_5_en_titulo" placeholder="Campo Opcional 5 Título (EN)" class="form-control">
                                    <textarea name="campo_opcional_5_en" rows="3"  placeholder="Campo Opcional 5 (EN)" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Coordinación Editorial (EN)</label>
                                    <textarea name="coordinacion_editorial_en" rows="3"  placeholder="Coordinación Editorial (EN)" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Diseño (EN)</label>
                                    <input type="text" name="diseno_en" placeholder="Diseño (EN)" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Textos (EN)</label>
                                    <input type="text" name="textos_en" placeholder="Textos (EN)" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_2_en_titulo" placeholder="Campo Opcional 2 Título (EN)" class="form-control">
                                    <textarea name="campo_opcional_2_en" rows="3"  placeholder="Campo Opcional 2 (EN)" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_6_en_titulo" placeholder="Campo Opcional 6 Título (EN)" class="form-control">
                                    <textarea name="campo_opcional_6_en" rows="3"  placeholder="Campo Opcional 6 (EN)" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_7_en_titulo" placeholder="Campo Opcional 7 Título (EN)" class="form-control">
                                    <textarea name="campo_opcional_7_en" rows="3"  placeholder="Campo Opcional 7 (EN)" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Sinopsis (EN)</label>
                                    <textarea name="sinopsis_en" rows="5"  placeholder="Sinopsis de la publicación (EN)" class="form-control tinymce" id="input-sinopsis-en" data-height="300"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Fecha Publicación (EN)</label>
                                    <div>
                                        <input type="text" name="fecha_publicacion_en" placeholder="Fecha (EN)" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_3_en_titulo" placeholder="Campo Opcional 3 Título (EN)" class="form-control">
                                    <textarea name="campo_opcional_3_en" rows="3"  placeholder="Campo Opcional 3 (EN)" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="campo_opcional_4_en_titulo" placeholder="Campo Opcional 4 Título (EN)" class="form-control">
                                    <textarea name="campo_opcional_4_en" rows="3"  placeholder="Campo Opcional 4 (EN)" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Crear Publicación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pre_scripts')
    <script src="{{ asset('/assets/plugins/tinymce/tinymce.min.js') }}"></script>
@endsection