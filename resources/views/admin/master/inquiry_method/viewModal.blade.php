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
			<div action="#" class="form-horizontal form-bordered ">
				<div class="form-body">
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.name_inquiry_method') }} (EN) </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $inquiry_method->method_en }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.name_inquiry_method') }} (MY)</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $inquiry_method->method_my }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('master.created_at')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ date('d/m/Y', strtotime( $inquiry_method->created_at)) }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.category') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $inquiry_method->code }}</span>
						</div>
					</div>
					<!-- <div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">Location</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<div id="map"></div>
						</div>
					</div> -->
				</div>
			</div>
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