<?php
$locale = App::getLocale();
$category_lang = "category_".$locale;
?>
@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
<!-- #start -->

<!-- BEGIN PAGE TITLE-->
@if(strpos(Request::url(),'edit') !== false)
{{ Form::open(['route' => 'master.classification.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'master.classification.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif
<input type="hidden" name="claim_classification_id" value="{{ $classification->claim_classification_id }}">
<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3> {{ trans('master.claim_classification') }} </h3>
    <span> {{ trans('home_staff.fill_in') }} </span>
</div>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('new.add_classification') }} </span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">

                {{ textInput($errors, 'text', $classification, 'classification_en', trans('new.name').' (EN)', true) }}

                {{ textInput($errors, 'text', $classification, 'classification_my', trans('new.name').' (MY)', true) }}

                {{ textInput($errors, 'text', $classification, 'rcy_id', trans('new.code'), true) }}

                <div class="form-group form-md-line-input">
                    <label for="rcy_id" class="control-label col-md-4">{{ trans('new.category') }}
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <select class="form-control select2 bs-select" id="category_id" name="category_id"  data-placeholder="---">
                            <option value="" disabled selected>---</option>
                            @foreach($categories as $cat)
                            <option 
                            @if($classification->category_id == $cat->claim_category_id)
                                selected
                            @endif
                            value="{{ $cat->claim_category_id }}">{{ $cat->$category_lang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>     
            </div>
            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="button" class="btn default" onclick="location.href ='{{ route('master.classification') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
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
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

$("#submitForm").submit(function(e){

    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: form.attr('method'),
        data: new FormData(form[0]),
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
                    window.location.href = "{{ route('master.classification') }}";
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

