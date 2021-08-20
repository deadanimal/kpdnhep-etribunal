<?php
$locale = App::getLocale();
$category_lang = "category_".$locale;
?>

<!-- Modal -->
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

<div id="processModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="max-width: 99%;">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ __("new.create_instant_f1") }}</h4>
        </div>
        <div class="modal-body">
        	<form class="form-horizontal" role="form">
                <div class="form-body">

                    <div id="row_claimant_identification_no" class="form-group form-md-line-input">
                        <label for="claimant_identification_no" style="padding-top: 0px"
                               class="control-label col-md-4 col-xs-12">
                                <select id="claimant_identity_type"
                                        name="claimant_identity_type"
                                        class="bs-select form-control"
                                        data-width="60%">
                                    <option value="1">{{ __('form1.ic_no') }}</option>
                                    <option value="2">{{ __('form1.passport_no') }}</option>
                                    {{-- <option value="3">{{ __('form1.company_no') }}</option> --}}
                                </select>
                                <span>:</span>
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <div class="input-group-control">
                                    <input type="text" class="form-control numeric" id="claimant_identification_no" maxlength="12" required onchange="checkClaimant()" name="claimant_identification_no" />
                                    <span class="help-block"></span><br> 
                                    <small id='claimant_myidentity_info'></small>
                                </div>
                                <span class="input-group-btn btn-right" >
                                    <a id='btn_claimant_myidentity' href="javascript:;" onclick='checkMyIdentityClaimant()' class="btn btn-circle">
                                        <i class="fa fa-search"></i> {{ __('button.check') }} MyIdentity
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="row_claimant_name" class="form-group form-md-line-input">
                        <label for="claimant_name" id="label_claimant_name" class="control-label col-md-4">{{ __('form1.name') }} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <input required type="text" class="form-control" id="claimant_name" name="claimant_name" />
                            <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div id="row_filing_date" class="form-group form-md-line-input">
                        <label for="filing_date" id="label_filing_date" class="control-label col-md-4">{{ __('form1.filing_date') }} :
                            <span class="required"> &nbsp;&nbsp; </span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group date" data-date-format="dd/mm/yyyy">
                                <input class="form-control form-control-inline date-picker datepicker clickme" name="filing_date" id="filing_date" readonly="" data-date-end-date="0d" data-date-format="dd/mm/yyyy" type="text" value="{{ date('d/m/Y') }}"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                    <div id="row_claim_category" class="form-group form-md-line-input">
                        <label for="claim_category" id="label_claim_category" class="control-label col-md-4">{{ __('form1.category_claim') }} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <select required class="form-control select2 bs-select" id="claim_category" name="claim_category"  data-placeholder="---">
                                <option value="" disabled selected>---</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->claim_category_id }}">{{ $category->$category_lang }}</option>
                                @endforeach
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div id="row_branch" class="form-group form-md-line-input">
                        <label for="branch_id" id="row_claim_offence" class="control-label col-md-4">{{ trans('new.branch')}} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <select required class="form-control select2 bs-select" id="branch_id" name="branch_id"  data-placeholder="---">
                                <option value="" disabled selected>---</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }} @if($branch->is_hq)(HQ)@endif</option>
                                @endforeach
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
            <a id="btn_submit" class="btn green-sharp" onclick='submitInstant()'>{{ trans('button.create') }}</a>
        </div>
    </div>

  </div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
$("#processModal").modal("show");

function checkClaimant(){

    var id_no = $("#claimant_identification_no").val();
    $("#btn_submit").removeClass("hidden");

    $.ajax({
        url: "{{ route('form1-checkopponent') }}",
        type: 'GET',
        data: {
            id_no: id_no,
        },
        datatype: 'json',
        success: function(data){
            if(data.result == "Exist") {

                $("#claimant_name").val(data.user_data.name);

                // Change ID type
                // Change nationality list
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
        }
    });
}

function checkMyIdentityClaimant(){
    var id_no = $("#claimant_identification_no").val();

    $.ajax({
        url: "{{ route('integration-myidentity-checkic', ['ic'=>'']) }}/"+id_no,
        type: 'POST',
        datatype: 'json',
        success: function(data){
            if(data.ReplyIndicator == 1) {
                toastr.success('{{ __("swal.user_found")}}!');
                
                $("#claimant_name").val(data.Name);
                $("#claimant_myidentity_info").html("{{ __('new.residentialstatus') }}: <span class='font-green-sharp'>"+data.ResidentialStatus+"</span><br>{{ __('new.recordstatus') }}: <span class='font-green-sharp'>"+data.RecordStatus+"</span>");

                if(data.RecordStatus == "{{ __('new.died') }}") {
                    swal("{{ __('new.recordstatus') }}", data.RecordStatus, "error");
                    $("#btn_submit").addClass("hidden");
                }
                else {
                    $("#btn_submit").removeClass("hidden");
                }
            }
            else {
                toastr.error('{{ __("swal.user_not_found") }}!');
                $("#claimant_myidentity_info").html("");
                $("#claimant_name").val("");
                $("#btn_submit").removeClass("hidden");
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
            toastr.error('{{ __("new.cannot_connect_myidentity") }}');
            $("#btn_submit").removeClass("hidden");
        }
    });
}

function submitInstant(){

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('form1-instant') }}",
        type: 'POST',
        data: $('form').serialize(),
        datatype: 'json',
        async: false,
        success: function(data){
            if(data.result == "Success") {
                $("#processModal").modal("hide");
                swal({
                    title: data.case_no.number,
                    text: "{{ trans('swal.success') }}",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true
                },
                function(){
                    swal({
                        text: "{{ trans('swal.reload') }}..",
                        showConfirmButton: false
                    });
                    location.href="{{ route('onlineprocess.form1', ['status' => 16]) }}";
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
            $("#processModal").modal("hide");
            swal("{{ trans('swal.unexpected_error') }}!", thrownError, "error");
            //alert(thrownError);
        }
    });
}

</script>