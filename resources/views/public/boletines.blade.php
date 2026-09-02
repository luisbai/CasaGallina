@extends('layouts.boilerplate')

@section('content')
    <div id="boletines-index">
    	<section id="boletines-banner">
            <img src="/assets/images/casa/banner.jpg" class="img-fluid">
        </section>
    	<section id="boletines-intro">

            <div class="container">
                <div class="section-title text-center">
                    <span>Boletines</span>
                </div>

                <div class="intro-text">
                    Una compilación, para fines de archivo, del Boletín enviado cada cuatro meses por correo electrónico para compartir las estrategias y líneas programáticas implementadas por Casa Gallina. Para un seguimiento más detallado de las actividades diarias, consulte la página de Facebook de Casa Gallina.
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                	<h1 class="text-center">Archivo de boletines</h1>
                	<div class="row mb-5">
                		<div class="col-md-12">
                			@foreach ($boletines as $year => $boletines_year)
			                	<table class="table table-small" id="boletines-table">
			                		<thead>
			                            <tr>
			                                <th>{{ $year }}</th>
			                                <th class="text-center">Descargar</th>
			                                <th class="text-center">Ver</th>
			                            </tr>
			                        </thead>
			                        <tbody>
		                            	@foreach ($boletines_year as $boletin)
		                            		<tr>
                                             <td class="boletin-fecha-txt text-capitalize">
                                                {{ !empty($boletin->boletin_fecha) ? \Carbon\Carbon::parse($boletin->boletin_fecha)->translatedFormat('F Y') : 'S/F' }}
                                                </td>
   {{-- Columna Descargar --}}
    <td class="btn-icon">
        @if($boletin->multimedia_es?->filename)
            <a href="{{ $boletin->multimedia_es->url }}"
               download="boletin-{{ !empty($boletin->boletin_fecha) ? \Carbon\Carbon::parse($boletin->boletin_fecha)->format('m-y') : $boletin->id }}">
                <i class="fa fa-download"></i>
            </a>
        @else
            <span class="text-muted"><i class="fa fa-minus"></i></span>
        @endif
    </td>

    {{-- Columna Ver --}}
    <td class="btn-icon">
        @if($boletin->multimedia_es?->filename)
            <a href="{{ $boletin->multimedia_es->url }}" target="_blank">
                <i class="fa fa-eye"></i>
            </a>
        @else
            <span class="text-muted"><i class="fa fa-minus"></i></span>
        @endif
    </td>
</tr>
		                            	@endforeach
			                        </tbody>
			                    </table>
		                    @endforeach
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

