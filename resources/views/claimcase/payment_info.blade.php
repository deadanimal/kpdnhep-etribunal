@if($claim_case->form1_id) @if($payments)
    @foreach($payments as $payment)
        <div class="portlet light bordered form-fit">
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">
                    <div class="form-body">
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-12">
                                <span class="bold" style="align-items: stretch;">{{ trans('form1.payment_info')}}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4"
                                 style="padding-top: 13px;"> {{ trans('form1.payment_method')}}</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_details">
                                @if($payment->payment_fpx_id)
                                        {{ __('form1.online_payment') }}
                                    @elseif($payment->payment_postalorder_id)
                                        {{ __('form1.postal_order') }}
                                    @else
                                        {{ __('form1.pay_counter') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        @if($payment->payment_fpx_id)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ trans('fpx.trans_id') }}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claim_details">
                                        @if(Auth::id() == $claim_case->claimant_user_id || Auth::user()->user_type_id != 3)
                                            <a data-toggle="tooltip"
                                               title="{{ trans('form1.view_receipt') }}"
                                               class='btn blue'
                                               href='{{ route("integration-fpx-details", ["payment_id" => $payment->payment_id]) }}'>
                                                <i class='fa fa-file-text-o'></i> {{ $payment->fpx->fpx_transaction_no }}
                                            </a>
                                        @else
                                            {{ $payment->fpx->fpx_transaction_no }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ trans('fpx.trans_bank') }}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claim_details">{{ $payment->fpx->bank ? $payment->fpx->bank->bank : '' }}</span>
                                </div>
                            </div>
                        @elseif($payment->payment_postalorder_id)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;"> {{ trans('form1.postal_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claim_details">{{ $payment->postalorder->postalorder_no }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4"
                                 style="padding-top: 13px;">{{ trans('fpx.payment_amount')}}</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_details">RM 5.00</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4"
                                 style="padding-top: 13px;">{{ trans('fpx.payment_date')}}</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_details">{{ $date['form1_paid_at'] or '' }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4"
                                 style="padding-top: 13px;">{{ trans('fpx.payment_status')}}</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_details">{{ $payment->status->$status_lang }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4"
                                 style="padding-top: 13px;">{{ trans('form1.receipt_no')}}</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_details">{{ $payment->receipt_no }}</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endif @endif