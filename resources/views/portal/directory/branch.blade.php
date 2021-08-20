<?php
$l10n = $locale = App::getLocale();
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

	td, th {

		
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
	}

	td{
		font-size: 13px;
		color: #757575;
	}

	th{
		font-size: 16px;
	}


</style>
@endpush

@section('content')
<div class="content container" style="margin-top: 80px">
	<div class="row">
		<div class="col-md-12">

			<h2>{!! $page->$title !!}</h2>
			<br/>

			
			<table class="table table-bordered table-striped" style="width: 100%;" cellpadding="5">
				<tr>
					<th width="250">{{ trans('master.directory_branch_state') }}</th>
					<th>{{ trans('master.directory_branch_address') }}</th>
					<th>{{ trans('master.directory_branch_ks_email') }}</th>
				</tr>
				@foreach ($directoryBranch as $directory)
				<tr>
					<td style="text-transform: uppercase;">{{$directory->state->state}}</td>
					<td style="text-transform: uppercase;"> 
						TRIBUNAL TUNTUTAN PENGGUNA MALAYSIA <br>
						{{ $directory->address_1 }} <br/>
						{{ $directory->address_2 }} 
						@if($directory->address_3)
						{{ $directory->address_3 }} <br/>
						@endif
						{{ $directory->postcode }} 
						{{ $directory->district->district}} <br/> 
						Tel: {{ $directory->directory_branch_tel }} <br/>
						Faks: {{ $directory->directory_branch_faks }} 
					</td>
					<td>Nama: {{ $directory->directory_branch_head }} <br/>
						Emel: {{ $directory->directory_branch_email }} 

					</td>


				</tr>	@endforeach
			</table>




		</div>
	</div>
</div>
@endsection