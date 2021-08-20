    <?php
        $locale = App::getLocale();
        $status_lang = "case_status_".$locale;
        $hearing_lang="hearing_status_".$locale;
        $method_lang="stop_method_".$locale;
        $form_status_lang="form_status_desc_".$locale;
        $hearing_position_lang="hearing_position_".$locale;
        $designation_lang="designation_".$locale;
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
        <h3>{{ __('new.case_info') }}</h3>
        <span>{{ __('new.details_case') }}</span>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-layers font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">
                            <span id="claim_no">{{ $form4->case->case_no }}</span> | 
                            <small style="font-weight: normal;"><span id="claim_no">{{ $form4->case->form1->filing_date }}</span></small>
                        </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs ">
                            @if($form4->case->claim_case_id->form1_id)
                            <li class="active">
                                <a href="#tab_form1" data-toggle="tab" aria-expanded="true">{{ __('new.form1') }}</a>
                            </li>
                            @endif

                            <li class="active">
                                <a href="#tab_form2" data-toggle="tab" aria-expanded="true">{{ __('new.form1') }}</a>
                            </li>
                            @endif @endif
                            @if($form4->case->form1_id) @if($form4->case->form1->form2_id) @if($form4->case->form1->form2->form3_id)
                            <li>
                                <a href="#tab_form3" data-toggle="tab" aria-expanded="false">{{ __('new.stop_notice') }}</a>
                            </li>
                            @endif @endif @endif
                            <li>
                                <a href="#tab_form4" data-toggle="tab" aria-expanded="true">{{ __('new.form4') }}</a>
                            </li>
                            @if($form4->stop_notice) 
                            <li>
                                <a href="#tab_stop_notice" data-toggle="tab" aria-expanded="false">{{ __('new.stop_notice') }}</a>
                            </li>
                            @endif
                            @if($form4->hearing_status_id)
                            <li>
                                <a href="#tab_hearing_status" data-toggle="tab" aria-expanded="false">{{ __('new.hearing_status') }}</a>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content" style="padding-top: 0px;">
                            <div id="tab_form1" class="tab-pane active" style="margin-top: 30px;">
                                <div class="portlet light bordered form-fit">
                                    <div class="portlet-body form">
                                        <form action="#" class="form-horizontal form-bordered ">
                                            <div class="form-body">
                                                <div class="form-group" style="display: flex;">
                                                    <div class="col-xs-12">
                                                        <span class="bold" style="align-items: stretch;">{{ __('new.particulars_claim') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.transaction_date') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_purchased_date">{{ $form4->case->purchased_date or '' }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.purchased_used') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_purchased_item">{{ $form4->case->form1->purchased_item_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.brand_model') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_purchased_brand">{{ $form4->case->form1->purchased_item_brand }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.amount_paid') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_purchased_amount">{{ $form4->case->form1->purchased_amount }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.particular_claim') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->claim_details }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.amount_claim') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_amount">{{ $form4->case->form1->claim_amount }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.prev_court') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_is_filed_on_court">
                                                            @if( $form4->case->form1->court_case_id)
                                                            {{ trans('form1.yes') }}
                                                            @else
                                                            {{ trans('form1.no') }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="col-md-12">
                                                        <span class="bold" style="align-items: stretch;">{{ trans('form1.process_info') }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;"> {{ trans('form1.payment_method')}}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">
                                                            @if($form4->case->form1->payment->payment_fpx_id)
                                                            {{ __('form1.online_payment') }}
                                                            @elseif($form4->case->form1->payment->payment_postalorder_id)
                                                            {{ __('form1.postal_order') }}
                                                            @else
                                                            {{ __('form1.pay_counter') }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.receipt_no')}}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->payment->receipt_no }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('fpx.payment_date')}}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->payment->paid_at or '' }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.category_claim') }}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->classification->category->$category_lang or '' }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.classification_claim') }}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->classification->$classification_lang or '' }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.type_offence') }}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details"><strong>{{ $form4->case->form1->offence_type->offence_code or '' }}</strong><br>{{ $claim_case->form1->offence_type->$offence_lang or '' }}</span>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($form4->case->form1_id) @if($form4->case->form1->form2_id)
                            <div id="tab_form2" class="tab-pane" style="margin-top: 30px;">
                                <div class="portlet light bordered form-fit">
                                    <div class="portlet-body form">
                                        <form action="#" class="form-horizontal form-bordered ">
                                            <div class="form-body">
                                                @if( $form4->case->opponent->user_public_type_id == 2)
                                                <div class="form-group" style="display: flex;">
                                                    <div class="col-xs-12">
                                                        <span class="bold" style="align-items: stretch;">{{ __('new.representative_info') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.ic') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_purchased_date">{{ $form4->case->opponent->public_data->company->representative_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('new.designation') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_purchased_item">{{ $form4->case->opponent->public_data->company->designation->$designation_lang }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="col-xs-12">
                                                        <span class="bold" style="align-items: stretch;">{{ __('form2.statement_defence') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.statement_defence') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_purchased_brand">{{ $form4->case->form1->form2->defence_statement }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.defence_counterclaim') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_purchased_amount">{{ $form4->case->form1->form2->counterclaim->counterclaim_statement }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.total_counterclaim') }} </div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->form2->counterclaim->counterclaim_amount }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group" style="display: flex;">
                                                    <div class="col-md-12">
                                                        <span class="bold" style="align-items: stretch;">{{ trans('form1.process_info') }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;"> {{ trans('form1.payment_method')}}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">
                                                            @if($form4->case->form1->payment->payment_fpx_id)
                                                            {{ __('form1.online_payment') }}
                                                            @elseif($form4->case->form1->payment->payment_postalorder_id)
                                                            {{ __('form1.postal_order') }}
                                                            @else
                                                            {{ __('form1.pay_counter') }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.receipt_no')}}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->payment->receipt_no }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('fpx.payment_date')}}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->payment->paid_at or '' }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.category_claim') }}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->classification->category->$category_lang or '' }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.classification_claim') }}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details">{{ $form4->case->form1->classification->$classification_lang or '' }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: flex;">
                                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.type_offence') }}</div>
                                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                        <span id="view_claim_details"><strong>{{ $form4->case->form1->offence_type->offence_code or '' }}</strong><br>{{ $claim_case->form1->offence_type->$offence_lang or '' }}</span>
                                                    </div>
                                                </div>
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
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-layers font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('form2.claimant_info') }}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form action="#" class="form-horizontal form-bordered ">
                        <div class="form-body">
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.ic_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant->public_data->user_public_type_id))
                                    @if($form4->case->claimant->public_data->user_public_type_id ==1)
                                    <span id="form_status_id">{{ $form4->case->claimant->public_data->individual->identification_no}}</span>
                                    @else
                                    <span id="form_status_id">{{ $form4->case->claimant->public_data->company->representative_identification_no}}</span>
                                    @endif
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.nationality') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant->public_data->user_public_type_id))
                                    @if($form4->case->claimant->public_data->user_public_type_id ==1)
                                    <span id="form_status_id">{{ $form4->case->claimant->public_data->individual->nationality->country}}</span>
                                    @else
                                    <span id="form_status_id">{{ $form4->case->claimant->public_data->company->nationality->country}}</span>
                                    @endif
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.name') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant->name))
                                    <span id="form_status_id">{{ $form4->case->claimant->name}}</span> 
                                    @else -
                                    @endif
                                </div>
                            </div>

                            <div id="show_claimant_info" onclick="toggleClaimantInfo()" style="text-align: center; font-size: small; cursor: pointer; padding: 5px;" class="bg-green-sharp font-white">{{ trans('form2.full_info')}}</div>
                            <div id="claimant_info" style="display:none;">
                                <div class="form-group non-tourist" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.address_street') }} 1 </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                     @if(!empty($form4->case->claimant_address_id))
                                     <span id="form_status_id">{{ $form4->case->claimant_address->street_1 }}</span>
                                     @else -
                                     @endif
                                 </div>
                             </div>
                             <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.address_street') }} 2 </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_address_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->street_2 }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.address_street') }} 3</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_address_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->street_3 }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_address_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->postcode }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_address_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->district->district }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_user_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->state->state }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_user_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->home_phone }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_user_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->mobile_phone }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_user_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->office_phone }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_user_id))
                                    <span id="form_status_id">{{ $form4->case->claimant_address->fax_no }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->claimant_user_id))
                                    <span id="form_status_id">{{ $form4->case->claimant->email }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="portlet light bordered form-fit">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-layers font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase"> {{ __('form1.opponent_info') }}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form action="#" class="form-horizontal form-bordered ">
                        <div class="form-body">
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.ic_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->opponent->public_data->user_public_type_id))
                                    @if($form4->case->opponent->public_data->user_public_type_id == 1)
                                    <span id="form_status_id">{{ $form4->case->opponent->public_data->company->representative_identification_no}}</span>
                                    @else
                                    <span id="form_status_id">{{ $form4->case->opponent->public_data->company->representative_identification_no}}
                                    </span>
                                    @endif
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.nationality') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->opponent->public_data->user_public_type_id))
                                    @if($form4->case->opponent->public_data->user_public_type_id == 1)
                                    <span id="form_status_id">{{ $form4->case->opponent->public_data->individual->nationality->country}}</span>
                                    @else
                                    <span id="form_status_id">{{ $form4->case->opponent->public_data->company->nationality->country}}</span>
                                    @endif
                                    @else -
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.name') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    @if(!empty($form4->case->opponent->name))
                                    <span id="form_status_id">{{ $form4->case->opponent->name }}</span>
                                    @else -
                                    @endif
                                </div>
                            </div>

                            <div id="show_opponent_info" onclick="toggleOpponentInfo()" style="text-align: center; font-size: small; cursor: pointer; padding: 5px;" class="bg-green-sharp font-white"> {{ __('form2.full_info') }} </div>

                            <div id="opponent_info" style="display:none;">

                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }} 1 </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_address_id))
                                        <span id="claim_no">{{ $form4->case->opponent_address->street_1 }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }} 2 </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_address_id))
                                        <span id="form_status_id">{{ $form4->case->opponent_address->street_2 }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }} 3 </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_address_id))
                                        <span id="form_status_id">{{ $form4->case->opponent_address->street_3 }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_address_id))
                                        <span id="form_status_id">{{ $form4->case->opponent_address->postcode }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_address_id))
                                        <span id="form_status_id">{{ $form4->case->opponent_address->district->district }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_address_id))
                                        <span id="form_status_id">{{ $form4->case->opponent_address->state->state }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_user_id))
                                        <span id="form_status_id">{{ $form4->case->opponent->home_phone }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_user_id))
                                        <span id="form_status_id">{{ $form4->case->opponent->phone_office }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_user_id))
                                        <span id="form_status_id">{{ $form4->case->opponent->phone_office }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_user_id))
                                        <span id="form_status_id">{{ $form4->case->opponent->phone_office }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        @if(!empty($form4->case->opponent_user_id))
                                        <span id="form_status_id">{{ $form4->case->opponent->email }}</span>
                                        @else -
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
    </div>

@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

 $("#opponent_info").slideUp(0)
 $("#claimant_info").slideUp(0)

 function toggleOpponentInfo(){
    $("#opponent_info").slideToggle();
}

function toggleClaimantInfo(){
    $("#claimant_info").slideToggle();
}

</script>

@endsection