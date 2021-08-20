<?php
use Carbon\Carbon;
?>

<form id="step_4" class="row step_item">
    
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