<?php
$locale = App::getLocale();
$title_lang = "title_".$locale;
$description_lang = "description_".$locale;
?>
<!-- Modal -->
<div id="announcementModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">{{ $announcement->$title_lang }}</h4>
			</div>
			<div class="modal-body">
				<p>{{ $announcement->$description_lang }}</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('new.close')}}</button>
			</div>
		</div>

	</div>
</div>

<script>
$("#announcementModal").modal("show");
</script>