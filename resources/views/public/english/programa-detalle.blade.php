@extends('layouts.boilerplate')

@section('content')
    @livewire('public.programa-detalle', ['slug' => $slug, 'route_tipo' => $route_tipo])
@endsection