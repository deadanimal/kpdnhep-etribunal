<div class="portlet light bordered form-fit">
    <div class="portlet-body form">
        <form action="#" class="form-horizontal form-bordered ">
            <div class="form-body">
                <div class="form-group" style="display: flex;">
                    <div class="col-xs-12 font-green-sharp" style="align-items: stretch;">
                        <span class="bold" style="align-items: stretch;">{{ __('form1.claim_info') }}</span>
                    </div>
                </div>
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.particular_claim') }} </div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="view_claim_details">{!! nl2br($claim_case->form1->claim_details) !!}</span>
                    </div>
                </div>
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.amount_claim') }} </div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="view_claim_amount">{{ number_format($claim_case->form1->claim_amount, 2, '.', ',') }}</span>
                    </div>
                </div>
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.prev_court') }} </div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_is_filed_on_court">
                                                        @if( $claim_case->form1->court_case_id)
                                                            {{ trans('form1.yes') }}
                                                        @else
                                                            {{ trans('form1.no') }}
                                                        @endif
                                                    </span>
                    </div>
                </div>
                @if( $claim_case->form1->court_case_id)
                    <div class="form-group is_filed" style="display: flex;">
                        <div class="col-md-12">
                            <span class="bold" style="align-items: stretch;">{{ __('form1.court_info') }}</span>
                        </div>
                    </div>

                    <div class="form-group is_filed" style="display: flex;">
                        <div class="control-label col-md-4">{{ __('form1.court_name') }}:</div>
                        <div class="col-md-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_case_name">{{ $claim_case->form1->court_case->court_case_name }}</span>
                        </div>
                    </div>
                    <div class="form-group is_filed" style="display: flex;">
                        <div class="control-label col-md-4">{{ __('form1.status_case') }} :</div>
                        <div class="col-md-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_case_status">{{ $claim_case->form1->court_case->court_case_status }}</span>
                        </div>
                    </div>
                    <div class="form-group is_filed" style="display: flex;">
                        <div class="control-label col-md-4">{{ __('form1.place_case') }} :</div>
                        <div class="col-md-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_case_place">{{ $claim_case->form1->court_case->court_case_location }}</span>
                        </div>
                    </div>
                    <div class="form-group is_filed" style="display: flex;">
                        <div class="control-label col-md-4">{{ __('form1.filing_date') }} :</div>
                        <div class="col-md-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_case_created_at">{{ $date['court_case_filing_date'] or '' }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>