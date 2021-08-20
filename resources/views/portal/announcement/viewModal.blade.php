<?php
$locale = App::getLocale();
$announcement_type_lang = "announcement_type_".$locale;
?>
<style>
	.modal-body {padding: 0px;}
	
	.control-label-custom  {
        padding-top: 15px !important;
    }

    /*#map {
    	width: 100%;
    	height: 400px;
    	background-color: grey;
    }*/
</style>
<div class="modal-body">
	<div class="portlet light bordered form-fit">
		<div class="portlet-body form">
			<form action="#" class="form-horizontal form-bordered ">
				<div class="form-body">
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.title') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span style="font-weight: bold;">{{ $announcement->title_en }}</span><br>
							<span style="font-style: italic;">{{ $announcement->title_my }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.announcement') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span style="font-weight: bold;">{{ $announcement->description_en }}</span><br>
							<span style="font-style: italic;">{{ $announcement->description_my }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.created_by')}} </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id=""><span class='label label-primary'>{{ $announcement->created_by->roleuser->first()->role->display_name }}</span> {{ $announcement->created_by->name }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.created_date')}} </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ date('d/m/Y', strtotime($announcement->created_at)) }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.start_date') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ date('d/m/Y', strtotime($announcement->start_date)) }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.expiry_date') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ date('d/m/Y', strtotime($announcement->end_date)) }}</span>
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