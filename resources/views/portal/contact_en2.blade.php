@extends('layouts.portal.app-main')

@section('title')
Contact Us
@endsection

@section('subtitle')
@endsection

@section('content')
<!--=========================-->
<!--=       Contact         =-->
<!--=========================-->
<section id="contact-two" style="padding: 0px;">
	{{--
	<div class="container">
		<div class="gp-contact-form-two">

			<form id="gp-contact-form-two" action="" method="POST" name="appai_message_form">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" name="your_name" class="form-control" id="name" placeholder="Your Name*" required="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="email" name="your_mail" class="form-control" id="email" placeholder="Email Address*" required="">

						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input type="text" name="your_subject" class="form-control" placeholder="Your Subject">

						</div>
					</div>
				</div>
				<div class="form-group">
					<textarea name="your_message" class="form-control" rows="3" placeholder="Write Message*" required=""></textarea>
				</div>
				<button type="submit" class="gp-btn">SEND MESSAGE <span></span></button>
				<p class="appai-form-send-message"></p>
			</form>
		</div>
	</div>
	<!-- /.container -->
	--}}

	<div id="map">
		<div class="contact-details-two" style="transform: translate(-50%, -30%) !important;">

			<div class="contact-info-two">
				<i class="iconsmind-Smartphone"></i>
				<p>Toll-Free: 1-800-88-9811</p>
				<p>Office: 03-8882 5822</p>
				<p>Fax: 03-8882 5831</p>
			</div>

			<div class="contact-info-two">
				<i class="iconsmind-Envelope-2"></i>
				<p>
					Ministry of Domestic Trade,<br>Co-operatives and Consumerism
				</p>

			</div>

			<div class="contact-info-two">
				<i class="iconsmind-Map2"></i>
				<p>
					Aras 5, Podium 2,<br>No. 13, Persiaran Perdana,<br>Presint 2, 62623 Putrajaya
				</p>

			</div>

		</div>
	</div>
	<!-- /.contact-details-two -->
	<div class="google-map">
		<div class="gmap3-area" data-lat="2.9201384" data-lng="101.6860464" data-mrkr="{{ url('portal_res/assets/img/map-marker.png') }}">
		</div>
		<!-- /.google-map -->
	</div>
	<!-- /#map -->
</section>
<!-- /#contact-three -->
@endsection

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAssaWBjq7xp_L88KSNA6X7wVA-HxF9rtM"></script>
@endpush