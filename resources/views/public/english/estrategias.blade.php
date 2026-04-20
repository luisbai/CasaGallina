@extends('layouts.english.boilerplate')

@section('content')
    <div class="container">
        <div id="estrategias-index">
            <div class="section-title text-center">
                <span>Program</span>
            </div>

            <div class="row">
                <div class="card-columns">
                    @foreach ($estrategias as $estrategia)
                        <div class="card">
                            <div class="estrategia-item">
                                <div class="estrategia-image"
                                    onclick="window.location = '/en/strategy/{{ \Str::slug($estrategia->titulo_en) }}/{{ $estrategia->id }}'">
                                    <img src='{{ $estrategia->featured_multimedia?->url }}' class="img-fluid">
                                </div>
                                <div class="estrategia-title">
                                    <a
                                        href="/en/strategy/{{ \Str::slug($estrategia->titulo_en) }}/{{ $estrategia->id }}">{{ $estrategia->titulo_en }}</a>
                                    <div class="estrategia-subtitle">
                                        {{ $estrategia->fecha_en }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection