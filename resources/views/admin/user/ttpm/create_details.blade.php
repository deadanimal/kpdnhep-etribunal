<?php
$locale = App::getLocale();
$language_lang = "language_".$locale;
?>

{{ textInput($errors, 'text', $findUser, 'name', trans('new.staff_name'), true) }}

{{ textInput($errors, 'text', $findUser, 'username', trans('new.user_name'), true) }}

@if(strpos(Request::url(),'edit') === false)
{{ textInput($errors, 'password', $findUser, 'password', trans('new.password'), true) }}

{{ textInput($errors, 'password', $findUser, 'repeat_password', trans('new.confirm_password'), true) }}
@endif

<div class="form-group form-md-line-input">
    <label for="language" class="control-label col-md-4">{{ trans('new.choice_language') }}</label>
    <div class="col-md-6">
        <div class="md-radio-inline"> 
   <!--     @if($findUser->language_id == 1) {{'checked1'}} @else {{'checked2'}} @endif -->
    	@foreach($master_language AS $key => $value)
        	<div class="md-radio">
                <input id="language_{{ $key }}" name="language_id" @if(App::getLocale() == $value->language_code) checked="" @endif type="radio" value="{{ $value->language_id }}" >
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

{{ masterSelectTrans($errors, $master_user_status, $findUser, NULL, 'user_status_id', 'status', trans('new.status'), true) }}