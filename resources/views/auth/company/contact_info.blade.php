<?php
$locale = App::getLocale();
$method_lang = "method_".$locale;
?>


{{ textInputNumeric($errors, 'text', NULL, 'phone_office', trans('new.phone_office')) }}

{{ textInputNumeric($errors, 'text', NULL, 'phone_fax', trans('new.phone_fax')) }}

{{ textInput($errors, 'email', NULL, 'email', trans('new.email'), true) }}

<div class="form-group form-md-line-input hide">
    <label for="notification" class="control-label col-md-4"> {{ trans('new.notification_method') }}</label>
    <div class="col-md-6 md-checkbox-inline">

        @foreach($masterNotificationMethod AS $key => $value)
        <div class="md-checkbox">
            <input @if($value->notification_method_id == 2) checked @endif id="notification_{{ $key }}" name="notification_method_id[]" type="checkbox" value="{{ $value->notification_method_id }}">
            <label for="notification_{{ $key }}">
                <span></span>
                <span class="check"></span>
                <span class="box"></span> {{ $value->$method_lang }}
            </label>
        </div>
        @endforeach
    </div>
</div>