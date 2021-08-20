<?php
$locale = App::getLocale();
$type_lang = 'type_'.$locale;
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
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.user') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span> {{ $audit_trail->created_by ? $audit_trail->created_by->name : '-' }} </span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;"> Model </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span> {{ $audit_trail->model ? $audit_trail->model : "-" }} </span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.old_data') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span style="overflow-wrap: break-word;"> {{ $audit_trail->data_old ? $audit_trail->data_old : "-" }} </span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.new_data') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span style="overflow-wrap: break-word;"> {{ $audit_trail->data_new ? $audit_trail->data_new : "-" }} </span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.type') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span>{{ $audit_trail->type->$type_lang }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;"> URL </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span> {{ $audit_trail->url ? $audit_trail->url : "-" }} </span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.ip_address') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span> {{ $audit_trail->ip_address }} </span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.created_at') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span> {{ date('d/m/Y', strtotime( $audit_trail->created_at)) }} </span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.desc') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span> {{ $audit_trail->description ? $audit_trail->description : "-" }}</span>
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

