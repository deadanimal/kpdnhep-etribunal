@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

{{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}
<style>

	#step_4 .control-label, .control-label-custom  {
		padding-top: 15px !important;
	}

	.clickme {
		cursor: pointer !important;
	}

	#step_header {
		display: flex;
		flex-wrap: wrap;
	}

	.step_header_item {
		position: relative;
		flex: auto;
		min-width: 130px;
	}

    .bootstrap-tagsinput {
        width: 100%;
    }

</style>
@endsection

@section('content')
<!-- #start -->

<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"> {{ __('form3.form3_registration') }}
    <small></small>
</h1>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->

<div class="row">
    <div class="col-md-12">
        <div class="mt-element-step">
            <div id="step_header" class="row step-background-thin">
                <div id="step_header_1" onclick="goToStep(1)" class="step_header_item bg-grey-steel mt-step-col clickme active">
                    <div class="mt-step-number">1</div>
                    <div class="mt-step-title uppercase font-grey-cascade">{{ trans('form3.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ trans('form3.view_form2') }}</div>
                </div>
                <div id="step_header_2" onclick="goToStep(2)" class="step_header_item bg-grey-steel mt-step-col clickme">
                    <div class="mt-step-number">2</div>
                    <div class="mt-step-title uppercase font-grey-cascade">{{ trans('form3.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ trans('form3.defence_counterclaim') }}</div>
                </div>
                <div id="step_header_3" onclick="goToStep(3)" class="step_header_item bg-grey-steel mt-step-col clickme">
                    <div class="mt-step-number">3</div>
                    <div class="mt-step-title uppercase font-grey-cascade">{{ trans('form3.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ trans('form3.verification') }}</div>
                </div>
                @if($is_staff)
                <div id="step_header_5" onclick="goToStep(4)" class="step_header_item bg-grey-steel mt-step-col clickme">
                    <div class="mt-step-number">4</div>
                    <div class="mt-step-title uppercase font-grey-cascade">{{ __('form1.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ __('form1.process_claim') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<br>

@include('claimcase.form3.steps.viewStep1')

@include('claimcase.form3.steps.viewStep2')

@include('claimcase.form3.steps.viewStep3')

@if($is_staff)
@include('claimcase.form3.steps.viewStep4')
@endif

<div class="row">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">

        <button id="btn_back" onclick="backStep()" class="btn default button-previous hidden">
            <i class="fa fa-angle-left"></i> {{ __('form1.back') }}
        </button>
        <button id="btn_next" onclick="nextStep()" class="btn btn-outline green button-next"> {{ __('form1.next') }}
            <i class="fa fa-angle-right"></i>
        </button>
        @if($is_staff)
        <button id="btn_process" onclick="nextStep()" type="submit" class="btn green button-submit hidden">{{ __('form1.edit') }}
            <i class="fa fa-check"></i>
        </button>
        @else
        <button id="btn_process" onclick="nextStep()" type="submit" class="btn green button-submit hidden">{{ __('button.send') }}
            <i class="fa fa-check"></i>
        </button>
        @endif

    </div>
</div>

@endsection

@section('after_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

{{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    
    $('.dropify').dropify({
        messages: {
            'default': '',
            'replace': '',
            'remove': '{!! __("new.dropify_msg_remove") !!}',
            'error': '{!! __("new.dropify_msg_error") !!}'
        },
        error: {
            'fileSize': '{!! __("new.dropify_error_fileSize") !!}',
            'imageFormat': '{!! __("new.dropify_error_imageFormat") !!}'
        }
    });


    function updateReview(){
        $('#view_defence_counterclaim').text( $('#defence_counterclaim').val() );

        $(".attachment_list").addClass('hidden');

        if(file1)
            if(file1[0]) {
                $("#attachment_list_1").removeClass('hidden');
                $("#attachment_list_1").find('span').text(file1[0].name);
                //console.log(file1[0].name);
            }

        if(file2)
            if(file2[0]) {
                $("#attachment_list_2").removeClass('hidden');
                $("#attachment_list_2").find('span').text(file2[0].name);
                //console.log(file1[0].name);
            }

        if(file3)
            if(file3[0]) {
                $("#attachment_list_3").removeClass('hidden');
                $("#attachment_list_3").find('span').text(file3[0].name);
                //console.log(file1[0].name);
            }

        if(file4)
            if(file4[0]) {
                $("#attachment_list_4").removeClass('hidden');
                $("#attachment_list_4").find('span').text(file4[0].name);
                //console.log(file1[0].name);
            }

        if(file5)
            if(file5[0]) {
                $("#attachment_list_5").removeClass('hidden');
                $("#attachment_list_5").find('span').text(file5[0].name);
                //console.log(file1[0].name);
            }
    }

    function isYesNo(bin){
        if(bin == 1)
            return "{{ __('form1.yes') }}";
        else
            return "{{ __('form1.no') }}";
    }

    var current_step = 0;

    function goToStep(no){
    	@if(strpos(Request::url(),'edit') !== false)
        current_step = no-1;
        nextStep();
        @endif
    }

    function updateButton(){
        $("#btn_back, #btn_next").removeClass("hidden");
        $("#btn_process").addClass("hidden");

        if(current_step==1)
            $("#btn_back, #btn_process").addClass("hidden");
        @if($is_staff)
        else if(current_step==4) {
            $("#btn_next").addClass("hidden");
            $("#btn_process").removeClass("hidden");
        }
        @else
        else if(current_step==3) {
            $("#btn_next").addClass("hidden");
            $("#btn_process").removeClass("hidden");
        }
        @endif
    }

    function nextStep(){
        if(current_step <= $("#step_header").children().length) {

            var loadNext = false;

            if(current_step > 0 && current_step < 3) {
                loadNext = updatePartial(current_step);
            }
            else if(current_step == 3) {
                loadNext = uploadAttachment();
            }
            else if(current_step == 4) {
                loadNext = submitForm();
            }
            else {
                loadNext = true;
            }


            if(loadNext) {
                resetStep();

                current_step++;

                $("#step_"+current_step).removeClass("hidden");
                $("#step_header_"+current_step).addClass("active");

                for(var i=0; i<current_step; i++)
                    $("#step_header_"+i).addClass("done");

                $("html, body").animate({ scrollTop: 0 }, "slow");
                updateButton();
            }

        }
    }

    function backStep(){
        if(current_step > 1) {

        	var loadNext = false;

            // if(current_step < 4)
            //     loadNext = updatePartial(current_step);
            // else
                loadNext = true;

            if(loadNext) {

	            resetStep();
	            
	            current_step--;

	            $("#step_"+current_step).removeClass("hidden");
	            $("#step_header_"+current_step).addClass("active");

	            for(var i=0; i<current_step; i++)
	                $("#step_header_"+i).addClass("done");

	            $("html, body").animate({ scrollTop: 0 }, "slow");
	            updateButton();
	        }
        }
    }

    function resetStep(){
        $(".step_item").addClass("hidden");
        $(".step_header_item").removeClass("done");
        $(".step_header_item").removeClass("active");
    }

    updateReview();

    // Initialize Condition

    resetStep();
    nextStep();


    function updatePartial(no) {

        switch(no){
            case 1: return true;
            case 2: var urlpost = "{{ route('form3-partial2') }}"; break;
            default: return false;
        }

        var res = $.ajax({
            url: urlpost,
            type: 'POST',
            data: $('form').serialize(),
            datatype: 'json',
            async: false,
            success: function(data){
                if(data.result == "Success") {
                }
                else {
                    //swal("{{ trans('swal.error') }}!", data.error_msg, "error");

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

        if(res.responseJSON && res.responseJSON.result == "Success")
            return true;
        else
            return false;
        
    }



    //////////////////////////////////// Attachment Section ////////////////////////////////////////


    // Variable to store your files
    var file1, file2, file3, file4, file5;
    var file1_info = 0, file2_info = 0, file3_info = 0, file4_info = 0, file5_info = 0;

    @if($attachments)
        @if($attachments->get(0))
            file1_info = 1;
        @endif
        @if($attachments->get(1))
            file2_info = 1;
        @endif
        @if($attachments->get(2))
            file3_info = 1;
        @endif
        @if($attachments->get(3))
            file4_info = 1;
        @endif
        @if($attachments->get(4))
            file5_info = 1;
        @endif
    @endif

    // Add events. Grab the files and set them to our variable
    $('#attachment_1').on('change', function(event){
        file1 = event.target.files;
        file1_info = 2;
        updateReview();
    });

    $('#attachment_2').on('change', function(event){
        file2 = event.target.files;
        file2_info = 2;
        updateReview();
    });

    $('#attachment_3').on('change', function(event){
        file3 = event.target.files;
        file3_info = 2;
        updateReview();
    });

    $('#attachment_4').on('change', function(event){
        file4 = event.target.files;
        file4_info = 2;
        updateReview();
    });

    $('#attachment_5').on('change', function(event){
        file5 = event.target.files;
        file5_info = 2;
        updateReview();
    });

    $('.dropify-clear').on('click', function(){
        $(this).siblings('input').trigger('change');
        console.log('remove button clicked!');
    });

    // Catch the form submit and upload the files
    function uploadAttachment()
    {

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(file1, function(key, value)
        {
            data.append('attachment_1', value);
        });

        $.each(file2, function(key, value)
        {
            data.append('attachment_2', value);
        });

        $.each(file3, function(key, value)
        {
            data.append('attachment_3', value);
        });

        $.each(file4, function(key, value)
        {
            data.append('attachment_4', value);
        });

        $.each(file5, function(key, value)
        {
            data.append('attachment_5', value);
        });

        data.append('claim_case_id', $("#claim_case_id").val());
        data.append('file1_info', file1_info);
        data.append('file2_info', file2_info);
        data.append('file3_info', file3_info);
        data.append('file4_info', file4_info);
        data.append('file5_info', file5_info);

        var res = $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '{{ route("form3-attachment") }}',
            type: 'POST',
            data: data,
            cache: false,
            async: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == "Success") {
                    // Update claim_case_id
                    @if(!$is_staff)
                    swal({
                        title: "{{ trans('swal.success') }}",
                        text: "{{ trans('swal.data_saved') }}",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonText: "{{ trans('swal.back_list') }}",
                        closeOnConfirm: false
                    },
                    function(){
                        location.href="{{ route('onlineprocess.form3') }}";
                    });
                    @endif
                }
                else swal("{{ trans('swal.error') }}!", data.error_msg, "error");
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                swal("{{ trans('swal.unexpected_error') }}!", thrownError, "error");
                //alert(thrownError);
            }
        });

        @if(!$is_staff)
            return false;
        @endif


        if(res.responseJSON && res.responseJSON.result == "Success") {
            console.log('return true');
            return true;
        }
        else {
            console.log('return false');
            return false;
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////

    function submitForm(){

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('form3-final') }}",
            type: 'POST',
            data: $('form').serialize(),
            datatype: 'json',
            async: false,
            success: function(data){
                if(data.result == "Success") {

                    swal({
                        title: "{{ trans('swal.success') }}",
                        text: "{{ trans('swal.process_success') }}!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true
                    },
                    function(){
                        swal({
                            text: "{{ trans('swal.reload') }}..",
                            showConfirmButton: false
                        });
                        location.href="{{ route('onlineprocess.form3') }}";
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
@endsection