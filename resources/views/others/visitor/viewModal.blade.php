<?php
$locale = App::getLocale();
$reason_lang = "reason_".$locale;
?>
<style>
    .modal-body {padding: 0px;}
    
    .control-label-custom  {
        padding-top: 15px !important;
    }

</style>
<div class="modal-body">
    <div class="portlet light bordered form-fit">
        <div class="portlet-body form">
            <form action="#" class="form-horizontal form-bordered ">
                <div class="form-body">
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ $visitor->country_id == 129 ? __('form1.ic_no') : __('form1.passport_no') }}</div>
                        <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                            <span>{{ $visitor->visitor_identification_no }}</span>
                        </div>
                    </div>
                    @if($visitor->country_id != 129)
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('form1.nationality') }}</div>
                        <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                            <span>@if($visitor->country_id){{ $visitor->country->country }}@endif</span>
                        </div>
                    </div>
                    @endif
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('form1.name') }}</div>
                        <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                            <span>{{ $visitor->visitor_name }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('form1.reason') }}</div>
                        <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                            <span>{{ $visitor->reason->$reason_lang }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('form1.remarks') }}</div>
                        <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                            <span>{{ $visitor->visitor_remarks }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.date_time') }}</div>
                        <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                            <span>{{ date('d/m/Y H:i A', strtotime($visitor->visitor_datetime)) }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('form1.psu_assigned') }}</div>
                        <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                            <span>{{ $visitor->psu->name }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.branch') }}</div>
                        <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                            <span>{{ $visitor->psu->ttpm_data->branch->branch_name }}</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('new.close')}}</button>
</div>
