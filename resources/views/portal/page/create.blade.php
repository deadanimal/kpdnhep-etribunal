<?php
$locale = App::getLocale();
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

<link href="{{ URL::to('/assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
{{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}

@endsection

@section('content')
<!-- #start -->

<!-- BEGIN PAGE TITLE-->
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
@if(strpos(Request::url(),'edit') !== false)
{{ Form::open(['route' => 'cms.page.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'cms.page.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif
<input type="hidden" name="portal_id" value="{{ $page->portal_id }}">
@if(strpos(Request::url(),'create') !== false)
<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3>  {{ trans('portal.add_page')}}</h3>
    <span> {{ trans('portal.fill_in') }} </span>
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('portal.page_setting') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-2">URL
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-4">
                        <input unupper="unUpper" type="text" class="form-control" id="url" name="url" value="{{$page->url }}"/>
                        <span class="help-block"></span>
                    </div>
                </div>

            </div>
        </div>
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="fa fa-cog font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('portal.editor_setting') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab"> {{ __('portal.en') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab2" data-toggle="tab"> {{ __('portal.my') }} </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_tab1">

                        <div class="form-group">
                            <label class="control-label col-md-2">{{ __('portal.title') }} (EN)
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-10">
                                <input unupper="unUpper" type="text" class="form-control" id="title_en" name="title_en" value="{{$page->title_en }}"/>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">{{ __('portal.subtitle') }}
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-10">
                                <input unupper="unUpper" type="text" class="form-control" id="subtitle_en" name="subtitle_en" value="{{$page->subtitle_en }}"/>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">{{ __('portal.content') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-10">
                                <!-- <textarea unupper="unUpper" id="content_en" name="content_en" class="form-control" rows="5" placeholder="">{!! $page->content_en !!}</textarea> -->
                                <div id="content_en" name="content_en" class="form-control summernote">{!! $page->content_en !!}</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="portlet_tab2">

                        <div class="form-group">
                            <label class="control-label col-md-2">{{ __('portal.title') }} (MY)
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-10">
                                <input unupper="unUpper" type="text" class="form-control" id="title_my" name="title_my" value="{{$page->title_my }}"/>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">{{ __('portal.subtitle') }}
                                <span>&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-10">
                                <input unupper="unUpper" type="text" class="form-control" id="subtitle_my" name="subtitle_my" value="{{$page->subtitle_my }}"/>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">{{ __('portal.content') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-10">
                                <!-- <textarea unupper="unUpper" id="content_my" name="content_my" class="form-control" rows="5" placeholder="">{!! $page->content_my !!}</textarea> -->
                                <div id="content_my" name="content_my" class="form-control summernote">{!! $page->content_my !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix">
            <div style="text-align: center;">
                <button type="button" class="btn default" onclick="location.href ='{{ route('cms.page') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                @if(strpos(Request::url(),'edit') !== false)
                <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.update') }}</button>
                @else
                <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.create') }}</button>
                @endif
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
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
<script src="{{ URL::to('/assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
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
$('#content_en').summernote({height: 300});
$('#content_my').summernote({height: 300});

$("#submitForm").submit(function(e){

    e.preventDefault();
    var form = $(this);
    var data = new FormData(form[0]);
    data.append('content_en', $('#content_en').summernote('code'));
    data.append('content_my', $('#content_my').summernote('code'));

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
                    //window.location.href = '{{ route('cms.page') }}';
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