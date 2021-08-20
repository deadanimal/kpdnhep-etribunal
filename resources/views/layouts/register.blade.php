<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
<title>{{ config('app.name', 'Laravel') }}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="" />
<meta name="author" content="" />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('before_styles')
<!-- BEGIN GLOBAL MANDATORY STYLES -->
{{ Html::style('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') }}
{{ Html::style(URL::to('/assets/global/plugins/font-awesome/css/font-awesome.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap/css/bootstrap.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')) }}
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')) }}
<!-- END PAGE LEVEL PLUGINS -->
@yield('after_styles')
<!-- BEGIN THEME GLOBAL STYLES -->
{{ Html::style(URL::to('/assets/global/css/components-md.min.css')) }}
{{ Html::style(URL::to('/assets/global/css/plugins-md.min.css')) }}
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
{{ Html::style(URL::to('/assets/layouts/layout3/css/themes/default.min.css')) }}
{{ Html::style(URL::to('/assets/layouts/layout3/css/layout.min.css')) }}
{{ Html::style(URL::to('/assets/layouts/layout/css/custom.min.css')) }}
{{ Html::style(URL::to('/css/custom.css')) }}
<!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
<style type="text/css">
.page-header {height: auto; background-color: #2D5F8B !important}
.page-header .page-header-top {height: auto;}
.page-header .page-header-top .page-logo {width: 500px;}
.logo-default {margin: 3px 3px 0px !important;}
</style>
<!-- Scripts -->
<script>
window.Laravel = <?= json_encode(['csrfToken' => csrf_token(),]); ?>
</script>
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-md">
<div class="page-wrapper">
    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
            <!-- BEGIN HEADER -->
            <div class="page-header">
                <!-- BEGIN HEADER TOP -->
                <div class="page-header-top">
                    <div class="container-fluid">
                        <!-- BEGIN LOGO -->
                        <div class="page-logo mt20">
                            <a href="{{ route('login') }}">
                                <img width="200px" src="{{ URL::to('/assets/pages/img/etribunalv2/logo-ttpm.png') }}" alt="logo" class="logo-default" />
                            </a>
                            <div class="menu-toggler sidebar-toggler hide">
                                <span></span>
                            </div>
                        </div>
                        <!-- END LOGO -->
                        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                        <a href="javascript:;" class="menu-toggler"></a>
                        <!-- END RESPONSIVE MENU TOGGLER -->
                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="top-menu mt40">
                            <ul class="nav navbar-nav pull-right">
                                
                            </ul>
                        </div>
                        <!-- END TOP NAVIGATION MENU -->
                    </div>
                </div>
                <!-- END HEADER TOP -->
                <!-- BEGIN HEADER MENU -->
                <div class="page-header-menu">
                    <div class="container">
                        <div class="hor-menu">
                            <ul class="nav navbar-nav">
                                <li class="menu-dropdown classic-menu-dropdown">
                                    <a href="{{ route('login') }}">{{ __('new.home')}}<span class="arrow"></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END HEADER MENU -->
            </div>
            <!-- END HEADER -->
        </div>
    </div>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <!-- BEGIN PAGE HEAD-->

                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="container">
                        <!-- BEGIN PAGE CONTENT INNER -->
                        @yield('content')
                        <!-- END PAGE CONTENT INNER -->
                    </div>
                    <!-- END PAGE CONTENT BODY -->
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>

                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
        </div>
    </div>
    <div class="page-wrapper-row">
        <div class="page-wrapper-bottom">
            <!-- BEGIN FOOTER -->
            <!-- BEGIN PRE-FOOTER -->
            <!-- END PRE-FOOTER -->
            <!-- BEGIN INNER FOOTER -->
            <div class="page-footer">
                <div class="container"> 2016 &copy; {{ __('login.ttpm_full') }}, {{ __('login.kpdnkk_full') }}, Malaysia. {{ __('login.rights_reserved') }}
                </div>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
            <!-- END INNER FOOTER -->
            <!-- END FOOTER -->
        </div>
    </div>
</div>
@yield('before_scripts')
<!--[if lt IE 9]>
<script src="{{ URL::to('/assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ URL::to('/assets/global/plugins/excanvas.min.js') }}"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
{{ Html::script(URL::to('/assets/global/plugins/jquery.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap/js/bootstrap.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/js.cookie.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/jquery.blockui.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')) }}
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')) }}
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
{{ Html::script(URL::to('/assets/global/scripts/app.min.js')) }}
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
{{ Html::script(URL::to('/assets/pages/scripts/ui-sweetalert.min.js')) }}
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
{{ Html::script(URL::to('/assets/layouts/layout/scripts/demo.min.js')) }}
{{ Html::script(URL::to('/assets/layouts/layout/scripts/layout.min.js')) }}
{{ Html::script(URL::to('/assets/layouts/global/scripts/quick-sidebar.min.js')) }}
<!-- END THEME LAYOUT SCRIPTS -->
{{ Html::script(URL::to('/assets/global/scripts/custom.js')) }}
@yield('after_scripts')
</body>
</html>