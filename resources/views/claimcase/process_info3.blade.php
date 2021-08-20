<div class="portlet light bordered form-fit">
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal form-bordered ">
                                        <div class="form-body">

                                            <div class="form-group" style="display: flex;">
                                                <div class="col-md-12">
                                                    <span class="bold" style="align-items: stretch;">{{ trans('form1.process_info') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;"> {{ trans('form1.filing_date') }}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claim_details">{{ $date['form3_filing_date'] or '' }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('form1.psu_incharged') }}</div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_claim_details">{{ $claim_case->psu->name or '' }}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>