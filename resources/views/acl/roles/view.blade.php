<?php

$display_name = "display_name_".App::getLocale();

?>

<link href="{{ URL::to('/assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
.sweet-overlay{z-index:50000;}.sweet-alert{z-index:50001;}  .swal-modal{z-index:50002;}
.modal-body {padding: 0px;}
</style>
<div class="modal-body">
 <div class="portlet light bordered form-fit">
    <div class="portlet-body form">
      <form action="#" class="form-horizontal form-bordered ">
        <div class="form-body">
            <div class="form-group" style="display: flex;">
              <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('acl.role') }}</div>
              <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                <span id="">{{$role->name  or ''}}</span>
              </div>
            </div>  
            <div class="form-group" style="display: flex;">
              <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('acl.role_name') }} (EN)</div>
              <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                <span id="">{{$role->display_name_en  or ''}}</span>
              </div>
            </div>
            <div class="form-group" style="display: flex;">
              <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('acl.role_name') }} (MY)</div>
              <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                <span id="">{{$role->display_name_my  or ''}}</span>
              </div>
            </div>
            <div class="form-group" style="display: flex;">
              <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('acl.role_desc') }}</div>
              <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                <span id="">{{$role->description  or ''}}</span>
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
<script src="{{ URL::to('/assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>
