<div id="step_3" class="row step_item">
    <div class="col-md-12 ">
        <!-- Inquiry-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form1.transaction_info') }} </span>
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
                        <div id="row_is_online_transaction" class="form-group form-md-line-input">
                            <label for="is_online_transaction_yes" id="label_is_online_transaction" class="control-label col-md-4">{{ __('form1.online_purchase') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input required onchange="updateReview()" id="is_online_transaction_yes" name="is_online_transaction" class="md-checkboxbtn" checked type="radio" value="1">
                                        <label for="is_online_transaction_yes">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>{{ __('form1.yes') }}
                                        </label>
                                    </div>
                                    <div class="md-radio">
                                        <input required onchange="updateReview()" id="is_online_transaction_no" name="is_online_transaction" class="checkboxbtn" type="radio" value="0">
                                        <label for="is_online_transaction_no">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>{{ __('form1.no') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="row_transaction_date" class="form-group form-md-line-input">
                            <label for="purchased_date" id="label_transaction_date" class="control-label col-md-4">{{ __('form1.transaction_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input onchange="updateReview()" class="form-control form-control-inline date-picker datepicker clickme" name="purchased_date" id="purchased_date" readonly="" data-date-format="dd/mm/yyyy" type="text" data-date-end-date="0d"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div id="row_purchased_item" class="form-group form-md-line-input">
                            <label for="purchased_item" id="label_purchased_item" class="control-label col-md-4">{{ __('form1.purchased_used') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea required onchange="updateReview()" id="purchased_item" name="purchased_item" class="form-control" rows="2" placeholder=""></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_purchased_brand" class="form-group form-md-line-input">
                            <label for="purchased_brand" id="label_purchased_brand" class="control-label col-md-4">{{ __('form1.brand_model') }} :
                                <span> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control" id="purchased_brand" name="purchased_brand" value=""/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_purchased_amount" class="form-group form-md-line-input">
                            <label for="purchased_amount" id="label_purchased_amount" class="control-label col-md-4">{{ __('form1.amount_paid') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control decimal" id="purchased_amount" name="purchased_amount" value=""/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <!-- Claim-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form1.claim_info') }}</span>
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
                        <div id="row_claim_details" class="form-group form-md-line-input">
                            <label for="claim_details" id="label_claim_details" class="control-label col-md-4">{{ __('form1.particular_claim') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea required onchange="updateReview()" id="claim_details" name="claim_details" class="form-control" rows="2" placeholder=""></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claim_amount" class="form-group form-md-line-input">
                            <label for="claim_amount" id="label_claim_amount" class="control-label col-md-4">{{ __('form1.amount_claim') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input required onchange="updateReview()" type="text" class="form-control decimal" id="claim_amount" name="claim_amount" value=""/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_filed_on_court" class="form-group form-md-line-input">
                            <label for="filed_on_court" id="label_filed_on_court" class="control-label col-md-4">{{ __('form1.filed_on_court') }} :
                            <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input onchange="updateReview()" id="is_filed_on_court_yes" name="is_filed_on_court" class="md-checkboxbtn" type="radio" value="1">
                                        <label for="is_filed_on_court_yes">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>{{ __('form1.yes') }}
                                        </label>
                                    </div>
                                    <div class="md-radio">
                                        <input onchange="updateReview()" id="is_filed_on_court_no" name="is_filed_on_court" class="checkboxbtn" checked type="radio" value="0">
                                        <label for="is_filed_on_court_no">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>{{ __('form1.no') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class='is_filed' style="border: 1px solid black; padding: 0px; margin-bottom: 25px; ">
                            <div id="row_case_name" class="form-group form-md-line-input">
                                <label for="case_name" id="label_case_name" class="control-label col-md-4">{{ __('form1.court_name') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input required onchange="updateReview()" type="text" class="form-control" id="case_name" name="case_name" value=""/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_case_status" class="form-group form-md-line-input">
                                <label for="case_status" id="label_case_status" class="control-label col-md-4">{{ __('form1.status_case') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="text" class="form-control" id="case_status" name="case_status" value=""/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_case_place" class="form-group form-md-line-input">
                                <label for="case_place" id="label_case_status" class="control-label col-md-4">{{ __('form1.place_case') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="text" class="form-control" id="case_place" name="case_place" value=""/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_case_created_at" class="form-group form-md-line-input">
                                <label for="case_created_at" id="label_case_created_at" class="control-label col-md-4">{{ __('form1.registration_date') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group date" data-date-format="dd/mm/yyyy">
                                        <input onchange="updateReview()" class="form-control form-control-inline date-picker datepicker clickme" name="case_created_at" id="case_created_at" readonly="" data-date-format="dd/mm/yyyy" type="text"/>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>


                        @if(!$is_staff)
                        <div id="row_preferred_ttpm_branch" class="form-group form-md-line-input">
                            <label for="preferred_ttpm_branch" id="label_claimant_nationality" class="control-label col-md-4">{{ __('form1.preferred_ttpm_branch') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required onchange="updateReview()" class="form-control select2 bs-select" id="preferred_ttpm_branch" name="preferred_ttpm_branch"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($branches as $branch)
                                        <option 
                                        @if($case)
                                            @if($case->branch_id == $branch->branch_id) selected 
                                            @endif
                                        @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }} @if($branch->is_hq == 1)(HQ)@endif</option>
                                    @endforeach
                                </select><br>
                                <small style="color: red;">{{ trans('form1.hearing_loc') }}</small>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        @endif
                        <div id="row_supporting_docs" class="form-group form-md-line-input"">
                            <label id="label_supporting_docs" class="col-md-4 control-label">{{ __('form1.supporting_docs') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="m-heading-1 border-green m-bordered margin-bottom-10">
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
                                        <span class="required"> ** {{ __('new.example') }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>