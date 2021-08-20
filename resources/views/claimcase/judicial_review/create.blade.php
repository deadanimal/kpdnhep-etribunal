<?php
$locale = App::getLocale();
$term_lang = "term_".$locale;
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
{{ Form::open(['route' => 'judicialreview.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submit_form']) }}

@if($judicial_review)
<input type="hidden" name="judicial_review_id" value="{{ $judicial_review->judicial_review_id }}">
@endif
<input type="hidden" name="form4_id" value="{{ $form4->form4_id }}">
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered form-fit">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"> {{$form4->case->case_no}} | 
                        <small style="font-weight: normal;"> {{ date('d/m/Y', strtotime($form4->case->form1->filing_date." 00:00:00")) }} </small>
                    </span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal ">
                    <div class="form-body row">
                        <div class="form-group col-md-6" style="display: flex;">
                            <div class="control-label control-label-custom col-xs-5">{{ __('new.claimant_name')}}</div>
                            <div class="col-xs-7 font-green-sharp" style="align-items: stretch;">
                                <span style='font-weight: bold'>{{ $form4->case->claimant->name }}</span><br>(<small>{{ $form4->case->claimant->username }}</small>)
                            </div>
                        </div>
                        <div class="form-group col-md-6" style="display: flex;">
                            <div class="control-label control-label-custom col-xs-5">{{ __('new.opponent_name')}}</div>
                            <div class="col-xs-7 font-green-sharp" style="align-items: stretch;">
                                <span style='font-weight: bold'>{{ $form4->case->opponent->name }}</span><br>(<small>{{ $form4->case->opponent->username }}</small>)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase">{{ trans('new.judicial_review_application') }} </span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
             <div class="portlet-body form">
                <div class="form-horizontal" role="form">
                    <div class="form-body">

                        <div class="form-group form-md-line-input">
                            <label for="hearing_date" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('new.hearing_date') }} :
                                <span class="required">&nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                {{ date('d/m/Y h:i A', strtotime($form4->hearing->hearin_date." ".$form4->hearing->hearin_time)) }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="award_remove_date" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('new.award_created_date') }} :
                                <span class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                {{ date('d/m/Y', strtotime($form4->award->created_at)) }}
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="applied_by" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('new.applied_by') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select class="form-control select2 bs-select" id="applied_by" name="applied_by"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @if(($old_review && $old_review->applied_by == 3) || !$old_review)
                                    <option value="2">{{ $form4->case->claimant->name }}</option>
                                    @endif
                                    @if(($old_review && $old_review->applied_by == 2) || !$old_review)
                                    <option value="3">{{ $form4->case->opponent->name }}</option>
                                    @endif
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="application_no" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('new.application_no') }} :
                                <span class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="application_no" name="application_no" value="{{ $form4->judicial_review ? $form4->judicial_review->application_no : '' }}" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="court_id" class="control-label col-md-4"> {{ trans('new.high_court') }} :
                                <span class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <select class="form-control select2-allow-clear bs-select" id="court_id" name="court_id"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($courts as $court)
                                    <option value="{{ $court->court_id }}">{{ $court->court_name }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="applied_at" class="control-label col-md-4" style="padding-top: 0px;">{{ trans('new.application_date_court') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date date-picker mb10" data-date-format="dd/mm/yyyy" style="margin-right: 10px;"> 
                                    <input type="text" class="form-control" name="applied_at" id="applied_at" data-date-format="dd/mm/yyyy"/>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>      <!-- REQUEST TO DISPLAY ON WHAT WE SELECT -->
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="notification" class="control-label col-md-4"> {{ trans('new.document') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6 md-checkbox-inline">
                                <div class="md-checkbox">
                                    <input id="doc_proceedingnotes" name="is_doc_proceedingnotes" type="checkbox" value="1">
                                    <label for="doc_proceedingnotes">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ __('new.proceeding_notes') }}
                                    </label>
                                </div>
                                <br>
                                <div class="md-checkbox">
                                    <input id="doc_decisionreason" name="is_doc_decisionreason" type="checkbox" value="1">
                                    <label for="doc_decisionreason">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ __('new.decision_reason') }}
                                    </label>
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="hearing_date" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('new.prez_action') }} :
                                <span class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                {{ $form4->president->name }}
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label for="court_details" class="control-label col-md-4" >{{ trans('new.court_detail') }} :
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <textarea id="court_details" name="court_details" class="form-control" rows="4" placeholder="">{{ $form4->judicial_review ? $form4->judicial_review->court_details : '' }}</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="psu_notes" class="control-label col-md-4" >{{ trans('new.psu_notes') }} :
                                <span class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <textarea id="psu_notes" name="psu_notes" class="form-control" rows="4" placeholder="">{{ $form4->judicial_review ? $form4->judicial_review->psu_notes : '' }}</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input"">
                            <label class="col-md-4 control-label">{{ trans('inquiry.supporting_docs') }} :
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <div class="m-heading-1 border-green m-bordered" style="margin-bottom: 10px;">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">

        <a id="btn_back" class="btn default button-previous" href='{{ route("onlineprocess.judicial_review") }}'>
            <i class="fa fa-angle-left"></i> {{ trans('button.back') }}
        </a>
        <a id="btn_draft" onclick='submitForm(true)' class="btn green-sharp btn-outline button-submit">{{ trans('swal.save_draft') }}
            <i class="fa fa-check"></i>
        </a>
        <a id="btn_process" onclick='submitForm(false)' class="btn green-sharp button-submit">{{ trans('button.process') }}
            <i class="fa fa-check"></i>
        </a>

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

    var is_draft = true;

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
        console.log('remove button clicked!');
    });

    function submitForm(is_draft){

        var form = $("#submit_form");
        var data = new FormData(form[0]);
        data.append('file1_info', file1_info);
        data.append('file2_info', file2_info);
        data.append('file3_info', file3_info);
        data.append('file4_info', file4_info);
        data.append('file5_info', file5_info);
        data.append('is_draft', is_draft);

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
                if(data.result=='ok'){
                    swal({
                        title: "{{ __('new.success') }}",
                        text: "{{ strpos(Request::url(),'create') !== false ? trans('new.create_success') : trans('new.update_success') }}",
                        type: "success"
                    },
                    function () {
                        //location.href = "{{ route('home') }}";
                        location.href = "{{ route('onlineprocess.judicial_review') }}";
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
                            swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
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
    }


@if($judicial_review)

    $("#applied_by").val({{ $judicial_review->applied_by }}).trigger('change');
    $("#application_no").val('{{ $judicial_review->application_no }}');
    $("#court_id").val({{ $judicial_review->court_id }}).trigger('change');

    @if($judicial_review->court_applied_at)
        $("#applied_at").val("{{ date('d/m/Y', strtotime($judicial_review->court_applied_at)) }}");
    @endif

    $("#doc_proceedingnotes").prop('checked', {{ $judicial_review->is_doc_proceedingnotes == 1 ? true : false }});
    $("#doc_decisionreason").prop('checked', {{ $judicial_review->is_doc_decisionreason == 1 ? true : false }});

    $("#court_details").val('{{ $judicial_review->court_details }}');
    $("#psu_notes").val('{{ $judicial_review->psu_notes }}');

@endif


</script>
@endsection