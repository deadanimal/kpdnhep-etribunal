<div id="step_3" class="row step_item">
    <div class="col-md-12 ">
        <div class="portlet light form-fit bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.review_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab"> {{ trans('form2.form2_details') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab3" data-toggle="tab"> {{ trans('form3.defence_towards_counterclaim') }} </a>
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
                                                <span class="bold" style="align-items: stretch;">{{ trans('form3.claimant_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div id="label_view_claimant_identification_no" class="control-label col-md-4">
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
                                                <div class="control-label col-xs-4">{{ __('form2.nationality') }} :</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claimant_nationality">{{ $case->claimant->public_data->individual->nationality->country }}</span>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form2.name') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_name">{{ $case->claimant->name }}</span>
                                            </div>
                                        </div>



                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ trans('form3.opponent_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div id="label_view_claimant_identification_no" class="control-label col-md-4">
                                            @if($claim_case_opponent->opponent->public_data->user_public_type_id == 1)
                                                @if($claim_case_opponent->opponent->public_data->individual->nationality_country_id == 129)
                                                    {{ __('form2.ic_no') }} :
                                                @else
                                                    {{ __('form2.passport_no') }} :
                                                @endif
                                            @else
                                                {{ __('form2.company_no') }} :
                                            @endif
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_identification_no">{{ $claim_case_opponent->opponent->username }}</span>
                                            </div>
                                        </div>
                                        @if($claim_case_opponent->opponent->public_data->user_public_type_id == 1)
                                            @if($claim_case_opponent->opponent->public_data->individual->nationality_country_id != 129)
                                            <div id="row_view_claimant_nationality" class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4">{{ __('form2.nationality') }} :</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claimant_nationality">{{ $claim_case_opponent->opponent->public_data->individual->nationality->country }}</span>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ __('form2.name') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_name">{{ $claim_case_opponent->opponent->name }}</span>
                                            </div>
                                        </div>
                                        




                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ trans('form3.claim_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ trans('form3.particular_claim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_street12">{{ $case->form1->claim_details }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ trans('form3.amount_claim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_street22">RM {{ number_format($case->form1->claim_amount, 2, '.', ',') }}</span>
                                            </div>
                                        </div>
                                        
                                        @if($f1_attachments) @if($f1_attachments->count() > 0)
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form1.supporting_docs') }}</span>
                                            </div>
                                        </div>
                                        @foreach($f1_attachments as $att)
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">
                                                    <a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'><i class='fa fa-download'></i> {{ trans('button.download')}}</a>
                                                </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claim_details">{{ $att->attachment_name }}</span>
                                                </div>
                                            </div>
                                        @endforeach

                                        @endif @endif








                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ trans('form3.defence_counterclaim_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ trans('form3.statement_defence') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_street3">{{ $claim_case_opponent->form2->defence_statement }}</span>
                                            </div>
                                        </div>
                                        @if($claim_case_opponent->form2->counterclaim_id)
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ trans('form3.statement_counterclaim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_postcode">{{ $claim_case_opponent->form2->counterclaim->counterclaim_statement }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group non-tourist" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ trans('form3.total_counterclaim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claimant_district">RM {{ number_format($claim_case_opponent->form2->counterclaim->counterclaim_amount, 2, '.', ',') }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        @if($f2_attachments) @if($f2_attachments->count() > 0)
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-md-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form1.supporting_docs') }}</span>
                                            </div>
                                        </div>
                                        @foreach($f2_attachments as $att)
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">
                                                    <a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'><i class='fa fa-download'></i> {{ trans('button.download')}}</a>
                                                </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claim_details2">{{ $att->attachment_name }}</span>
                                                </div>
                                            </div>
                                        @endforeach

                                        @endif @endif
                                        




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
                                                <span class="bold" style="align-items: stretch;">{{ trans('form3.defence_towards_counterclaim') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4">{{ trans('form3.defence_towards_counterclaim') }} :</div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_defence_counterclaim"></span>
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
                </div>
            </div>
        </div>
    </div>
</div>