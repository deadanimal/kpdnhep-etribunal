<?php
$locale = App::getLocale();
$announcement_type_lang = "announcement_type_".$locale;
$display_name = "display_name_".$locale;
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
{{ Form::open(['route' => 'others.announcement.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'others.announcement.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif
<input type="hidden" name="announcement_id" value="{{ $announcement->announcement_id }}">
<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3>  {{ trans('menu.announcement')}}</h3>
    <span> {{ trans('home_staff.fill_in') }} </span>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('others.add_announcement') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">

                {{ textInput($errors, 'text', $announcement, 'title_en', trans('others.title_en'), true) }}

                {{ textInput($errors, 'text', $announcement, 'title_my', trans('others.title_my'), true) }}

                {{ textarea($errors, $announcement, 'description_en', trans('others.announcement_en'), true) }} 

                {{ textarea($errors, $announcement, 'description_my', trans('others.announcement_my'), true) }}  

                <div class="form-group form-md-line-input">
                    <label for="type" class="control-label col-md-4">{{ __('new.type') }} :
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <select onchange='updateTarget()' class="form-control select2 bs-select" id="announcement_type_id" name="announcement_type_id"  data-placeholder="---">
                            <option value="" disabled selected>---</option>
                            @foreach ($types as $type)
                            <option @if($announcement->announcement_type_id == $type->announcement_type_id) selected @endif value="{{ $type->announcement_type_id }}">{{ $type->$announcement_type_lang }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="target_roles" class="control-label col-md-4">{{ trans('others.show_to') }} :
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class='md-radio-inline'>
                            <div class="md-radio">
                                <input id="all_users" name="select_mode" type="radio" value="1" onchange='changeMode()'>
                                <label for="all_users">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('others.all_users') }}
                                </label>
                            </div>
                            <div class="md-radio">
                                <input id="all_staff" name="select_mode" type="radio" value="2" onchange='changeMode()'>
                                <label for="all_staff">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('others.all_staff') }}
                                </label>
                            </div>
                            <div class="md-radio">
                                <input id="custom" name="select_mode" type="radio" value="3" onchange='changeMode()' @if($announcement) checked @endif>
                                <label for="custom">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('new.other') }}
                                </label>
                            </div>
                        </div>
                        <div id='target_area'>
                            <select name='target_roles[]' id="target_roles" class="form-control select2-multiple" multiple data-placeholder="---">
                                @foreach($roles as $role)

                                @if($announcement->announcement_type_id == 3 && ($role->id = 3 || $role->id = 6))
                                @else
                                <option 
                                    @foreach($announcement->targets as $target)
                                        @if($target->role_id == $role->id)
                                            selected
                                        @endif
                                    @endforeach

                                    value="{{ $role->id }}" usertype='{{ $role->type }}'>{{ $role->$display_name }}</option>
                                @endif

                                @endforeach
                            </select>   
                        </div>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="duration" class="control-label col-md-4">{{ __('others.duration')}} :
                        <span class="required"> &nbsp;&nbsp; </span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group input-large date-picker input-daterange" data-date-start-date="+0d" data-date-format="dd/mm/yyyy" >
                            <input type="text" class="form-control" name="start_date" id="start_date" value="{{ $start_date }}">
                            <span class="input-group-addon">{{ __('new.to')}} </span>
                            <input type="text" class="form-control" name="end_date" id="end_date" value="{{ $end_date }}"> 
                        </div>
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
            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="button" class="btn default" onclick="location.href ='{{ route('others.announcement') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
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

@endsection

@section('after_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>



<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
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

    var data_prez = [];
    var data_normal = [];

    @foreach($roles as $role)
        data_normal.push({
            id: '{{ $role->id }}',
            @foreach($announcement->targets as $target)
            @if($target->role_id == $role->id)
            selected: 'selected',
            @endif
            @endforeach
            text: '{{ $role->$display_name }}'
        });

        @if($role->id != 3 && $role->id != 6)
        data_prez.push({
            id: '{{ $role->id }}',
            @foreach($announcement->targets as $target)
            @if($target->role_id == $role->id)
            selected: 'selected',
            @endif
            @endforeach
            text: '{{ $role->$display_name }}'
        });
        @endif
    @endforeach

    function updateTarget() {
        //console.log($("#announcement_type_id").val());
        if( $("#announcement_type_id").val() == 3 ) {
            $("#target_roles").empty().select2({ data: data_prez});
        }
        else
            $("#target_roles").empty().select2({ data: data_normal});
    }

    function changeMode() {
        if( $("input[name=select_mode]:checked").val() == 3 )
            $("#target_area").slideDown();
        else
            $("#target_area").slideUp();
    }

    changeMode();

    // $("#target_roles").on("change", function(){
    //     if( $("#target_roles option:selected"). )
    // });

    updateTarget();

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
                    title: "{{ __('swal.success') }}",
                    text: '', 
                    type: "success"
                },
                function () {
                    window.location.href = '{{ route('others.announcement') }}';
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