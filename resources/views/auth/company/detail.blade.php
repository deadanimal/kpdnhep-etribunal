<?php
$locale = App::getLocale();
$language_lang = "language_".$locale;
?>

{{ textInput($errors, 'text', NULL, 'company_no', trans('new.company_no'), true) }}

{{ textInput($errors, 'text', NULL, 'name', trans('new.company_name'), true) }}

<div class="form-group form-md-line-input">
    <label for="language" class="control-label col-md-4">{{ trans('new.choice_language') }}</label>
    <div class="col-md-6">
        <div class="md-radio-inline"> 
    	@foreach($masterLanguage AS $key => $value)
        	<div class="md-radio">
                <input id="language_{{ $key }}" name="language_id" @if(App::getLocale() == $value->language_code) checked="" @endif type="radio" value="{{ $value->language_id }}">
                <label for="language_{{ $key }}">
                   <span></span>
                   <span class="check"></span>
                   <span class="box"></span> {{ $value->$language_lang }}
                </label>
            </div>
    	@endforeach
        </div>
    </div>
</div>