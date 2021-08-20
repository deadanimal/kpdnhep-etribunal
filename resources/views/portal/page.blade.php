<?php
$locale = App::getLocale();
$title = "title_".$locale;
$subtitle = "subtitle_".$locale;
$content = "content_".$locale;
?>
@extends('layouts.portal.app-v3-page')

@push('css')
<style>
.content {
	margin-top: 30px;
	margin-bottom: 20px;
}
.content-overlay {
    margin-top: -160px;
    margin-bottom: 120px;
	text-shadow: 2px 2px 4px #000000;
	color: #FFFFFF;
}

.content-overlay h1 {
	font-weight: 700;
}
</style>
@endpush

@section('content')
<div class="content container" style="margin-top: 80px">
	<div class="row">
		<div class="col-md-12">
			{!! $page->$content !!}
		</div>
	</div>
</div>
@endsection