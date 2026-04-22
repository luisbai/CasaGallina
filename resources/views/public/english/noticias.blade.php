@extends('layouts.boilerplate')

@section('meta')
    <!-- add alpinejs -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
    <div class="noticias-index">
        <livewire:public.noticias-page />
    </div>
@endsection