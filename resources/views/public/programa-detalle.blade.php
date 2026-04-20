@extends('layouts.boilerplate')

@section('content')
    <livewire:public.programa-detalle :$slug :$route_tipo />
@endsection
