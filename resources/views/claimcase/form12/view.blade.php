<?php
$locale = App::getLocale();
$status_lang = "hearing_status_".$locale;
$term_lang = "term_".$locale;
?>

@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<style>

    .control-label-custom  {
        padding-top: 15px !important;
    }

</style>
@endsection

@section('content')

<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3>{{ __('new.f12_info')}}</h3>
    <span>{{ __('new.view_complete_info')}}</span>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">  {{ $claim_case->case_no }} | <small style="font-weight: normal;">{{ date('d/m/Y', strtotime($claim_case->created_at)) }}</small></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_hearing_status" data-toggle="tab" aria-expanded="true"> {{ __('new.hearing_status')}} </a>
                        </li>
                        <li class="">
                            <a href="#tab_form12" data-toggle="tab" aria-expanded="false"> {{ __('new.form')}} 12 </a>
                        </li>
                        @if($attachments) @if($attachments->count() > 0)
                        <li class="">
                            <a href="#tab_attachment" data-toggle="tab" aria-expanded="false"> {{ trans('form1.attachment_list')}} </a>
                        </li>
                        @endif @endif
                    </ul>
                    <div class="tab-content" style="padding-top: 0px;">
                        <div class="tab-pane active" id="tab_hearing_status" style="margin-top: 30px;">
                            <div class="portlet light bordered form-fit">
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal form-bordered ">
                                        <div class="form-body">

                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.hearing_status')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ $form12->form4->hearing_status->$status_lang }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.award_type')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ __('new.form')}} {{ $form12->form4->award->award_type }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.award_value')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ number_format($form12->form4->award->award_value, 2, '.', ',') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.cost')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ number_format($form12->form4->award->award_cost_value, 2, '.', ',') }}</span>
                                                </div>
                                            </div>
                                            @if($form12->form4->award->term && $form12->form4->award->award_obey_duration)
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.award_period')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ $form12->form4->award->award_obey_duration." ".$form12->form4->award->term->$term_lang }} 
                                                    @if( $form12->form4->award->award_type == 6 || $form12->form4->award->award_type == 9 )
                                                    {{ __('new.after_award_negotiation')}}
                                                    @else
                                                    {{ __('new.after_award_hearing')}}
                                                    @endif
                                                    </span>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.award_desc')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ $form12->form4->award->award_description }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.president_name')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ $form12->form4->president->name }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.awarded_to')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>
                                                        @if($form12->form4->award->award_type == 7)
                                                        {{ $claim_case_opponent->opponent_address->name }}
                                                        @else
                                                        {{ $form12->form4->case->claimant->name }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.award_date')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ date('d/m/Y', strtotime($form12->form4->award_award_date." 00:00:00")) }}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_form12" style="margin-top: 30px;">
                            <div class="portlet light bordered form-fit">
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal form-bordered ">
                                        <div class="form-body">
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.applied_by')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_purchased_date">
                                                    @if($form12->applied_by == 2)
                                                        {{ $form12->form4->case->claimant->name }}
                                                    @elseif($form12->applied_by == 3)
                                                        {{ $claim_case_opponent->opponent->name }}
                                                    @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.applied_against')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_purchased_item">
                                                        @if($form12->applied_by == 2)
                                                            {{ $claim_case_opponent->name }}
                                                        @elseif($form12->applied_by == 3)
                                                            {{ $form12->form4->case->claimant->name }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.application_date')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_purchased_brand">{{ $form12->application_date ? date('d/m/Y', strtotime($form12->application_date." 00:00:00")) : '' }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.filing_date')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_purchased_brand">{{ $form12->filing_date ? date('d/m/Y', strtotime($form12->filing_date." 00:00:00")) : '' }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.reason_of_absence')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ $form12->absence_reason }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.reason_of_unfiled')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ $form12->unfiled_reason or '-' }}</span>
                                                </div>
                                            </div>

                                            @if($form12->psu)
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.psu_assigned')}}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>{{ $form12->psu->name }}</span>
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if($attachments) @if($attachments->count() > 0)
                        <div class="tab-pane" id="tab_attachment" style="margin-top: 30px;">
                            <div class="portlet light bordered form-fit">
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal form-bordered ">
                                        <div class="form-body">

                                            <div class="form-group" style="display: flex;">
                                                <div class="col-md-12">
                                                    <span class="bold" style="align-items: stretch;">{{ trans('form1.attachment_list')}}</span>
                                                </div>
                                            </div>
                                            @foreach($attachments as $att)
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">
                                                    <a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'><i class='fa fa-download'></i> {{ trans('button.download')}}</a>
                                                </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claim_details">{{ $att->attachment_name }}</span>
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">

        <div class="portlet light bordered form-fit">
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">

                    <div class="form-group" style="display: flex;">
                        <div class="col-xs-12 font-green-sharp" style="align-items: stretch;">
                            <span class="bold">{{ trans('form1.claimant_info') }}</span>
                        </div>
                    </div>

                    <div class="form-body">
                        
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">@if( $claim_case->claimant_address->is_company == 0)
                                @if($claim_case->claimant_address->nationality_country_id != 129 )
                                {{ __('form1.passport_no') }}
                                @else
                                {{ __('form1.ic_no') }}
                                @endif
                            @else
                            {{ __('form1.company_no') }}
                            @endif</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_identification_no">{{ $claim_case->claimant_address->identification_no }}</span>
                            </div>
                        </div>
                        @if( $claim_case->claimant_address->is_company == 0 && $claim_case->claimant_address->nationality_country_id != 129 )
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.nationality') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_nationality">{{ $claim_case->claimant_address->nationality->country }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.name') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_name">{{ $claim_case->claimant_address->name }}</span>
                            </div>
                        </div>

                        <div id="show_claimant_info" onclick="toggleClaimantInfo()" style="text-align: center; font-size: small; cursor: pointer; padding: 5px;" class="bg-green-sharp font-white camelcase">{{ strtolower(trans('form1.full_info')) }}</div>

                        <div id="claimant_info" style="display:none;">

                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }}  </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_street1">{{ $claim_case->claimant_address->street_1 }}<br>{{ $claim_case->claimant_address->street_2 }}<br>{{ $claim_case->claimant_address->street_3 }}
                                    </span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_postcode">{{ $claim_case->claimant_address->postcode }}</span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_district">{{  $claim_case->claimant_address->district ? $claim_case->claimant_address->district->district : '' }}</span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_state">{{ $claim_case->claimant_address->state ? $claim_case->claimant_address->state->state : '' }}</span>
                                </div>
                            </div>
                            @if($claim_case->claimant_address->is_company == 0)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_home">{{ $claim_case->claimant_address->phone_home }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_mobile">{{ $claim_case->claimant_address->phone_mobile}}</span>
                                </div>
                            </div>
                            @endif
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_office">{{ $claim_case->claimant_address->phone_office }}</span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_fax">{{ $claim_case->claimant_address->phone_fax }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_email">{{ $claim_case->claimant_address->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="portlet light bordered form-fit">
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">

                    <div class="form-group" style="display: flex;">
                        <div class="col-xs-12 font-green-sharp" style="align-items: stretch;">
                            <span class="bold">{{ trans('form1.opponent_info') }}</span>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">@if( $claim_case_opponent->opponent_address->is_company == 0)
                                @if($claim_case_opponent->opponent_address->nationality_country_id != 129 )
                                {{ __('form1.passport_no') }}
                                @else
                                {{ __('form1.ic_no') }}
                                @endif
                            @else
                            {{ __('form1.company_no') }}
                            @endif</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_identification_no">{{  $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->identification_no : '-'}}</span>
                            </div>
                        </div>
                        @if( $claim_case_opponent->opponent_address->is_company == 0 && $claim_case_opponent->opponent_address->nationality_country_id != 129 )
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.nationality') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_nationality">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->nationality->country : ''}}</span>
                            </div>
                        </div>
                        @endif
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.name') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_name">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->name : '' }}</span>
                            </div>
                        </div>

                        <div id="show_opponent_info" onclick="toggleOpponentInfo()" style="text-align: center; font-size: small; cursor: pointer; padding: 5px;" class="bg-green-sharp font-white camelcase">{{ strtolower(__('form1.full_info')) }}</div>

                        <div id="opponent_info" style="display:none;">

                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_street1">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->street_1 : '' }}<br>{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->street_2 : '' }}<br>{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->street_3 : '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_postcode">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->postcode : '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_district">{{ $claim_case_opponent->opponent_address->district ? $claim_case_opponent->opponent_address->district->district : '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_state">{{ $claim_case_opponent->opponent_address->state ? $claim_case_opponent->opponent_address->state->state : '' }}</span>
                                </div>
                            </div>
                            @if($claim_case_opponent->opponent_address->is_company == 0)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_home">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->phone_home : '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_mobile">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->phone_mobile : '' }}</span>
                                </div>
                            </div>
                            @endif
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_office">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->phone_office : '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_fax">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->phone_fax : '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_email">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->email : '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class="col-md-12" style="text-align: center;">
        <a class='btn default' onclick='history.back()'>{{ __('button.back_to_list') }}</a>
    </div>
</div>
@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    
    $("#opponent_info").slideUp(0)
    $("#claimant_info").slideUp(0)

    function toggleOpponentInfo(){
        $("#opponent_info").slideToggle();
    }

    function toggleClaimantInfo(){
        $("#claimant_info").slideToggle();
    }

    function exportPDF(id) {
        location.href = "{{ url('') }}/form1/"+id+"/export/pdf";
    }

    function processForm1(id) {
        $("#modalDiv").load("{{ url('/') }}/form1/"+id+"/process");
    }

</script>

@endsection