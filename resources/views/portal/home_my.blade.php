<?php
$locale = App::getLocale();
$title = "title_".$locale;
$subtitle = "subtitle_".$locale;
$content = "content_".$locale;
?>

@extends('layouts.portal.app-new')

@push('css')
<style type="text/css">
.carousel-indicators {
	bottom: unset !important;
}

.carousel-inner {
	top: 10px;
}

.carousel-indicators li {
	background-color: #dff0d8 !important;
}

.carousel-indicators .active {
	background-color: #bed2b6 !important;
}

.carousel-inner .panel-body {
	min-height: 140px !important;
}
</style>
@endpush

@section('content')
<div class="content-overlay container">
	<div class="row">
		<div class="col-md-4 col-sm-12 offset-md-8">
			<div class="box-info">
				<h4>Pengumuman</h4>
				<hr>

				<div id="demo" class="carousel slide" data-ride="carousel">

					<!-- Indicators -->
					<ul class="carousel-indicators">
						@foreach ($announcements as $index => $announcement)
						<li data-target="#demo" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
						@endforeach
					</ul>

					<!-- The slideshow -->
					<div class="carousel-inner">
						@foreach ($announcements as $index => $announcement)
						<div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
							<div @if($index > 0) class="hidden" @endif>
								<h5>{{ $announcement->title_my }}</h5>
								<p>{!! strlen($announcement->description_my) > 100 ? substr($announcement->description_my, 0, 100).'...' : $announcement->description_my !!}</p>
								@if(strlen($announcement->description_my) > 100)
								<a href="javascript:;" onclick="openAnnouncement('{{ $announcement->portal_announcement_id }}')">Baca selanjutnya..</a>
								@endif
							</div>
						</div>
						@endforeach
					</div>

					

				</div>

			</div>
		</div>
	</div>
</div>

<div class="content container">
	<div class="row">
		<div class="col-md-7">
			<h6><strong>{!! $page->$title !!}</strong></h6>
			<h3>{!! $page->$subtitle !!}</h3>
			{!! $page->$content !!}
		</div>
		<div class="col-md-4 offset-md-1 text-center">
			<a href="{{ route('login') }}"><img class="footer-link" src="{{ asset('images/button_inquiry.jpg') }}"></a>
			<a href="{{ route('login') }}"><img class="footer-link" src="{{ asset('images/button_claim.jpg') }}"></a>
			<a href="#"><img class="footer-link" src="{{ asset('images/button_journal.jpg') }}"></a>
		</div>
	</div>
</div>
<div id="modalDiv"></div>
@endsection

@push('js')
<script type="text/javascript">
function openAnnouncement(id) {
	$("#modalDiv").load("{{ route('portal.announcement', ['id' => '']) }}/"+id);
}
</script>
@endpush