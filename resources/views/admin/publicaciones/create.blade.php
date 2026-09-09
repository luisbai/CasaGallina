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




                            <div class="space-y-6">
    <!-- Título -->
    <flux:editor toolbar="italic bold" label="Título" wire:model.blur="title"
        placeholder="Título de la publicación" class="h-28" />

    <!-- Fecha -->
    <flux:date-picker label="Fecha Publicación" wire:model="publication_date"
        placeholder="Selecciona una fecha" />

    <!-- Créditos y Detalles Fijos (2 columnas) -->
    <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl space-y-4">
        <flux:subheading size="sm" class="!font-semibold !text-forest-700">
            Créditos y Detalles
        </flux:subheading>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input label="Diseño" wire:model="diseno" placeholder="Nombre del diseñador..." />
            <flux:input label="Textos" wire:model="textos" placeholder="Autores de textos..." />
        </div>

        <div>
            <flux:textarea label="Coordinación Editorial" wire:model="editorial_coordination"
                placeholder="Coordinación Editorial" rows="3" />
        </div>
    </div>

    <!-- Campos Opcionales (1 al 7) en Acordeón -->
    <flux:accordion>
        <flux:accordion.item heading="Campos Adicionales Opcionales (1 al 7)">
            <div class="space-y-4 pt-3">
                @for($i = 1; $i <= 7; $i++)
                    <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm space-y-3">
                        <flux:input
                            wire:model="campo_opcional_{{ $i }}_titulo"
                            label="Título Campo {{ $i }}"
                            placeholder="Ej: Fotografías, Traducción, ISBN..."
                        />
                        <flux:textarea
                            wire:model="campo_opcional_{{ $i }}"
                            label="Contenido Campo {{ $i }}"
                            placeholder="Descripción o contenido del campo opcional {{ $i }}"
                            rows="2"
                        />
                    </div>
                @endfor
            </div>
        </flux:accordion.item>
    </flux:accordion>

    <!-- Sinopsis -->
    <flux:editor label="Sinopsis" wire:model.blur="synopsis"
        placeholder="Sinopsis de la publicación" />

    <flux:editor label="Contenido Adicional" wire:model.blur="additional_content"
        placeholder="Contenido adicional de la publicación"
        toolbar="heading | bold italic underline | bullet ordered" />
</div>


                               <div class="space-y-6">
    <!-- Title (EN) -->
    <div>
        <flux:label>Title (EN)</flux:label>
        <flux:editor toolbar="italic bold" wire:model.blur="title_en"
            placeholder="Publication title (EN)" class="h-28" />
    </div>

    <!-- Date (EN) -->
    <div>
        <flux:label>Publication Date (EN)</flux:label>
        <flux:date-picker wire:model="publication_date_en" placeholder="Select a date" />
    </div>

    <!-- Credits & Fixed Details (EN) -->
    <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl space-y-4">
        <flux:subheading size="sm" class="!font-semibold !text-forest-700">
            Credits & Details (EN)
        </flux:subheading>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input label="Design (EN)" wire:model="diseno_en" placeholder="Designer name..." />
            <flux:input label="Texts (EN)" wire:model="textos_en" placeholder="Text authors..." />
        </div>

        <div>
            <flux:textarea label="Editorial Coordination (EN)" wire:model="editorial_coordination_en"
                placeholder="Editorial Coordination (EN)" rows="3" />
        </div>
    </div>

    <!-- Optional Fields (1-7 EN) in Accordion -->
    <flux:accordion>
        <flux:accordion.item heading="Optional Additional Fields (1 to 7)">
            <div class="space-y-4 pt-3">
                @for($i = 1; $i <= 7; $i++)
                    <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm space-y-3">
                        <flux:input
                            wire:model="campo_opcional_{{ $i }}_en_titulo"
                            label="Field {{ $i }} Title (EN)"
                            placeholder="E.g.: Photography, Translation, ISBN..."
                        />
                        <flux:textarea
                            wire:model="campo_opcional_{{ $i }}_en"
                            label="Field {{ $i }} Content (EN)"
                            placeholder="Description or content for optional field {{ $i }}"
                            rows="2"
                        />
                    </div>
                @endfor
            </div>
        </flux:accordion.item>
    </flux:accordion>

    <!-- Synopsis (EN) -->
    <div>
        <flux:label>Synopsis (EN)</flux:label>
        <flux:editor wire:model.blur="synopsis_en" placeholder="Publication synopsis (EN)" />
    </div>

    <div>
        <flux:label>Additional Content (EN)</flux:label>
        <flux:editor wire:model.blur="additional_content_en"
            placeholder="Additional publication content (EN)"
            toolbar="heading | bold italic underline | bullet ordered" />
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
