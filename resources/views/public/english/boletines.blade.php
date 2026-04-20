@extends('layouts.english.boilerplate')

@section('content')
	<div id="boletines-index">
		<section id="boletines-banner">
			<img src="/assets/images/casa/banner.jpg" class="img-fluid">
		</section>
		<section id="boletines-intro">

			<div class="container">
				<div class="section-title text-center">
					<span>Archive of Newsletters</span>
				</div>

				<div class="intro-text">
					A compilation, for archival purposes, of the Newsletter sent every four months by e-mail to share the
					strategies and programmatic lines implemented by Casa Gallina. For closer follow-up of daily activities,
					please see Casa Gallina's Facebook page.
				</div>
			</div>
		</section>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-4">
					<div class="row mb-5">
						<div class="col-md-12">
							@foreach ($boletines as $year => $boletines_year)
								<table class="table table-small" id="boletines-table">
									<thead>
										<tr>
											<th>{{ $year }}</th>
											<th class="text-center">Download</th>
											<th class="text-center">View</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($boletines_year as $boletin)
											<tr>
												<td class="fecha">{{ $boletin->boletin_fecha }}</td>
												<td class="btn-icon">
													<a href="{{ $boletin->multimedia_en?->url }}"
														download="boletin-{{ Carbon\Carbon::parse($boletin->boletin_fecha)->format('m-y') }}"><i
															class="fa fa-download"></i></a>
												</td>
												<td class="btn-icon">
													<a href="{{ $boletin->multimedia_en?->url }}" target="_blank"><i
															class="fa fa-eye"></i></a>
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