@extends('layouts.login')

@section('content')
    {{ Form::open(['route' => 'login', 'method' => 'POST', 'class' => 'login-form']) }}
    <h3 class="form-title font-green">{{ __('login.welcome') }}</h3>

    @include('components.notification.notification', ['is_login' => 1])

    {{ loginInput($errors, 'text', 'username', trans('login.username'), 'fa fa-user mt15', trans('login.id')) }}

    {{ loginInput($errors, 'password', 'password', trans('login.password'), 'fa fa-key mt15') }}

    {{ Html::link(route('password.request'), trans('login.forgot_pass'), ['id' => 'forget-password', 'class' => 'forget-password font-sm']) }}

    <div class="form-actions">
        <button type="submit" class="btn green uppercase"><i class="fa fa-lock mr10"></i>{{ __('login.login') }}
        </button>

        <select id="languageSwitcher" class="btn btn-default dropdown-toggle pull-right">
            <option value="">{{ __('login.choose_language') }}</option>
            @foreach(['en' => trans('new.lang_english'), 'my' => trans('new.lang_malay')] AS $key => $lang)
                <option value="{{ $key }}" {{ ((Lang::getLocale()) == $key)? 'selected' : '' }}>{{ $lang }}</option>
            @endforeach
        </select>
    </div>

    <div class="create-account">
        <p>
            {{ Html::link('#modalDaftar', trans('login.register_acc'), ['id' => 'register-btn', 'class' => 'uppercase', 'data-toggle' => 'modal']) }}
        </p>
    </div>

    {{ Form::close() }}

    @include('auth.modal.modal_content')
    @include('modals.20210406')
@endsection
@section('after_scripts')
    <!-- START ENTRUST.NET SEAL CODE -->
    <script type="text/javascript">

      $(document).ready(function () {
        $('#myModalInfo').modal('show')

        // (function (d, t) {
        //   var s = d.createElement(t),
        //     options = { 'domain': '*.kpdnhep.gov.my', 'style': '16', 'container': 'entrust-net-seal' }
        //   s.src = 'https://seal.entrust.net/sealv2.js'
        //   s.async = true
        //   var scr = d.getElementsByTagName(t)[ 0 ], par = scr.parentNode
        //   par.insertBefore(s, scr)
        //   s.onload = s.onreadystatechange = function () {
        //     var rs = this.readyState
        //     if (rs) if (rs != 'complete') if (rs != 'loaded') return
        //     try {
        //       goEntrust(options)
        //     } catch (e) {
        //     }
        //   }
        // })(document, 'script')
      })


    </script>
    <!-- END ENTRUST.NET SEAL CODE -->
@endsection