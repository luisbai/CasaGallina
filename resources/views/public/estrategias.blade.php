@extends('layouts.boilerplate')

@section('content')
    <div class="container">
        <div id="estrategias-index">
            <div class="section-title text-center">
                <span>Programa</span>
            </div>

            <div class="row">
                <div class="card-columns">
                    @foreach ($estrategias as $estrategia)
                        <div class="card">
                            <div class="estrategia-item">
                                <div class="estrategia-image" onclick="window.location = '/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}'">
                                    <img src='/storage/cache/{{ $estrategia->destacada_multimedia->filename  }}' class="img-fluid">
                                </div>
                                <div class="estrategia-title">
                                    <a href="/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}">{{ $estrategia->titulo }}</a>
                                </div>
                                <div class="estrategia-subtitle">
                                    {{ $estrategia->fecha }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection