<!-- Modal -->
<div id="modalReason" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <form role="form" method="post" action="{{ $url }}">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('button.edit_hearing_status') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-md-line-input">
                        <textarea class="form-control" rows="5" placeholder="" name="reason" required></textarea>
                        <label for="form_control_1">{{ __('new.reason_update') }}</label>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('button.close') }}</button>
                    <button type="submit" class="btn btn-primary" >{{ __('button.submit') }}</button>
                </div>
            </div>

        </form>

    </div>
</div>

<script type="text/javascript">
    $("#modalReason").modal("show");
</script>