<div id="step_1" class="row step_item">
    <div class="col-md-12">

        <!-- Inquiry-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.branch') }}</span>
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
                            <label for="inquiry_no" class="control-label col-md-4"
                                   style="padding-top: 0px"> {{ __('form2.tribunal_branch') }} :</label>
                            <div class="col-md-7">
                                <input hidden type="text" id="claim_case_id" name="claim_case_id"
                                       @if(isset($case))
                                       value="{{ $caseOppo->id }}"
                                        @endif
                                />
                                <span style="padding-top: 5px; font-weight: bold;">{{ $case->branch->branch_name }}</span><br>
                                {{ $case->branch->branch_address }},<br>
                                {{ $case->branch->branch_address2 }}<br><br>
                                {{ $case->branch->branch_address3 }}<br>
                                {{ $case->branch->branch_postcode }} {{ $case->branch->district->district }}<br>
                                {{ $case->branch->state->state }}<br><br>
                                {{ __('form2.phone') }}: {{ $case->branch->branch_office_phone }}
                                / {{ $case->branch->branch_office_fax }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <!-- Claimant-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.claimant_info') }} </span>
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
                            <label for="claimant_identification_no" style="padding-top: 0px"
                                   class="control-label col-md-4">
                                <span id="label_claimant_identification_no">
                                @if($case->claimant_address->is_company == 0)
                                        @if($case->claimant_address->nationality_country_id == 129)
                                            {{ __('form2.ic_no') }} :
                                        @else
                                            {{ __('form2.passport_no') }} :
                                        @endif
                                    @else
                                        {{ __('form2.company_no') }} :
                                    @endif
                                </span>
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->identification_no }}
                            </div>
                        </div>
                        @if($case->claimant_address->is_company == 0)
                            @if($case->claimant_address->nationality_country_id != 129)
                                <div class="form-group form-md-line-input">
                                    <label for="claimant_name" style="padding-top: 0px"
                                           class="control-label col-md-4">{{ __('form2.nationality') }} :
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-6">
                                        {{ $case->claimant_address->nationality->country }}
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="form-group form-md-line-input">
                            <label for="claimant_name" style="padding-top: 0px"
                                   class="control-label col-md-4">{{ __('form2.claimant_name') }} :
                                <span class="required"> * </span>
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

    <div class="col-md-12 ">
        <!-- Claimant Contact Details-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.claimant_address_info') }} </span>
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
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street1" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.street') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->street_1 }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street2" class="control-label col-md-4" style="padding-top: 0px">
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->street_2 }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street3" class="control-label col-md-4" style="padding-top: 0px">
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->street_3 }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_postcode" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.postcode') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->postcode }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_state" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.district') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->district ? $case->claimant_address->district->district : '' }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_district" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.state') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->state ? $case->claimant_address->state->state : '' }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <!-- Claimant Mailing Address Details-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.claimant_mailing_address_info') }} </span>
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
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street1" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.street') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->address_mailing_street_1 ? $case->claimant_address->address_mailing_street_1 : '' }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street2" class="control-label col-md-4" style="padding-top: 0px">
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->address_mailing_street_2 ? $case->claimant_address->address_mailing_street_2 : '' }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street3" class="control-label col-md-4" style="padding-top: 0px">
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->address_mailing_street_3 ? $case->claimant_address->address_mailing_street_3 : '' }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_postcode" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.postcode') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->address_mailing_postcode ? $case->claimant_address->address_mailing_postcode : '' }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_state" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.district') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->address_mailing_district_id ? $case->claimant_address->districtmailing->district : '' }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist">
                            <label for="claimant_district" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.state') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->address_mailing_state_id ? $case->claimant_address->statemailing->state : '' }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <!-- Claimant Contact Details-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.claimant_contact_info') }} </span>
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
                        <div class="form-group form-md-line-input" id="row_claimant_phone_home">
                            <label for="claimant_phone_home" class="control-label col-md-4" style="padding-top: 0px">
                                <span id="label_claimant_phone_home">{{ __('form2.home_phone') }} :</span>
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                @if($case->claimant_address->is_company == 0)
                                    {{ $case->claimant_address->phone_home }}
                                @else
                                    {{ $case->claimant->public_data->company->representative_phone_home }}
                                @endif
                            </div>
                        </div>
                        <div class="form-group form-md-line-input" id="row_claimant_phone_mobile">
                            <label for="claimant_phone_mobile" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.mobile_phone') }} :
                                <span id="claimant_phone_mobile" class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                @if($case->claimant_address->is_company == 0)
                                    {{ $case->claimant_address->phone_mobile }}
                                @else
                                    {{ $case->claimant->public_data->company->representative_phone_mobile }}
                                @endif
                            </div>
                        </div>

                        <div class="form-group form-md-line-input non-tourist" id="row_claimant_phone_office">
                            <label for="claimant_phone_office" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.office_phone') }} :
                                <span id="claimant_phone_office" class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->phone_office }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input non-tourist" id="row_claimant_phone_fax">
                            <label for="claimant_phone_fax" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.fax_no') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->phone_fax }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="claimant_email" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.email') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->claimant_address->email }}
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
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.claim_info') }} </span>
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
                            <label for="purchased_date" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.transaction_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->form1->purchased_date ? date('d/m/Y', strtotime($case->form1->purchased_date)) : '-' }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="purchased_item" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.purchased_used') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->form1->purchased_item_name }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="purchased_brand" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.brand_model') }} :
                                <span> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->form1->purchased_item_brand }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="paid_amount" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.amount_paid') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->form1->purchased_amount == 0 ? number_format($case->form1->purchased_amount, 2, '.', ',') : '-' }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="claim_details" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.particular_claim') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ $case->form1->claim_details }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="claim_amount" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.amount_claim') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ number_format($case->form1->claim_amount, 2, '.', ',') }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="filed_on_court" class="control-label col-md-4"
                                   style="padding-top: 0px">{{ __('form2.filed_on_court') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                @if($case->form1->court_case_id){{ __('form2.yes') }}@else{{ __('form2.no') }}@endif
                            </div>
                        </div>
                        @if($case->form1->court_case_id)
                            <div id="row_court_case" class="form-group form-md-line-input">
                                <label for="case_name" class="control-label col-md-4"
                                       style="padding-top: 0px">{{ __('form2.court_name') }} :
                                    <span class="required"> &nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    {{ $case->form1->court_case->court_case_name }}
                                </div>
                            </div>
                            <div id="row_status_case" class="form-group form-md-line-input">
                                <label for="case_status" class="control-label col-md-4"
                                       style="padding-top: 0px">{{ __('form2.status_case') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    {{ $case->form1->court_case->court_case_status }}
                                </div>
                            </div>
                            <div id="row_place_case" class="form-group form-md-line-input">
                                <label for="case_place" class="control-label col-md-4"
                                       style="padding-top: 0px">{{ __('form2.place_case') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    {{ $case->form1->court_case->court_case_location }}
                                </div>
                            </div>
                            <div id="row_date_register" class="form-group form-md-line-input ">
                                <label for="case_created_at" class="control-label col-md-4"
                                       style="padding-top: 0px">{{ __('form2.registration_date') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    @if($case->form1->court_case->filing_date)
                                        {{ date('d/m/Y', strtotime($case->form1->court_case->filing_date)) }}
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if($f1_attachments) @if($f1_attachments->count() > 0)
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label"
                                       style="padding-top: 0px">{{ __('form2.supporting_docs') }} :
                                    <span>&nbsp;&nbsp;</span>
                                </label>
                                <div class="col-md-6">
                                    @foreach($f1_attachments as $att)
                                        <a target="_blank"
                                           href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}'
                                           class='btn dark btn-outline'><i
                                                    class='fa fa-download'></i> {{ $att->attachment_name }}</a><br>
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