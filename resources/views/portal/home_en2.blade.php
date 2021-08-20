<?php
$locale = App::getLocale();
$title = "title_".$locale;
$subtitle = "subtitle_".$locale;
$content = "content_".$locale;
?>
@extends('layouts.portal.app-main')

@section('title')
{!! $page->$title !!}
@endsection

@section('subtitle')
{!! $page->$subtitle !!}
@endsection

@push('css')
<style type="text/css">
.bold {
	font-weight: bold;
}

.panel {
	margin-bottom: 0px;
}

body {
	background-color: #f8f8f8;
}

.carousel-indicators {
	bottom: unset !important;
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
<div class='row' style="background-color: #f8f8f8;">
	<div class='col-md-3' style='padding: 30px;'>
		<h4 style="margin-bottom: 15px">Announcement</h4>

		<div id="myCarousel" class="carousel slide" data-ride="carousel">

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				@foreach ($announcements as $index => $announcement)
				<div class="item {{ $index == 0 ? 'active' : '' }}">
					<div class="panel panel-success" @if($index > 0) class="hidden" @endif>
						<div class="panel-heading bold">{{ $announcement->title_en }}</div>
						<div class="panel-body" style="background-color: white;">{!! strlen($announcement->description_en) > 100 ? substr($announcement->description_en, 0, 100).'... <a href="javascript:;" onclick="openAnnouncement('.$announcement->portal_announcement_id.')" style="font-style: italic; font-weight: bold">Read More</a>' : $announcement->description_en !!}</div>
					</div>
				</div>
				@endforeach
			</div>

			<!-- Indicators -->
			<ol class="carousel-indicators">
				@foreach ($announcements as $index => $announcement)
				<li data-target="#myCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
				@endforeach
			</ol>
		</div>





	</div>
	<div class='col-md-9' style="padding: 30px; background-color: #ffffff;">
		{!! $page->$content !!}
	</div>
</div>
<div id="modalDiv"></div>
@endsection

@push('js')
<script src="{{ URL::to('/assets/global/plugins/jquery.twbsPagination.min.js') }}" type="text/javascript"></script>
<script>
$(function () {
    window.pagObj = $('#pagination').twbsPagination({
        totalPages: $('.panel').length,
        visiblePages: $('.panel').length,
        loop: true,
        first: '',
        prev: '',
        next: '',
        last: '',
        onPageClick: function (event, page) {
            console.info(page + ' (from options)');
            $('.panel').addClass('hidden');
            $('.panel').eq(page-1).removeClass('hidden');
        }
    });
});

function openAnnouncement(id) {
	$("#modalDiv").load("{{ route('portal.announcement', ['id' => '']) }}/"+id);
}
</script>
@endpush