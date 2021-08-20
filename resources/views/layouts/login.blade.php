<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8, minimum-scale=0.8"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{ Html::style('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') }}
    {{ Html::style(URL::to('/assets/global/plugins/font-awesome/css/font-awesome.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/bootstrap/css/bootstrap.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')) }}
    {{ Html::style(URL::to('/assets/global/css/components-md.min.css')) }}
    {{ Html::style(URL::to('/assets/global/css/plugins-md.min.css')) }}
    {{ Html::style(URL::to('/assets/pages/css/login.min.css')) }}
    {{ Html::style(URL::to('/css/custom.css')) }}
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <style type="text/css">
        .has-success .form-control, .has-error .form-control {
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
        }

        .has-success .form-control {
            border-color: #36c6d3 !important;
        }

        .has-error .form-control {
            border-color: #e73d4a !important;
        }

        .login .content .forget-form, .login .content .register-form {
            display: block;
        }

        .login .content {
            width: 500px;
            margin: 15px auto 10px;
        }

        .login .content .forget-password {
            font-size: 13px;
        }

        .login .content .form-actions {
            padding: 5px 30px 20px;
        }

        .login .content .forget-form .form-actions {
            padding-bottom: 10px;
        }

        .break-word {
            word-wrap: break-word;
        }

        .plr40 {
            padding: 0 40px;
        }

        .btn-md {
            width: 170px !important;
        }

        #background {
            width: 100%;
            height: 100%;
            position: fixed;
            left: 0px;
            top: 0px;
            z-index: -1; /* Ensure div tag stays behind content; -999 might work, too. */
        }

        .stretch {
            width: 100%;
            height: 100%;
        }

        .copyright {
            color: #e6ead8 !important;
        }

        @media (max-width: 768px) {
            .login .content {
                width: 90%;
                min-width: 400px;
                margin: 15px auto 10px;
            }

            .copyright {
                color: #e6ead8 !important;
            }
        }

        .control-label-custom {
            padding-top: 15px !important;
        }
    </style>
@yield('after_styles')
<!-- Scripts -->
    <script>
      window.Laravel = '{{ json_encode(['csrfToken' => csrf_token(),]) }}'
    </script>
</head>
<!-- END HEAD -->

<body class="login">
<div id="background">
    <img src="{{ url('/images/bg_login4.jpg') }}" class="stretch" alt=""/>
</div>
<!-- BEGIN LOGO -->
<div class="logo mt60">
    <a href="{{ route('login') }}">
        <img width="200px" style="display: inline-flex;"
             src="{{ URL::to('/assets/pages/img/etribunalv2/logo-ttpm.png') }}" class="mt10" alt=""/>

        <div style="display: inline-flex; text-align: left; padding-left: 20px;color: #211d70;">
            <div>
                <span style="font-size: 26px; font-weight: 700;">{{ __('login.login_title') }}</span>
                <br>
                <span>{{ __('login.ttpm_full') }}</span>
            </div>
        </div>
    </a>
</div>
<!-- END LOGO -->
<div class="content" style="background-color: #fbfbfb;">
    @yield('content')
</div>
<div style="text-align: center; color: #FFF; ">
    <a href='{{ route("portal") }}' class='label bg-dark'>
        <i class="fa fa-caret-left"></i> {{ __('login.back_to_portal') }}
    </a>
</div>
<div class="content" style="background-color: transparent;">
    <div class="row">
        <div class="col-xs-2 col-sm-1">
            <div id="entrust-net-seal"><a href="https://www.entrust.com/ssl-certificates/">SSL Certificate</a></div>
        </div>
        <div class="col-xs-10">
            <div class="copyright">{{ __('login.ttpm_full') }},<br>{{ __('login.kpdnkk_full') }}
                <br>{{trans('login.copyright')}}
                © <?= date('Y'); ?>.
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2 col-sm-1">
        </div>
        <div class="col-xs-10">
            <div class="copyright">{{ __('login.browser_compability') }}
            </div>
        </div>
    </div>
</div>
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
{{ Html::script(URL::to('/assets/global/plugins/jquery.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/jquery.hotkeys.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap/js/bootstrap.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/js.cookie.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/jquery.blockui.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')) }}
{{ Html::script(URL::to('/assets/global/scripts/app.min.js')) }}
{{ Html::script(URL::to('/assets/global/scripts/custom.js')) }}
@yield('after_scripts')
<script type="text/javascript">
  $(document).ready(function () {
    $('#languageSwitcher').change(function () {
      var locale = $(this).val()

      $.ajax({
        url: "{{ route('language-chooser') }}",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        data: { locale: locale },
        datatype: 'json',
        beforeSend: function () {

        },
        success: function (data) {

        },
        error: function (data) {

        },
        complete: function (data) {
          window.location.reload(true)
        }
      })
    })
  })

  $('#submitForm').submit(function (e) {
    e.preventDefault()
    var form = $(this)
    $.ajax({
      url: form.attr('action'),
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: form.attr('method'),
      data: new FormData(form[ 0 ]),
      dataType: 'json',
      contentType: false,
      processData: false,
      async: true,
      beforeSend: function () {
        App.blockUI({ boxed: !0 })
      },
      success: function (data) {
        if (data.status == 'ok') {
          window.onkeydown = window.onfocus = null
          App.unblockUI()

          var parent = $('#submitForm input').parents('.form-group')
          parent.removeClass('has-error')
          parent.addClass('has-success')
          parent.find('.help-block').html('')

          swal({
              title: "{{ __('new.success') }}",
              text: data.message,
              type: 'success'
            },
            function () {
              window.location.href = '{{ route('login') }}'
            })
        } else {
          App.unblockUI()
          var inputError = []

          console.log(Object.keys(data.message)[ 0 ])
          if ($('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':radio') || $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':checkbox')) {
            var input = $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']')
          } else {
            var input = $('#' + Object.keys(data.message)[ 0 ])
          }

          $('html,body').animate(
            { scrollTop: input.offset().top - 100 },
            'slow', function () {
              window.onkeydown = window.onfocus = null
              swal("{{ __('new.error') }}!", data.message[ Object.keys(data.message)[ 0 ] ], 'error')
              input.focus()
            }
          )

          $.each(data.message, function (key, data) {
            if ($('input[name=\'' + key + '\']').is(':radio') || $('input[name=\'' + key + '\']').is(':checkbox')) {
              var input = $('input[name=\'' + key + '\']')
            } else {
              var input = $('#' + key)
            }
            var parent = input.parents('.form-group')
            parent.removeClass('has-success')
            parent.addClass('has-error')
            parent.find('.help-block').html(data[ 0 ])
            inputError.push(key)
          })

          $.each(form.serializeArray(), function (i, field) {
            if ($.inArray(field.name, inputError) === -1) {
              if ($('input[name=\'' + field.name + '\']').is(':radio') || $('input[name=\'' + field.name + '\']').is(':checkbox')) {
                var input = $('input[name=\'' + field.name + '\']')
              } else {
                var input = $('#' + field.name)
              }
              var parent = input.parents('.form-group')
              parent.removeClass('has-error')
              parent.addClass('has-success')
              parent.find('.help-block').html('')
            }
          })
        }
      },
      error: function (xhr) {
        console.log(xhr.status)
      }
    })
    return false
  })
</script>
</body>
</html>