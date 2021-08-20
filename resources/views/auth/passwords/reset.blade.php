<?php

use Illuminate\Support\Facades\Session;

?>

@extends('layouts.login')

@section('content')
{{ Form::open(['route' => 'password.request', 'method' => 'POST', 'class' => 'login-form', 'id' => 'submitForm']) }}

    <h3 class="form-title font-green">{{ __('reset_password_email.pass_reset') }}</h3>

    <input type="hidden" name="token" value="{{ $token }}">

    @if(Session::has('email'))
    <input type="hidden" type="email" id="email" name="email" value="{{ Session::get('email') }}">
    @else
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9" for="email">{{ trans('new.email') }}</label>
        <div class="input-icon">
            <i class="fa fa-envelope mt15" style="color: #ccc; top: 0;"></i>
            <input class="form-control placeholder-no-fix" id="email" name="email" placeholder="{{ trans('new.email') }}" type="email">
            <div class="form-control-focus"></div>
            <span class="font-sm help-block"></span>
        </div>
    </div>
    @endif

    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9" for="password">{{ trans('new.password') }}</label>
        <div class="input-icon">
            <i class="fa fa-key mt15" style="color: #ccc; top: 0;"></i>
            <input class="form-control placeholder-no-fix" id="password" name="password" placeholder="{{ trans('new.password') }}" type="password">
            <div class="form-control-focus"></div>
            <span class="font-sm help-block" style="padding-top: 10px;"></span>
            <span class="font-sm info-block">{{ trans('new.validation_pswd') }}</span>
        </div>
    </div>

    {{ loginInput($errors, 'password', 'password_confirmation', trans('login.confirm_pass'), 'fa fa-key mt15') }}

    <div class="form-actions">
        <button type="submit" class="btn green uppercase"><i class="fa fa-refresh mr10"></i>{{ __('reset_password_email.Set_new_pass') }}</button>
    </div>

{{ Form::close() }}
@endsection
