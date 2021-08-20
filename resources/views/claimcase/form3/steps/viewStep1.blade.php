<div id="step_1" class="row step_item">
    <!-- Claimant -->
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.claimant_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="claimant_identification_no" style="padding-top: 0px !important" class="control-label control-label-custom col-xs-4"><span id="label_claimant_identification_no">@if($case->claimant_address->is_company == 0)
                                    @if($case->claimant_address->nationality_country_id == 129)
                                        {{ __('form2.ic_no') }} :
                                    @else
                                        {{ __('form2.passport_no') }} :
                                    @endif
                                @else
                                    {{ __('form2.company_no') }} :
                                @endif</span>
                            </label>
                            <div class="col-md-6">
                                <input hidden type="text" id="claim_case_id" name="claim_case_id" 
                                @if(isset($claim_case_opponent))
                                value="{{ $claim_case_opponent->id }}"
                                @endif
                                />
                                {{ $case->claimant_address->identification_no }}
                            </div>
                        </div>
                        @if($case->claimant_address->is_company == 0)
                            @if($case->claimant_address->nationality_country_id != 129)
                            <div class="form-group form-md-line-input">
                                <label for="claimant_name" style="padding-top: 0px !important" class="control-label control-label-custom col-md-4">{{ __('form2.nationality') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    {{ $case->claimant_address->nationality->country }}
                                </div>
                            </div>
                            @endif
                        @endif 
                        <div class="form-group form-md-line-input">
                            <label for="claimant_name" style="padding-top: 0px !important" class="control-label control-label-custom col-xs-4">{{ trans('form3.claimant_name') }} :

                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->name }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Opponent -->
    <div class="col-md-12 ">
        
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.step') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="opponent_identification_no" style="padding-top: 0px !important" class="control-label control-label-custom col-xs-4"><span id="label_opponent_company_no">@if($claim_case_opponent->opponent_address->is_company == 0)
                                    @if($claim_case_opponent->opponent_address->nationality_country_id == 129)
                                        {{ __('form2.ic_no') }} :
                                    @else
                                        {{ __('form2.passport_no') }} :
                                    @endif
                                @else
                                    {{ __('form2.company_no') }} :
                                @endif</span>
                            </label>
                            <div class="col-md-6">
                                {{ $claim_case_opponent->opponent_address->identification_no }}
                            </div>
                        </div>
                        @if($claim_case_opponent->opponent_address->is_company == 0)
                            @if($claim_case_opponent->opponent_address->nationality_country_id != 129)
                            <div class="form-group form-md-line-input">
                                <label for="claimant_name" style="padding-top: 0px !important" class="control-label control-label-custom col-md-4">{{ __('form2.nationality') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    {{ $claim_case_opponent->opponent_address->nationality->country }}
                                </div>
                            </div>
                            @endif
                        @endif 
                        <div class="form-group form-md-line-input">
                            <label for="opponent_name" style="padding-top: 0px !important" class="control-label control-label-custom col-xs-4">{{ trans('form3.opponent_name') }} :

                            </label>
                            <div class="col-md-6">
                                {{ $claim_case_opponent->opponent_address->name }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Claim Details-->
    <div class="col-md-12 ">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.claim_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>

            <div class="portlet-body form">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="detail_claim" style="padding-top: 0px !important" class="control-label control-label-custom col-xs-4">{{ trans('form3.particular_claim') }} :

                            </label>
                            <div class="col-md-6">
                            {{ $case->form1->claim_details }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="amount_claim" style="padding-top: 0px !important" class="control-label control-label-custom col-xs-4">{{ trans('form3.amount_claim') }} :

                            </label>
                            <div class="col-md-6">
                               RM {{ number_format($case->form1->claim_amount, 2, '.', ',') }}
                           </div>
                       </div>
                        @if($f1_attachments) @if($f1_attachments->count() > 0)
                        <div class="form-group form-md-line-input">
                            <label class="col-md-4 control-label" style="padding-top: 0px">{{ __('form2.supporting_docs') }} :
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                @foreach($f1_attachments as $att)
                                    <a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'><i class='fa fa-download'></i> {{ $att->attachment_name }}</a><br>
                                @endforeach
                            </div>
                        </div>
                        @endif @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Defense and counterclaim Details-->
    <div class="col-md-12 ">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.defence_counterclaim_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>

            <div class="portlet-body form">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="purchased_item" style="padding-top: 0px !important" class="control-label control-label-custom col-xs-4"> {{ trans('form3.statement_defence') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $claim_case_opponent->form2->defence_statement }}
                            </div>
                        </div>
                        @if($claim_case_opponent->form2->counterclaim_id)
                        <div class="form-group form-md-line-input">
                            <label for="purchased_item" style="padding-top: 0px !important" class="control-label control-label-custom col-xs-4"> {{ trans('form3.statement_counterclaim') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $claim_case_opponent->form2->counterclaim->counterclaim_statement }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input" id="row_amont_counterclaim">
                        <label for="amont_counterclaim" style="padding-top: 0px !important" class="control-label control-label-custom col-md-4">{{ trans('form3.total_counterclaim') }} :
                                <span id="amont_counterclaim" class="required">&nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                RM {{ number_format($claim_case_opponent->form2->counterclaim->counterclaim_amount, 2, '.', ',') }}
                            </div>
                        </div>
                        @endif
                        @if($f2_attachments) @if($f2_attachments->count() > 0)
                        <div class="form-group form-md-line-input">
                            <label class="col-md-4 control-label" style="padding-top: 0px">{{ __('form2.supporting_docs') }} :
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                @foreach($f2_attachments as $att)
                                    <a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'><i class='fa fa-download'></i> {{ $att->attachment_name }}</a><br>
                                @endforeach
                            </div>
                        </div>
                        @endif @endif



                    </div>

                </form>
            </div>

        </div>
    </div>
</div>