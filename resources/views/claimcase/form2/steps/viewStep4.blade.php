<div id="step_4" class="row step_item">
    <div class="col-md-12 ">
        <div class="portlet light form-fit bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.review_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab"> {{ __('form2.claimant') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab4" data-toggle="tab"> {{ __('form1.claim') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab2" data-toggle="tab"> {{ __('form2.opponent') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab3" data-toggle="tab"> {{ __('form2.defence') }} &amp; {{ __('form2.counterclaim') }} </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_tab1">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                            <div class="scroller" style="overflow: hidden; width: auto;" data-initialized="1">
                                <form action="#" class="form-horizontal form-bordered ">
                                    <div class="form-body">
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form2.claimant_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div id="label_view_claimant_identification_no" class="control-label control-label-custom col-md-4">
                                            @if($case->claimant->public_data->user_public_type_id == 1)
                                                @if($case->claimant->public_data->individual->nationality_country_id == 129)
                                                    {{ __('form2.ic_no') }} :
                                                @else
                                                    {{ __('form2.passport_no') }} :
                                                @endif
                                            @else
                                                {{ __('form2.company_no') }} :
                                            @endif
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_identification_no">{{ $case->claimant->username }}</span>
                                            </div>
                                        </div>
                                        @if($case->claimant->public_data->user_public_type_id == 1)
                                            @if($case->claimant->public_data->individual->nationality_country_id != 129)
                                            <div id="row_view_claimant_nationality" class="form-group" style="display: flex;">
                                                <div class="control-label control-label-custom col-xs-4">{{ __('form2.nationality') }} :</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claimant_nationality">{{ $case->claimant->public_data->individual->nationality->country }}</span>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.name') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_name">{{ $case->claimant->name }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form2.claimant_contact_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.address_street') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_street1">{{ $case->claimant_address->street_1 }}</span><br>
                                                <span id="view_claimant_street2">{{ $case->claimant_address->street_2 }}</span><br>
                                                <span id="view_claimant_street3">{{ $case->claimant_address->street_3 }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.postcode') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_postcode">{{ $case->claimant_address->postcode }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.district') }}:</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_district">{{ $case->claimant_address->district ? $case->claimant_address->district->district : '' }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.state') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_state">{{ $case->claimant_address->state ? $case->claimant_address->state->state : '' }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.mailing_street') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_street1">{{ $case->claimant_address->address_mailing_street_1 ? $case->claimant_address->address_mailing_street_1 : '-' }}</span><br>
                                                <span id="view_claimant_street2">{{ $case->claimant_address->address_mailing_street_2 ? $case->claimant_address->address_mailing_street_2 : '' }}</span><br>
                                                <span id="view_claimant_street3">{{ $case->claimant_address->address_mailing_street_3 }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.mailing_postcode') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_postcode">{{ $case->claimant_address->address_mailing_postcode ? $case->claimant_address->address_mailing_postcode : '' }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.mailing_district') }}:</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_district">{{ $case->claimant_address->address_mailing_district_id ? $case->claimant_address->districtmailing->district : '' }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.mailing_state') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_state">{{ $case->claimant_address->address_mailing_state_id ? $case->claimant_address->statemailing->state : '' }}</span>
                                            </div>
                                        </div>

                                        <div id="row_view_claimant_phone_home" class="form-group" style="display: flex;">
                                            <div id="label_view_claimant_phone_home" class="control-label control-label-custom col-md-4">{{ __('form2.home_phone') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_phone_home">@if($case->claimant_address->is_company == 0){{ $case->claimant_address->phone_home }}@else{{ $case->claimant_address->phone_home }}@endif</span>
                                            </div>
                                        </div>

                                        <div id="row_view_claimant_phone_mobile" class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.mobile_phone') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_phone_mobile">@if($case->claimant_address->is_company == 0){{ $case->claimant_address->phone_mobile }}@else{{ $case->claimant_address->phone_mobile }}@endif</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.office_phone') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_phone_office">{{ $case->claimant_address->phone_office }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.fax_no') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_phone_fax">{{ $case->claimant_address->phone_fax }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.email') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_email">{{ $case->claimant_address->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="portlet_tab2">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                            <div class="scroller" style="overflow: hidden; width: auto;" data-initialized="0">
                                <form action="#" class="form-horizontal form-bordered ">
                                    <div class="form-body">
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form2.opponent_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div id="label_view_opponent_identification_no" class="control-label control-label-custom col-md-4">{{ __('form2.ic_no') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_identification_no">{{ $caseOppo->opponent->username }}</span>
                                            </div>
                                        </div>
                                        @if($caseOppo->opponent->public_data->user_public_type_id == 1)
                                            @if($caseOppo->opponent->public_data->individual->nationality_country_id != 129)
                                            <div id="row_view_opponent_nationality" class="form-group" style="display: flex;">
                                                <div class="control-label control-label-custom col-xs-4">{{ __('form2.nationality') }} :</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_opponent_nationality">{{ $caseOppo->opponent->public_data->individual->nationality->country }}
                                                    </span>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                        <div class="form-group" style="display: flex;">
                                            <div id="label_opponent_name" class="control-label control-label-custom col-md-4">{{ __('form2.name') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_name">{{ $caseOppo->opponent->name }}</span>
                                            </div>
                                        </div>


                                        @if($caseOppo->opponent->public_data->user_public_type_id == 2)
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form2.representative_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div id="label_view_representative_identification_no" class="control-label control-label-custom col-md-4">{{ __('form2.ic_no') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_representative_identification_no"></span>
                                            </div>
                                        </div>
                                        <div id="row_view_representative_nationality" class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.nationality') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_representative_nationality"></span>
                                            </div>
                                        </div>
                                        <div id="row_view_representative_name" class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.representative_name') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_representative_name"></span>
                                            </div>
                                        </div>
                                        <div id="row_view_representative_designation" class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.representative_designation') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_representative_designation"></span>
                                            </div>
                                        </div>
                                        @endif


                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form2.opponent_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.address_street') }} 1 :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_street1"></span><br>
                                                <span id="view_opponent_street2"></span><br>
                                                <span id="view_opponent_street3"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.postcode') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_postcode"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.district') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_district"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.state') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_state"></span>
                                            </div>
                                        </div>
                                        @if($caseOppo->opponent->public_data->user_public_type_id == 2)
                                        <div id="row_view_opponent_phone_home" class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.home_phone') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_phone_home"></span>
                                            </div>
                                        </div>
                                        <div id="row_view_opponent_phone_mobile" class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.mobile_phone') }}  :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_phone_mobile"></span>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.office_phone') }}  :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_phone_office"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.fax_no') }}  :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_phone_fax"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.email') }}  :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_opponent_email"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>











                    <div class="tab-pane" id="portlet_tab3">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                            <div class="scroller" style="overflow: hidden; width: auto;" data-initialized="0">
                                <form action="#" class="form-horizontal form-bordered ">
                                    <div class="form-body">
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form2.defence_counterclaim_info') }} </span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.statement_defence') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_defence_statement"></span>
                                            </div>
                                        </div>



                                        <div class="form-group is_counterclaim" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form2.counterclaim') }} </span>
                                            </div>
                                        </div>
                                        <div class="form-group is_counterclaim" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.total_counterclaim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_total_counterclaim"></span>
                                            </div>
                                        </div>
                                        <div class="form-group is_counterclaim" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form2.counterclaim_statements') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_counterclaim_desc"></span>
                                            </div>
                                        </div>



                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form1.attachment_list') }}</span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_1' class="form-group attachment_list" style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_2' class="form-group attachment_list" style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_3' class="form-group attachment_list" style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_4' class="form-group attachment_list" style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_5' class="form-group attachment_list" style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>







                    <div class="tab-pane" id="portlet_tab4">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                            <div class="scroller" style="overflow: hidden; width: auto;" data-initialized="0">
                                <form action="#" class="form-horizontal form-bordered ">
                                    <div class="form-body">
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form1.transaction_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.online_purchased') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_is_online_transaction">@if($case->form1->is_online_purchased == 1){{ __('form2.yes') }}@else{{ __('form2.no') }}@endif</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.transaction_date') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_date">{{ date('d/m/Y', strtotime($case->form1->purchased_date." 00:00:00")) }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.purchased_used') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_item">{{ $case->form1->purchased_item_name }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.brand_model') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_brand">{{ $case->form1->purchased_item_brand }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.amount_paid') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_amount">RM {{ number_format($case->form1->purchased_amount, 2, '.', ',') }}</span>
                                            </div>
                                        </div>




                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form1.claim_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.particular_claim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claim_details">{{ $case->form1->claim_details }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.amount_claim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claim_amount">RM {{ number_format($case->form1->claim_amount, 2, '.', ',') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.prev_court') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_is_filed_on_court">@if($case->form1->court_case_id){{ __('form2.yes') }}@else{{ __('form2.no') }}@endif</span>
                                            </div>
                                        </div>



                                        @if($case->form1->court_case_id)
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form1.court_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.court_name') }}:</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_case_name">{{ $case->form1->court_case->court_case_name }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.status_case') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_case_status">{{ $case->form1->court_case->court_case_status }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.place_case') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_case_place">{{ $case->form1->court_case->court_case_location }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="control-label control-label-custom col-xs-4">{{ __('form1.registration_date') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_case_created_at">{{ date('d/m/Y', strtotime($case->form1->court_case->filing_date." 00:00:00")) }}</span>
                                            </div>
                                        </div>
                                        @endif


                                        @if($f1_attachments) @if($f1_attachments->count() > 0)
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form1.supporting_docs') }}</span>
                                            </div>
                                        </div>
                                        @foreach($f1_attachments as $att)
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label control-label-custom col-xs-4" style="padding-top: 13px;">
                                                    <a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'><i class='fa fa-download'></i> {{ trans('button.download')}}</a>
                                                </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claim_details">{{ $att->attachment_name }}</span>
                                                </div>
                                            </div>
                                        @endforeach

                                        @endif @endif

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>






                </div>
            </div>
        </div>
    </div>
</div>