<?php
$locale = App::getLocale();
$designation_lang = "designation_".$locale;
?>

{{ textInput($errors, 'text', $userPublicCompany, 'representative_name', trans('new.rep_name'), true) }}

<div class="form-group form-md-line-input">
    <label class="control-label col-md-4" for="representative_identification_type">{{ trans('new.identity_type') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">
        <div class="input-icon right">
            <select class="form-control select2" id="representative_identification_type" name="representative_identification_type" data-placeholder="Choose Identity Type">
                <option value>{{ trans('new.choose_identity_type') }}</option>

                <option value="1" @if($userPublicCompany->representative_nationality_country_id == 129) selected @endif>{{ trans('new.ic') }}</option>
                <option value="2" @if($userPublicCompany->representative_nationality_country_id != 129) selected @endif>{{ trans('new.passport') }}</option>
            </select>
        </div>
    </div>
</div>

@if($userPublicCompany->representative_nationality_country_id == 129)
{{ textInput($errors, 'text', $userPublicCompany, 'representative_identification_no', trans('new.ic'), true) }}
@else
{{ textInput($errors, 'text', $userPublicCompany, 'representative_identification_no', trans('new.passport'), true) }}
@endif

{{-- {{ masterSelect($errors, $masterCountry, $userPublicCompany, 'representative_nationality_country_id', 'country_id', 'country', trans('new.nationality'), true) }} --}}


<div id="row_representative_nationality_country_id" class="form-group form-md-line-input @if($userPublicCompany->representative_nationality_country_id == 129) hidden @endif">
    <label for="language" class="control-label col-md-4">{{ trans('new.nationality') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">

        <div class="input-icon right">
            <select class="form-control select2" id="representative_nationality_country_id" name="representative_nationality_country_id">
                @foreach($masterCountry AS $key => $value)
                    @if($value->country_id == $userPublicCompany->representative_nationality_country_id)
                        <option value="{{$value->country_id}}" selected>{{$value->country}}</option>
                    @else
                        <option value="{{$value->country_id}}">{{$value->country}}</option>
                    @endif
                @endforeach

            </select>

        </div>
    </div>
</div>

{{-- {{ masterSelect($errors, $masterDesignation, $userPublicCompany, 'representative_designation_id', 'designation_id', 'designation', 'Designation', true) }} --}}

<div class="form-group form-md-line-input">
    <label for="language" class="control-label col-md-4">{{ trans('new.designation') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">

        <div class="input-icon right">
            <select class="form-control select2" id="representative_designation_id" name="representative_designation_id">
                @foreach($masterDesignation AS $key => $value)
                    @if($value->designation_id == $userPublicCompany->representative_designation_id)
                        <option value="{{$value->designation_id}}" selected>{{$value->$designation_lang}}</option>
                    @else
                        <option value="{{$value->designation_id}}">{{ $value->$designation_lang }}</option>
                    @endif
                @endforeach

            </select>

        </div>
    </div>
</div>

{{ textInputNumeric($errors, 'text', $userPublicCompany, 'representative_phone_home', trans('new.phone_home'), false) }}

{{ textInputNumeric($errors, 'text', $userPublicCompany, 'representative_phone_mobile', trans('new.phone_mobile'), true) }}