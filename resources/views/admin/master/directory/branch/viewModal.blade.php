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
    						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('master.directory_branch_state') }}</div>
    						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
    							<span id="">{{ $directoryBranch->state->state }}</span>
    						</div>
    					</div>
    					<div class="form-group" style="display: flex;">
    						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('master.directory_branch_head') }}</div>
    						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
    							<span id="">{{ $directoryBranch->directory_branch_head }}</span>
    						</div>
    					</div>
    					<div class="form-group" style="display: flex;">
    						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('master.directory_branch_address') }}</div>
    						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
    							<span id="">
                                    TRIBUNAL TUNTUTAN PENGGUNA MALAYSIA <br>
    								{{ $directoryBranch->address_1 }} <br/>
                                    {{ $directoryBranch->address_2 }} 
                                    @if($directoryBranch->address_2)
                                    {{ $directoryBranch->address_2 }} <br/>
                                    @endif
                                     @if($directoryBranch->address_3)
                                    {{ $directoryBranch->address_3 }} <br/>
                                    @endif
                                    {{ $directoryBranch->postcode }} 
                                    {{ $directoryBranch->district->district}} <br/> 
                                    {{ $directoryBranch->state->state }} 
    							</span>
    						</div>
    					</div>
    					<div class="form-group" style="display: flex;">
    						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('master.directory_branch_email') }}</div>
    						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
    							<span id="">
    								{{ $directoryBranch->directory_branch_email }} 
    							</span>
    						</div>
    					</div>
    					<div class="form-group" style="display: flex;">
    						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('master.directory_branch_tel') }}</div>
    						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
    							<span id="">{{ $directoryBranch->directory_branch_tel }}</span>
    						</div>
    					</div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('master.directory_branch_faks') }}</div>
                            <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $directoryBranch->directory_branch_faks }}</span>
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
<!-- <script>
	function initMap() {
		var myLocation = {lat: -25.363, lng: 131.044};
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 5,
			center: myLocation
		});
		var marker = new google.maps.Marker({
			position: myLocation,
			map: map
		});
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqxUL2IsDDjAcTMOLysEuUTDwlgKspkXI&callback=initMap"></script> -->