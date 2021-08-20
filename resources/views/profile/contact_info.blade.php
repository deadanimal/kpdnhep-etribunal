<?php
$locale = App::getLocale();
$method_lang = "method_".$locale;
?>

@if($userPublic->user_public_type_id != 2)
{{ textInputNumeric($errors, 'text', $userPublicIndividual, 'phone_home', trans('new.phone_home')) }}

{{ textInputNumeric($errors, 'text', $userPublicIndividual, 'phone_mobile', trans('new.phone_mobile'), true) }}
@endif
{{ textInputNumeric($errors, 'text', $user, 'phone_office', trans('new.phone_office')) }}

{{ textInputNumeric($errors, 'text', $user, 'phone_fax', trans('new.phone_fax')) }}

{{ textInput($errors, 'email', $user, 'email', trans('new.email'), true) }}

<div class="form-group form-md-line-input">
    <label for="notification" class="control-label col-md-4"> {{ trans('new.notification_method') }}</label>
    <div class="col-md-6 md-checkbox-inline">
        @if(!empty($masterNotificationMethod))
        @foreach($masterNotificationMethod AS $key => $value)
        <div class="md-checkbox">
            <input id="notification_{{ $key }}" name="notification_method_id[]" type="checkbox" value="{{ $value->notification_method_id }}" @if(!empty($userPublic->notification->notification_method_id)) @if($userPublic->notification->notification_method_id==$value->notification_method_id || $userPublic->notification->notification_method_id==3) checked @endif @endif>
            <label for="notification_{{ $key }}">
                <span></span>
                <span class="check"></span>
                <span class="box"></span> {{ $value->$method_lang }}
            </label>
        </div>
        @endforeach
        @endif
    </div>
</div>