<?php
$display_name = "display_name_".App::getLocale();
?>

{{ textInput($errors, 'tel', $findTTPMUser, 'phone_mobile', trans('new.phone_mobile'), true) }}

{{ textInput($errors, 'text', $findTTPMUser, 'identification_no', trans('new.ic'), true) }}

<!-- {{ masterSelect($errors, $roles, $findTTPMUser, 'designation_id', 'designation_id', 'designation', trans('new.designation'), true) }} -->

<!-- {{ masterSelect($errors, $master_branch, $findTTPMUser, 'branch_id', 'branch_id', 'branch_name', trans('new.branch'), true) }} -->

<!-- {{ masterSelect($errors, $roles, NULL, 'designation_type', 'id', 'display_name', 'Designation', true) }} -->

<div class="form-group form-md-line-input">
    <label class="control-label col-md-4" for="designation_id">{{trans('new.designation')}}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">
    <div class="input-icon right">

    @if(Auth::user()->hasRole('admin') || strpos(Request::url(),'create') !== false)
    <select class="form-control select2" onchange="checkPrez()" name="designation_id" id="designation_id" required="required" data-placeholder="{{ trans('dropdown.choose_designation')}}">
		<!-- <option value="" selected style="display:none;">Sila Pilih</option> -->
    	@foreach($roles AS $key => $value)
            <option @if($value->id == $role_user) selected @endif value={{$value->id}}>{{$value->$display_name}}</option>
        @endforeach
    </select>
    @else
    <input type="hidden" name="designation_id" value="{{ $role_user }}">
    <input type="text" class="form-control" disabled value="{{ $findUser ? $findUser->roleuser->first()->role->$display_name : '' }}">
    @endif

    <div class="form-control-focus"></div>
    </div>
    </div>
</div>

<div class="form-group form-md-line-input pilihcawangan">
    <label class="control-label col-md-4" for="branch_id">{{trans('new.branch')}}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">
    <div class="input-icon right">
    <select class="form-control select2" name="branch_id" id="branch_id" required="required" data-placeholder="{{ trans('dropdown.choose_branch')}}">
		<!-- <option value="" selected style="display:none;">Sila Pilih</option> -->
    	@foreach($master_branch AS $key => $value)
            <option @if($value->branch_id == $findTTPMUser->branch_id) selected @endif value={{$value->branch_id}}>{{$value->branch_name}}@if($value->is_hq == 1) {{" (HQ)"}} @endif</option>
        @endforeach
    </select>
    <div class="form-control-focus"></div>
    </div>
    </div>
</div>

<fieldset id="is_president">
    {{ textInput($errors, 'text', $findPresidentUser, 'president_code', trans('new.president_code'), true) }}

    {{ masterSelectTrans($errors, $master_salutation, $findPresidentUser, NULL, 'salutation_id', 'salutation', trans('new.salutation'), true) }}

    <div class="form-group form-md-line-input">
        <label for="president_type_permanent" id="label_is_online_transaction" class="control-label col-md-4">{{ __('new.president_type') }} :
            <span class="required"> * </span>
        </label>
        <div class="col-md-6">
            <div class="md-radio-inline">
                <div class="md-radio">
                    <input required onchange="toggleDuration()" id="president_type_permanent" name="is_appointed" class="md-checkboxbtn" checked type="radio" value="0">
                    <label for="president_type_permanent">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>{{ __('new.permanent') }}
                    </label>
                </div>
                <div class="md-radio">
                    <input required onchange="toggleDuration()" id="president_type_appointed" name="is_appointed" class="checkboxbtn" type="radio" value="1">
                    <label for="president_type_appointed">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>{{ __('new.appointed') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div id='row_duration' class="form-group form-md-line-input">
        <label for="from" id="label_is_online_transaction" class="control-label col-md-4">{{ __('new.year_duration') }} :
            <span class="required"> * </span>
        </label>
        <div class="col-md-6">
            <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy">
                <input id='from' type="text" class="form-control" name="year_start" value='{{ date("Y") }}'>
                <span class="input-group-addon"> {{ __('new.to') }} </span>
                <input id='to' type="text" class="form-control" name="year_end"> </div>
                <!-- /input-group -->
                <span class="help-block"></span>
            </div>
        </div>
    </div>

</fieldset>

{{ textInput($errors, 'tel', $findUser, 'phone_office', trans('new.phone_office'), true) }}

{{ textInput($errors, 'tel', $findUser, 'phone_fax', trans('new.phone_fax')) }}

{{ textInput($errors, 'email', $findUser, 'email', trans('new.email'), true) }}

<div class="form-group form-md-line-input"">
    <label id="label_supporting_docs" class="col-md-4 control-label">{{ __('new.signature') }}<span class="required"><!-- <i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i> --></span></label>
    <div class="col-md-6">
        <input type="file" id="signature_blob" name="signature_blob" class="dropify" data-default-file="@if($findUser->user_id)
        {{ route('general-getsignature', ['ttpm_user_id' => $findUser->user_id]) }}@endif" data-max-file-size="2M" data-allowed-file-extensions="jpeg jpg png"/>
    </div>
</div>

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