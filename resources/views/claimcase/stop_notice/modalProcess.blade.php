<?php
use Carbon\Carbon;
?>

<!-- Modal -->
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet" type="text/css" />



<div id="processModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ __('notice_discontinuance.process_notice')}}</h4>
        </div>
        <div class="modal-body"> 
            <div class="row">
                <div class="col-md-12 form">
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="process_date" class="control-label col-md-5"> {{ __('notice_discontinuance.process_date')}}  :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group date" data-date-format="dd/mm/yyyy">
                                        <input type='hidden' name='stop_notice_id' value='{{ $stop_notice->stop_notice_id }}'>
                                        <input type='hidden' name='form_status_id' value='27'>
                                        <input class="form-control form-control-inline date-picker datepicker clickme" name="processed_at" id="processed_at" readonly="" data-date-format="dd/mm/yyyy" type="text" value="{{ date('d/m/Y') }}"/>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group form-md-line-input">
                                <label for="psu" class="control-label col-md-5">{{ trans('form1.psu_incharged')}} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input readonly type="hidden" value="{{ Auth::id() }}" class="form-control" id="processed_by_user_id" name="processed_by_user_id" />
                                    <input disabled type="text" value="{{ Auth::user()->name }}" class="form-control"  />
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
            <a class="btn green-sharp" onclick='submitProcess()'>{{ trans('button.process') }}</a>
        </div>
    </div>

  </div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
$("#processModal").modal("show");

// Initialization

function submitProcess(){

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('stopnotice-finalize') }}",
        type: 'POST',
        data: $('form').serialize(),
        datatype: 'json',
        async: false,
        success: function(data){
            if(data.result == "Success") {

                swal({
                    title: "{{ __('swal.success')}}",
                    text: "{{ __('swal.success_process_notice')}}",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true
                },
                function(){
                    swal({
                        text: "{{ trans('swal.reload') }}..",
                        showConfirmButton: false
                    });
                    location.reload();
                });

            } else {
                var inputError = [];

                console.log(Object.keys(data.message)[0]);
                if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
                    var input = $("input[name='"+Object.keys(data.message)[0]+"']");
                } else {
                    var input = $('#'+Object.keys(data.message)[0]);
                }

                $('html,body').animate(
                    {scrollTop: input.offset().top - 100},
                    'slow', function() {
                        //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                        input.focus();
                    }
                );

                $.each(data.message,function(key, data){
                    if($("input[name='"+key+"']").is(':radio') || $("input[name='"+key+"']").is(':checkbox')){
                        var input = $("input[name='"+key+"']");
                    } else {
                        var input = $('#'+key);
                    }
                    var parent = input.parents('.form-group');
                    parent.removeClass('has-success');
                    parent.addClass('has-error');
                    parent.find('.help-block').html(data[0]);
                    inputError.push(key);
                });

                $.each(form.serializeArray(), function(i, field) {
                    if ($.inArray(field.name, inputError) === -1)
                    {
                        if($("input[name='"+field.name+"']").is(':radio') || $("input[name='"+field.name+"']").is(':checkbox')){
                            var input = $("input[name='"+field.name+"']");
                        } else {
                            var input = $('#'+field.name);
                        }
                        var parent = input.parents('.form-group');
                        parent.removeClass('has-error');
                        parent.addClass('has-success');
                        parent.find('.help-block').html('');
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            swal("{{ trans('swal.unexpected_error') }}!", thrownError, "error");
            //alert(thrownError);
        }
    });

    return false;
}

</script>