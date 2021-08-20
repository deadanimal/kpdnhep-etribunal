<?php
use App\MasterModel\MasterBank;
use App\MasterModel\MasterFPXStatus;
$locale = App::getLocale();
$desc_lang = "description_".$locale;
?>

@extends('layouts.app')

@section('after_styles')
<style>
    .control-label-custom  {
        padding-top: 15px !important;
    }
</style>
@endsection

@section('content')

<style>
@media print {
    #btn-action {
        display: none;
    }
}
</style>

<div class="m-heading-1 border-green m-bordered margin-top-10">
    <h3>{{ trans('fpx.trans_details') }}</h3>
    <span>{{ trans('fpx.trans_check') }}.</span>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet light bordered form-fit">
            <div class="portlet-body form">
                <div class="form-horizontal form-bordered ">
                    <div class="form-body">
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.trans_status') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                @if($fpx_debitAuthCode && $fpx_debitAuthCode=="00")
                                <span style="color:#5bcf36 !important" id="">{{ trans('fpx.success') }}</span>
                                @elseif($fpx_debitAuthCode && in_array($fpx_debitAuthCode, ['99', '09']))
                                <span style="color:#d18721 !important" id="">{{ trans('fpx.pending') }}. {{ trans('fpx.pending_notes') }}</span>
                                @else
                                <span style="color:red !important" id="">{{ trans('fpx.unsuccess') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.trans_remarks') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">@if($fpx_debitAuthCode){{ MasterFPXStatus::find($fpx_debitAuthCode)->$desc_lang }}@else{{ trans('fpx.undefined') }}@endif</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.trans_id') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $fpx_fpxTxnId }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.seller_order_no') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $fpx_sellerOrderNo }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.seller_name') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ trans('fpx.kpdnkk') }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.trans_bank') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ MasterBank::where('bank_code',$fpx_buyerBankId)->first()->name }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.trans_amount') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">RM {{ $fpx_txnAmount }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.trans_date') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $payment->fpx->paid_at ?: date('d/m/Y h:i A') }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.claim_no') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $case->case_no }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.payment_desc') }} :</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $description }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id='btn-action' class="row">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">

        <a id="btn_back" href="{{ request()->is('payment/fpx/details/*') ? 'javascript:;' : url('/onlineprocess/form').$form_no.'/?status='.( $form_no == 1 ? '15' : '20') }}" class="btn default button-previous"  @if(request()->is('payment/fpx/details/*')) onclick='goBack()' @endif >
            <i class="fa fa-angle-left"></i> {{ __('button.back') }}
        </a>

        <a id="btn_print" onclick="window.print();" class="btn dark btn-outline button-previous">
            <i class="fa fa-print"></i> {{ __('button.print') }}
        </a>

        @if($payment->payment_status_id == 4)
        <a id="btn_print_receipt" href="{{ route('integration-fpx-receipt-print', ['payment_id' => $payment->payment_id] ) }}" class="btn dark button-previous">
            <i class="fa fa-print"></i> {{ __('button.print_receipt') }}
        </a>
        @endif

    </div>
</div>

@endsection

@section('after_scripts')
<script type="text/javascript">
    function goBack() {
        if (document.referrer == "") {
            console.log(document.referrer);
            window.close()
        } else {
            history.back()
        }
    }
</script>
@endsection