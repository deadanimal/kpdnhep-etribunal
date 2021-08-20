<?php
use Carbon\Carbon;
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
                            <label for="filing_date" id="label_filing_date" class="control-label col-md-4">{{ __('form1.filing_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme" name="filing_date" id="filing_date" readonly="" data-date-end-date="0d" data-date-format="dd/mm/yyyy" type="text" value="{{ date('d/m/Y') }}"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <div id="row_matured_date" class="form-group form-md-line-input">
                            <label for="matured_date" id="label_matured_date" class="control-label col-md-4">{{ __('form1.matured_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme" name="matured_date" id="matured_date" readonly="" data-date-start-date="+0d" data-date-format="dd/mm/yyyy" type="text" value="{{ Carbon::now()->addDays( env('CONF_F2_MATURED_DURATION', 14) )->format('d/m/Y') }}"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div id="row_payment_method" class="form-group form-md-line-input">
                            <label for="payment_method" id="row_claim_offence" class="control-label col-md-4">{{ __('form1.payment_method') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange='togglePostal()' required class="form-control select2 bs-select" id="payment_method" name="payment_method"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @if($case) 
                                        @if($case->form2)
                                            @if($case->form2->payment)
                                                @if($case->form2->payment->payment_fpx_id != null)
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
                            <label for="postalorder_no" id="label_claimant_name" style="padding-top: 0px" class="control-label col-md-4">{{ __('form1.postal_no') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="postalorder_no" name="postalorder_no" data-role="tagsinput" 
                                @if($case)
                                    @if($case->form2)
                                        @if($case->form2->payment_id)
                                            @if($case->form2->payment->payment_postalorder_id)
                                                value="{{ $case->form2->payment->postalorder->postalorder_no }}"
                                            @elseif($case->form2->payment->payment_fpx_id)
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
                            <label for="receipt_no" id="label_claimant_name" style="padding-top: 0px" class="control-label col-md-4">{{ __('form1.receipt_no') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="receipt_no" name="receipt_no"
                                @if($case)
                                    @if($case->form2_id)
                                        @if($case->form2->payment_id)
                                            @if($case->form2->payment->receipt_no) value="{{ $case->form2->payment->receipt_no }}"
                                            @endif

                                            @if($case->form2->payment->payment_fpx_id OR false)
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
                            <label for="payment_date" id="label_filing_date" class="control-label col-md-4">{{ __('form1.payment_date') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme" name="payment_date" id="payment_date" readonly="" data-date-format="dd/mm/yyyy" type="text" 
                                    @if($case)
                                        @if($case->form2_id)
                                            @if($case->form2->payment_id)
                                                @if($case->form2->payment->paid_at) value="{{ date('d/m/Y', strtotime($case->form2->payment->paid_at)) }}"
                                                @else value="{{ date('d/m/Y') }}"
                                                @endif

                                                @if($case->form2->payment->payment_fpx_id OR false)
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

                        <div id="row_psu" class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence" class="control-label col-md-4">{{ trans('form1.psu_incharged')}} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2 bs-select" id="psu" name="psu"  data-placeholder="---">
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

                    </div>
                </div>
            </div>
        </div>
    </div>

</form>