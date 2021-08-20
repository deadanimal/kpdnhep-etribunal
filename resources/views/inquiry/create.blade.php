<?php
$locale = App::getLocale();
$method_lang = "method_".$locale;
$category_lang = "category_".$locale;
$classification_lang = "classification_".$locale;
$feedback_lang = "feedback_".$locale;
?>

@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
{{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}
<style>

	#step_4 .control-label, .control-label-custom  {
		padding-top: 15px !important;
	}

	.clickme {
		cursor: pointer !important;
	}

    .modal-body {padding: 0px;}

</style>
@endsection

@section('content')
<!-- #start -->

<div class="m-heading-1 border-red m-bordered margin-top-10 margin-bottom-10">
    <h3>{{ __('inquiry.inquiry_notice_title') }}</h3>
    <p>{!! __('inquiry.inquiry_notice_content') !!}</p>
</div>
<!-- BEGIN PAGE TITLE-->
<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3>{{ __('inquiry.inquiry_feedback') }}</h3>
    <p>{{ __('inquiry.fill_in') }}</p>
</div>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
@php
if(!isset($is_process)){
    $is_process = 0;
}
@endphp

@if($is_process == 1)
<form class="form-horizontal" id="submit_form" role="form" method="POST" enctype="multipart/form-data" action="{{route('inquiry.updateprocess')}}">
@else
<form class="form-horizontal" id="submit_form" role="form" method="POST" enctype="multipart/form-data" action="{{route('inquiry.store')}}">
@endif
{{ csrf_field() }}
@if($is_staff and !($inquiry))
<input type="hidden" name="is_process" value="1" >
@else
<input type="hidden" name="is_process" value="{{ $is_process }}" >
@endif
@if($is_process == 0)
<div class="row">
    <div class="col-md-12 ">
        <!-- Inquiry-->
        @if($is_staff)
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('inquiry.inquiry_method') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="form-body">
                            @if($is_staff)
                            <div class="form-group form-md-line-input">
                                <label for="inquiry_method" class="control-label col-md-4"> {{ trans('inquiry.inquiry_method') }} :
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6">
                                @if($inquiry && $inquiry->inquiry_method_id == 7)
                                    <input id="inquiry_method" name="inquiry_method" type="hidden" value="7" />
                                    <input class="form-control" value="{{ __('new.sms') }}" disabled />
                                @else
                                    <select id="inquiry_method" name="inquiry_method" class="form-control select2 bs-select" data-placeholder="---">
                                        <option value="" disabled selected>---</option>
                                        @foreach ($inquiry_methods as $met)
                                            <option @if($inquiry) @if($inquiry->inquiry_method_id == $met->inquiry_method_id) selected @endif @endif value="{{ $met->inquiry_method_id }}">{{ $met->$method_lang }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                @endif
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label for="inquiry_date" class="control-label col-md-4"> {{ trans('inquiry.inquiry_date') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group date" data-date-format="dd/mm/yyyy">
                                        <input onchange="updateReview()"
                                               class="form-control form-control-inline date-picker datepicker clickme"
                                               name="inquiry_date"
                                               id="inquiry_date"
                                               readonly=""
                                               data-date-format="dd/mm/yyyy"
                                               type="text"
                                               value="@if($inquiry){{ date('d/m/Y', strtotime($inquiry->created_at)) }}@endif"
                                               data-date-end-date="0d"
                                        />
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="form-group form-md-line-input">
                                {{-- <label class="col-md-4 control-label" for="inquiry_type"> {{ trans('inquiry.inquiry_type') }} :
                                    <span> &nbsp;&nbsp;</span>
                                </label> --}}
                                <div class="col-md-6">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            {{-- <input @if($inquiry) @if($inquiry->inquiry_type_id == 1) checked @endif @endif onchange='changeInquiryType()' type="radio" id="inquiry_claim" name="inquiry_type" class="md-radiobtn" value="1" checked> --}}
                                            {{-- <label for="inquiry_claim">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{ trans('inquiry.inquiry_general') }}
                                            </label> --}}
                                        </div>

                                        @if($is_staff || (!$is_staff && Auth::user()->public_data->user_public_type_id == 1))
                                                <div class="md-radio">
                                                    {{-- <input @if($inquiry) @if($inquiry->inquiry_type_id == 2) checked @endif @endif onchange='changeInquiryType()' type="radio" id="inquiry_general" name="inquiry_type" class="md-radiobtn" value='2'> --}}
                                                    {{-- <label for="inquiry_general">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> {{ trans('inquiry.inquiry_claim') }}
                                                    </label> --}}
                                                </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        @endif
    </div>
    @if($is_staff)
    <div class="col-md-12 ">
        <!-- Opponent Details-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('inquiry.inquiry_parties') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="claimant_identification_no" class="control-label col-md-4 col-xs-12">
                                <select id="claimant_identity_type" name='claimant_identity_type' onchange="changeClaimantType()" class="bs-select form-control" data-width="60%">
                                    <option value="1">{{ trans('inquiry.ic_no') }}</option>
                                    <option value="2">{{ trans('inquiry.passport_no') }}</option>
                                    <option value="3">{{ trans('form1.company_no') }}</option>
                                </select>
                                <span>:</span>
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control" id="claimant_identification_no" name="claimant_identification_no" value="@if($inquiry) @if($inquiry->inquired_by_user_id){{ $inquiry->inquired_by->username }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_nationality" class="form-group form-md-line-input hidden">
                            <label for="claimant_nationality" class="control-label col-md-4">{{ trans('inquiry.nationality') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select class="form-control select2 bs-select" id="claimant_nationality" name="claimant_nationality"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->country_id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="name" class="control-label col-md-4">{{ trans('new.name') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name" name="name" value="@if($inquiry) @if($inquiry->inquired_by_user_id){{ $inquiry->inquired_by->name }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <!-- Opponent Contact Details-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('new.contact_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>

            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="street1" class="control-label col-md-4">{{ trans('new.street') }} :
                                <span class="required"> &nbsp;&nbsp;  </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="street1" name="street1" value="@if($inquiry) @if($inquiry->inquired_by_user_id){{ $inquiry->inquired_by->public_data->address_street_1 }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="street2" class="control-label col-md-4">
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="street2" name="street2" value="@if($inquiry) @if($inquiry->inquired_by_user_id){{ $inquiry->inquired_by->public_data->address_street_2 }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="street3" class="control-label col-md-4">
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="street3" name="street3" value="@if($inquiry) @if($inquiry->inquired_by_user_id){{ $inquiry->inquired_by->public_data->address_street_3 }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="postcode" class="control-label col-md-4">{{ trans('new.postcode') }} :
                                <span class="required"> &nbsp;&nbsp;  </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text"
                                       min="5"
                                       max="5"
                                       class="form-control numeric"
                                       id="postcode"
                                       name="postcode"
                                       value="{{ ($inquiry && $inquiry->inquired_by_user_id) ? $inquiry->inquired_by->public_data->postcode : '' }}"
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="state" class="control-label col-md-4">{{ trans('new.state') }} :
                                <span class="required"> &nbsp;&nbsp;  </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange="loadDistricts('state','district')" class="form-control select2 bs-select" id="state" name="state"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($states as $state)
                                    <option value="{{ $state->state_id }}">{{ $state->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="district" class="control-label col-md-4">{{ trans('new.district') }} :
                                <span class="required"> &nbsp;&nbsp;  </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-control">
                                        <select class="form-control select2 bs-select" id="district" name="district"  data-placeholder="---">
                                            <option value="" disabled selected>---</option>
                                        </select>
                                        <span class="help-block"></span><br>
                                    </div>
                                    <span class="input-group-btn btn-right" >
                                        <a href="{{ url('files/ref_district.pdf') }}" class="btn btn-circle">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group form-md-line-input" id="phone_home">
                            <label for="phone_home" class="control-label col-md-4">{{ trans('new.phone_home') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input type="tel" class="form-control numeric" id="phone_home" name="phone_home" value="@if($inquiry) @if($inquiry->inquired_by_user_id) @if($inquiry->inquired_by->user_public_type_id == 1) {{ $inquiry->inquired_by->public_data->individual->phone_home }}@endif @endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input" id="phone_mobile">
                            <label for="phone_mobile" class="control-label col-md-4">{{ trans('new.phone_mobile') }} :
                                <span class="required"> &nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <input type="tel" class="form-control numeric" id="phone_mobile" name="phone_mobile" value="@if($inquiry) @if($inquiry->inquired_by_user_id) @if($inquiry->inquired_by->user_public_type_id == 1){{ $inquiry->inquired_by->public_data->individual->phone_mobile }}@endif @endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input" id="phone_office">
                            <label for="phone_office" class="control-label col-md-4">{{ trans('new.phone_office') }} :
                                <span id="phone_office" class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input type="tel" class="form-control numeric" id="phone_office" name="phone_office" value="@if($inquiry) @if($inquiry->inquired_by_user_id){{ $inquiry->inquired_by->phone_office }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input" id="phone_fax">
                            <label for="phone_fax" class="control-label col-md-4">{{ trans('new.phone_fax') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input type="tel" class="form-control numeric" id="phone_fax" name="phone_fax" value="@if($inquiry) @if($inquiry->inquired_by_user_id){{ $inquiry->inquired_by->phone_fax }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="email" class="control-label col-md-4">{{ trans('new.email') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="email" name="email" value="@if($inquiry) @if($inquiry->inquired_by_user_id){{ $inquiry->inquired_by->email }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-md-12 row_claim">
        <!-- Inquiry-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('inquiry.opponent_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="opponent_identification_no" class="control-label col-md-4 col-xs-12">
                                <select id="opponent_identity_type" name='opponent_identity_type' onchange="changeOpponentType()" class="bs-select form-control" data-width="60%">
                                    <option value="1">{{ trans('inquiry.ic_no') }}</option>
                                    <option value="2">{{ trans('inquiry.passport_no') }}</option>
                                    <option value="3">{{ trans('inquiry.company_no') }}</option>
                                </select>
                                <span>:</span>
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="opponent_identification_no" name="opponent_identification_no" value="@if($inquiry) @if($inquiry->opponent_user_extra_id){{ $inquiry->opponent->identification_no }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_opponent_nationality" class="form-group form-md-line-input">
                            <label for="opponent_nationality" class="control-label col-md-4">{{ trans('new.nationality') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange="updateOpponentType()" class="form-control select2 bs-select" id="opponent_nationality" name="opponent_nationality"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->country_id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="opponent_name" class="control-label col-md-4">{{ trans('new.name') }} :
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="opponent_name" name="opponent_name" value="@if($inquiry) @if($inquiry->opponent_user_extra_id){{ $inquiry->opponent->name }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="row_inquiry_msg">
        <!-- Inquiry Info-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('inquiry.inquiry_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="inquiry_msg" class="control-label col-md-4">{{ trans('inquiry.inquiry_msg') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea id="inquiry_msg" name="inquiry_msg" class="form-control" maxlength="1000" rows="10" placeholder="">@if($inquiry) {{ $inquiry->inquiry_msg }} @endif</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 row_claim">
        <!-- Inquiry-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('inquiry.transaction_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="transaction_date" class="control-label col-md-4">{{ trans('inquiry.transaction_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input onchange="updateReview()" class="form-control form-control-inline date-picker datepicker clickme" name="transaction_date" id="transaction_date" readonly="" data-date-format="dd/mm/yyyy" type="text" value="@if($inquiry) @if($inquiry->form1_id){{ date('d/m/Y',strtotime($inquiry->form1->purchased_date)) }}@endif @endif" data-date-end-date="0d"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="purchased_item" class="control-label col-md-4">{{ trans('inquiry.purchased_used') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea onchange="updateReview()" id="purchased_item" name="purchased_item" class="form-control" rows="2" placeholder="">@if($inquiry) @if($inquiry->form1_id){{ $inquiry->form1->purchased_item_name }}@endif @endif</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="purchased_brand" class="control-label col-md-4">{{ trans('inquiry.brand_model') }} :
                                <span> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control" id="purchased_brand" name="purchased_brand" value="@if($inquiry) @if($inquiry->form1_id){{ $inquiry->form1->purchased_item_brand }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="paid_amount" class="control-label col-md-4">{{ trans('inquiry.amount_paid') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control decimal" id="paid_amount" name="paid_amount" value="@if($inquiry) @if($inquiry->form1_id){{ $inquiry->form1->purchased_amount }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="phone_no" class="control-label col-md-4">{{ trans('inquiry.phone_no') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control decimal" id="phone_no" name="phone_no" value="@if($inquiry){{ $inquiry->phone_no }}@endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="transaction_address" class="control-label col-md-4">{{ trans('inquiry.transaction_address') }} :
                            </label>
                            <div class="col-md-6">
                                <textarea onchange="updateReview()" id="transaction_address" name="transaction_address" class="form-control" rows="2" placeholder="">@if($inquiry){{ $inquiry->transaction_address }}@endif</textarea>
                                <span class="required"> ** {{ __('new.accepted') }} </span>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="transaction_postcode" class="control-label col-md-4">{{ trans('inquiry.transaction_postcode') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()"
                                       type="text"
                                       class="form-control decimal"
                                       id="transaction_postcode"
                                       name="transaction_postcode"
                                       value="{{ $inquiry ? $inquiry->transaction_postcode : '' }}"
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="transaction_state" class="control-label col-md-4">{{ trans('inquiry.transaction_state') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange="loadDistricts('transaction_state','transaction_district')" class="form-control select2 bs-select" id="transaction_state" name="transaction_state"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($states as $state)
                                    <option @if($inquiry) @if($state->state_id == $inquiry->transaction_state) selected @endif @endif value="{{ $state->state_id }}">{{ $state->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="transaction_district" class="control-label col-md-4">{{ trans('inquiry.transaction_district') }} :
                                <span class="required"> &nbsp;&nbsp;  </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-control">
                                        <select class="form-control select2 bs-select" id="transaction_district" name="transaction_district"  data-placeholder="---">
                                            <option value="" disabled selected>---</option>
                                        </select>
                                        <span class="help-block"></span><br>
                                    </div>
                                    <span class="input-group-btn btn-right" >
                                        <a href="{{ url('files/ref_district.pdf') }}" class="btn btn-circle">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 row_claim">
        <!-- Inquiry-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('inquiry.claim_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group form-md-line-input ">
                            <label for="reason" class="control-label col-md-4">{{ trans('inquiry.particular_claim') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea id="reason" name="reason" class="form-control" rows="2" placeholder="">@if($inquiry) @if($inquiry->form1_id){{ $inquiry->form1->claim_details }}@endif @endif</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="claim_amount" class="control-label col-md-4">{{ trans('inquiry.amount_claim') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control decimal" id="claim_amount" name="claim_amount" value="@if($inquiry) @if($inquiry->form1_id){{ $inquiry->form1->claim_amount }}@endif @endif"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="is_filed_on_court" class="control-label col-md-4">{{ trans('inquiry.filed_on_court') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input @if($inquiry) @if($inquiry->form1_id) @if($inquiry->form1->court_case_id) checked @endif @endif @endif onchange="updateReview()" id="is_filed_on_court_yes" name="is_filed_on_court" class="md-checkboxbtn" type="radio" value="1">
                                        <label for="is_filed_on_court_yes">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>{{ trans('inquiry.yes') }}
                                        </label>
                                    </div>
                                    <div class="md-radio">
                                        <input @if($inquiry) @if($inquiry->form1_id) @if(!$inquiry->form1->court_case_id) checked @endif @endif @else checked @endif onchange="updateReview()" id="is_filed_on_court_no" name="is_filed_on_court" class="checkboxbtn" type="radio" value="0">
                                        <label for="is_filed_on_court_no">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>{{ trans('inquiry.no') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class='is_filed' style="border: 1px solid black; padding: 0px; margin-bottom: 25px; ">
                            <div class="form-group form-md-line-input is_filed">
                                <label for="case_name" class="control-label col-md-4">{{ trans('form1.court_name') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="text" class="form-control" id="case_name" name="case_name" value="@if($inquiry) @if($inquiry->form1_id) @if($inquiry->form1->court_case_id){{$inquiry->form1->court_case->court_case_name}}@endif @endif @endif"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input is_filed">
                                <label for="case_status" class="control-label col-md-4">{{ trans('inquiry.status_case') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="text" class="form-control" id="case_status" name="case_status" value="@if($inquiry) @if($inquiry->form1_id) @if($inquiry->form1->court_case_id){{$inquiry->form1->court_case->court_case_status}}@endif @endif @endif"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input is_filed">
                                <label for="case_place" class="control-label col-md-4">{{ trans('inquiry.place_case') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="text" class="form-control" id="case_place" name="case_place" value="@if($inquiry) @if($inquiry->form1_id) @if($inquiry->form1->court_case_id){{$inquiry->form1->court_case->court_case_location}}@endif @endif @endif"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input is_filed">
                                <label for="case_created_at" class="control-label col-md-4">{{ trans('inquiry.registration_date') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                   <div class="input-group date" data-date-format="dd/mm/yyyy">
                                        <input onchange="updateReview()" class="form-control form-control-inline date-picker datepicker clickme" name="case_created_at" id="case_created_at" readonly="" data-date-format="dd/mm/yyyy" type="text" value="@if($inquiry) @if($inquiry->form1_id) @if($inquiry->form1->court_case_id){{ date('d/m/Y',strtotime($inquiry->form1->court_case->filing_date)) }}@endif @endif @endif"/>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="form-group form-md-line-input"">
                            <label class="col-md-4 control-label">{{ trans('inquiry.supporting_docs') }} :
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <div class="m-heading-1 border-green m-bordered" style="margin-bottom: 10px;">
                                    {!! __('new.dropify_msg') !!}
                                </div>
                                <div style="display: flex; flex-wrap: wrap;">
                                    <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                        <input type="file" id="attachment_1" name="attachment_1" class="dropify" @if($attachments) @if($attachments->get(0))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(0)->attachment_id, 'filename' => $attachments->get(0)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                    </div>
                                    <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                        <input type="file" id="attachment_2" name="attachment_2" class="dropify" @if($attachments) @if($attachments->get(1))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(1)->attachment_id, 'filename' => $attachments->get(1)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                    </div>
                                    <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                        <input type="file" id="attachment_3" name="attachment_3" class="dropify" @if($attachments) @if($attachments->get(2))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(2)->attachment_id, 'filename' => $attachments->get(2)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                    </div>
                                    <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                        <input type="file" id="attachment_4" name="attachment_4" class="dropify" @if($attachments) @if($attachments->get(3))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(3)->attachment_id, 'filename' => $attachments->get(3)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                    </div>
                                    <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                        <input type="file" id="attachment_5" name="attachment_5" class="dropify" @if($attachments) @if($attachments->get(4))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(4)->attachment_id, 'filename' => $attachments->get(4)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if($is_process == 1 || (!($inquiry) && $is_staff))
<div class="row">
    <div class="col-md-12 ">
        <!-- Claim-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('inquiry.inquiry_process') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        @if($inquiry && $inquiry->inquiry_no)
                        <div class="form-group form-md-line-input">
                            <label for="claim_type" class="control-label col-md-4"> {{ trans('inquiry.inquiry_no') }}:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <a value="{{route('inquiry.viewprocess', ['inquiry_id' => $inquiry->inquiry_id, 'is_process' => 1])}}" rel="tooltip" data-original-title="{{trans('button.view')}}" data-toggle="modal" class="btn btnModalPeranan" >{{ $inquiry->inquiry_no }}<i class="fa fa-search"></i></a>
                                </div>
                                <div class="col-md-6">
                                    <a rel="tooltip" data-original-title="{{trans('button.view')}}" class="btn info" data-toggle="modal" data-target="#branchModal" style="border-radius: 60px"></i><i class="fa fa-info"></i></a>
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        @endif
                        <div class="form-group form-md-line-input row_claim">
                            <label for="claim_type" class="control-label col-md-4"> {{ trans('inquiry.claim_type') }}:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select id="claim_category" name="claim_category" onchange="loadClassification()" class="form-control select2 bs-select"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->claim_category_id }}">{{ $cat->$category_lang }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input row_claim">
                            <label for="claim_classification" class="control-label col-md-4">{{ trans('inquiry.claim_classification') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select id="claim_classification" name="claim_classification" class="form-control select2 bs-select" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="feedback_type" class="control-label col-md-4">{{ trans('inquiry.feedback') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select id="feedback_type" name="feedback_type" onchange="changeFeedbackType()" class="form-control select2 bs-select"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($inquiry_feedbacks as $feed)
                                        <option value="{{ $feed->inquiry_feedback_id }}">{{ $feed->$feedback_lang }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="feedback_branch form-group form-md-line-input hidden">
                            <label for="feedback_type" class="control-label col-md-4">{{ trans('inquiry.branch') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select onchange="changeBranch()" id="feedback_branch" name="feedback_branch" class="form-control select2 bs-select"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($branches as $index => $branch)
                                        <option value="{{ $index }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!-- if feedback = cannot be filing -->
                        <div id="row_feedback_cannot_filed_reason" class="form-group form-md-line-input feedback_item hidden">
                            <label for="feedback_cannot_filed_reason" class="control-label col-md-4">{{ trans('inquiry.reason') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select id="feedback_cannot_filed_reason" name="feedback_cannot_filed_reason" onchange="changeFeedbackType()" class="form-control select2 bs-select" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    <option value="1">{{ trans('inquiry.outside_jurisdiction') }}</option>
                                    <option value="2">{{ trans('inquiry.any_other') }}</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_feedback_cannot_filed_agencies" class="form-group form-md-line-input feedback_item reason_item hidden for-staff">
                            <label for="feedback_cannot_filed_agencies" class="control-label col-md-4">{{ trans('inquiry.ext_agencies') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select onchange="changeOrganization()" id="feedback_cannot_filed_agencies" name="feedback_cannot_filed_agencies" class="form-control select2 bs-select" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($organizations as $index => $org)
                                        <option value="{{ $org->jurisdiction_organization_id }}">{{ $org->organization }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_feedback_cannot_filed_msg" class="form-group form-md-line-input">
                            <label for="inquiry_feedback_msg" class="control-label col-md-4"></label>
                            <div class="col-md-6">
                                <textarea onchange="updateReview()" id="inquiry_feedback_msg" name="inquiry_feedback_msg" class="form-control for-staff" rows="6" placeholder="">@if($inquiry){{ $inquiry->inquiry_feedback_msg }}@endif</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">
        <button onclick="history.back()" type="button" class="btn default button-previous">
            <i class="fa fa-angle-left"></i> {{ __('button.back') }}
        </button>
        @if ($is_staff)
        <button type="button" class="btn green button-submit">{{ __('button.process') }}
            <i class="fa fa-check"></i>
        </button>
        @else
        <button type="button" class="btn green button-submit">{{ __('button.submit') }}
            <i class="fa fa-check"></i>
        </button>
        @endif
    </div>
</div>

@if($is_process == 1)
<div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"> {{ trans('inquiry.inquiry_info') }} </h4>
            </div>
            <div class="modal-body" id="modalbodyperanan">
                <div style="text-align: center;"><div class="loader"></div></div>
            </div>
        </div>
    </div>
</div>
@endif
</form>

<div id="branchModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ __('new.branch')}}</h4>
        </div>
        <div class="modal-body">
            <div class="portlet light bordered form-fit">
                <div class="portlet-body form">
                    <form action="#" class="form-horizontal form-bordered ">
                        @foreach($branches as $branch)
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;"> {{ $branch->branch_code }}</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $branch->branch_name }} </span>
                            </div>
                        </div>
                        @endforeach
            {{--
            <div class="row">
                <div class="col-md-12 form">
                    <form>
                        <div class="form-body">
                            @foreach($branches as $branch)
                            <div class="form-group form-md-line-input">
                                <label class="control-label col-md-4"> {{ $branch->branch_code }} </label>
                                <div class="col-md-8">{{ $branch->branch_name }} </div>
                            </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
            --}}
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
        </div>
    </div>

  </div>
</div>

@endsection

@section('after_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

{{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}

<script type="text/javascript">
$('body').on('click', '.btnModalPeranan', function(){
    $('#modalperanan').modal('show')
        .find('#modalbodyperanan')
        .load($(this).attr('value'));
});
$('#modalperanan').on('hidden.bs.modal', function(){
    $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>');
});


@if($is_process)
@if($inquiry->inquiry_type_id == 1)
$('.row_claim').hide();
@endif
@endif
    var msg = null;
    console.log($('#feedback_type').val());
    var b = [
    @foreach ($branches as $branch)
        "{{ $branch->branch_name .'\n'. $branch->branch_address .'\n'. $branch->branch_address2 .'\n'. $branch->branch_address3 .'\n'. $branch->branch_postcode .' '. $branch->district->district .' '. $branch->state->state.'\n'. __('new.email').': '. $branch->branch_emel .'\n'. __('new.phone_office').': '. $branch->branch_office_phone }}",
    @endforeach
    ];
    function changeFeedbackMsg(){
        var address = b[15];
        if( $('#feedback_type').val() == 1 )
            $('#inquiry_feedback_msg').val("{{ __('inquiry.feedback_1') }}");

        else if( $('#feedback_type').val() == 3 )
            $('#inquiry_feedback_msg').val("{{ __('inquiry.feedback_3') }}");

        else if( $('#feedback_type').val() == 4 )
            $('#inquiry_feedback_msg').val("{{ __('inquiry.feedback_4') }}"+'\n'+ address);

        else if( $('#feedback_type').val() == 2 ) {
            if( $('#feedback_cannot_filed_reason').val() == 1 )
                $('#inquiry_feedback_msg').val("{{ __('inquiry.feedback_2') }}");
            else if( $('#feedback_cannot_filed_reason').val() == 2 )
                $('#inquiry_feedback_msg').val("{{ __('inquiry.feedback_5') }}");
            else
                $('#inquiry_feedback_msg').val('');
        }

        else
            $('#inquiry_feedback_msg').val('');

        msg = $("#inquiry_feedback_msg").val();

    }


    var b = [
    @foreach ($branches as $branch)
        "{{ $branch->branch_name .'\n'. $branch->branch_address .'\n'. $branch->branch_address2 .'\n'. $branch->branch_address3 .'\n'. $branch->branch_postcode .' '. $branch->district->district .' '. $branch->state->state.'\n'. __('new.email').': '. $branch->branch_emel .'\n'. __('new.phone_office').': '. $branch->branch_office_phone }}",
    @endforeach
    ];



    function changeBranch(){

        var branch = $("#feedback_branch").val();
        console.log(msg);
        var address = b[branch];

        $('#inquiry_feedback_msg').val( msg +'\n'+ address);
    }

    var o = [
    @foreach ($organizations as $org)
        "{{ $org->organization .'\n'. $org->org_address .'\n'. $org->org_address2 .'\n'. $org->org_address3 .'\n'. $org->org_postcode .' '. $org->district->district .' '. $org->state->state.'\n'. __('new.email').': '. $org->org_emel .'\n'. __('new.phone_office').': '. $org->org_office_phone }}",
    @endforeach
    ];

    function changeOrganization(){

        var organization = $("#feedback_cannot_filed_agencies").val() - 1;
        console.log(msg);
        var address = o[organization];

        $('#inquiry_feedback_msg').val( msg +'\n'+ address);
    }

    // function changeInquiryType(){
    //     if( $('input[name="inquiry_type"]:checked').val() == 2 ) {
    //         $(".row_claim").removeClass("hidden");
            $("#row_inquiry_msg").addClass("hidden");
    //     }
    //     else {
    //         $("#row_inquiry_msg").removeClass("hidden");
    //         $(".row_claim").addClass("hidden");
    //     }
    // }

    $('.dropify').dropify({
        messages: {
            'default': '',
            'replace': '',
            'remove': '{!! __("new.dropify_msg_remove") !!}',
            'error': '{!! __("new.dropify_msg_error") !!}'
        },
        error: {
            'fileSize': '{!! __("new.dropify_error_fileSize") !!}',
            'imageFormat': '{!! __("new.dropify_error_imageFormat") !!}'
        }
    });

    function updateReview(){
        if( $('input[name="is_filed_on_court"]:checked').val() == 0 )
            $(".is_filed").addClass("hidden");
        else
            $(".is_filed").removeClass("hidden");
    }

    function isYesNo(bin){
        if(bin == 1)
            return "Yes";
        else
            return "No";
    }

    function changeOpponentType() {
        var type_id = $("#opponent_identity_type").val();

        if(type_id == 1) // Citizen
            isOpponentCitizen();
        else if(type_id == 2) // Non-Citizen
            isOpponentNonCitizen();
        else if(type_id == 3) // Company
            isOpponentCompany();
    }

    function changeClaimantType() {
        var type_id = $("#claimant_identity_type").val();

        if(type_id == 1 || type_id == 3) // Citizen
            isClaimantCitizen();
        else if(type_id == 2) // Non-Citizen
            isClaimantNonCitizen();
    }

    function changeFeedbackType() {
        var type_id = $("#feedback_type").val();
        var reason_id = $("#feedback_cannot_filed_reason").val();

        // if(type_id == 1) // Can-Filed
        //     isFeedbackCanFiled();

        // else
        if(type_id == 2) { // Cannot-Filed
            $('#row_feedback_cannot_filed_reason').removeClass("hidden");
            $('.feedback_branch').addClass('hidden');

            if(reason_id == 1){
                $('#row_feedback_cannot_filed_agencies').removeClass("hidden");
            }
            else {
                $('#row_feedback_cannot_filed_agencies').addClass("hidden");
            }
        }
        else if(type_id == 4){
            $('.feedback_branch').addClass('hidden');
            $('#row_feedback_cannot_filed_reason').addClass("hidden");
            $('#row_feedback_cannot_filed_agencies').addClass("hidden");
        }
        else {
            $('.feedback_branch').removeClass('hidden');
            $('#row_feedback_cannot_filed_reason').addClass("hidden");
            $('#row_feedback_cannot_filed_agencies').addClass("hidden");

            /*if(reason_id == 1)
                isFeedbackOutJurisdiction();
            else
                isFeedbackOthers();*/
        }
        // else if(type_id == 3) // Refer-Branch

        //  isFeedbackReferBranch();

        // else if(type_id == 4) // Forward-SU
        //     isFeedbackForward();

        changeFeedbackMsg();
    }


    // CONDITION: Opponent
    function isOpponentCompany(){
        $("#row_opponent_nationality, #row_view_opponent_nationality").addClass("hidden");
        $("#required_opponent_phone_office").html(" * ");
        // Change required attributes as well
        $("#required_opponent_phone_mobile").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        $("#label_view_opponent_identification_no").text("Company No. :"); // Translate plz
    }

    function isOpponentCitizen(){
        $("#row_opponent_nationality, #row_view_opponent_nationality").addClass("hidden");
        $("#required_opponent_phone_office").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        $("#required_opponent_phone_mobile").html(" * ");
        // Change required attributes as well
        $("#label_view_opponent_identification_no").text("Identity Card No. :"); // Translate plz
    }

    function isOpponentNonCitizen(){
        $("#row_opponent_nationality, #row_view_opponent_nationality").removeClass("hidden");
        $("#required_opponent_phone_office").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        $("#required_opponent_phone_mobile").html(" * ");
        // Change required attributes as well
        $("#label_view_opponent_identification_no").text("Passport No. :"); // Translate plz
    }

    function isFeedbackOutJurisdiction(){
        $(".feedback_item, .reason_item").addClass("hidden");
        $("#row_feedback_cannot_filed_agencies, #row_feedback_cannot_filed_msg, #row_feedback_cannot_filed_reason").removeClass("hidden");

    }

    function isFeedbackOthers(){
        $(".feedback_item, .reason_item").addClass("hidden");
        $("#row_feedback_cannot_filed_others, #row_feedback_cannot_filed_reason").removeClass("hidden");


    }

    function isClaimantCitizen(){
        //$("#label_view_claimant_identification_no, #label_claimant_identification_no").text("__('form1.ic_no') :"); // Translate plz
        $("#row_claimant_nationality, #row_view_claimant_nationality").addClass("hidden");
    }

    function isClaimantNonCitizen(){
        //$("#label_view_claimant_passport_no, #label_claimant_passport_no").text("{{ __('form1.passport_no') }} :"); // Translate plz
        $("#row_claimant_nationality, #row_view_claimant_nationality").removeClass("hidden");
    }

    $('#claim_amount').on('keyup', function(e){
        //console.log($('#claim_amount').val());
        if( $('#claim_amount').val() > {{config('tribunal.claim_amount')}} ) {
            swal("Opps!", "{{ __('swal.max_25000') }}", "error");
            $('#claim_amount').val({{config('tribunal.claim_amount')}});
            e.preventDefault();
        }
    });

    // Initialize Condition
    isClaimantCitizen();     // Claimant
    isOpponentCitizen();     // Opponent

    // Check for opponent type conditions
    updateReview();

    function loadDistricts(state_input_id,district_input_id) {

        var state_id = $("#"+state_input_id).val();
        $('#'+district_input_id).empty();

        $.ajax({
            url: "{{ url('/') }}/state/"+state_id+"/districts",
            type: 'GET',
            datatype: 'json',
            success: function(data){
                $.each(data.state_districts, function(key, district) {
                    $('#'+district_input_id).append("<option value='" + district.district_id +"'>" + district.district + "</option>");
                });
                //updateReview();
            },
            error: function(xhr, ajaxOptions, thrownError){
                //swal("Unexpected Error!", thrownError, "error");
                //alert(thrownError);
            }
        });
    }

    $(document).ready(function () {
	    $('.button-submit').on('click',function(){
		    var idtype = $('#opponent_identity_type').val();
			var idno = $('#opponent_identification_no').val();
			
			if(idno == ""){
				if(idtype == '1'){
					alert('Sila lengkapkan Nombor IC anda');
				}else if(idtype == '2'){
					alert('Sila lengkapkan Nombor Passport anda');
				}else if(idtype == '3'){
					alert('Sila lengkapkan Nombor Syarikat anda');
				}
			}else{
				$('#submit_form').submit();
			}
		});
	
        $('[data-toggle="tooltip"]').tooltip()

        $('#transaction_postcode').on('blur', function () {
          console.log('test')
          // get data negeri n daerah from api
          $.ajax({
            url: '{{ route('postcode.detail') }}?p=' + $(this).val(),
            type: 'GET',
            success: function (data) {
              console.log('success to retrive data', data)
              $('#transaction_state').val(data.postcode.state_id).trigger('change')
              setTimeout(function () {
                $('#transaction_district').val(data.postcode.district_id).trigger('change')
              }, 1000)
            }
          })
          // repopulate data dropdown for negeri n daerah
        })

        $('#postcode').on('blur', function () {
          console.log('test')
          // get data negeri n daerah from api
          $.ajax({
            url: '{{ route('postcode.detail') }}?p=' + $(this).val(),
            type: 'GET',
            success: function (data) {
              console.log('success to retrive data', data)
              $('#state').val(data.postcode.state_id).trigger('change')
              setTimeout(function () {
                $('#district').val(data.postcode.district_id).trigger('change')
              }, 1000)
            }
          })
          // repopulate data dropdown for negeri n daerah
        })
    })
    @foreach ($categories as $category)
        var cat{{ $category->claim_category_id }} = [];
    @endforeach

    // Insert data into array
    @foreach ($classifications as $classification)
        cat{{ $classification->category_id }}.push({ "id": "{{ $classification->claim_classification_id }}", "name": "{{ $classification->$classification_lang }}" });
    @endforeach

    function loadClassification() {

        var cat = $('#claim_category').val();
        console.log(cat);
        $('#claim_classification').empty();

        @foreach ($categories as $category)
        if(cat == {{ $category->claim_category_id }}) {
            $.each(cat{{ $category->claim_category_id }}, function(key, data) {
                $('#claim_classification').append("<option value='" + data.id +"'>" + data.name + "</option>");
            });
        }
        @endforeach

        updateReview();

    }

    var file1_info = 0, file2_info = 0, file3_info = 0, file4_info = 0, file5_info = 0;
    @if($attachments)
        @if($attachments->get(0))
            file1_info = 1;
        @endif
        @if($attachments->get(1))
            file2_info = 1;
        @endif
        @if($attachments->get(2))
            file3_info = 1;
        @endif
        @if($attachments->get(3))
            file4_info = 1;
        @endif
        @if($attachments->get(4))
            file5_info = 1;
        @endif
    @endif

    // Add events. Grab the files and set them to our variable
    $('#attachment_1').on('change', function(event){
        file1_info = 2;
    });

    $('#attachment_2').on('change', function(event){
        file2_info = 2;
    });

    $('#attachment_3').on('change', function(event){
        file3_info = 2;
    });

    $('#attachment_4').on('change', function(event){
        file4_info = 2;
    });

    $('#attachment_5').on('change', function(event){
        file5_info = 2;
    });

     $('.dropify-clear').on('click', function(){
        $(this).siblings('input').trigger('change');
        console.log('remove button clicked!');
    });

    $("#submit_form").submit(function(e){

        e.preventDefault();
        myBlockui()
        var form = $(this);
        var data = new FormData(form[0]);
        data.append('file1_info', file1_info);
        data.append('file2_info', file2_info);
        data.append('file3_info', file3_info);
        data.append('file4_info', file4_info);
        data.append('file5_info', file5_info);
        data.append('inquiry_id', '@if($inquiry){{$inquiry->inquiry_id}}@endif');

        $.ajax({
            url: form.attr('action'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: form.attr('method'),
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            beforeSend: function() {

            },
            success: function(data) {
                $.unblockUI();
                if(data.status=='ok'){
                    swal({
                        title: "{{ __('new.success') }}",
                        text: "{{ trans('inquiry.inquiry_no') }} : "+data.inquiry_no,
                        type: "success"
                    },
                    function () {
                        //location.href = "{{ route('home') }}";
                        location.href = "{{ route('onlineprocess.inquiry') }}";
                    });
                } else {
                    var inputError = [];

                    console.log(Object.keys(data.message)[0]);
                    if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
                        var input = $("input[name='"+Object.keys(data.message)[0]+"']");
                    } else {
                        var input = $('#'+Object.keys(data.message)[0]);
                    }

                    $('html,body').animate(
                        {scrollTop: input.offset().top - 100},
                        'slow', function() {
                            swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                            input.focus();
                        }
                    );

                    $.each(data.message,function(key, data){
                        if($("input[name='"+key+"']").is(':radio') || $("input[name='"+key+"']").is(':checkbox')){
                            var input = $("input[name='"+key+"']");
                        } else {
                            var input = $('#'+key);
                        }
                        var parent = input.parents('.form-group');
                        parent.removeClass('has-success');
                        parent.addClass('has-error');
                        parent.find('.help-block').html(data[0]);
                        inputError.push(key);
                    });

                    $.each(form.serializeArray(), function(i, field) {
                        if ($.inArray(field.name, inputError) === -1)
                        {
                            if($("input[name='"+field.name+"']").is(':radio') || $("input[name='"+field.name+"']").is(':checkbox')){
                                var input = $("input[name='"+field.name+"']");
                            } else {
                                var input = $('#'+field.name);
                            }
                            var parent = input.parents('.form-group');
                            parent.removeClass('has-error');
                            parent.addClass('has-success');
                            parent.find('.help-block').html('');
                        }
                    });
                }
            },
            error: function(xhr){
                console.log(xhr.status);
            }
        });
        return false;
    });

    @if($inquiry)
        @if($inquiry->inquired_by_user_id)
            @if($inquiry->inquired_by->public_data->user_public_type_id == 1)
                @if($inquiry->inquired_by->public_data->individual->nationality_country_id == 129)
                    $("#claimant_identity_type").val(1).trigger('change');
                @else
                    $("#claimant_identity_type").val(2).trigger('change');
                @endif

                $("#claimant_nationality").val({{ $inquiry->inquired_by->public_data->individual->nationality_country_id }}).trigger('change');
            @else
                $("#claimant_identity_type").val(3).trigger('change');
            @endif
        @endif

        @if($inquiry->opponent_user_extra_id)
            @if($inquiry->opponent->relationship_id == 3)
                $("#opponent_identity_type").val(3).trigger('change');
            @elseif($inquiry->opponent->nationality_country_id == 129)
                $("#opponent_identity_type").val(1).trigger('change');
            @else
                $("#opponent_identity_type").val(2).trigger('change');
            @endif

            $("#opponent_nationality").val({{ $inquiry->opponent->nationality_country_id }}).trigger('change');
        @endif

        @if($inquiry->inquired_by_user_id)
        @if($inquiry->inquired_by->public_data->address_state_id)
            $("#state").val({{ $inquiry->inquired_by->public_data->address_state_id }}).trigger('change');
        @endif
        @endif

        @if($inquiry->inquiry_feedback_id)
            $("#feedback_type").val({{ $inquiry->inquiry_feedback_id }}).trigger('change');

            @if($inquiry->jurisdiction_organization_id)
                $("#feedback_cannot_filed_reason").val(1).trigger('change');
                $("#feedback_type").val({{ $inquiry->jurisdiction_organization_id }}).trigger('change');
            @else
                $("#feedback_cannot_filed_reason").val(2).trigger('change');
            @endif
        @endif

        @if($inquiry->form1_id)
        @if(!empty($inquiry->form1->claim_classification_id))
            $("#claim_category").val({{$inquiry->form1->classification->category_id}}).trigger('change');
            $("#claim_classification").val({{$inquiry->form1->claim_classification_id}}).trigger('change');
        @endif
        @endif

    @endif
</script>
@endsection