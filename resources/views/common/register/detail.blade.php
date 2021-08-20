<?php
$locale = App::getLocale();
$language_lang = "language_".$locale;
?>

@if(Route::current()->getName() == 'public.create.citizen' || $type == 'citizen')
    {{ textInput($errors, 'text', $userPublicIndividual, 'identification_no', trans('new.ic'), true) }}
@elseif(Route::current()->getName() == 'public.create.noncitizen' || $type == 'noncitizen')
    {{ textInput($errors, 'text', $userPublicIndividual, 'identification_no', trans('new.passport'), true) }}
@else
    {{ textInput($errors, 'text', $userPublicCompany, 'company_no', trans('new.company_no'), true) }}
@endif

@if(Route::current()->getName() == 'public.create.noncitizen' || $type == 'noncitizen')
{{ masterSelect($errors, $masterCountry, $userPublicIndividual, 'nationality_country_id', 'country_id', 'country', trans('new.nationality'), true) }}
@endif

@if(Route::current()->getName() == 'public.create.company' || $type == 'company')
    {{ textInput($errors, 'text', $user, 'name', trans('new.company_name'), true) }}
@else
    {{ textInput($errors, 'text', $user, 'name', trans('new.full_name'), true) }}
@endif

<div class="form-group form-md-line-input">
    <label for="language" class="control-label col-md-4">{{ trans('new.choice_language') }}</label>
    <div class="col-md-6">
        <div class="md-radio-inline"> 
    	@foreach($masterLanguage AS $key => $value)
        	<div class="md-radio">
                <input id="language_{{ $key }}" name="language_id" @if($user) @if($user->language_id == $value->language_id) checked="" @endif @endif type="radio" value="{{ $value->language_id }}">
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


{{ masterSelectTrans($errors, $masterUserStatus, $user, NULL, 'user_status_id', 'status', trans('new.status'), true) }}