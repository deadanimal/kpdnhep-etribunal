<div id="step_4" class="row step_item">
    <div class="col-md-12 ">
        <div class="portlet light form-fit bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form1.review_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab"> {{ __('form1.claimant') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab2" data-toggle="tab"> {{ __('form1.opponent') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab3" data-toggle="tab"> {{ __('form1.claim') }} </a>
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
                                            <div class="col-md-12" style="align-items: stretch;">
                                                <span class="bold"
                                                      style="align-items: stretch;">{{ __('form1.inquiry_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.inquiry_ref_no') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_inquiry_no"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold"
                                                      style="align-items: stretch;">{{ __('form1.claimant_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div id="label_view_claimant_identification_no"
                                                 class="control-label col-xs-4">{{ __('form1.ic_no') }} :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_identification_no">XXXXXXXXXXXXXXXXXXXX</span>
                                            </div>
                                        </div>
                                        <div id="row_view_claimant_nationality" class="form-group hidden">
                                            <div class="control-label col-xs-4">{{ __('form1.nationality') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_nationality"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.name') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_name">This Is My Name</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.address_street') }} 1 :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_street1"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.address_street') }} 2 :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_street2"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.address_street') }} 3 :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_street3"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.postcode') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_postcode"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.district') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_district"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.state') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_state"></span>
                                            </div>
                                        </div>

                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.mailing_street') }} 1 :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_mailing_street1"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.mailing_street') }} 2 :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_mailing_street2"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.mailing_street') }} 3 :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_mailing_street3"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.mailing_postcode') }}:
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_mailing_postcode"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.mailing_district') }}:
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_mailing_district"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.mailing_state') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_mailing_state"></span>
                                            </div>
                                        </div>

                                        <div id="row_view_claimant_phone_home" class="form-group"
                                             style="display: flex;">
                                            <div id="label_view_claimant_phone_home"
                                                 class="control-label col-xs-4">{{ __('form1.home_phone') }} :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_phone_home"></span>
                                            </div>
                                        </div>
                                        <div id="row_view_claimant_phone_mobile" class="form-group"
                                             style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.mobile_phone') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_phone_mobile"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.office_phone') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_phone_office"></span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.fax_no') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_phone_fax"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.email') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_email"></span>
                                            </div>
                                        </div>


                                        <div class="form-group extra hidden" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold"
                                                      style="align-items: stretch;">{{ __('form1.extra_claimant_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group extra hidden" style="display: flex;">
                                            <div id="label_view_extra_claimant_identification_no"
                                                 class="control-label col-xs-4">{{ __('form1.ic_no') }} :
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_extra_claimant_identification_no">XXXXXXXXXXXXXXXXXXXX</span>
                                            </div>
                                        </div>
                                        <div id="row_view_claimant_nationality" class="form-group hidden">
                                            <div class="control-label col-xs-4">{{ __('form1.nationality') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_extra_claimant_nationality"></span>
                                            </div>
                                        </div>
                                        <div class="form-group extra hidden" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.name') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_extra_claimant_name">This Is My Name</span>
                                            </div>
                                        </div>
                                        <div class="form-group extra hidden" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.relationship') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_extra_claimant_relationship"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <span class="bold" style="align-items: stretch;">{{ __('new.service_rating') }}</span>
                                <div class="modal-body" style="background: white; ">
                                    <div class="row">
                                        <div class="col-sm-4 text-center">
                                            <label for="rating3"><img for="rating3" style="width: 50% !important;"
                                                                      src="{{ url('images/perform5.png') }}"/></label>
                                            <div class="radio radio-primary">
                                                <input id="rating3" type="radio" value="3" name="rating" checked><label
                                                        for="rating3"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <label for="rating2"><img alt="image" style="width: 50% !important;"
                                                                      src="{{ url('images/perform4.png') }}"/></label>
                                            <div class="radio radio-primary">
                                                <input id="rating2" type="radio" value="2" name="rating"><label
                                                        for="rating2"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <label for="rating1"><img alt="image" style="width: 50% !important;"
                                                                      src="{{ url('images/perform3.png') }}"/></label>
                                            <div class="radio radio-primary">
                                                <input id="rating1" type="radio" value="1" name="rating"><label
                                                        for="rating1"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="portlet_tab2">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                            <div class="scroller" style="overflow: hidden; width: auto;" data-initialized="0"
                                 id="opponent_summary_div">
								 <?php /* ?>
                                @if(!empty($case))
                                    @foreach($case->multiOpponents as $i => $opponent)
                                        @include('claimcase.form1.steps.opponentSummaryDetails', ['i' => $i, 'opponent' => $opponent])
                                    @endforeach
                                @endif
								<?php */ ?>
								
								 @include('claimcase.form1.steps.opponentSummaryDetails2', ['i' => 1])
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
                                                <span class="bold"
                                                      style="align-items: stretch;">{{ __('form1.transaction_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.online_purchased') }}:
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_is_online_transaction"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.transaction_date') }}:
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_date"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.purchased_used') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_item"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.brand_model') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_brand"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.amount_paid') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_amount"></span>
                                            </div>
                                        </div>


                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold"
                                                      style="align-items: stretch;">{{ __('form1.claim_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.particular_claim') }}:
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claim_details"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.amount_claim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claim_amount"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.prev_court') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_is_filed_on_court"></span>
                                            </div>
                                        </div>


                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold"
                                                      style="align-items: stretch;">{{ __('form1.court_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.court_name') }}:</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_case_name"></span>
                                            </div>
                                        </div>
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.status_case') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_case_status"></span>
                                            </div>
                                        </div>
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.place_case') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_case_place"></span>
                                            </div>
                                        </div>
                                        <div class="form-group is_filed" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form1.registration_date') }}:
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_case_created_at"></span>
                                            </div>
                                        </div>


                                        @if(!$is_staff)
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4">{{ __('form1.preferred_ttpm_branch') }}
                                                    :
                                                </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_preferred_ttpm_branch"></span>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold"
                                                      style="align-items: stretch;">{{ __('form1.attachment_list') }}</span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_1' class="form-group attachment_list"
                                             style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_2' class="form-group attachment_list"
                                             style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_3' class="form-group attachment_list"
                                             style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_4' class="form-group attachment_list"
                                             style="display: flex;">
                                            <div class="control-label col-xs-4"></div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div id='attachment_list_5' class="form-group attachment_list"
                                             style="display: flex;">
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
                </div>
            </div>
        </div>
    </div>
</div>