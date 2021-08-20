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
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.branch_name') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $branch->branch_name }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.branch_code') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $branch->branch_code }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.street') }} (MY)</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">
							{{ $branch->branch_address }} <br>
							{{ $branch->branch_address2 }} <br>
							{{ $branch->branch_address3 }}
							</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.street') }} (EN)</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">
							{{ $branch->branch_address_en }} <br>
							{{ $branch->branch_address2_en }} <br>
							{{ $branch->branch_address3_en }}
							</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.postcode') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $branch->branch_postcode }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.district') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $branch->district->district }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.state') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $branch->state->state }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_office') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $branch->branch_office_phone }}</span>
						</div>
					</div> 
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_fax') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $branch->branch_office_fax }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.email') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $branch->branch_emel }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.branch_hq') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							@if( $branch->is_hq == 1 )
								<span id="">{{ trans('inquiry.yes') }}</span>
							@else
								<span id="">{{ trans('inquiry.no') }}</span>
							@endif
						</div>
					</div>
					<!-- <div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">Location</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<div id="map"></div>
						</div>
					</div> -->
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