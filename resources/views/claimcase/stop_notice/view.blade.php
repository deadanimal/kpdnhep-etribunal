<?php
$locale = App::getLocale();
$method_lang = "stop_method_".$locale;
$reason_lang = "stop_reason_".$locale;
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

<div class="m-heading-1 border-green m-bordered margin-top-10">
    <h3>{{ __('notice_discontinuance.info_stop')}} </h3>
    <span> {{ __('notice_discontinuance.view_stop')}} </span>
</div>
<div class="row">
    <div class="col-xs-12" style="text-align: right;">
        <div id='buttonDiv' class="btn-group">
            @if($stop_notice->form_status_id == 27 )
            <div class="btn-group pull-right">
                <a class="btn yellow btn-outline" href="javascript:;" style='margin-bottom: 10px; margin-left: 5px;' data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-download"></i> {{ __('button.download').' '.__('new.stop_notice') }}
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:;" onclick="exportPDF('{{ $stop_notice->stop_notice_id }}', 'notice')">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" onclick="exportDOCX('{{ $stop_notice->stop_notice_id }}', 'notice')">
                            <i class="fa fa-file-pdf-o"></i> DOCX
                        </a>
                    </li>
                </ul>
            </div>
             <div class="btn-group pull-right">
                <a class="btn yellow btn-outline" href="javascript:;" style='margin-bottom: 10px; margin-left: 5px;' data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-download"></i> {{ __('button.download').' '.__('new.letter') }}
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:;" onclick="exportPDF('{{ $stop_notice->stop_notice_id }}', 'letter')">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" onclick="exportDOCX('{{ $stop_notice->stop_notice_id }}', 'letter')">
                            <i class="fa fa-file-pdf-o"></i> DOCX
                        </a>
                    </li>
                </ul>
            </div>
            @endif     
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">  {{ $stop_notice->case->case_no }} | <small style="font-weight: normal;">{{ date('d/m/Y', strtotime($stop_notice->case->form1->filing_date)) }} </small></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                        <a href="#tab_stop_notice" data-toggle="tab" aria-expanded="true">{{ __('notice_discontinuance.stop_notice')}} </a>
                        </li>
                        @if($stop_notice->form_status_id == 27)
                        <li>
                        <a href="#tab_process" data-toggle="tab" aria-expanded="true">{{ __('notice_discontinuance.process_info')}} </a>
                        </li>
                        @endif
                        @if($attachments) @if($attachments->count() > 0)
                        <li class="">
                            <a href="#tab_attachment" data-toggle="tab" aria-expanded="false"> {{ trans('form1.attachment_list')}} </a>
                        </li>
                        @endif @endif
                    </ul>
                    <div class="tab-content" style="padding-top: 0px;">
                        <div class="tab-pane active" id="tab_stop_notice" style="margin-top: 30px;">
                            <div class="portlet light bordered form-fit">
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal form-bordered ">
                                        <div class="form-body">
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;"> {{ __('notice_discontinuance.apply_method')}} </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>
                                                        {{ $stop_notice->method->$method_lang }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;"> {{ __('notice_discontinuance.reason')}} </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>
                                                        {{ $stop_notice->reason->$reason_lang }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('notice_discontinuance.additional_reason')}} </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span> {{ $stop_notice->stop_notice_reason_desc }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('notice_discontinuance.date_stop_notice')}}  </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>
                                                        {{ date('d/m/Y', strtotime($stop_notice->stop_notice_date)) }}
                                                    </span>
                                                </div>
                                            </div>
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
                        @if($stop_notice->form_status_id == 27)
                        <div class="tab-pane" id="tab_process" style="margin-top: 30px;">
                            <div class="portlet light bordered form-fit">
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal form-bordered ">
                                        <div class="form-body">
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;"> {{ __('notice_discontinuance.process_date')}} </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>
                                                        {{ date('d/m/Y', strtotime($stop_notice->processed_at)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('notice_discontinuance.process_by')}} </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span>
                                                        {{ $stop_notice->processed_by->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
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
                            <div class="control-label col-xs-4" style="padding-top: 13px;">@if( $stop_notice->case->claimant_address->is_company == 0)
                                @if($stop_notice->case->claimant_address->nationality_country_id != 129 )
                                {{ __('form1.passport_no') }}
                                @else
                                {{ __('form1.ic_no') }}
                                @endif
                            @else
                            {{ __('form1.company_no') }}
                            @endif</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_identification_no">{{ $stop_notice->case->claimant_address->identification_no }}</span>
                            </div>
                        </div>
                        @if( $stop_notice->case->claimant_address->is_company == 0 && $stop_notice->case->claimant_address->nationality_country_id != 129 )
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.nationality') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_nationality">{{ $stop_notice->case->claimant_address->nationality->country }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.name') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_name">{{ $stop_notice->case->claimant_address->name }}</span>
                            </div>
                        </div>

                        <div id="show_claimant_info" onclick="toggleClaimantInfo()" style="text-align: center; font-size: small; cursor: pointer; padding: 5px;" class="bg-green-sharp font-white camelcase">{{ strtolower(trans('form1.full_info')) }}</div>

                        <div id="claimant_info" style="display:none;">

                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }}  </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_street1">{{ $stop_notice->case->claimant_address->street_1 }}<br>{{ $stop_notice->case->claimant_address->street_2 }}<br>{{ $stop_notice->case->claimant_address->street_3 }}
                                    </span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_postcode">{{ $stop_notice->case->claimant_address->postcode }}</span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_district">{{ $stop_notice->case->claimant_address->district ? $stop_notice->case->claimant_address->district->district : ''}}</span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_state">{{ $stop_notice->case->claimant_address->state ? $stop_notice->case->claimant_address->state->state : ''}}</span>
                                </div>
                            </div>

                            @if($stop_notice->case->claimant_address->address_mailing_street_1)
                                <div class="form-group non-tourist" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mailing_street') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="view_claimant_state">{{ $stop_notice->case->claimant_address->address_mailing_street_1 }}<br>{{ $stop_notice->case->claimant_address->address_mailing_street_2 }}<br>{{ $stop_notice->case->claimant_address->address_mailing_street_3 }}</span>
                                    </div>
                                </div>
                                <div class="form-group non-tourist" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mailing_postcode') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="view_claimant_state">{{ $stop_notice->case->claimant_address->address_mailing_postcode }}</span>
                                    </div>
                                </div>
                                <div class="form-group non-tourist" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mailing_district') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_state">
                                        {{ $stop_notice->case->claimant_address->address_mailing_district_id ? $stop_notice->case->claimant_address->districtmailing->district : '-' }}
                                    </span>
                                    </div>
                                </div>
                                <div class="form-group non-tourist" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mailing_state') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="view_claimant_state">{{ $stop_notice->case->claimant_address->address_mailing_state_id ? $stop_notice->case->claimant_address->statemailing->state : '-' }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($stop_notice->case->claimant_address->is_company == 0)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_home">{{ $stop_notice->case->claimant_address->phone_home }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_mobile">{{ $stop_notice->case->claimant_address->phone_mobile}}</span>
                                </div>
                            </div>
                            @endif
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_office">{{ $stop_notice->case->claimant_address->phone_office }}</span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_fax">{{ $stop_notice->case->claimant_address->phone_fax }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_email">{{ $stop_notice->case->claimant_address->email }}</span>
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
                            <div class="control-label col-xs-4" style="padding-top: 13px;">
                            @if($stop_notice->multiOpponents->opponent_address)
                                @if( $stop_notice->multiOpponents->opponent_address->is_company == 0)
                                    @if($stop_notice->multiOpponents->opponent_address->nationality_country_id != 129 )
                                    {{ __('form1.passport_no') }}
                                    @else
                                    {{ __('form1.ic_no') }}
                                    @endif
                                @else
                                {{ __('form1.company_no') }}
                                @endif
                            @else
                            {{ __('form1.ic_no') }}
                            @endif
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_identification_no">{{ $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->identification_no : '' }}</span>
                            </div>
                        </div>
                        @if($stop_notice->multiOpponents->opponent_address)
                        @if( $stop_notice->multiOpponents->opponent_address->is_company == 0 && $stop_notice->multiOpponents->opponent_address->nationality_country_id != 129 )
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.nationality') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_nationality">{{ $stop_notice->multiOpponents->opponent_address->nationality->country }}</span>
                            </div>
                        </div>
                        @endif
                        @endif
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.name') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_name">{{ $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->name : '' }}</span>
                            </div>
                        </div>

                        <div id="show_opponent_info" onclick="toggleOpponentInfo()" style="text-align: center; font-size: small; cursor: pointer; padding: 5px;" class="bg-green-sharp font-white camelcase">{{ strtolower(__('form1.full_info')) }}</div>

                        <div id="opponent_info" style="display:none;">

                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_street1">
                                        @if($stop_notice->multiOpponents->opponent_address)
                                        {{ $stop_notice->multiOpponents->opponent_address->street_1 }}<br>
                                        {{ $stop_notice->multiOpponents->opponent_address->street_2 }}<br>
                                        {{ $stop_notice->multiOpponents->opponent_address->street_3 }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_postcode">{{ $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->postcode : '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_district">
                                        @if ($stop_notice->multiOpponents->opponent_addresss)
                                        {{ $stop_notice->multiOpponents->opponent_addresss->district ? $stop_notice->multiOpponents->opponent_address->district->district : '' }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_state">
                                        @if($stop_notice->multiOpponents->opponent_address)
                                        {{ $stop_notice->multiOpponents->opponent_address->state ? $stop_notice->multiOpponents->opponent_address->state->state : '' }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @if($stop_notice->multiOpponents->opponent_address->is_company == 0)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_home">{{ $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->phone_home : ''}}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_mobile">{{ $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->phone_mobile : '' }}</span>
                                </div>
                            </div>
                            @endif
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_office">{{ $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->phone_office : ''}}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_fax">{{ $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->phone_fax : ''}}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_email">{{ $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->email : '' }}</span>
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

    function exportPDF(id, type) {
        location.href = "{{ url('') }}/stop_notice/"+id+"/export/"+type+"/pdf";
    }
    function exportDOCX(id, type) {
        location.href = "{{ url('') }}/stop_notice/"+id+"/export/"+type+"/docx";
    }

</script>

@endsection