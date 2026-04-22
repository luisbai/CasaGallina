@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" id="admin-estrategias-edit">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="float-left mt-1">Nueva Estrategia</div>
                        <div class="float-right">
                            <a href="/admin/estrategias" class="btn btn-sm btn-secondary">Volver a estrategias</a>
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
                        <form action="/admin/estrategias" class="form-horizontal" method="POST"
                            enctype="multipart/form-data" id="admin-estrategias-edit-form">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Órden</label>
                                        <input type="number" name="orden" placeholder="Posición" class="form-control"
                                            value="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Título</label>
                                        <input type="text" name="titulo" placeholder="Título de la estrategia"
                                            class="form-control" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Subtitulo</label>
                                        <textarea name="subtitulo" rows="5" placeholder="Subtítulo de la estrategia"
                                            class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Contenido</label>
                                        <div id="contenido"></div>
                                        <input type="hidden" name="contenido" id="contenido-input" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Programas de implementación de la estrategia</label>
                                        <div id="programas"></div>
                                        <input type="hidden" name="programas" id="programas-input" value="">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_1_titulo"
                                            placeholder="Campo Opcional 1 Título" class="form-control titulo-input">
                                        <textarea name="campo_opcional_1" rows="3" placeholder="Campo Opcional 1"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_2_titulo"
                                            placeholder="Campo Opcional 2 Título" class="form-control titulo-input">
                                        <textarea name="campo_opcional_2" rows="3" placeholder="Campo Opcional 2"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_3_titulo"
                                            placeholder="Campo Opcional 3 Título" class="form-control titulo-input">
                                        <textarea name="campo_opcional_3" rows="3" placeholder="Campo Opcional 3"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Colaboradores</label>
                                        <textarea name="colaboradores" rows="3" placeholder="Colaboradores"
                                            class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <div>
                                            <input type="text" name="fecha" placeholder="Fecha" class="form-control"
                                                value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Lugar</label>
                                        <textarea name="lugar" rows="3" placeholder="Lugar" class="form-control"
                                            required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_4_titulo"
                                            placeholder="Campo Opcional 4 Título" class="form-control titulo-input">
                                        <textarea name="campo_opcional_4" rows="3" placeholder="Campo Opcional 4"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_5_titulo"
                                            placeholder="Campo Opcional 5 Título" class="form-control titulo-input">
                                        <textarea name="campo_opcional_5" rows="3" placeholder="Campo Opcional 5"
                                            class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Título (EN)</label>
                                        <input type="text" name="titulo_en" placeholder="Título de la estrategia (EN)"
                                            class="form-control" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Subtitulo (EN)</label>
                                        <textarea name="subtitulo_en" rows="5" placeholder="Subtítulo de la estrategia (EN)"
                                            class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Contenido (EN)</label>
                                        <div id="contenido-en"></div>
                                        <input type="hidden" name="contenido_en" id="contenido-en-input" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Programas de implementación de la estrategia (EN)</label>
                                        <div id="programas-en"></div>
                                        <input type="hidden" name="programas_en" id="programas-en-input" value="">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_1_en_titulo"
                                            placeholder="Campo Opcional 1 Título (EN)" class="form-control titulo-input">
                                        <textarea name="campo_opcional_1_en" rows="3" placeholder="Campo Opcional 1 (EN)"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_2_en_titulo"
                                            placeholder="Campo Opcional 2 Título (EN)" class="form-control titulo-input">
                                        <textarea name="campo_opcional_2_en" rows="3" placeholder="Campo Opcional 2 (EN)"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_3_en_titulo"
                                            placeholder="Campo Opcional 3 Título (EN)" class="form-control titulo-input">
                                        <textarea name="campo_opcional_3_en" rows="3" placeholder="Campo Opcional 3 (EN)"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Colaboradores (EN)</label>
                                        <textarea name="colaboradores_en" rows="3" placeholder="Colaboradores (EN)"
                                            class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha (EN)</label>
                                        <div>
                                            <input type="text" name="fecha_en" placeholder="Fecha (EN)" class="form-control"
                                                value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Lugar (EN)</label>
                                        <textarea name="lugar_en" rows="3" placeholder="Lugar (EN)" class="form-control"
                                            required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_4_en_titulo"
                                            placeholder="Campo Opcional 4 Título (EN)" class="form-control titulo-input">
                                        <textarea name="campo_opcional_4_en" rows="3" placeholder="Campo Opcional 4 (EN)"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="campo_opcional_5_en_titulo"
                                            placeholder="Campo Opcional 5 Título (EN)" class="form-control titulo-input">
                                        <textarea name="campo_opcional_5_en" rows="3" placeholder="Campo Opcional 5 (EN)"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Imágenes</label>
                                        <input type="file" name="imagenes[]" class="form-control" multiple="true" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Imagen Predeterminada</label>
                                        <input type="file" name="destacada_multimedia_id" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group float-right">
                                <button type="submit" class="btn btn-primary">Crear Estrategia</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection