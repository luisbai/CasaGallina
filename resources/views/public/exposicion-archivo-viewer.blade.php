@extends('layouts.plain')

@section('page-title', $archivo->titulo ?: 'Archivo')

@section('styles')
    <style>
        #body {
            height: 100vh;
            background-color: #4e5f61;
        }
    </style>

    <!-- Icons Stylesheet -->
    <link href="{{ asset('assets/plugins/dflip/css/themify-icons.min.css') }}" rel="stylesheet" type="text/css">


    <!-- Flipbook StyleSheet -->
    <link href="{{ asset('assets/plugins/dflip/css/dflip.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section id="body">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="col-lg-12">
                    <div id="pdf-container">
                        <div id="brochure"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

    <script src="/assets/scripts/jquery.min.js"></script>
    <!-- Flipbook main Js file -->
    <script src="{{asset('assets/plugins/dflip/js/dflip.min.js')}}" type="text/javascript" defer></script>

    <script>
        $(document).ready(function () {

            const options = {
                height: 700,
                duration: 400,
                backgroundColor: "#4e5f61",
                soundEnable: false,
            };

            const source = '{{ $archivo->download_url }}';

            const flipBook = $("#brochure").flipBook(source, options);

        });
    </script>

@endsection