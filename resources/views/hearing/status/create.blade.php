<?php
$locale = App::getLocale();
$category_lang = "category_" . $locale;
$classification_lang = "classification_" . $locale;
$form_status_desc_lang = "form_status_desc_" . $locale;
$hearing_status_lang = "hearing_status_" . $locale;
$hearing_position_lang = "hearing_position_" . $locale;
$hearing_position_reason_lang = "hearing_position_reason_" . $locale;
$type_lang = "type_" . $locale;
$term_lang = "term_" . $locale;
?>

@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
    {{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}
    <style>

        .control-label-custom {
            padding-top: 15px !important;
        }

        legend {
            font-size: small;
        }

    </style>
@endsection

@section('content')
    <div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
        <h3>{{ __('new.set_status') }}</h3>
        <span> {{ __('home_staff.fill_in') }} </span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered form-fit">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-layers font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase"> {{$form4->case->case_no}} |
                        <small style="font-weight: normal;"> {{ date('d/m/Y', strtotime($form4->case->form1->filing_date." 00:00:00")) }} </small>
                    </span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal form-bordered ">
                        <div class="form-body">
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('new.claimant_name')}}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span>{{$form4->claimCase->claimant_address->name}}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('new.f1_filing_date')}}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span> {{ date('d/m/Y', strtotime($form4->claimCase->form1->filing_date." 00:00:00")) }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('new.f1_matured_date')}}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span>{{ date('d/m/Y', strtotime($form4->claimCase->form1->matured_date." 00:00:00")) }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('new.type_claim')}}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span> {{ $form4->claimCase->form1->classification->category->$category_lang or ''}}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('new.claim_classification')}}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span>{{ $form4->claimCase->form1->classification->$classification_lang or ''}}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('new.hearing_date')}}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span> {{ date('d/m/Y', strtotime($form4->hearing->hearing_date." 00:00:00")) }}</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(strpos(Request::url(),'update') !== false)
        {{ Form::open(['route' => 'form4-status-update-submit', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
    @else
        {{ Form::open(['route' => 'form4-status-store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
    @endif

    @if( Request::has('reason') )
        <input type="hidden" name="reason" value="{{ Request::get('reason') }}">
    @endif

    <input type="hidden" name="form4_id" value="{{ $form4->form4_id }}">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject font-green-sharp bold uppercase"> {{ __('new.status_entry')}}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"></a>
                        <a href="" class="fullscreen"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group form-md-line-input">
                        <label class="col-md-4 control-label">{{ __('new.presence_claimant')}} :
                            <span>&nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6" style="padding-top: 5px;">
                            @if( isset($form4->attendance->attendance_id) )
                                @if($form4->attendance->is_claimant_present == 1)
                                    {{ __('new.present') }}
                                @else
                                    @if($form4->attendance->representative->count() > 0)
                                        @php $oppo_rep = false @endphp
                                        @foreach($form4->attendance->representative as $rep)
                                            @if($rep->is_representing_claimant == 1  && $rep->is_present)
                                                @php $oppo_rep = true @endphp
                                                {{ __('new.present') .' - ('. __('new.representative').')' }}
                                            @endif
                                        @endforeach
                                        @if(!$oppo_rep)
                                            {{ __('new.absent') }}
                                        @endif
                                    @else {{ __('new.absent') }}
                                    @endif
                                @endif
                            @else {{ __('new.no_record_age') }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group form-md-line-input">
                        <label class="col-md-4 control-label">{{ __('new.presence_opponent')}} :
                            <span>&nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6" style="padding-top: 5px;">
                            @if( isset($form4->attendance->attendance_id) )
                                @if($form4->claimCaseOpponent && $form4->claimCaseOpponent->opponent->public_data->user_public_type_id == 1)
                                    @if($form4->attendance->is_opponent_present == 1)
                                        {{ __('new.present') }}
                                    @else
                                        @if($form4->attendance->representative->count() > 0)
                                            @php $oppo_rep = false @endphp
                                            @foreach($form4->attendance->representative as $rep)
                                                @if($rep->is_representing_claimant == 0  && $rep->is_present)
                                                    @php $oppo_rep = true @endphp
                                                    {{ __('new.present') .' - ('. __('new.representative').')' }}
                                                @endif
                                            @endforeach
                                            @if(!$oppo_rep)
                                                {{ __('new.absent') }}
                                            @endif
                                        @else
                                            {{ __('new.absent') }}
                                        @endif
                                    @endif
                                @else
                                    @if($form4->attendance->representative->count() > 0)
                                        @foreach($form4->attendance->representative as $rep)
                                            @if($rep->is_representing_claimant == 0  && $rep->is_present)
                                                {{ __('new.present') .' - ('. __('new.representative').')' }}
                                            @endif
                                        @endforeach
                                    @else
                                        {{ __('new.absent') }}
                                    @endif
                                @endif
                            @else
                                {{ __('new.no_record_age') }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group form-md-line-input">
                        <label class="col-md-4 control-label">{{ __('new.hearing_start_time')}} :
                            <span>&nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6">
                            <input type="input" class="form-control clickme" id="start_time" name="start_time"
                                   value="{{ $form4->hearing_start_time ? $form4->hearing_start_time : $form4->hearing->hearing_time }}"/>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input">
                        <label class="col-md-4 control-label">{{ __('new.hearing_end_time')}} :
                            <span> &nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6">
                            <input type="input" class="form-control clickme" id="end_time" name="end_time"
                                   value="{{ $form4->hearing_end_time ? $form4->hearing_end_time : $form4->hearing->hearing_time }}"/>
                            <span class="help-block"></span>

                        </div>
                    </div>

                    <div class="form-group form-md-line-input">
                        <label for="president" class="control-label col-md-4"> {{ __('new.president')}} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <select class="form-control select2 bs-select" id="president" name="president"
                                    data-placeholder="---">
                                <option value="" disabled selected>---</option>
                                @foreach ($presidents as $prez)
                                    <option
                                            @if( ($form4->president_user_id ? $form4->president_user_id : $form4->hearing->president_user_id) == $prez->user_id) selected
                                            @endif
                                            value="{{ $prez->user_id }}">{{ $prez->user->name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input">
                        <label class="col-md-4 control-label"> {{ __('new.f2_status')}} :
                            <span>&nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6" style="padding-top: 5px;">
                            <!-- if null, not filed-->
                            @if($form4->claimCaseOpponent && $form4->claimCaseOpponent->form2)
                                {{ $form4->claimCaseOpponent->form2->status->$form_status_desc_lang }}
                            @else
                                {{ __('new.not_filed')}}
                            @endif

                        </div>
                    </div>

                    <div class="form-group form-md-line-input">
                        <label class="col-md-4 control-label"> {{ __('new.f3_status')}} :
                            <span>&nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6" style="padding-top: 5px;">
                            <!-- if null, not filed-->
                            @if($form4->claimCaseOpponent && $form4->claimCaseOpponent->form2)
                                @if($form4->claimCaseOpponent->form2->form3_id)
                                    {{ $form4->claimCaseOpponent->form2->form3->status->$form_status_desc_lang }}
                                @else
                                    {{ __('new.not_filed')}}
                                @endif
                            @else
                                {{ __('new.not_filed')}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group form-md-line-input">
                        <label for="hearing_status"
                               class="control-label col-md-4"> {{ __('new.hearing_status')}} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input id="is_finish_yes" name="is_finish"
                                           @if($form4->hearing_status_id == 1)
                                           checked
                                           @endif
                                           class="md-checkboxbtn" type="radio" value="1"
                                           onchange="updateStatus()">
                                    <label for="is_finish_yes">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ __('new.finished')}}
                                    </label>
                                </div>
                                <div class="md-radio">
                                    <input id="is_finish_no" name="is_finish"
                                           @if($form4->hearing_status_id == 2)
                                           checked
                                           @endif
                                           class="checkboxbtn" type="radio" value="2" onchange="updateStatus()">
                                    <label for="is_finish_no">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ __('new.not_finished')}}
                                    </label>
                                </div>
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <fieldset style='padding: 0px;'>

                        <div class="form-group form-md-line-input">
                            <label for="hearing_position_id"
                                   class="control-label col-md-4">{{ __('new.position') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select id="hearing_position_id" class="form-control select2 bs-select"
                                        name="hearing_position_id"
                                        onchange="updatePosition()" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_hearing_reason" class="form-group form-md-line-input hidden">
                            <label for="hearing_position_reason_id"
                                   class="control-label col-md-4"> {{ __('new.reason') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select id="hearing_position_reason_id" class="form-control select2 bs-select"
                                        name="hearing_position_reason_id" onchange="loadHearing()"
                                        data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <!-- If status Not Finished -->
                        <div class="block_not_finished hidden">

                            <div id="row_hearing_branch" class="form-group form-md-line-input hidden">
                                <label for="branch_id" class="control-label col-md-4"> {{ __('new.branch') }} :
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6">
                                    <select onchange="loadHearing()" id="branch_id"
                                            class="form-control select2 bs-select"
                                            name="branch_id" value="1" data-placeholder="---">
                                        <option value="" disabled selected>---</option>
                                        @foreach($branches as $branch)
                                            <option
                                                    value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label for="details" class="control-label col-md-4">{{ __('new.details') }} :
                                    {{-- <span class="required"> * </span> --}}
                                </label>
                                <div class="col-md-6">
                                    <textarea id="details" name="details" class="form-control" rows="4"
                                              placeholder="">{{ $form4->hearing_details }}</textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label for="new_hearing_date"
                                       class="control-label col-md-4">{{ __('new.new_hearing_date') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <select class="form-control select2-allow-clear select2 bs-select"
                                            id="new_hearing_date"
                                            name="new_hearing_date" data-placeholder="---">
                                        <option value="" disabled selected>---</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                        </div>

                        <!-- If status Finished -->
                        <div class="block_finished hidden">
                            <div id="row_position_revoked" class="form-group form-md-line-input hidden">
                                <label for="stop_notice_date" id="label_case_created_at"
                                       class="control-label col-md-4"> {{ __('new.revoked_date') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group date" data-date-format="dd/mm/yyyy">
                                        <input class="form-control form-control-inline date-picker datepicker clickme"
                                               name="stop_notice_date" id="stop_notice_date" readonly=""
                                               data-date-format="dd/mm/yyyy"
                                               type="text" value=""/>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div id="block_award" class="hidden">

                                <div class="form-group form-md-line-input">
                                    <label for="notification"
                                           class="control-label col-md-4"> {{ __('new.display_award') }}
                                        :</label>
                                    <div class="col-md-6 md-checkbox-inline">
                                        <div class="md-checkbox">
                                            <input id="is_representative_yes" name="is_representative"
                                                   type="checkbox"
                                                   value="1"/>
                                            <label for="is_representative_yes">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{ __('new.s_yes') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="row_hearing_award" class="form-group form-md-line-input">
                                    <label for="award_type"
                                           class="control-label col-md-4">{{ __('new.award_type') }} :
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-6">
                                        <div class="md-radio-inline">
                                            <div class="md-radio is_negotiate_award">
                                                <input id="is_award_6" name="award_type" class="md-checkboxbtn"
                                                       type="radio"
                                                       value="6">
                                                <label for="is_award_6">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{ __('new.form')}} 6
                                                </label>
                                            </div>
                                            <div class="md-radio is_negotiate_award">
                                                <input id="is_award_9" name="award_type" class="checkboxbtn"
                                                       type="radio"
                                                       value="9">
                                                <label for="is_award_9">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('new.form')}} 9
                                                </label>
                                            </div>


                                            <div class="md-radio is_hearing_award">
                                                <input id="is_award_5" name="award_type" class="md-radiobtn"
                                                       type="radio"
                                                       value="5"
                                                       onchange="updateF10()">
                                                <label for="is_award_5">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('new.form')}} 5
                                                </label>
                                            </div>
                                            <div class="md-radio is_hearing_award">
                                                <input id="is_award_7" name="award_type" class="md-radiobtn"
                                                       type="radio"
                                                       value="7"
                                                       onchange="updateF10()">
                                                <label for="is_award_7">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('new.form')}} 7
                                                </label>
                                            </div>
                                            <div class="md-radio is_hearing_award">
                                                <input id="is_award_8" name="award_type" class="md-radiobtn"
                                                       type="radio"
                                                       value="8"
                                                       onchange="updateF10()">
                                                <label for="is_award_8">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('new.form')}} 8
                                                </label>
                                            </div>
                                            <div class="md-radio is_hearing_award">
                                                <input id="is_award_10" name="award_type" class="md-radiobtn"
                                                       type="radio"
                                                       value="10"
                                                       onchange="updateF10()">
                                                <label for="is_award_10">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('new.form')}} 10
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="block_f10" class="hidden">
                                    <div class="form-group form-md-line-input">
                                        <label for="f10_type_id" class="control-label col-md-4">
                                            <span>&nbsp;&nbsp;</span>
                                        </label>
                                        <div class="col-md-6">
                                            <select onchange="updateDecision()" id="f10_type_id"
                                                    class="form-control select2 bs-select"
                                                    name="f10_type_id" value="1" data-placeholder="---">
                                                <option value="" disabled selected>---</option>
                                                @foreach($f10_types as $type)
                                                    <option
                                                            value="{{ $type->f10_type_id }}">{{ $type->$type_lang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class='decision'>
                                        <div class="form-group form-md-line-input">
                                            <label for="same_president"
                                                   class="control-label col-md-4">{{ __('new.same_president') }}
                                                ? :
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <div class="md-radio-inline" id="same_president">
                                                    <div class="md-radio">
                                                        <input id="same_president_yes" name="is_president"
                                                               class="md-checkboxbtn"
                                                               type="radio" value="1"
                                                               onchange="updatePresident()" checked>
                                                        <label for="same_president_yes">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>{{ __('new.s_yes') }}
                                                        </label>
                                                    </div>
                                                    <div class="md-radio">
                                                        <input id="same_president_no" name="is_president"
                                                               class="checkboxbtn"
                                                               type="radio" value="0"
                                                               onchange="updatePresident()">
                                                        <label for="same_president_no">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>{{ __('new.s_no') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="row_president" class="form-group form-md-line-input hidden">
                                            <label for="earlier_president"
                                                   class="control-label col-md-4"> {{ __('new.new_president') }}
                                                :
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <select class="form-control select2 bs-select"
                                                        id="earlier_president"
                                                        name="earlier_president" data-placeholder="---">
                                                    <option value="" disabled selected>---</option>
                                                    @foreach ($presidents as $prez)
                                                        <option
                                                                value="{{ $prez->user_id }}">{{ $prez->user->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group form-md-line-input hidden">
                                            <label for="new_hearing_date2"
                                                   class="control-label col-md-4">{{ __('new.new_hearing_date') }}
                                                :
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <select class="form-control select2 bs-select"
                                                        id="new_hearing_date2"
                                                        name="new_hearing_date2" data-placeholder="---">
                                                    <option value="" disabled selected>---</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label for="award_value"
                                           class="control-label col-md-4">{{ __('new.award_value') }} :
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control decimal" id="award_value"
                                               name="award_value"
                                               value="@if($form4->award) {{ $form4->award->award_value }} @endif"/>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label for="cost" class="control-label col-md-4">{{ __('new.cost') }} :
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control decimal" id="cost" name="cost"
                                               value="@if($form4->award) {{ $form4->award->award_cost_value }} @endif"/>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label for="num_period"
                                           class="control-label col-md-4">{{ __('new.award_period') }} :
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-6">
                                        <div class='row'>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control numeric" id="num_period"
                                                       name="num_period"
                                                       value=" @if($form4->award) {{ $form4->award->award_obey_duration}} @endif"/>
                                            </div>
                                            <div class="col-md-6">
                                                <select id="period" class="form-control select2 bs-select"
                                                        name="period"
                                                        value="1"
                                                        data-placeholder="---">
                                                    <option value="" disabled selected>---</option>
                                                    @foreach ($terms as $term)
                                                        <option
                                                                @if($form4->award)
                                                                @if($form4->award->award_term_id ==  $term->duration_term_id )
                                                                selected
                                                                @endif
                                                                @endif
                                                                value="{{ $term->duration_term_id }}">{{ $term->$term_lang }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="is_negotiate_award hidden"
                                                       style="color: red;">{{ __('new.after_award_negotiation')}}</small>
                                                <small class="is_hearing_award hidden"
                                                       style="color: red;">{{ __('new.after_award_hearing')}}</small>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label for="award_desc"
                                           class="control-label col-md-4"> {{ __('new.award_desc')}} :
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-6">
                        <textarea unupper="unUpper" id="award_desc" name="award_desc" class="form-control" rows="2"
                                  placeholder="">@if($form4->award){{$form4->award->award_description}}@endif</textarea>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label for="award_description_en"
                                           class="control-label col-md-4"> {{ __('new.award_description_en')}} :
                                    </label>
                                    <div class="col-md-6">
                        <textarea unupper="unUpper" id="award_description_en" name="award_description_en"
                                  class="form-control" rows="2"
                                  placeholder="">@if($form4->award){{$form4->award->award_description_en}}@endif</textarea>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div id="letter_branch_address_id_div" class="form-group form-md-line-input">
                                    <label for="letter_branch_address_id"
                                           class="control-label col-md-4">
                                        {{ __('new.letter_branch_address_id') }}: <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-6">
                                        <select class="form-control select2 bs-select"
                                                id="letter_branch_address_id"
                                                name="letter_branch_address_id"
                                                data-placeholder="---">
                                            <option value="" disabled selected>---</option>
                                            @foreach ($letter_branch_addresses as $k => $letter_branch_address)
                                                <option value="{{ $k }}"> {{ $letter_branch_address }} </option>
                                            @endforeach
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div id="letter_court_id_div" class="form-group form-md-line-input">
                                    <label for="letter_court_id"
                                           class="control-label col-md-4">
                                        {{ __('new.letter_court_id') }}: <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-6">
                                        <select class="form-control select2 bs-select"
                                                id="letter_court_id"
                                                name="letter_court_id"
                                                data-placeholder="---">
                                            <option value="" disabled selected>---</option>
                                            @foreach ($letter_courts as $k => $letter_court)
                                                <option value="{{ $k }}"> {{ $letter_court }} </option>
                                            @endforeach
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label for="award_date" id="label_case_created_at"
                                           class="control-label col-md-4"> {{ __('new.award_date')}} :
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-group date" data-date-format="dd/mm/yyyy">
                                            <input class="form-control form-control-inline date-picker datepicker clickme"
                                                   name="award_date" id="award_date" readonly=""
                                                   data-date-format="dd/mm/yyyy"
                                                   type="text"
                                                   value="@if($form4->award) {{ date('d/m/Y', strtotime($form4->award->award_date)) }} @else {{ date('d/m/Y', strtotime($form4->hearing->hearing_date)) }} @endif"/>
                                        </div>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>


                    <div class="form-group form-md-line-input">
                        <label for="psus" class="control-label col-md-4"> {{ __('new.psu_assigned') }} :
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                            <select id="psus" class="form-control select2-multiple bs-select" multiple
                                    name="psus[]"
                                    data-placeholder="---">
                                @foreach ($psus as $psu)
                                    <option
                                            @foreach($form4->psus as $psu_f4)
                                            @if($psu_f4->psu_user_id == $psu->user_id)
                                            selected
                                            @endif
                                            @endforeach
                                            value="{{ $psu->user_id }}">
                                        {{ $psu->user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align: center; line-height: 80px;">
                <a id="btn_back" class="btn default button-previous" style="margin-right: 10px;"
                   href='{{ route("form4-status-list") }}'>
                    <i class="fa fa-angle-left"></i> {{ __('button.back') }}
                </a>
                <button id="btn_process" type="submit" class="btn green button-submit">{{ __('button.save') }}
                    <i class="fa fa-check"></i>
                </button>
            </div>
        </div>
    {{ Form::close() }}
    @endsection

    @section('after_scripts')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
                    type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}"
                    type="text/javascript"></script>
        {{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
        <!-- END PAGE LEVEL SCRIPTS -->
            <script type="text/javascript">

              $('#cost').on('keyup', function (e) {
                //console.log($('#claim_amount').val());
                if ($('#cost').val() > 200) {
                  swal('Opps!', "{{ __('swal.max_200') }}", 'error')
                  $('#cost').val('200')
                  e.preventDefault()
                }
              })

              $('#start_time').timepicker({ autoclose: true, minuteStep: 1 })
              $('#end_time').timepicker({ autoclose: true, minuteStep: 1 })


              var position_status1 = []
              var position_status2 = []

              // insert all positions into array based on hearing status
              @foreach($positions as $position)
              position_status{{ $position->hearing_status_id }}.push({
                'id': "{{ $position->hearing_position_id }}",
                'name': "{{ $position->$hearing_position_lang }}"
              })

              @endforeach

              function updateStatus() {

                var status = $('input[name="is_finish"]:checked').val()
                //console.log(status);
                $('#hearing_position_id').empty()

                if (status == 1) {
                  $('fieldset').removeClass('hidden')
                  $('.block_not_finished').addClass('hidden')
                  $('.block_finished').removeClass('hidden')
                  $('#row_hearing_reason').addClass('hidden')
                  $('#hearing_position_id').append('<option value="" disabled selected>---</option>')
                  $.each(position_status1, function (key, data) {
                    $('#hearing_position_id').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
                  })
                } else if (status == 2) {
                  $('fieldset').removeClass('hidden')
                  $('.block_not_finished').removeClass('hidden')
                  $('.block_finished').addClass('hidden')
                  $('#row_new_hearing_reason').removeClass('hidden')
                  $('#hearing_position_id').append('<option value="" disabled selected>---</option>')
                  $.each(position_status2, function (key, data) {
                    $('#hearing_position_id').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
                  })
                } else {
                  $('fieldset').addClass('hidden')
                }

              }

              $('#cost').on('keyup', function (e) {
                //console.log($('#claim_amount').val());
                if ($('#cost').val() > {{ config('tribunal.claim_amount') }} ) {
                  swal('Opps!', "{{ __('swal.max_25000') }}", 'error')
                  $('#cost').val({{ config('tribunal.claim_amount') }})
                  e.preventDefault()
                }
              })

              $('#award_value').on('keyup', function (e) {
                //console.log($('#claim_amount').val());
                if ($('#award_value').val() > {{ config('tribunal.claim_amount') }} ) {
                  swal('Opps!', "{{ __('swal.max_25000') }}", 'error')
                  $('#award_value').val({{ config('tribunal.claim_amount') }})
                  e.preventDefault()
                }
              })

              updateStatus()

              var reason_position1 = []
              var reason_position2 = []
              var reason_position4 = []

              // insert all reasons into array based on hearing position
              @foreach($reasons as $reason)
              reason_position{{ $reason->hearing_position_id }}.push({
                'id': "{{ $reason->hearing_position_reason_id }}",
                'name': "{{ $reason->$hearing_position_reason_lang }}"
              })

              @endforeach

              function updatePosition() {

                var position = $('#hearing_position_id').val()

                $('#hearing_position_reason_id').empty()
                $('#hearing_position_reason_id').append('<option value="" disabled selected>---</option>')

                if (position == 1) {
                  $('#row_position_revoked').addClass('hidden')
                  $('#block_f10').addClass('hidden')
                  $('#row_hearing_reason').removeClass('hidden')
                  $.each(reason_position1, function (key, data) {
                    $('#hearing_position_reason_id').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
                  })
                } else if (position == 2) {
                  $('#row_position_revoked').addClass('hidden')
                  $('#block_f10').addClass('hidden')
                  $('#row_hearing_reason').removeClass('hidden')
                  $.each(reason_position2, function (key, data) {
                    $('#hearing_position_reason_id').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
                  })
                } else if (position == 3) {
                  $('#row_position_revoked').addClass('hidden')
                  $('#row_hearing_reason').addClass('hidden')
                  $('#block_award').removeClass('hidden')
                  $('.is_negotiate_award').addClass('hidden')
                  $('.is_hearing_award').removeClass('hidden')
                } else if (position == 4) {
                  $('#row_position_revoked').addClass('hidden')
                  $('#row_hearing_reason').removeClass('hidden')
                  $('#block_award').addClass('hidden')
                  $('#block_f10').addClass('hidden')
                  $.each(reason_position4, function (key, data) {
                    $('#hearing_position_reason_id').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
                  })
                } else if (position == 5) {
                  $('#row_position_revoked').addClass('hidden')
                  $('#row_hearing_reason').addClass('hidden')
                  $('#block_award').removeClass('hidden')
                  $('.is_negotiate_award').removeClass('hidden')
                  $('#block_f10').addClass('hidden')
                  $('.is_hearing_award').addClass('hidden')
                } else if (position == 6) {
                  $('#row_hearing_reason').addClass('hidden')
                  $('#row_position_revoked').removeClass('hidden')
                  $('#block_f10').addClass('hidden')
                  $('#block_award').addClass('hidden')
                }
              }

              updatePosition()

              function updateReason() {
                var reason = $('#hearing_position_reason_id').val()

                if (reason == 9) {
                  $('#row_hearing_branch').removeClass('hidden')
                } else
                  $('#row_hearing_branch').addClass('hidden')

              }

              updateReason()

              function updateF10() {

                var hearing = $('input[name="award_type"]:checked').val()

                //console.log('award '+hearing);

                if (hearing == 10) {
                  $('#block_f10').removeClass('hidden')
                } else
                  $('#block_f10').addClass('hidden')

              }

              updateF10()

              function updatePresident() {

                var president = $('input[name="is_president"]:checked').val()

                console.log('president ' + president)

                if (president == 1)
                  $('#row_president').addClass('hidden')
                else
                  $('#row_president').removeClass('hidden')

              }

              updatePresident()

              function updateDecision() {

                var f10_type = $('#f10_type_id').val()

                if (f10_type == 1)
                  $('.decision').removeClass('hidden')
                else
                  $('.decision').addClass('hidden')

              }

              updateDecision()


              $('#submitForm').submit(function (e) {
                myBlockui()

                e.preventDefault()
                var form = $(this)
                $.ajax({
                  url: form.attr('action'),
                  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                  method: form.attr('method'),
                  data: new FormData(form[ 0 ]),
                  dataType: 'json',
                  contentType: false,
                  processData: false,
                  async: true,
                  beforeSend: function () {

                  },
                  success: function (data) {
                    if (data.status == 'ok') {
                      swal({
                          title: "{{ __('new.success') }}",
                          text: data.message,
                          type: 'success'
                        },
                        function () {
                            @if(strpos(Request::url(),'edit') !== false)
                              window.location.href = '{{ route("form4-status-update-list") }}'
                            @else
                              window.location.href = '{{ route("form4-status-update-view", ["form4_id" => $form4->form4_id]) }}'
                            @endif
                        })
                    } else {
                      var inputError = []

                      console.log(Object.keys(data.message)[ 0 ])
                      if ($('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':radio') || $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':checkbox')) {
                        var input = $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']')
                      } else {
                        var input = $('#' + Object.keys(data.message)[ 0 ])
                      }

                      $('html,body').animate(
                        { scrollTop: input.offset().top - 100 },
                        'slow', function () {
                          //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                          input.focus()
                        }
                      )

                      $.each(data.message, function (key, data) {
                        if ($('input[name=\'' + key + '\']').is(':radio') || $('input[name=\'' + key + '\']').is(':checkbox')) {
                          var input = $('input[name=\'' + key + '\']')
                        } else {
                          var input = $('#' + key)
                        }
                        var parent = input.parents('.form-group')
                        parent.removeClass('has-success')
                        parent.addClass('has-error')
                        parent.find('.help-block').html(data[ 0 ])
                        inputError.push(key)
                      })

                      $.each(form.serializeArray(), function (i, field) {
                        if ($.inArray(field.name, inputError) === -1) {
                          if ($('input[name=\'' + field.name + '\']').is(':radio') || $('input[name=\'' + field.name + '\']').is(':checkbox')) {
                            var input = $('input[name=\'' + field.name + '\']')
                          } else {
                            var input = $('#' + field.name)
                          }
                          var parent = input.parents('.form-group')
                          parent.removeClass('has-error')
                          parent.addClass('has-success')
                          parent.find('.help-block').html('')
                        }
                      })
                      $.unblockUI()
                    }
                  },
                  error: function (xhr) {
                    console.log(xhr.status)
                    $.unblockUI()
                  }
                })
                return false
              })

              function loadHearing() {

                console.log('loadHearing')

                $('#new_hearing_date').empty()
                $('#new_hearing_date').append('<option value="" disabled selected>---</option>')

                // on reason change
                // if(position sambung bicara)
                if ($('input[name="is_finish"]:checked').val() == 2) {

                  // if(reason pindah)
                  if ($('#hearing_position_reason_id').val() == 9) {
                    // check hearings based on selected branch
                    var branch = $('#branch_id').val()


                  }
                  // else
                  else {
                    // check hearings based on current branch
                    var branch = '{{ $form4->hearing->branch_id }}'
                  }

                  if (branch) {
                    var today = new Date()
                    $.get('/branch/' + branch + '/hearings?date=' + today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear())
                      .then(function (data) {
                        $.each(data, function (key, hearings) {
                          $.each(hearings, function (k, hearing) {
                            console.log(hearing)
                            if (hearing.hearing_room === null)
                              $('#new_hearing_date').append('<option value=\'' + hearing.hearing_id + '\'>' + hearing.hearing_date + ' ' + hearing.hearing_time + '</option>')
                            else
                              $('#new_hearing_date').append('<option value=\'' + hearing.hearing_id + '\'>' + hearing.hearing_date + ' ' + hearing.hearing_time + ' (' + hearing.hearing_venue + ' : ' + hearing.hearing_room + ')</option>')
                          })
                        })
                        $('#new_hearing_date').removeAttr('disabled')
                      }, function (err) {
                        console.error(err)
                      })
                  }
                }
                updateReason()
              }

              function loadHearing2() {
                console.log('loadHearing2')
                var today = new Date()
                $('#new_hearing_date2').empty()
                $('#new_hearing_date2').append('<option value="" disabled selected>---</option>')

                $.get('/branch/{{ $form4->hearing->branch_id }}/hearings?date=' + today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear())
                  .then(function (data) {
                    $.each(data, function (key, hearings) {
                      $.each(hearings, function (k, hearing) {
                        console.log(hearing)
                        if (hearing.hearing_room === null)
                          $('#new_hearing_date2').append('<option value=\'' + hearing.hearing_id + '\'>' + hearing.hearing_date + ' ' + hearing.hearing_time + '</option>')
                        else
                          $('#new_hearing_date2').append('<option value=\'' + hearing.hearing_id + '\'>' + hearing.hearing_date + ' ' + hearing.hearing_time + ' (' + hearing.hearing_venue + ' : ' + hearing.hearing_room + ')</option>')
                      })
                    })
                    $('#new_hearing_date2').removeAttr('disabled')
                  }, function (err) {
                    console.error(err)
                  })
              }

              loadHearing2()

              $(document).ready(function () {

                  @if($form4->hearing_position_id)
                  $('#hearing_position_id').val({{ $form4->hearing_position_id }}).trigger('change')
                  @endif

                  @if($form4->hearing_position_reason_id)
                  $('#hearing_position_reason_id').val({{ $form4->hearing_position_reason_id }}).trigger('change')
                  @endif

                  @if($form4->award)
                  @if($form4->award->is_display_representative == 1)
                  $('#is_representative_yes').prop('checked', true).trigger('change')
                  @endif

                  $("#is_award_{{ $form4->award->award_type }}").prop('checked', true).trigger('change')

                  @if($form4->award->f10_type_id)
                  $('#f10_type_id').val({{ $form4->award->f10_type_id }}).trigger('change')

                  @if($form4_next)
                  @if($form4->president_user_id == $form4_next->hearing->president_user_id)
                  $('#same_president_yes').prop('checked', true).trigger('change')
                $('#earlier_president').val({{ $form4_next->president_user_id ? $form4_next->president_user_id : $form4_next->hearing->president_user_id }}).trigger('change')
                  @else
                  $('#same_president_no').prop('checked', true).trigger('change')
                $('#earlier_president').val({{ $form4_next->president_user_id }}).trigger('change')
                  @endif
                  @else
                  $('#same_president_yes').prop('checked', true).trigger('change')
                  @endif
                  @endif

                  $('#award_value').val('{{ $form4->award->award_value }}')
                $('#cost').val('{{ $form4->award->award_cost_value }}')
                $('#num_period').val('{{ $form4->award->award_obey_duration }}')
                $('#period').val({{ $form4->award->award_term_id }}).trigger('change')
                $('#award_desc').val("{!! str_replace('<br>','\n', str_replace(array("\r", "\n"), '', $form4->award->award_description)) !!}")
                $('#award_date').val('{{ date("d/m/Y", strtotime($form4->award->award_date." 00:00:00")) }}')
                  @endif

                  @if($form4_next)
                  $('#branch_id').val({{ $form4_next->hearing->branch_id }}).trigger('change')
                $('#new_hearing_date').val({{ $form4_next->hearing_id }}).trigger('change')
                $('#new_hearing_date2').val({{ $form4_next->hearing_id }}).trigger('change')

                setTimeout(function () {
                  $('#new_hearing_date').val({{ $form4_next->hearing_id }}).trigger('change')
                  $('#new_hearing_date2').val({{ $form4_next->hearing_id }}).trigger('change')
                }, 3000)
                  @endif

              })
            </script>
@endsection
