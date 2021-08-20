@extends('layouts.login')

@section('content')
{{ Form::open(['route' => 'password.email', 'method' => 'POST', 'class' => 'forget-form', 'id' => 'submitForm']) }}

    <h3 class="font-green">{{ __('reset_password_email.forgot_pass') }} </h3>

    <div class="note note-danger sbold mt20"><span class="text-danger font-sm"> {{ __('reset_password_email.enter_email') }} </span></div>

    {{ loginInput($errors, 'email', 'email', 'Email', 'fa fa-envelope mt15', trans('reset_password_email.email') ) }}

    <div class="form-actions">
        <button type="button" id="back-btn" class="btn default" onclick="location.href ='{{ route('login') }}'"><i class="fa fa-reply mr10"></i>{{ __('reset_password_email.back') }}</button>
        <button type="submit" class="btn btn-success uppercase pull-right"><i class="fa fa-paper-plane mr10"></i>{{ __('reset_password_email.next') }}</button>
    </div>

{{ Form::close() }}
@endsection