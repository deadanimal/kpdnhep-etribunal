<div class="form-group form-md-line-input ">
    <label class="control-label col-md-4" for="password">{{ trans('new.password') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">
	    <div class="input-icon right">
		    <input class="form-control" id="password" name="password" type="password">
		    <div class="form-control-focus"></div>
		    <span class="font-sm help-block" style="padding-top: 10px;"></span>
		    <span class="font-sm info-block">{{ trans('new.validation_pswd') }}</span>
	    </div>
    </div>
</div>

{{ textInput($errors, 'password', NULL, 'password_confirmation', trans('new.confirm_password'), true) }}

<div class="form-group form-md-line-input ">
    <label class="control-label col-md-4" for="password">Captcha <i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">
        <div class="input-icon right">
            <div class="captcha-holder"></div>
            <div class="form-control-focus"></div>
            <span class="font-sm help-block"></span>
        </div>
    </div>
</div>