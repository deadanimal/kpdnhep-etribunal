<?php

use Carbon\Carbon;

$locale = App::getLocale();
$category_lang = "category_" . $locale;
$offence_lang = "offence_description_" . $locale;
?>

<form id="step_5" class="row step_item">

    <div class="col-md-12 mt-element-ribbon">
        <!-- Process-->

        <div class="ribbon ribbon-right ribbon-clip ribbon-color-danger uppercase">
            <div class="ribbon-sub ribbon-clip ribbon-right"></div> {{ __('form1.office_use') }}
        </div>

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-red-thunderbird"></i>
                    <span class="caption-subject bold font-red-thunderbird uppercase"> {{ __('form1.process_claim') }}</span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal" role="form">
                    <div class="form-body">

                        <div id="row_filing_date" class="form-group form-md-line-input">
                            <label for="filing_date" id="label_filing_date"
                                   class="control-label col-md-4">{{ __('form1.filing_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme"
                                           name="filing_date" id="filing_date" readonly="" data-date-end-date="0d"
                                           data-date-format="dd/mm/yyyy" type="text" value="{{ date('d/m/Y') }}"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <div id="row_matured_date" class="form-group form-md-line-input">
                            <label for="matured_date" id="label_matured_date"
                                   class="control-label col-md-4">{{ __('form1.matured_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme"
                                           name="matured_date" id="matured_date" readonly="" data-date-start-date="+0d"
                                           data-date-format="dd/mm/yyyy" type="text"
                                           value="{{ Carbon::now()->addDays( env('CONF_F1_MATURED_DURATION', 14) )->format('d/m/Y') }}"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div id="row_payment_method" class="form-group form-md-line-input">
                            <label for="payment_method" id="row_claim_offence"
                                   class="control-label col-md-4">{{ __('form1.payment_method') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange='togglePostal()' required class="form-control select2 bs-select"
                                        id="payment_method" name="payment_method" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @if($case)
                                        @if($case->form1_id)
                                            @if($case->form1->payment_id)
                                                @if($case->form1->payment->payment_fpx_id)
                                                    <option value="1">{{ __('form1.online_payment') }}</option>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                    <option value="2">{{ __('form1.pay_counter') }}</option>
                                    <option value="3">{{ __('form1.postal_order') }}</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_postalorder_no" class="form-group form-md-line-input hidden">
                            <label for="postalorder_no" id="label_claimant_name" style="padding-top: 0px"
                                   class="control-label col-md-4">{{ __('form1.postal_no') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="postalorder_no" name="postalorder_no"
                                       data-role="tagsinput"
                                       @if($case)
                                       @if($case->form1_id)
                                       @if($case->form1->payment_id)
                                       @if($case->form1->payment->payment_postalorder_id)
                                       value="{{ $case->form1->payment->postalorder->postalorder_no }}"
                                       @elseif($case->form1->payment->payment_fpx_id)
                                       readonly
                                        @endif
                                        @endif
                                        @endif
                                        @endif
                                />
                                <small style="font-style: italic; color: grey;">{{ __('new.use_comma_separator') }}</small>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_receipt_no" class="form-group form-md-line-input">
                            <label for="receipt_no" id="label_claimant_name" style="padding-top: 0px"
                                   class="control-label col-md-4">{{ __('form1.receipt_no') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="receipt_no" name="receipt_no"
                                       @if($case)
                                       @if($case->form1_id)
                                       @if($case->form1->payment_id)
                                       @if($case->form1->payment->receipt_no) value="{{ $case->form1->payment->receipt_no }}"
                                       @endif

                                       @if($case->form1->payment->payment_fpx_id OR false)
                                       readonly
                                        @endif

                                        @endif
                                        @endif
                                        @endif

                                />
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_payment_date" class="form-group form-md-line-input">
                            <label for="payment_date" id="label_filing_date"
                                   class="control-label col-md-4">{{ __('form1.payment_date') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme"
                                           name="payment_date" id="payment_date" readonly=""
                                           data-date-format="dd/mm/yyyy" type="text"
                                           @if($case)
                                           @if($case->form1_id)
                                           @if($case->form1->payment_id)
                                           @if($case->form1->payment->paid_at) value="{{ date('d/m/Y', strtotime($case->form1->payment->paid_at)) }}"
                                           @else value="{{ date('d/m/Y') }}"
                                           @endif

                                           @if($case->form1->payment->payment_fpx_id OR false)
                                           disabled
                                           @endif

                                           @else value="{{ date('d/m/Y') }}"
                                           @endif
                                           @else value="{{ date('d/m/Y') }}"
                                           @endif
                                           @else value="{{ date('d/m/Y') }}"
                                            @endif
                                    />
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div id="row_claim_category" class="form-group form-md-line-input">
                            <label for="claim_category" id="label_claim_category"
                                   class="control-label col-md-4">{{ __('form1.category_claim') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required onchange="loadClassification()" class="form-control select2 bs-select"
                                        id="claim_category" name="claim_category" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->claim_category_id }}">{{ $category->$category_lang }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_claim_classification" class="form-group form-md-line-input">
                            <label for="claim_classification" id="label_claim_classification"
                                   class="control-label col-md-4">{{ __('form1.classification_claim') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2 bs-select" id="claim_classification"
                                        name="claim_classification" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_claim_offence" class="form-group form-md-line-input">
                            <label for="claim_offence" id="row_claim_offence"
                                   class="control-label col-md-4">{{ __('form1.type_offence') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2 bs-select" id="claim_offence"
                                        name="claim_offence" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($offences as $offence)
                                        <option
                                                @if($case && $case->form1_id && $case->form1->offence_type_id && $case->form1->offence_type_id == $offence->offence_type_id)
                                                selected
                                                @endif
                                                value="{{ $offence->offence_type_id }}">{{ $offence->offence_code }}
                                            - {{ $offence->$offence_lang }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <hr>

                        <div id="row_branch" class="form-group form-md-line-input">
                            <label for="branch" id="row_claim_offence"
                                   class="control-label col-md-4">{{ trans('new.branch')}} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange='loadHearing(this)' required class="form-control select2 bs-select"
                                        id="branch" name="branch" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($branches as $branch)
                                        <option
                                                @if($case)
                                                @if($case->branch_id == $branch->branch_id) selected
                                                @endif
                                                @endif
                                                value="{{ $branch->branch_id }}">{{ $branch->branch_name }} @if($branch->is_hq)
                                                (HQ)@endif</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_venue" class="form-group form-md-line-input">
                            <label for="hearing_venue_id" class="control-label col-md-4">{{ __('new.place_hearing') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2 bs-select" id="hearing_venue_id"
                                        name="hearing_venue_id" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($hearing_venues as $venue)
                                        @if($venue->is_active == 1)
                                            <option
                                                    @if($case)
                                                    @if($case->hearing_venue_id)
                                                    @if($case->hearing_venue_id == $venue->hearing_venue_id) selected
                                                    @endif
                                                    @endif
                                                    @endif
                                                    value="{{ $venue->hearing_venue_id }}">{{ $venue->hearing_venue }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_psu" class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence"
                                   class="control-label col-md-4">{{ trans('form1.psu_incharged')}} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2 bs-select" id="psu" name="psu"
                                        data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($psus as $psu)
                                        <option
                                                @if($case)
                                                @if($case->psu_user_id)
                                                @if($case->psu_user_id == $psu->user_id) selected
                                                @endif
                                                @endif
                                                @endif
                                                value="{{ $psu->user_id }}">{{ $psu->user->name }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_hearing_date" class="form-group form-md-line-input">
                            <label for="hearing_date" id="label_hearing_date"
                                   class="control-label col-md-4">{{ __('form1.hearing_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <select class="form-control select2-allow-clear bs-select" id="hearing_date"
                                        name="hearing_date" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
