<?php
$locale = App::getLocale();
$category_lang = "category_".$locale;
$classification_lang = "classification_".$locale;
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
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.claim_no') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span>{{ $journal->journal_desc}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('others.category') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span>{{ $journal->classification->category->$category_lang}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('others.classification') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span>{{ $journal->classification->$classification_lang }} </span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.status') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span>
							@if( $journal->is_active == 1 )
							{{ __('new.publish') }} 
							@else {{ __('new.unpublish') }}
							@endif 
							</span>
						</div>
					</div>

					<div class="form-group" style="display: flex;">
						<div class="col-md-12">
							<span class="bold" style="align-items: stretch;">{{ trans('form1.attachment_list')}}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3" style="padding-top: 13px;">
							<a class="btn dark btn-outline" href="javascript:;" onclick="exportPDF('{{ $journal->journal_desc }}')">
		                        <i class='fa fa-download'></i> {{ trans('button.download')}}
		                    </a>
						</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span>{{ trans('new.form')}}</span>
						</div>
					</div>

					@if($attachments) @if($attachments->count() > 0)
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
<script>
    function exportPDF(case_no) {
        location.href = "{{ url('') }}/others/journal/"+case_no+"/export/pdf";
    }
</script>