<?php
$locale = App::getLocale();
$category_lang = "category_".$locale;
$type_lang = "type_".$locale;
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
							<span id="">{{ $claim_submission->form4 ? $claim_submission->form4->case->case_no : "" }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.branch') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $claim_submission->form4 ? $claim_submission->form4->hearing->branch->branch_name : "" }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.submission_date') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ date('d/m/Y', strtotime($claim_submission->submission_date)) }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					@if( $claim_submission->is_claimant_submit == 1)
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.submission_category') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $claim_submission->category ? $claim_submission->category->$category_lang : "-" }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					@if ( $claim_submission->submission_category_id == 2 )
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.pos_ref_no') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $claim_submission->pos_reference_no }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					@endif
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.submission_type') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $claim_submission->type->$type_lang }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
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
					@endif
					@if( $claim_submission->is_claimant_submit == 0)
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.rep_letter') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">
								@if ( $claim_submission->is_letter == 1)
								{{ __('new.s_yes') }}
								@else
								{{ __('new.s_no') }}
								@endif

							</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					@if ( $claim_submission->is_letter == 1 )
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
					@endif
					
					@endif
				</div>
			</form>
		</div>
	</div>
</div>
