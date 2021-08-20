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
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('master.court_name') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $court->court_name }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('master.address') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $court->address1 }}<br>
							{{ $court->address2 }}<br>
							{{ $court->postcode }} {{ $court->district->district }}, {{ $court->state->state }}<br>
							</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('master.branch') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $court->branch->branch_name }}</span>
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