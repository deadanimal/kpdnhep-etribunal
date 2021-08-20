<?php
$locale = App::getLocale();
$language_lang = "language_".$locale;
?>

@php
$html = '<div class="col-md-2 md-checkbox-inline">
            <div class="md-checkbox">
                <input id="is_tourist" name="is_tourist" class="md-checkboxbtn" type="checkbox" value="0" required>
                <label for="is_tourist">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span> '.trans('new.is_tourist').'
                </label>
            </div>
        </div>';
@endphp

@if(Route::current()->getName() == 'citizen')
    {{ textInput($errors, 'text', NULL, 'identification_no', trans('new.ic'), true) }}
@else
    {{ textInput($errors, 'text', NULL, 'identification_no', trans('new.passport'), true) }}
@endif

@if(Route::current()->getName() != 'citizen')
<div class="form-group">
    <label for="date_of_birth" class="control-label col-md-4">{{ trans('new.dob') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-4">
        <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy">
            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" readonly>
            <span class="input-group-btn">
                <button class="btn default" type="button">
                    <i class="fa fa-calendar"></i>
                </button>
            </span>
        </div>
    </div>
</div>
{{ masterSelect($errors, $masterCountry, NULL, 'nationality_country_id', 'country_id', 'country', trans('new.nationality'), true) }}
@endif

{{ textInput($errors, 'text', NULL, 'name', trans('new.full_name'), true) }}

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