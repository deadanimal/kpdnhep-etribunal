<?php
use App\User;
use App\UserTTPM;
use App\MasterModel\MasterBranch;
?>
<?php 
$FindUserTTPM = UserTTPM::where('user_id','=', $ttpmuser->user_id)->first(); 
$FindBranch = MasterBranch::where('branch_id','=', $FindUserTTPM['branch_id'])->first();
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
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.name')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$ttpmuser->name}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.user_id')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$ttpmuser->username}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.status')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">@if($ttpmuser->user_status_id == 1) {{ trans('new.active') }} @elseif($ttpmuser->user_status_id == 2) {{ trans('new.inactive') }} @endif</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_mobile')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$FindUserTTPM['phone_mobile']}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.ic')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$FindUserTTPM['identification_no']}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.branch')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$FindBranch['branch_name']}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.designation')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$designation}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_office')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$ttpmuser->phone_office}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_fax')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$ttpmuser->phone_fax}}</span>
						</div>
					</div> 
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.email')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{$ttpmuser->email}}</span>
						</div>
					</div> 
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.signature')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<img src="data:image/png;base64,{{ base64_encode($FindUserTTPM->signature_blob) }}" style="width: 300px; height: auto; max-width: 75%;">
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

