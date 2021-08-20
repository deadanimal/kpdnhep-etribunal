<?php
$locale = App::getLocale();
$category_lang = "category_".$locale;
$classification_lang = "classification_".$locale;
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
{{ Form::open(['route' => 'others.journal.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ __('others.add_journal') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body ">
                <div class="form-group form-md-line-input"">
                    <label class="col-md-4 control-label" id="description">{{ __('new.claim_no') }} :
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <label class="control-label">{{ $claim_case->case_no }}</label>
                        <input type="hidden" value="{{ $claim_case->case_no }}" id="journal_desc" name="journal_desc" />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label for="category" class="control-label col-md-4">{{ __('others.category') }} :
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <label class="control-label">{{ $claim_case->form1->classification->category->$category_lang }}</label>
                        <input type="hidden" value="{{ $claim_case->form1->classification->category_id }}" id="claim_category_id" name="claim_category_id" />
                        <!-- <select onchange="loadClassification()" class="form-control select2 bs-select" id="claim_category_id" name="claim_category_id"  data-placeholder="---">
                            <option value="" disabled selected>---</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->claim_category_id }}">{{ $category->$category_lang }}</option>
                            @endforeach
                        </select> -->
                        <span class="help-block"></span>
                    </div>
                </div>
                <!-- Classification depend on Category-->
                <div class="form-group form-md-line-input">
                    <label for="classification" class="control-label col-md-4">{{ __('others.classification') }} :
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <!-- <select class="form-control select2 bs-select" id="claim_classification_id" name="claim_classification_id"  data-placeholder="---">
                            <option value="" disabled selected>---</option>
                        </select> -->
                        <label class="control-label">{{ $claim_case->form1->classification->$classification_lang }}</label>
                        <input type="hidden" value="{{ $claim_case->form1->classification->claim_classification_id }}" id="claim_classification_id" name="claim_classification_id" />
                        <span class="help-block"></span>
                    </div>
                </div>

                <div id="row_is_status" class="form-group form-md-line-input">
                    <label for="is_status" id="label_is_status" class="control-label col-md-4">{{ __('new.status') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input required onchange="updateReview()" id="is_status_active" name="is_status" class="md-checkboxbtn" checked type="radio" value="1">
                                <label for="is_status_active">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>{{ __('new.publish') }}
                                </label>
                            </div>
                            <div class="md-radio">
                                <input required onchange="updateReview()" id="is_status_inactive" name="is_status" class="checkboxbtn" type="radio" value="2">
                                <label for="is_status_inactive">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>{{ __('new.unpublish') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="supporting_docs" class="form-group form-md-line-input">
                    <label for="attachments" id="attachments" class="control-label col-md-4"> {{ __('others.supporting_docs') }} :
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <div>

                        </div>
                        <div class="m-heading-1 border-green m-bordered">
                            {!! __('new.dropify_msg_journal') !!}
                        </div>
                        <div style="display: flex; flex-wrap: wrap;">
                            <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                <input type="file" id="attachment_1" name="attachment_1" class="dropify" @if($attachments) @if($attachments->get(0))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(0)->attachment_id, 'filename' => $attachments->get(0)->attachment_name])}}"@endif @endif data-max-file-size="5M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                            </div>
                            <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                <input type="file" id="attachment_2" name="attachment_2" class="dropify" @if($attachments) @if($attachments->get(1))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(1)->attachment_id, 'filename' => $attachments->get(1)->attachment_name])}}"@endif @endif data-max-file-size="5M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                            </div>
                            <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                <input type="file" id="attachment_3" name="attachment_3" class="dropify" @if($attachments) @if($attachments->get(2))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(2)->attachment_id, 'filename' => $attachments->get(2)->attachment_name])}}"@endif @endif data-max-file-size="5M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="button" class="btn default" onclick="location.href ='{{ route('others.journal') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                    @if(strpos(Request::url(),'edit') !== false)
                    <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.update') }}</button>
                    @else
                    <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.create') }}</button>
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

    // Initialization
    @foreach ($categories as $category)
        var cat{{ $category->claim_category_id }} = [];
    @endforeach

    // Insert data into array
    @foreach ($classifications as $classification)
        cat{{ $classification->category_id }}.push({ "id": "{{ $classification->claim_classification_id }}", "name": "{{ $classification->$classification_lang }}" });
    @endforeach

    function loadClassification() {

        var cat = $('#claim_category_id').val();
        $('#claim_classification_id').empty();
        $('#claim_classification_id').append('<option value="" disabled selected>---</option>');

        @foreach ($categories as $category)
        if(cat == {{ $category->claim_category_id }}) {
            $.each(cat{{ $category->claim_category_id }}, function(key, data) {
                $('#claim_classification_id').append("<option value='" + data.id +"'>" + data.name + "</option>");
            });
        }
        @endforeach

    }


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

    var file1_info = 0, file2_info = 0, file3_info = 0;
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
                        window.location.href = '{{ route('others.journal') }}';
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