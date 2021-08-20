<?php
$menu_lang = "menu_".App::getLocale();
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Meta Data -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
	<title>e-Tribunal Portal</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('portalz/plugins/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portalz/css/app.css') }}">

	<style>
	.header-slider {
		height: 280px;
		background-color: #a5a8ac;
		background-image: url({{ asset('images/slider.jpg') }});
		background-size: cover;
		background-position: 20% center;
	}
	</style>

	@stack('css')

</head>
<body>

	<div class="header">
		<div class="header-back">
			<div class="container">
				<div class="text-right">
					<a href="#" class="{{ App::getLocale() == 'my' ? 'font-weight-bold' : '' }}" onclick="changeLang('my')">{{ __('new.lang_malay') }}</a>
					/
					<a href="#" class="{{ App::getLocale() == 'en' ? 'font-weight-bold' : '' }}" onclick="changeLang('en')">{{ __('new.lang_english') }}</a>
				</div>
			</div>
		</div>

		<div class="header-center container">
			<!-- As a link -->
			<nav class="navbar navbar-expand-lg navbar-light bg-white">
				<a class="navbar-brand" href="{{ url('portal/home') }}">
					<img class="logo-menu" src="{{ asset('images/logo_ttpm.png') }}"></img>
				</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarsExampleDefault">
					<ul class="navbar-nav mr-auto">

						@foreach($menu as $m)
						<li class="nav-item {{ $m->children->count() > 0 ? 'dropdown' : '' }}">
							<a class="nav-link {{ $m->children->count() > 0 ? 'dropdown-toggle' : '' }}" @if($m->url) href="{{ url('portal/'.$m->url) }}" @endif @if($m->children->count() > 0) id="navbarDropdownMenuLink{{ $m->menu_id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif >{{ $m->$menu_lang }}</a>

							@if($m->children->count() > 0)
							<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink{{ $m->menu_id }}">
								@foreach($m->children as $childmenu)
								<li @if($childmenu->children->count() > 0) class="dropdown-submenu" @endif>
									<a class="dropdown-item {{ $childmenu->children->count() > 0 ? 'dropdown-toggle' : '' }} " @if($childmenu->url) href="{{ url('portal/'.$childmenu->url) }}" @endif >{{ $childmenu->$menu_lang }}</a>
									@if($childmenu->children->count() > 0)
									<ul class="dropdown-menu">
										@foreach($childmenu->children as $child)
										<li><a class="dropdown-item" @if($child->url) href="{{ url('portal/'.$child->url) }}" @endif >{{ $child->$menu_lang }}</a></li>
										@endforeach
									</ul>
									@endif
								</li>
								@endforeach
							</ul>
							@endif
						</li>
						@endforeach

					</ul>
					<a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('login') }}"><i class="fa fa-user mr-1"></i> {{ __('login.login') }}</a>
				</div>
			</nav>
		</div>
	</div>

	<div class="header-slider container-fluid px-0"></div>

	@yield('content')

	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<span class="text-muted">{{ __('portal.total_visitors')}} : {{ sprintf("%06d", env("PORTAL_COUNTER")) }}<br>&copy; {{ date('Y') }} - {!! __('portal.copyright')!!}</span>
				</div>
			</div>
		</div>
	</footer>

	<!-- <div class="header-divider container-fluid px-0">
	</div> -->

	<script type="text/javascript" src="{{ asset('portalz/plugins/jquery-3.2.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portalz/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portalz/plugins/popper/umd/popper.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portalz/js/app.js') }}"></script>

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