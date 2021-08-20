{{ textInput($errors, 'text', $userPublicCompany, 'representative_name', trans('new.full_name') , true) }}

<div class="form-group form-md-line-input">
    <label class="control-label col-md-4" for="representative_identification_type">{{ trans('new.identity_type') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">
        <div class="input-icon right">
            <select class="form-control select2" id="representative_identification_type" name="representative_identification_type" data-placeholder="{{ trans('new.choose_identity_type') }}">
                <option value>{{ trans('new.choose_identity_type') }}</option>
                @foreach([1 => trans('new.ic'),2 => trans('new.passport')] AS $key => $type)
                <option value="{{ $key }}" @if($userPublicCompany) @if($userPublicCompany->representative_nationality_country_id == 129 && $key == 1) selected @elseif($userPublicCompany->representative_nationality_country_id != 129 && $key == 2) selected @endif @endif>{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{ textInput($errors, 'text', $userPublicCompany, 'representative_identification_no', trans('new.ic'), true) }}

{{ masterSelect($errors, $masterCountry, $userPublicCompany, 'representative_nationality_country_id', 'country_id', 'country', trans('new.nationality'), true) }}

{{ masterSelectTrans($errors, $masterDesignation, $userPublicCompany, 'representative_designation_id', 'designation_id', 'designation', trans('new.designation'), true) }}

{{ textInputNumeric($errors, 'text', $userPublicCompany, 'representative_phone_home', trans('new.phone_home'), false) }}

{{ textInputNumeric($errors, 'text', $userPublicCompany, 'representative_phone_mobile', trans('new.phone_mobile') , true) }}

@if(strpos(Request::url(),'edit') !== false)
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
@endif