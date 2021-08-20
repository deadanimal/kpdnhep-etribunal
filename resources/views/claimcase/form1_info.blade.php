<div class="portlet light bordered form-fit">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="icon-layers font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('form1.info') }}</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form action="#" class="form-horizontal form-bordered ">

            <div class="form-group" style="display: flex;">
                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.ttpm_case_no') }} </div>
                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                    <span id="view_claimant_name">{{ $claim_case->case_no == $claim_case->form1_no ? '-' : $claim_case->case_no }}</span>
                </div>
            </div>

            <div class="form-group" style="display: flex;">
                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.form1_no') }} </div>
                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                    <span id="view_claimant_name">{{ $claim_case->form1_no }}</span>
                </div>
            </div>

            @if( $claim_case->inquiry_id )
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4"
                         style="padding-top: 13px;">{{ __('inquiry.inquiry_no') }} </div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="view_claimant_name">{{ $claim_case->inquiry->inquiry_no }}</span>
                    </div>
                </div>
            @endif

            <div class="form-group" style="display: flex;">
                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.submit_date') }} </div>
                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                    <span id="view_claimant_name">
                        @if(!!$claim_case->claimCase && !!$claim_case->claimCase->form1 && !!$claim_case->claimCase->form1->filing_date)
                            {{ date('d/m/Y', strtotime($claim_case->claimCase->form1->filing_date)) }}
                        @elseif(!!$claim_case->form1->filing_date)
                            {{ date('d/m/Y', strtotime($claim_case->form1->filing_date)) }}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>

            <div class="form-group" style="display: flex;">
                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.filing_date') }} </div>
                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                    <span id="view_claimant_name">
                        @if(!!$claim_case->claimCase && !!$claim_case->claimCase->form1 && !!$claim_case->claimCase->form1->processed_at)
                            {{ date('d/m/Y', strtotime($claim_case->claimCase->form1->processed_at)) }}
                        @elseif(!!$claim_case->form1->processed_at)
                            {{ date('d/m/Y', strtotime($claim_case->form1->processed_at)) }}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
