<div class="portlet light bordered form-fit">
                            <div class="portlet-body form">
                                <form action="#" class="form-horizontal form-bordered ">
                                    <div class="form-body">
                                        <div class="form-group" style="display: flex;">
                                            <div class="col-xs-12">
                                                <span class="bold" style="align-items: stretch;">{{ __('form1.transaction_info') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.online_purchased') }} </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_is_online_transaction">
                                                    @if( $claim_case->form1->is_online_purchased == 1)
                                                    {{ trans('form1.yes') }}
                                                    @else
                                                    {{ trans('form1.no') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.transaction_date') }} </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_date">{{ $claim_case->form1->purchased_date ? date('d/m/Y', strtotime($claim_case->form1->purchased_date." 00:00:00")) : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.purchased_used') }} </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_item">{{ $claim_case->form1->purchased_item_name }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.brand_model') }} </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_brand">{{ $claim_case->form1->purchased_item_brand ? $claim_case->form1->purchased_item_brand : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.amount_paid') }} </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_purchased_amount">{{ $claim_case->form1->purchased_amount ? number_format($claim_case->form1->purchased_amount, 2, '.', ',') : '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>