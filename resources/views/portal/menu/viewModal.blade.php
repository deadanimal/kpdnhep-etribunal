<?php
$locale = App::getLocale();
$menu_lang = "menu_".$locale;
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
							<span style="font-weight: bold;">{{ $menu->menu_en }}</span><br>
							<span style="font-style: italic;">{{ $menu->menu_my }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">URL </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $menu->url }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('portal.parent_menu')}} </div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $menu->parent->$menu_lang }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('portal.priority') }}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $menu->priority }}</span>
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