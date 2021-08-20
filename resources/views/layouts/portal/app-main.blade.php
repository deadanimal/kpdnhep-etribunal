<!doctype html>
<html>

<head>
	<!-- Meta Data -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
	<meta name="theme-color" content="#ffffff">
	<title>e-Tribunal V2 - Portal</title>

	<!-- Dependency Styles -->
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/bootstrap/css/bootstrap.min.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/font-awesome/css/font-awesome.min.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/font-awesome/css/gp-icons.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/gp-icons/style.css') }}" type="text/css">
	<!-- <link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/etlinefont-bower/style.css') }}" type="text/css"> -->
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/bootstrap-star-rating/css/star-rating.min.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/swiper/css/swiper.min.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/wow/animate.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/jquery-ui/css/jquery-ui.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/revslider/css/settings.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ URL::to('portal_res/dependencies/magnific-popup/magnific-popup.css') }}" type="text/css">
	{{ Html::style(URL::to('/assets/global/plugins/flag-icon/css/flag-icon.min.css')) }}

	<!-- Site Stylesheet -->
	<link rel="stylesheet" href="{{ URL::to('portal_res/assets/css/app.css') }}" type="text/css">

	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Catamaran:100,300,400,500,600,700,800,900|Playfair+Display:400,400i,700,700i,900,900i|Poppins:100i,300,300i,400,400i,500,500i,600,700,800,900" rel="stylesheet">

	<style>
	.page-banner {
		height: 250px;
		background-position: left center !important;
	}

	.breadcrumbs-inner {
	    height: 125px;
	}

	@media (max-width: 765px) {
		.breadcrumbs-inner {
		    height: 250px;
		}
		.breadcrumbs-title {
			font-size: xx-large !important;
		}
	}

	.menu-two #discohead.fixed {
	    top: 0px;
	}
	.overlay-dark {
	    background: rgba(1, 39, 120, 0.8);
	}
	#discovery-main-menu > ul {
		padding-left: 25px;
		padding-right: 25px;
	}
	/*.blog-single {
		background-image: url('{{ url('images/bg_footer.jpg') }}');
		background-position: bottom;
		background-size: cover;
	}*/
	.copy-right {
	    padding: 15px;
	}
	.copy-right p {
	    text-align: center;
	}
	#logo, .fixed #logo {
		padding: 15px 0;
	}
	.footer-details {
		padding: 20px;
	    padding-bottom: 10px;
	}
	.menu-two .dt-header #discovery-main-menu #menu-home {
		border-right: none !important;
	}
	</style>

	@stack('css')


</head>

