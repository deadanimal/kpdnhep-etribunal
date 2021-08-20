<?php
$locale = App::getLocale();
$language_lang = "language_".$locale;
?>

{{ textInput($errors, 'text', $user, 'name', trans('new.name'), true) }}

{{ textInput($errors, 'text', $user, 'username', trans('new.user_id'), true) }}
{{--
{{ textInput($errors, 'password', $userTTPM, 'password', trans('new.password'), true) }}

{{ textInput($errors, 'password', $userTTPM, 'repeat_password', trans('new.confirm_password'), true) }} --}}

<div class="form-group form-md-line-input">
    <label for="language" class="control-label col-md-4">{{ trans('new.choice_language') }}</label>
    <div class="col-md-6">
        <div class="md-radio-inline">
        @if(!empty($masterLanguage))
        @foreach($masterLanguage AS $key => $value)
            <div class="md-radio">
                  <input id="language_{{ $key }}" name="language_id" @if($user->language->language_code == $value->language_code) checked="" @endif type="radio" value="{{ $value->language_id }}">
                  <label for="language_{{ $key }}">
                     <span></span>
                     <span class="check"></span>
                     <span class="box"></span> {{ $value->$language_lang }}
                  </label>
              </div>
        @endforeach
        @endif
        </div>
    </div>
</div>