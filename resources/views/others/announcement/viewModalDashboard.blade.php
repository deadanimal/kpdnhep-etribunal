<?php
$locale = App::getLocale();
$title_lang = "title_".$locale;
$description_lang = "description_".$locale;
$display_name = "display_name_".$locale;
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
							<span>{{ $announcement->$title_lang }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.announcement') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span>{{ $announcement->$description_lang }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.created_by')}} </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">
								<span class='label label-primary'>{{ $announcement->creator ? $announcement->creator->roleuser->first()->role->$display_name : '' }}</span> {{ $announcement->creator ? $announcement->created_by->name : '' }}
							</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('others.created_date')}} </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ date('d/m/Y', strtotime($announcement->start_date)) }}</span>
						</div>
					</div>
					@if($attachments) @if($attachments->count() > 0)

					<div class="form-group" style="display: flex;">
						<div class="col-md-12">
							<span class="bold" style="align-items: stretch;">{{ trans('form1.attachment_list')}}</span>
						</div>
					</div>

					@foreach($attachments as $att)
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3" style="padding-top: 13px;">
							<a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'><i class='fa fa-download'></i> {{ trans('button.download')}}</a>
						</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span>{{ $att->attachment_name }}</span>
						</div>
					</div>
					@endforeach
					@endif @endif
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('new.close')}}</button>
</div>