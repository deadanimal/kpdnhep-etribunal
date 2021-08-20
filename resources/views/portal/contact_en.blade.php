@extends('layouts.portal.app-new')

@push('css')
<style>
#map {
	min-height: 315px;
	margin-top: -80px;
	margin-bottom: 0px;
}
.content-overlay {
	min-height: 200px;
	background-color: #ffffff;
	position: relative;
	z-index: 999;
	top: 50px;
	margin-right: 20%;
	margin-left: 20%;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.content-overlay > .row > div {
	text-align: center;
	padding-top: 50px;
	padding-bottom: 50px;
}
.content-overlay > .row > div > i {
	font-size: 50px;
	color: #2b477f;
}

@media (max-width: 767.99px) {
	#map {
		margin-top: -520px;
		min-height: 650px;
	}
	.content-overlay {
		margin-right: 5%;
		margin-left: 5%;
	}
}

.footer {
    background: #2c2f35;
}

.footer .text-muted {
	color: white !important;
}

</style>
@endpush

@section('content')
<div class="content-overlay">
	<div class="row">
		<div class="col-md-4">
			<i class="fa fa-phone"></i><br><br>
			Toll-Free: 1-800-88-9811<br>
			Office: 03-8882 5822<br>
			Fax: 03-8882 5831
		</div>
		<div class="col-md-4">
			<i class="fa fa-building"></i><br><br>
			Tribunal for Consumer Claims Malaysia,<br>
			Ministry of Domestic Trade<br>
			and Consumer Affairs
		</div>
		<div class="col-md-4">
			<i class="fa fa-map"></i><br><br>
			Level 5, Podium 2,<br>
			No. 13, Persiaran Perdana,<br>
			Presint 2, 62623 Putrajaya
		</div>
	</div>
</div>

<div id="map" class="container-fluid">
</div>
@endsection

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAssaWBjq7xp_L88KSNA6X7wVA-HxF9rtM&callback=myMap"></script>
@endpush