<body id="home-version-1" class="home-version-1 sticky-header transparent-header shop home-page menu-two" data-style="default">

	<div class="loader-wrap">
		<div class="cssload-square">
			<div>
				<div>
					<div>
						<div>
							<div></div>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div>
					<div>
						<div>
							<div></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="cssload-square cssload-two">
			<div>
				<div>
					<div>
						<div>
							<div></div>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div>
					<div>
						<div>
							<div></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.loader-wrap -->

	<a href="#main_content" data-type="section-switch" class="return-to-top">
		<i class="fa fa-chevron-up"></i>
	</a>

	<div id="main_content">

		@include('layouts.portal.header')

		<!--=========================-->
		<!--=        Banner         =-->
		<!--=========================-->
		<section class="page-banner" data-bg-image="{{ url('images/bg_header.jpg') }}" data-parallax="image">
			<div class="overlay-dark"></div>
			<div class="container">
				<div class="breadcrumbs-inner">
					<div class="breadcrumb-inner-wrap">
						<h1 class="breadcrumbs-title">@yield('title')</h1>
						<h3>@yield('subtitle')</h3>
					</div>
					<!-- /.breadcrumb-inner-wrap -->
				</div>
				<!-- /.breadcrumbs-inner -->
			</div>
			<!-- /.container -->
		</section>
		<!-- /.blog-banner -->

		@yield('content')


		{{--
			
		<!--===============================-->
		<!--=        Contact Form         =-->
		<!--===============================-->
		<section id="contact-form-three">
			<div class="style-one">
				<div class="container">
					<div class="contact-form-area">
						<div class="row">
							<div class="col-md-3">
								<div class="row">
									<div class="contact-info">
										<div class="con-details">
											<div class="con-icon">
												<i class="iconsmind-Map2"></i>
											</div>

											<p>
												129/3 Baten kha mor,<br> Chapai Nawabgonj, Bangladesh
											</p>
										</div>
										<div class="con-details">
											<div class="con-icon">
												<i class="iconsmind-Envelope-2"></i>
											</div>

											<p>
												info@yourdomain.com<br> contact@yourdomain.com
											</p>
										</div>
										<div class="con-details">
											<div class="con-icon">
												<i class="iconsmind-Smartphone"></i>
											</div>

											<p>
												Mob: +1 224 333 562<br> Mob: +1 741 223 333
											</p>
										</div>
									</div>
									<!-- /.contact-details -->
								</div>
								<!-- /.row -->
							</div>
							<!-- /.col-md-4 -->
							<div class="col-md-9">
								<div class="get-in-touch">


									<form id="gp-contact-form-three" action="http://html.gpthemes.co/avatar/mail.php" method="POST" name="appai_message_form">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<input type="text" name="your_name" class="form-control" id="name" placeholder="Your Name*" required="">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<input type="email" name="your_mail" class="form-control" id="email-two" placeholder="Email Address*" required="">

												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<input type="text" name="your_subject" class="form-control" placeholder="Your Subject">

												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<input type="text" name="your_subject" class="form-control" placeholder="Website">

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
							<!-- /.col-md-8 -->
						</div>
						<!-- /.row -->
					</div>
					<!-- /.contact-form-area -->
				</div>
				<!-- /.container -->
			</div>
			<!-- /.style-one -->

			<div class="style-two">
				<div class="container">
					<div class="gp-contact-form-two">
						<div class="section-title text-center">
							<h4>Get In Touch</h4>
							<h2>Contact Us</h2>
						</div>

						<form id="gp-contact-form-four" action="http://html.gpthemes.co/avatar/mail.php" method="POST" name="appai_message_form">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="your_name" class="form-control" id="name-two" placeholder="Your Name*" required="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="email" name="your_mail" class="form-control" id="email" placeholder="Email Address*" required="">

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="your_subject" class="form-control" placeholder="Your Subject">

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="your_subject" class="form-control" placeholder="Website">

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
			</div>
			<!-- /.style-two -->
		</section>
		<!-- /#contact-form -->

		--}}

		
	</div>
	<!-- /#site -->


	@include('layouts.portal.footer')


	<!-- Dependency Scripts -->
	<script src="{{ URL::to('portal_res/dependencies/jquery/jquery.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/isotope/isotope.pkgd.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/masonry/masonry.pkgd.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/countUp.js/countUp.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/gsap/jquery.gsap.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/gsap/TweenMax.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/gsap/TweenLite.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/typed.js/typed.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/swiper/js/swiper.jquery.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/swiperRunner/js/swiperRunner.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/jquery.appear.bas2k/jquery.appear.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/revslider/js/jquery.themepunch.revolution.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/revslider/js/jquery.themepunch.tools.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/jquery.parallax-scroll/jquery.parallax-scroll.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/twitter-fetcher/twitterFetcher.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/wow/js/wow.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/jquery.spinner/js/jquery.spinner.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/gmap3/gmap3.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/bootstrap-star-rating/js/star-rating.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/vivus/js/vivus.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/particleground/jquery.particleground.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/jquery.ripples/jquery.ripples-min.js') }}"></script>

	<script src="{{ URL::to('portal_res/assets/js/isMobile.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/assets/js/parallax.js') }}"></script>

	<!-- Revolution Slider Plugin -->

	<script src="{{ URL::to('portal_res/dependencies/revslider/js/extensions/revolution.extension.actions.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/revslider/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/revslider/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/revslider/js/extensions/revolution.extension.navigation.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/dependencies/revslider/js/extensions/revolution.extension.parallax.min.js') }}"></script>

	<!-- Site Scripts -->
	<script src="{{ URL::to('portal_res/assets/js/smooth_scroll.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/assets/js/home.min.js') }}"></script>
	<script src="{{ URL::to('portal_res/assets/js/app.js') }}"></script>

	<script>
		function changeLang(locale) {
			$.ajax({
	            url: "{{ route('language-chooser') }}",
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            type: 'POST',
	            data: {locale: locale},
	            datatype: 'json',
	            beforeSend: function(){

	            },
	            success: function(data){

	            },
	            error: function(data){

	            },
	            complete: function(data){
	                window.location.reload(true);
	            }
	        });
		}
	</script>

	@stack('js')

</body>

</html>