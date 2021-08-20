{{ textInput($errors, 'text', NULL, 'representative_name', trans('new.full_name') , true) }}

<div class="form-group form-md-line-input">
    <label class="control-label col-md-4" for="representative_identification_type">{{ trans('new.identity_type') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">
        <div class="input-icon right">
            <select class="form-control select2" id="representative_identification_type" name="representative_identification_type" data-placeholder="{{ trans('dropdown.choose_identity_type')}}">
                <option value>{{ trans('dropdown.choose_identity_type') }}</option>
                <option value="1">{{ trans('new.ic') }}</option>
                <option value="2">{{ trans('new.passport') }}</option>
            </select>
        </div>
    </div>
</div>

{{ textInput($errors, 'text', NULL, 'representative_identification_no', trans('new.ic'), true) }}

{{ masterSelect($errors, $masterCountry, NULL, 'representative_nationality_country_id', 'country_id', 'country', trans('new.nationality'), true) }}

{{ masterSelectTrans($errors, $masterDesignation, NULL, 'representative_designation_id', 'designation_id', 'designation', trans('new.designation'), true) }}

{{ textInputNumeric($errors, 'text', NULL, 'representative_phone_home', trans('new.phone_home'), false) }}

{{ textInputNumeric($errors, 'text', NULL, 'representative_phone_mobile', trans('new.phone_mobile') , true) }}