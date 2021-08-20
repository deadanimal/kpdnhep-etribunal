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
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
<meta name="description" content="" />
<meta name="author" content="" />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('before_styles')
<!-- BEGIN GLOBAL MANDATORY STYLES -->
{{ Html::style('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') }}
{{ Html::style(URL::to('/assets/global/plugins/font-awesome/css/font-awesome.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/flag-icon/css/flag-icon.min.css')) }}
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
{{ Html::style(URL::to('/assets/layouts/layout/css/layout.min.css')) }}
{{ Html::style(URL::to('/assets/layouts/layout/css/themes/darkblue.min.css'),['id'=>'style_color']) }}
{{ Html::style(URL::to('/assets/layouts/layout/css/custom.min.css')) }}
{{ Html::style(URL::to('/css/custom.css')) }}
<style>
.page-logo{
    width: 235px;
}

@media (min-width: @screen-sm-max) {
    .page-logo{
        width: unset;
    }
}

.page-sidebar-closed.page-sidebar-closed-hide-logo .page-header.navbar .page-logo {
    width: 235px;
}

.page-sidebar-closed.page-sidebar-closed-hide-logo .page-header.navbar .menu-toggler.sidebar-toggler {
    margin-right: 0px;
}

.tabbable-line > .nav-tabs > li.active {
    z-index: 1;
    margin-bottom: -4px !important;
}

.tabbable-line > .nav-tabs > li:hover {
    z-index: 1;
    margin-bottom: -4px !important;
}
</style>
<!-- END THEME LAYOUT STYLES -->
<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}" />
<!-- Scripts -->
<script>
window.Laravel = <?= json_encode(['csrfToken' => csrf_token(),]); ?>
</script>
</head>
<!-- END HEAD -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
    <div class="page-wrapper">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN LOGO -->
                <div class="page-logo" style="text-align: center;">
                    <a href="{{ url('/home') }}">
                        <img src="{{ url('/images/logo_ttpm.png') }}" alt="logo" class="logo_ttpm" style="margin-left: 30px; height: 40px; margin-top: 5px;">
                    </a>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <!-- END LOGO -->
                
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">

                    <ul class="nav navbar-nav pull-right">


                        <!-- BEGIN LANGUAGE DROPDOWN -->
                        <li class="dropdown" style="padding: 0px">
                            <a href="javascript:;" style="padding: 15px; color: #c6cfda; font-size: 13px;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username username-hide-on-mobile" style="font-size: 13px; text-transform: uppercase;"> {{ Config::get('app.locale') }} </span>
                                <i class="fa fa-angle-down" style="font-size: 13px;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a onclick="changeLanguage('en')" style="cursor: pointer;"><span class="flag-icon flag-icon-us"></span> {{ __('new.lang_english') }} </a>
                                </li>
                                <li>
                                    <a onclick="changeLanguage('my')" style="cursor: pointer;"><span class="flag-icon flag-icon-my"></span> {{ __('new.lang_malay') }} </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END LANGUAGE DROPDOWN -->

                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user" style="padding: 0px">
                            <a href="javascript:;" style="padding: 15px;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                @if (!Auth::guest())
                                <span class="username" style="font-weight: normal;"> 
                                    {{ Auth::user()->name }}
                                @endif
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{ url('/profile') }}">
                                        <i class="icon-user"></i> {{ __('new.my_profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a onclick="changePassword()" href="javascript:;">
                                        <i class="icon-key"></i> {{ __('new.change_password') }}
                                    </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    @impersonating
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('impersonate-leave-form').submit();">
                                            <i class="fa fa-sign-out"></i> {{ __('button.stop_impersonate') }}
                                        </a>
                                        <form id="impersonate-leave-form" action="{{ route('admin.users.impersonateLeave') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    @else
                                        <a href="{{ route('logout') }}">
                                            <i class="icon-logout"></i> {{ __('new.logout') }}
                                        </a>
                                    @endImpersonating
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            @include('layouts.sidebar')
            <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content" style="background-color: #f6f8fa">
                <!-- BEGIN PAGE HEADER-->

                
                <!-- END PAGE HEADER-->
                @yield('content')

            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner">
                {{ __('login.ttpm_full') }}, {{ __('login.kpdnkk_full') }}, Malaysia. 
                {{ __('login.copyright') }} &copy; <?= date('Y'); ?>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
    </div>
    <div id="modalDiv"></div>
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
    {{ Html::script(URL::to('/assets/global/scripts/blockui.js')) }}
@yield('after_scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('body').tooltip({
        selector: '[rel=tooltip]'
    });
});

function changeLanguage(locale){
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
};

function changePassword(){
    $("#modalDiv").load("{{ route('changepass-profile-modal') }}");
}

function openSuggestion(){
    $("#modalDiv").load("{{ route('others.suggestion.modal') }}");
}
</script>
</body>
</html>