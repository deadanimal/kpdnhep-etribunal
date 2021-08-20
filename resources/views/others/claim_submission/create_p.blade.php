<?php
$locale = App::getLocale();
$category_lang = "category_".$locale;
$type_lang = "type_".$locale;
?>

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
{{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}

@endsection

@section('content')
<!-- #start -->

<!-- BEGIN PAGE TITLE-->
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
@if(strpos(Request::url(),'edit') !== false)
{{ Form::open(['route' => 'others.claimsubmission.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'others.claimsubmission.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif
<input type="hidden" name="claim_submission_id" value="{{ $claim_submission->claim_submission_id }}">
<input type="hidden" name="claim_case_id" value="{{ $form4->case->claim_case_id }}">
<input type="hidden" name="form4_id" value="{{ $form4->form4_id }}">
<input type="hidden" name="is_claimant_submit" value="0">
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ __('new.add_claim_submission') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body ">
                <div class="form-group form-md-line-input"">
                    <label class="col-md-4 control-label">{{ __('new.claim_no') }} :
                        <span> &nbsp;&nbsp;</span>
                    </label>
                    <div class="col-md-6" style="margin-top: 6px;">
                        {{ $form4->case->case_no }}
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.rep_letter') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input required onchange="updateLetter()" id="is_letter_yes" name="is_letter" class="md-checkboxbtn" type="radio" value="1">
                                <label for="is_letter_yes">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>{{ __('form1.yes') }}
                                </label>
                            </div>
                            <div class="md-radio">
                                <input required onchange="updateLetter()" id="is_letter_no" name="is_letter" class="checkboxbtn" type="radio" value="0">
                                <label for="is_letter_no">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>{{ __('form1.no') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="supporting_docs" class="form-group form-md-line-input hidden">
                    <label for="attachments" id="attachments" class="control-label col-md-4"> {{ __('others.supporting_docs') }} :
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <div>

                        </div>
                        <div class="m-heading-1 border-green m-bordered">
                            {!! __('new.dropify_msg') !!}
                        </div>
                        <div style="display: flex; flex-wrap: wrap;">
                            <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                <input type="file" id="attachment_1" name="attachment_1" class="dropify" @if($attachments) @if($attachments->get(0))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(0)->attachment_id, 'filename' => $attachments->get(0)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                            </div>
                            <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                <input type="file" id="attachment_2" name="attachment_2" class="dropify" @if($attachments) @if($attachments->get(1))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(1)->attachment_id, 'filename' => $attachments->get(1)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                            </div>
                            <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                <input type="file" id="attachment_3" name="attachment_3" class="dropify" @if($attachments) @if($attachments->get(2))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(2)->attachment_id, 'filename' => $attachments->get(2)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                            </div>
                            <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                <input type="file" id="attachment_4" name="attachment_4" class="dropify" @if($attachments) @if($attachments->get(3))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(3)->attachment_id, 'filename' => $attachments->get(3)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                            </div>
                            <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                <input type="file" id="attachment_5" name="attachment_5" class="dropify" @if($attachments) @if($attachments->get(4))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(4)->attachment_id, 'filename' => $attachments->get(4)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="submission_date" id="label_case_created_at" class="control-label col-md-4"> {{ __('new.submission_date')}} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group input-medium date date-picker"  data-date-format="dd/mm/yyyy">
                            <input class="form-control" name="submission_date" readonly="" id="submission_date" data-date-format="dd/mm/yyyy" type="text" value="{{ $submission_date }}"/>
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>

            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="button" class="btn default" onclick="location.href ='{{ route('listing.attendance') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                    @if(strpos(Request::url(),'edit') !== false)
                    <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.update') }}</button>
                    @else
                    <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.save') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}
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
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
{{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">

    @if($claim_submission->is_representative_letter == 1)
    $("#is_letter_yes").prop("checked", true);
    @else
    $("#is_letter_no").prop("checked", true);
    @endif

    function updateLetter() {
        var letter = $('input[name="is_letter"]:checked').val();
        console.log(letter);

        if(letter == 1)
            $("#supporting_docs").removeClass("hidden");
        else
            $("#supporting_docs").addClass("hidden");
    }

    updateLetter();

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
        file1_info = 2;
    });

    $('#attachment_2').on('change', function(event){
        file2_info = 2;
    });

    $('#attachment_3').on('change', function(event){
        file3_info = 2;
    });

    $('#attachment_4').on('change', function(event){
        file4_info = 2;
    });

    $('#attachment_5').on('change', function(event){
        file5_info = 2;
    });

     $('.dropify-clear').on('click', function(){
        $(this).siblings('input').trigger('change');
        //console.log('remove button clicked!');
    });

    $("#submitForm").submit(function(e){

        e.preventDefault();
        var form = $(this);
        var data = new FormData(form[0]);
        data.append('file1_info', file1_info);
        data.append('file2_info', file2_info);
        data.append('file3_info', file3_info);
        data.append('file4_info', file4_info);
        data.append('file5_info', file5_info);

        $.ajax({
            url: form.attr('action'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: form.attr('method'),
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            beforeSend: function() {
                
            },
            success: function(data) {
                if(data.status=='ok'){
                    swal({
                        title: "{{ __('new.success') }}",
                        text: "", 
                        type: "success"
                    },
                    function () {
                        window.location.href = '{{ route('listing.attendance') }}';
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
            error: function(xhr){
                console.log(xhr.status);
            }
        });
        return false;
    });


</script>
@endsection