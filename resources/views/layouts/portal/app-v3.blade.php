<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    <!-- Add Your favicon here -->
    <!--<link rel="icon" href="img/favicon.ico">-->

    <title>e-Tribunal</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('portal_v3/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="{{ asset('portal_v3/css/animate.min.css') }}" rel="stylesheet">

    <link href="{{ asset('portal_v3/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="{{ asset('portal_v3/css/style.css') }}" rel="stylesheet">
</head>
<body id="page-top">
<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top navbar-scroll" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand m-t-xs" href="#">
                    <img src="{{ asset('images/logo_ttpm-long.png') }}" height="60px" alt="">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if($l10n == 'my')
                        <li>
                            <a class="page-scroll btn btn-xs" onclick="changeLanguage('en')" style="cursor: pointer;">
                                <img src="{{asset('images/flag-gb.png')}}" height="22px" alt=""> <small>English</small>
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="page-scroll btn btn-xs" onclick="changeLanguage('my')"
                               style="cursor: pointer;">
                                <img src="{{asset('images/flag-my.png')}}" height="22px" alt=""> <small>Bahasa
                                    Malaysia</small>
                            </a>
                        </li>
                    @endif
                    <li><a class="page-scroll" href="#page-top">{{ __('login.portal') }}</a></li>
                    <li><a class="page-scroll" href="#contact">{{ __('login.contact') }}</a></li>
                    <li>
                        <a class="btn btn-outline-success my-2 my-sm-0" style="background: -webkit-gradient(linear,left top,left bottom,from(#40C6D2),to(#40C6D2));
    background: linear-gradient(#40C6D2,#40C6D2);
    background-color: #40C6D2;
    border-color: #40C6D2;
    color: #fff; padding: 10px; margin-top: 16px" href="{{ route('login') }}"><i
                                    class="fa fa-user mr-1"></i> {{ __('login.login') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

@yield('slider')
@yield('content')

<script src="{{ asset('portal_v3/js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('portal_v3/js/pace.min.js') }}"></script>
<script src="{{ asset('portal_v3/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('portal_v3/js/classie.js') }}"></script>
<script src="{{ asset('portal_v3/js/cbpAnimatedHeader.js') }}"></script>
<script src="{{ asset('portal_v3/js/wow.min.js') }}"></script>
<script src="{{ asset('portal_v3/js/inspinia.js') }}"></script>
<script>
  function changeLanguage(l10n) {
    $.get("{{route('l10n')}}?l10n=" + l10n).then(
      function (data) {
        // console.log(data)
        window.location.reload(true)
      },
      function (err) {
        console.error(err)
      }
    )
  }
</script>

@yield('scripts')
</body>
</html>
