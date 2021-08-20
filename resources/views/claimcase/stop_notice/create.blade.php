<?php
$locale = App::getLocale();
$method_lang = "stop_method_".$locale;
$type_lang = "stop_type_".$locale;
$reason_lang = "stop_reason_".$locale;
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

<h1 class="page-title"> 
{{ trans('notice_discontinuance.apply_termination_notice')}}
</h1>

@if(strpos(Request::url(),'edit') !== false)
{{ Form::open(['route' => 'stopnotice-update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'stopnotice-store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif

<input type="hidden" name="stop_notice_id" value="{{ $stop_notice->stop_notice_id }}">
<input type="hidden" name="claim_case_id" value="{{ $case->claim_case_id }}">
<input type="hidden" name="claim_case_opponent_id" value="{{ $case->id }}">
<input type="hidden" name="requested_by_user_id" value="{{ $case->claimCase->claimant_user_id }}">

<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">

        @if($is_staff)
        <div class="portlet light bordered form-fit">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">
                        {{ $case->claimCase->case_no }} |
                        <small style="font-weight: normal;"> {{ date('d/m/Y', strtotime($case->claimCase->form1->filing_date)) }}</small>
                    </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4" style="padding-top: 5px;">{{ trans('notice_discontinuance.claimant') }}</div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="claimant_info">
                         <strong>{{ $case->claimCase->claimant_address->name}}</strong><br>{{ $case->claimCase->claimant->username}}
                        </span>
                    </div>
                </div>
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4" style="padding-top: 5px;">{{ trans('notice_discontinuance.opponent') }}</div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="opponent_info">
                            <strong>{{ $case->opponent_address->name}}</strong><br>{{ $case->opponent->username}}
                        </span>
                    </div>
                </div>       
            </div>
        </div>
        @endif

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase">{{ trans('notice_discontinuance.apply_termination_notice') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">
                @if(!($is_staff))
                <div class="form-group form-md-line-input">
                    <label for="applied_by" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('form1.claim_no') }} :
                        <span class="required"> &nbsp;&nbsp; </span>
                    </label>
                    <div class="col-md-6">
                        {{ $case->claimCase->case_no}}
                    </div>
                </div>
                @endif

                @if($is_staff)
                <div class="form-group form-md-line-input">
                    <label for="applied_by" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('notice_discontinuance.apply_by') }} :
                        <span class="required"> &nbsp;&nbsp; </span>
                    </label>
                    <div class="col-md-6">
                        {{ $case->claimCase->claimant_address->name}}
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="against" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('notice_discontinuance.against') }} :
                        <span class="required"> &nbsp;&nbsp; </span>
                    </label>
                    <div class="col-md-6">
                        {{ $case->opponent_address->name}}
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="form1_date" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('notice_discontinuance.form1_date') }} :
                        <span class="required">&nbsp;&nbsp;</span>
                    </label>
                    <div class="col-md-6">
                        {{ date('d/m/Y', strtotime($case->claimCase->form1->filing_date)) }}
                    </div>
                </div>

                <!-- 
                <div class="form-group form-md-line-input">
                    <label for="hearing_date" class="control-label col-md-4" style="padding-top: 0px"> {{ trans('notice_discontinuance.hearing_date') }} :
                        <span class="required">&nbsp;&nbsp; </span>
                    </label>
                    <div class="col-md-6">
                        21/12/2012
                    </div>
                </div> -->

                <div class="form-group form-md-line-input">
                    <label for="stop_notice_method_id" class="control-label col-md-4"> {{ trans('notice_discontinuance.apply_method') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <select class="form-control select2 bs-select" id="stop_notice_method_id" name="stop_notice_method_id"  data-placeholder="---">
                            <option value="" disabled selected>---</option>
                            @foreach($stop_methods as $method)
                            <option 
                            @if($stop_notice->stop_notice_method_id == $method->stop_method_id)
                            selected
                            @endif
                            value="{{ $method->stop_method_id }}">{{ $method->$method_lang }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="stop_notice_date" class="control-label col-md-4">{{ trans('notice_discontinuance.stop_notice_date') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group date" data-date-format="dd/mm/yyyy">
                            <input class="form-control form-control-inline date-picker datepicker clickme" name="stop_notice_date" id="stop_notice_date" readonly="" data-date-format="dd/mm/yyyy" type="text" value="{{ $stop_notice_date }}"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>

                @endif
                @if(!($is_staff))
                    <input type="hidden" name="stop_notice_method_id" value="1">
                    <input class="form-control form-control-inline date-picker datepicker clickme" name="stop_notice_date" id="stop_notice_date" readonly="" data-date-format="dd/mm/yyyy" type="hidden" value="{{ date('d/m/Y') }}"/>

                @endif

                <div class="form-group form-md-line-input">
                    <label for="reason" class="control-label col-md-4">{{ trans('notice_discontinuance.reason') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <select class="form-control select2 bs-select" id="stop_notice_reason_id" name="stop_notice_reason_id"  data-placeholder="---">
                            <option value="" disabled selected>---</option>
                            @foreach($stop_reasons as $reason)
                            <option 
                            @if($stop_notice->stop_notice_reason_id == $reason->stop_reason_id)
                            selected
                            @endif
                            value="{{ $reason->stop_reason_id }}">{{ $reason->$reason_lang }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="stop_notice_reason_desc" class="control-label col-md-4"> {{ trans('notice_discontinuance.additional_reason') }} :
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <textarea id="stop_notice_reason_desc" name="stop_notice_reason_desc" class="form-control" maxlength="225" rows="2">@if($stop_notice->stop_notice_reason_desc){{ $stop_notice->stop_notice_reason_desc }}@endif</textarea>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group form-md-line-input"">
                    <label class="col-md-4 control-label">{{ __('form1.supporting_docs') }} :
                        <span class="required">&nbsp;&nbsp;</span>
                    </label>
                    <div class="col-md-6">
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
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">
        <button type="button" class="btn default" onclick="history.back()">
            <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
        </button>
        @if(strpos(Request::url(),'edit') !== false)
        <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.update') }}</button>
        @else
        <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.create') }}</button>
        @endif
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
                        window.location.href = '{{ route('onlineprocess.stop_notice') }}';
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