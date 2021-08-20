<?php

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
   @if(strpos(Request::url(),'update') !== false) 
    {{ __('form11.update_witness')}}
   @else
    {{ __('form11.reg_witness')}}
   @endif
</h1>

@if(strpos(Request::url(),'edit') !== false) 
    {{ Form::open(['route' => 'form11-update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@elseif(strpos(Request::url(),'add') !== false) 
    {{ Form::open(['route' => 'form11-new', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
    {{ Form::open(['route' => 'form11-store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}

@endif

<input type="hidden" name="form4_id" value="{{ $form4->form4_id }}">
<input type="hidden" name="user_witness_id" value="{{ $user_witness->user_witness_id }}">
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('form11.on_behalf') }} </span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group form-md-line-input">
                    <label for="on_behalf" class="control-label col-md-4">{{ trans('form11.on_behalf') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6 md-radio" style="padding-top: 8px;">
                        <div class="md-radio">
                            <input id="witness_on_behalf1" name="witness_on_behalf" class="md-radiobtn" type="radio" value="1">
                            <label for="witness_on_behalf1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ trans('form11.ttpm') }}
                            </label>
                        </div>
                        <div class="md-radio">
                            <input id="witness_on_behalf2" name="witness_on_behalf" class="md-radiobtn" type="radio" value="2">
                            <label for="witness_on_behalf2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ trans('form11.claimant') }} - {{$form4->case->claimant->name}}
                            </label>
                        </div>
                        <div class="md-radio">
                            <input id="witness_on_behalf3" name="witness_on_behalf" class="md-radiobtn" type="radio" value="3">
                            <label for="witness_on_behalf3">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ trans('form11.opponent') }} - {{$form4->claimCaseOpponent->opponent->name}}
                            </label>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('form11.witness_info') }} </span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group form-md-line-input">
                    <label for="witness_identification_no" class="control-label col-md-4 col-xs-12">
                        <select id="witness_identity_type" name="witness_identity_type" onchange="changeWitnessType()" class="bs-select form-control" data-width="60%">
                            <option value="1">{{ trans('form11.ic_no') }}</option>
                            <option value="2">{{ trans('form11.passport_no') }}</option>
                            <option value="3">{{ trans('form11.company_no') }}</option>
                        </select>
                        <span>:</span>
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="identification_no" name="identification_no" value="{{ $user_witness->identification_no}}" />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div id="row_witness_nationality" class="form-group form-md-line-input">
                    <label for="nationality_country_id" class="control-label col-md-4">{{ trans('form11.nationality') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <select class="form-control select2 bs-select" id="nationality_country_id" name="nationality_country_id"  data-placeholder="---">
                            <option value="" disabled selected>---</option>
                            @foreach($countries as $country)
                            <option 
                                @if($user_witness)
                                    @if ($user_witness->nationality_country_id == $country->country_id) selected @endif
                                @endif
                                value="{{ $country->country_id }}">{{ $country->country }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label for="witness_name" class="control-label col-md-4">{{ trans('form11.name') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user_witness->name}}"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label for="address" class="control-label col-md-4"> {{ trans('form11.address') }} :
                        <span> &nbsp;&nbsp; </span>
                    </label>
                    <div class="col-md-6">
                        <textarea id="address" name="address" class="form-control" rows="2">{{ $user_witness->address}}</textarea>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label for="document_desc" class="control-label col-md-4"> {{ trans('form11.indicate_doc') }}  :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <textarea id="document_desc" name="document_desc" class="form-control" rows="2" placeholder="">{{ $user_witness->document_desc }}</textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label for="assigned_psu_id" class="control-label col-md-4"> {{ __('new.psu_assigned') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <select id="psu_user_id" class="form-control select2 bs-select" name="psu_user_id" value="1" data-placeholder="---">
                            <option value="" disabled selected>---</option>
                            @foreach ($psus as $psu)
                            <option 
                                @if($user_witness->form11)
                                    @if($user_witness->psu_user_id == $psu->user_id) selected @endif
                                @endif
                                value="{{ $psu->user_id }}">{{ $psu->user->name }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
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

    function changeWitnessType() {
        var type_id = $("#witness_identity_type").val();

        if( type_id == 2 ) 
            $("#row_witness_nationality").removeClass("hidden");
        else 
            $("#row_witness_nationality").addClass("hidden");
    }

    changeWitnessType();

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
                    if(data.form11)
                        window.location.href = '{{ url('/form11') }}/'+data.form11+"/view";
                    else
                        window.location.href = '{{ route("onlineprocess.form11") }}';
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

@if($user_witness->user_public_type_id)
$("#witness_identity_type").val({{ $user_witness->user_public_type_id == 2 ? 3 : ($user_witness->nationality_country_id != 129 ? 2 : 1) }}).trigger("change");
@endif

@if ($user_witness->witness_on_behalf == 1)
    $("#witness_on_behalf1").prop("checked", true);
@elseif($user_witness->witness_on_behalf == 2)
    $("#witness_on_behalf2").prop("checked", true);
@elseif($user_witness->witness_on_behalf == 3)
     $("#witness_on_behalf3").prop("checked", true);
@endif

</script>
@endsection