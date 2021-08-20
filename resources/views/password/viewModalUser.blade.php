<div id="modalChangePass" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ __('new.change_password') }}</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="pass_new" class="control-label col-md-5">{{ __('new.new_password') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="pass_new" name="pass_new" value=""/>
                                <span class="help-block">{{ __('new.field_required_alert') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="pass_confirm" class="control-label col-md-5">{{ __('new.confirm_new_password') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" value=""/>
                                <span class="help-block">{{ __('new.field_required_alert') }}</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{ __('new.cancel') }}</button>
                <button type="button" class="btn green" onclick="submitForm()">{{ __('new.change_password') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
$("#modalChangePass").modal('show');

var canSubmit = false;
var isMatched = false;

$("input").on("focusout", function(){
    if( !$(this).val() ) {
        $(this).parents(".form-group").addClass("has-error");
        $(this).siblings().text("{{ __('new.field_required_alert') }}");
        canSubmit = false;
    } else {
        $(this).parents(".form-group").removeClass("has-error");
        $(this).siblings().text("");
        canSubmit = true;
    }
});

$("#pass_new, #pass_confirm").on("focusout", function(){
    if( $(this).val() ) {
        if( $("#pass_confirm").val() != $("#pass_new").val() ) {
            $("#pass_new, #pass_confirm").parents(".form-group").addClass("has-error");
            $("#pass_new, #pass_confirm").siblings().text("{{ __('new.password_not_matched') }}");       // Translate this
            canSubmit = false;
        } else {
            $("#pass_new, #pass_confirm").parents(".form-group").removeClass("has-error");
            $("#pass_new, #pass_confirm").siblings().text("");
            canSubmit = true;
        }
    }
});

function submitForm() {

    if( $(".has-error").length == 0 && canSubmit) {
        var _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ route('changepass-user') }}",
            type: 'POST',
            data: {
                userid: '{{ $userid }}',
                newpass: $("#pass_new").val(),
                _token: _token
            },
            datatype: 'json',
            success: function(data){
                
                if(data.result == "Success") {
                    $("#modalChangePass").modal('hide');
                    swal({
                        title: "{{ __('new.success') }}!",
                        text: "{{ __('new.password_change_success') }}",
                        type: "success",
                    });
                    //alert("Password changed successfully.");
                } else {
                    swal("{{ __('new.error') }}!", data.error_msg, "error");
                    //alert(data.error_msg);
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                $("#modalChangePass").modal('hide');
                swal("{{ __('new.unexpected_error') }}!", thrownError, "error");
                //alert(thrownError);
            }
        });

    } else {
        //alert("Nope!");
    }
}

</script>