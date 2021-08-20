<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #1 for 404 page option 2" name="description" />
    <meta content="" name="author" />

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
    <!-- BEGIN THEME GLOBAL STYLES -->
    {{ Html::style(URL::to('/assets/global/css/components-md.min.css')) }}
    {{ Html::style(URL::to('/assets/global/css/plugins-md.min.css')) }}
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    {{ Html::style(URL::to('/assets/pages/css/error.min.css')) }}
    <link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}" />
    <!-- END HEAD -->
</head>

<body class=" page-404-full-page">
    <div class="row">
        <div class="col-md-12 page-404">
            <div class="number font-red" style="top: 10px;"> 500 </div>
            <div class="details">
                <h3>{{ __('error.500_header') }}</h3>
                <p>
                    {{ $exception->getMessage() ? $exception->getMessage() : __('error.500_description') }}<br>
                    {{ __('error.contact_at') }} <a style="color: #e7505a;" href="mailto:upa1helpdesk@kpdnhep.gov.my">upa1helpdesk@kpdnhep.gov.my</a>
                </p>
            </div>
        </div>
    </div>

    <!-- BEGIN CORE PLUGINS -->
    {{ Html::script(URL::to('/assets/global/plugins/jquery.min.js')) }}
    {{ Html::script(URL::to('/assets/global/plugins/bootstrap/js/bootstrap.min.js')) }}
    {{ Html::script(URL::to('/assets/global/plugins/js.cookie.min.js')) }}
    {{ Html::script(URL::to('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')) }}
    {{ Html::script(URL::to('/assets/global/plugins/jquery.blockui.min.js')) }}
    {{ Html::script(URL::to('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')) }}
    <!-- END CORE PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    {{ Html::script(URL::to('/assets/global/scripts/app.min.js')) }}
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <!-- END THEME LAYOUT SCRIPTS -->
</body>


</html>