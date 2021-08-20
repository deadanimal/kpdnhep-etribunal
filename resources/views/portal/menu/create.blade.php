<?php
$locale = App::getLocale();
$menu_lang = 'menu_'.$locale;
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
{{ Form::open(['route' => 'cms.menu.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'cms.menu.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif
<input type="hidden" name="portal_menu_id" value="{{ $menu->portal_menu_id }}">
<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3>  {{ trans('portal.add_menu')}}</h3>
    <span> {{ trans('home_staff.fill_in') }} </span>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('portal.add_menu') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('portal.menu') }} (EN)
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <input unupper="unUpper" type="text" class="form-control" id="menu_en" name="menu_en" value="{{$menu->menu_en }}"/>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('portal.menu') }} (MY)
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <input unupper="unUpper" type="text" class="form-control" id="menu_my" name="menu_my" value="{{$menu->menu_my }}"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">URL
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <input unupper="unUpper" type="text" class="form-control" id="url" name="url" value="{{$menu->url }}"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ trans('portal.parent_menu') }}
                        <span> &nbsp;&nbsp; </span>
                    </label>
                    <div class="col-md-6">
                        <select class="form-control select2 bs-select" id="parent_menu_id" name="parent_menu_id"  data-placeholder="---">
                            <option value="" disabled selected>---</option>
                            @foreach($menu_list as $list)
                            <option 
                            @if($menu->parent_menu_id == $list->portal_menu_id)
                                selected
                            @endif
                            value="{{ $list->portal_menu_id }}">{{ $list->$menu_lang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>    
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4"> {{ trans('portal.priority') }}
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <input unupper="unUpper" type="text" class="form-control numeric" id="priority" name="priority" value="{{$menu->priority }}"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                        
            </div>
            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="button" class="btn default" onclick="location.href ='{{ route('cms.menu') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
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

$("#submitForm").submit(function(e){

    e.preventDefault();
    var form = $(this);
    var data = new FormData(form[0]);

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
                    window.location.href = '{{ route('cms.menu') }}';
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