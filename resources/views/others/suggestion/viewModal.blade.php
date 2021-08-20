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
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.submission_date')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ date('d/m/Y H:i A', strtotime($suggestions->created_at)) }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.suggested_by')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $suggestions->created_by->name }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.email')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $suggestions->created_by->email }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.subject')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $suggestions->subject }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.comments')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $suggestions->suggestion }}</span>
						</div>
					</div>
					@if($attachments)
						@if($attachments->count() > 0)
							<div class="form-group" style="display: flex;">
								<div class="col-md-12">
									<span class="bold" style="align-items: stretch;">{{ trans('form1.attachment_list')}}</span>
								</div>
							</div>
							@foreach($attachments as $att)
							<div class="form-group" style="display: flex;">
								<div class="control-label col-xs-3" style="padding-top: 13px;">
									<a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'>{{ trans('button.download')}}</a>
								</div>
								<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
									<span id="view_claim_details">{{ $att->attachment_name }}</span>
								</div>
							</div>
							@endforeach
						@endif
					@endif
					@if($suggestions->response)
					<div class="form-group" style="display: flex;">
						<div class="col-md-12">
							<span class="bold" style="align-items: stretch;">{{ __('new.response_ttpm')}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.response_msg')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $suggestions->response }}</span>
						</div>
					</div>
					@endif
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('new.close')}}</button>
</div>