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

<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet" type="text/css" />

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
<h1 class="page-title"> {{ __('form2.form2_registration') }}
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
                    <div class="mt-step-title uppercase font-grey-cascade">{{ __('form2.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ __('form2.view_claim') }}</div>
                </div>
                <div id="step_header_2" onclick="goToStep(2)" class="step_header_item bg-grey-steel mt-step-col clickme">
                    <div class="mt-step-number">2</div>
                    <div class="mt-step-title uppercase font-grey-cascade">{{ __('form2.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ __('form2.opponent') }}</div>
                </div>
                <div id="step_header_3" onclick="goToStep(3)" class="step_header_item bg-grey-steel mt-step-col clickme">
                    <div class="mt-step-number">3</div>
                    <div class="mt-step-title uppercase font-grey-cascade">{{ __('form2.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ __('form2.defence') }} &amp; {{ __('form2.counterclaim') }}</div>
                </div>
                <div id="step_header_4" onclick="goToStep(4)" class="step_header_item bg-grey-steel mt-step-col clickme">
                    <div class="mt-step-number">4</div>
                    <div class="mt-step-title uppercase font-grey-cascade">{{ __('form2.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ __('form2.verification') }}</div>
                </div>
                @if($is_staff)
                <div id="step_header_5" onclick="goToStep(5)" class="step_header_item bg-grey-steel mt-step-col clickme">
                    <div class="mt-step-number">5</div>
                    <div class="mt-step-title uppercase font-grey-cascade">{{ __('form1.step') }}</div>
                    <div class="mt-step-content font-grey-cascade">{{ __('form1.process_claim') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<br>

@include('claimcase.form2.steps.viewStep1')

@include('claimcase.form2.steps.viewStep2')

@include('claimcase.form2.steps.viewStep3')

@include('claimcase.form2.steps.viewStep4')

@if($is_staff)
@include('claimcase.form2.steps.viewStep5')
@endif

<div class="row">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">

        <button id="btn_back" onclick="backStep()" class="btn default button-previous hidden">
            <i class="fa fa-angle-left"></i> {{ __('form2.back') }}
        </button>
        <button id="btn_next" onclick="nextStep()" class="btn btn-outline green button-next"> {{ __('form2.next') }}
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

<!-- Modal -->
<div id="fpxModal" class="modal fade modal-lg" role="dialog" style="width: 100%;">
  <div class="modal-dialog" style="width: 1000px; max-width: 100%;">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">FPX</h4>
        </div>
        <div class="modal-body">
            <div style="text-align: center;"><div class="loader"></div></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
            <a id="btnProceedFPX" class="btn green-sharp" onclick='submit()'>{{ trans('button.proceed') }}</a>
        </div>
    </div>

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

<script src="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>


{{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}

<script>

	$(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        $(document).on("change","#representative_nationality",function(){
            updateReview();
            console.log('ftested ');
        });
    });
    
    $('#fpxModal').on('hidden.bs.modal', function() {
        $('#fpxModal .modal-body').html('<div style="text-align: center;"><div class="loader"></div></div>');
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

        //console.log('run updateReview');

        // Opponent Info
        $("#view_opponent_email").text( $("#opponent_email").val() );
        $("#view_opponent_phone_mobile").text( $("#opponent_phone_mobile").val() );
        $("#view_opponent_phone_office").text( $("#opponent_phone_office").val() );
        $("#view_opponent_phone_home").text( $("#opponent_phone_home").val() );
        $("#view_opponent_phone_fax").text( $("#opponent_phone_fax").val() );
        $("#view_opponent_street1").text( $("#opponent_street1").val() );
        $("#view_opponent_street2").text( $("#opponent_street2").val() );
        $("#view_opponent_street3").text( $("#opponent_street3").val() );
        $("#view_opponent_state").text( $("#opponent_state option:selected").text() );
        $("#view_opponent_district").text( $("#opponent_district option:selected").text() );
        $("#view_opponent_postcode").text( $("#opponent_postcode").val() );

        @if($case->multiOpponents[0]->opponent->public_data->user_public_type_id == 2)
            $("#view_representative_identification_no").text( $("#representative_identification_no").val() );

            if($("#representative_identity_type").val() == 1)
                $('#label_view_representative_identification_no').text("{{ __('form2.ic_no') }}");
            else
                $('#label_view_representative_identification_no').text("{{ __('form2.passport_no') }}");

            $("#view_representative_nationality").text( $("#representative_nationality option:selected").text() );
            $("#view_representative_name").text( $("#representative_name").val() );
            $("#view_representative_designation").text( $("#representative_designation option:selected").text() );
        @endif

        // Counterclaim Info
        $("#view_defence_statement").text( $('#defence_statement').val() );
        $("#view_total_counterclaim").text( $("#total_counterclaim").val() );
        $("#view_counterclaim_desc").text( $("#counterclaim_desc").val() );

        if( $('input[name="is_counterclaim"]:checked').val() == 0 )
            $(".is_counterclaim").addClass("hidden");
        else
            $(".is_counterclaim").removeClass("hidden");

        // console.log('end updateReview');
        // console.log($('input[name="is_counterclaim"]:checked').val());

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

    function changeRepresentativeType() {
        var type_id = $("#representative_identity_type").val();

        if(type_id == 1) // Citizen
            isRepresentativeCitizen();
        else if(type_id == 2) // Non-Citizen
            isRepresentativeNonCitizen();

        updateReview();
    }


    // CONDITION: Opponent
    function isOpponentCompany(){
        $("#row_opponent_nationality, #row_view_opponent_nationality").addClass("hidden");
        //$("#required_opponent_phone_office").html(" * ");
        // Change required attributes as well
        //$("#required_opponent_phone_mobile").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        $("#label_view_opponent_identification_no, #label_opponent_identification_no").text("{{ __('form2.company_no') }} :"); // Translate plz
        $("#label_view_opponent_name, #label_opponent_name").text("{{ __('form2.company_name') }} :");
        $("#block_opponent_representative").removeClass("hidden");
        $("#row_opponent_phone_mobile, #row_opponent_phone_home, #row_view_opponent_phone_mobile, #row_view_opponent_phone_home").addClass("hidden");

        $("#btn_opponent_myidentity").addClass("hidden");
        $("#btn_opponent_ecbis").removeClass("hidden");
        $("#btn_opponent_ecbis").parent().css('display', 'table-cell');
    }

    function isOpponentCitizen(){
        $("#row_opponent_nationality, #row_view_opponent_nationality").addClass("hidden");
        //$("#required_opponent_phone_office").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        //$("#required_opponent_phone_mobile").html(" * ");
        // Change required attributes as well
        $("#label_view_opponent_identification_no, #label_opponent_identification_no").text("{{ __('form2.ic_no') }} :"); // Translate plz
        $("#label_view_opponent_name, #label_opponent_name").text("{{ __('form2.opponent_name') }} :");
        $("#block_opponent_representative").addClass("hidden");
        $("#row_opponent_phone_mobile, #row_opponent_phone_home, #row_view_opponent_phone_mobile, #row_view_opponent_phone_home").removeClass("hidden");

        $("#btn_opponent_myidentity").removeClass("hidden");
        $("#btn_opponent_ecbis").addClass("hidden");
        $("#btn_opponent_ecbis").parent().css('display', 'table-cell');
    }

    function isOpponentNonCitizen(){
        $("#row_opponent_nationality, #row_view_opponent_nationality").removeClass("hidden");
        //$("#required_opponent_phone_office").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        //$("#required_opponent_phone_mobile").html(" * ");
        // Change required attributes as well
        $("#label_view_opponent_identification_no, #label_opponent_identification_no").text("{{ __('form2.passport_no') }} :"); // Translate plz
        $("#label_view_opponent_name, #label_opponent_name").text("{{ __('form2.opponent_name') }} :");
        $("#block_opponent_representative").addClass("hidden");

        $("#row_opponent_phone_mobile, #row_opponent_phone_home, #row_view_opponent_phone_mobile, #row_view_opponent_phone_home").removeClass("hidden");

        $("#btn_opponent_myidentity").addClass("hidden");
        $("#btn_opponent_ecbis").addClass("hidden");
        $("#btn_opponent_ecbis").parent().css('display', 'table-column');
    }

    // CONDITION: Representative Opponent
    function isRepresentativeCitizen(){
        $("#row_representative_nationality, #row_view_representative_nationality").addClass("hidden");
        $("#label_view_representative_identification_no, #label_representative_identification_no").text("{{ __('form2.ic_no')}} :"); // Translate plz
    }

    function isRepresentativeNonCitizen(){
        $("#row_representative_nationality, #row_view_representative_nationality").removeClass("hidden");
        $("#label_view_representative_identification_no, #label_representative_identification_no").text("{{ __('form2.passport_no')}} :"); // Translate plz
    }

    // CONDITION: Claimant
    function isClaimantCompany(){
        $("#label_view_claimant_identification_no, #label_claimant_identification_no").text("{{ __('form2.company_no')}} :"); // Translate plz
        $("#row_view_claimant_nationality").addClass("hidden");
        $("#required_claimant_phone_office").html(" * ");
        $("#required_claimant_phone_mobile").html(" &nbsp;&nbsp; ");
        $("#row_view_claimant_phone_home").addClass("hidden");
        $("#row_claimant_phone_mobile, #row_claimant_phone_home, #row_view_claimant_phone_mobile, #row_view_claimant_phone_home").addClass("hidden");
    }

    function isClaimantCitizen(){
        $("#label_view_claimant_identification_no, #label_claimant_identification_no").text("{{ __('form2.ic_no')}} :"); // Translate plz
        $("#row_view_claimant_nationality").addClass("hidden");
        $("#required_claimant_phone_office").html(" &nbsp;&nbsp; ");
        $("#required_claimant_phone_mobile").html(" * ");

        $("#row_claimant_phone_mobile, #row_claimant_phone_home, #row_view_claimant_phone_mobile, #row_view_claimant_phone_home").removeClass("hidden");
    }

    function isClaimantNonCitizen(){
        $("#label_view_claimant_identification_no, #label_claimant_identification_no").text("{{ __('form2.passport_no')}} :"); // Translate plz
        $("#row_view_claimant_nationality").removeClass("hidden");
        $("#required_claimant_phone_office").html(" &nbsp;&nbsp; ");
        $("#required_claimant_phone_mobile").html(" * ");

        $("#row_claimant_phone_mobile, #row_claimant_phone_home, #row_view_claimant_phone_mobile, #row_view_claimant_phone_home").removeClass("hidden");
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
        else if(current_step==5) {
            $("#btn_next").addClass("hidden");
            $("#btn_process").removeClass("hidden");
        }
        @else
        else if(current_step==4) {
            $("#btn_next").addClass("hidden");
            $("#btn_process").removeClass("hidden");
        }
        @endif
    }

    function nextStep(){
        if(current_step <= $("#step_header").children().length) {

            var loadNext = false;

            if(current_step > 0 && current_step < 4) {
                loadNext = updatePartial(current_step);
            }
            else if(current_step == 4) {
                loadNext = uploadAttachment();
            }
            else if(current_step == 5) {
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

    function updatePartial(no) {

        switch(no){
            case 1: var urlpost = "{{ route('form2-partial1') }}"; break;
            case 2: var urlpost = "{{ route('form2-partial2') }}"; break;
            case 3: var urlpost = "{{ route('form2-partial3') }}"; break;
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
            url: '{{ route("form2-attachment") }}',
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

                    @if(!$is_staff)
                    if(!data.paid) {
                        swal({
                            title: "{{ trans('swal.success') }}",
                            text: "{{ trans('swal.data_saved') }} ",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonText: "{{ trans('swal.proceed_payment') }}",
                            cancelButtonText: "{{ trans('swal.save_draft') }}",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $("#modalDiv").load("{{ url('/') }}/payment/case/"+$('#claim_case_id').val()+"/2");
                                //location.href="{{ route('onlineprocess.form1') }}";
                            } else {
                                location.href="{{ route('onlineprocess.form2') }}";
                            }
                        });
                    } else {
                        swal({
                            title: "{{ trans('swal.success') }}",
                            text: "{{ trans('swal.data_saved') }}",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonText: "{{ trans('swal.back_list') }}",
                            closeOnConfirm: false
                        },
                        function(){
                            location.href="{{ route('onlineprocess.form2') }}";
                        });
                    }
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
            url: "{{ route('form2-final') }}",
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
                        location.href="{{ route('onlineprocess.form2') }}";
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

    function loadDistricts(state_input_id,district_input_id) {

        var state_id = $("#"+state_input_id).val();
        $('#'+district_input_id).empty();

        $.ajax({
            url: "{{ url('/') }}/state/"+state_id+"/districts",
            type: 'GET',
            datatype: 'json',
            success: function(data){
                $.each(data.state_districts, function(key, district) {
                    $('#'+district_input_id).append("<option value='" + district.district_id +"'>" + district.district + "</option>");
                });
                updateReview();
            },
            error: function(xhr, ajaxOptions, thrownError){
                //swal("Unexpected Error!", thrownError, "error");
                //alert(thrownError);
            }
        });
    }

    function togglePostal() {
        var method = $("#payment_method").val();

        if(method == 3)
            $("#row_postalorder_no").removeClass("hidden");
        else
            $("#row_postalorder_no").addClass("hidden");
    }
    
    // Initialize Condition

    @if(isset($case))
        @if($case->claimant->public_data->user_public_type_id == 1)
            @if($case->claimant->public_data->individual->nationality_country_id != 129)
                isClaimantCitizen(); 
            @else
                isClaimantNonCitizen(); 
            @endif
        @else
            isClaimantCompany(); 
        @endif

        @if($case->multiOpponents[0]->opponent->public_data->user_public_type_id == 1)
            @if($case->multiOpponents[0]->opponent->public_data->individual->nationality_country_id != 129)
                isOpponentCitizen();
            @else
                isOpponentNonCitizen();
            @endif
        @else
            isOpponentCompany();
        @endif

        @if($case->form2)
            @if($case->form2->counterclaim_id)
                $("#is_counterclaim_yes").prop('checked', true).trigger('change');
            @else
                $("#is_counterclaim_no").prop('checked', true).trigger('change');
            @endif

            @if($case->form2->payment_id)
                @if(!$case->form2->payment->payment_fpx_id OR false)
                    @if($case->form2->payment->payment_postalorder_id)
                        $("#payment_method").val(3).trigger('change');
                    @else
                        $("#payment_method").val(2).trigger('change');
                    @endif
                @endif
            @endif

        @endif
    @endif

    resetStep();
    nextStep();

    $('#total_counterclaim').on('keyup', function(e){
        //console.log($('#claim_amount').val());
        if( $('#total_counterclaim').val() > {{config('tribunal.claim_amount')}} ) {
            swal("Opps!", "{{ __('swal.max_25000') }}", "error");
            $('#total_counterclaim').val({{config('tribunal.claim_amount')}});
            e.preventDefault();
        }
    });



    $('#is_counterclaim_yes').attr('value', 1);
    


    // Check for opponent type conditions

</script>
 @endsection