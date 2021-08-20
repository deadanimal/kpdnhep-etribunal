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

@if($userPublicIndividual->nationality_country_id != 129 )
{{-- {{ masterSelect($errors, $masterCountry, $userPublicIndividual, 'nationality_country_id', 'country_id', 'country', trans('new.nationality'), true) }} --}}

<div class="form-group form-md-line-input">
    <label for="language" class="control-label col-md-4">{{ trans('new.nationality') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">

        <div class="input-icon right">
            <select class="form-control select2" id="nationality_country_id" name="nationality_country_id">
                @foreach($masterCountry AS $key => $value)
                    @if($value->country_id == $userPublicIndividual->nationality_country_id)
                        <option value="{{$value->country_id}}" selected>{{$value->country}}</option>
                    @else
                        <option value="{{$value->country_id}}">{{$value->country}}</option>
                    @endif
                @endforeach

            </select>

        </div>
    </div>
</div>
@endif

@if($userPublicIndividual->nationality_country_id == 129 )
    {{ textInput($errors, 'text', $userPublicIndividual, 'identification_no', trans('new.ic'), true) }}
@else
    {{ textInput($errors, 'text', $userPublicIndividual, 'identification_no', trans('new.passport'), true) }}
@endif

{{ textInput($errors, 'text', $user, 'name', trans('new.full_name'), true) }}

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