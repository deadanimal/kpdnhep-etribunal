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
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('master.category_en') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $category->category_en }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('master.category_my') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $category->category_my }}</span>
							<!-- ABOVE IS VARABLE FROM DB -->
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('master.category_code') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $category->category_code }}</span>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div><!-- 
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('new.close')}}</button>
</div> -->