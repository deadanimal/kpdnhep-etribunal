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
<style>
    .modal-body {padding: 0px;}
    
    .control-label-custom  {
        padding-top: 15px !important;
    }

    .right-left {
        text-align: right;
    }

    @media(max-width:768px){
        .right-left {
            text-align: left;
        }
    }

</style>
@endsection

@section('content')
<!-- #start -->

<!-- BEGIN PAGE TITLE-->
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->

<div class="row">
    <div class="col-md-7">
        {{--
        <div class="portlet light bordered form-fit">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ __('new.suggestion_details')}} :</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">
                    <div class="form-body">
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.name')}} :</div>
                            <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ auth()->user()->name }}</button>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.subject')}} :</div>
                            <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                <span style="font-weight: bold;">{{ $suggestions->subject }}</span><br>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ __('new.suggestion')}} :</div>
                            <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $suggestions->suggestion }}</span>
                            </div>
                        </div>
                        @if($attachments)
                        @if($attachments->count() > 0)
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-12">
                                <span class="bold" style="align-items: stretch;">{{ trans('form1.attachment_list')}}</span>
                            </div>
                        </div>
                        @foreach($attachments as $att)
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-3" style="padding-top: 13px;">
                                <a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'>{{ trans('button.download')}}</a>
                            </div>
                            <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_details">{{ $att->attachment_name }}</span>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        @endif
                    </div>
                </form>
            </div>
        </div>
        --}}

        <h4 class="bold uppercase">{{ __('new.suggestion_details')}}</h4>
        <small style='font-size: 14px;letter-spacing: 0;font-weight: 300;'>{{ __('new.suggestion_details_review')}}.</small>

        <div style="margin-top: 20px;">
            <div class='row' style='padding: 20px 0px;'>
                <div class="col-md-4 right-left" >{{ __('new.suggested_by')}} :</div>
                <div class="col-md-8 font-green-sharp">{{ $suggestions->created_by->name }}</div>
            </div>

            <div class='row' style='padding: 20px 0px; border-top: 1px solid #e1e6ec;'>
                <div class="col-md-4 right-left" >{{ __('new.subject')}} :</div>
                <div class="col-md-8 font-green-sharp">{{ $suggestions->subject }}</div>
            </div>

            <div class='row' style='padding: 20px 0px; border-top: 1px solid #e1e6ec;''>
                <div class="col-md-4 right-left" >{{ __('new.comments')}} :</div>
                <div class="col-md-8 font-green-sharp">{{ $suggestions->suggestion }}</div>
            </div>
            @if($attachments)
            @if($attachments->count() > 0)
            <div class='row' style='padding: 20px 0px; border-top: 1px solid #e1e6ec;'>
                <div class="col-md-4 right-left" >{{ trans('form1.attachment_list')}} :</div>
                <div class="col-md-8 font-green-sharp">
                @foreach($attachments as $att)
                <a target="_blank" href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}' class='btn dark btn-outline'><i class='fa fa-download'></i> {{ $att->attachment_name }}</a><br>
                @endforeach
                </div>
            </div>
            @endif
            @endif
        </div>



    </div>
    <div class="col-md-5">
    {{ Form::open(['route' => 'others.suggestion.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
    <input type="hidden" name="suggestion_id" value="{{ $suggestions->suggestion_id }}">
    
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ __('new.response')}}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div id="suggestion" class="form-group form-md-line-input">
                    <div class="col-md-12">
                        <textarea id="response" name="response" class="form-control" rows="10" placeholder="{{ __('new.placeholder_response')}}"></textarea>
                    </div>
                    <div class="col-md-12" style="text-align: right; margin-top: 10px;">
                        <button id="btn_back" class="btn default button-previous" onclick="location.href ='{{ route('others.suggestion') }}'">
                            <i class="fa fa-angle-left"></i> {{ __('button.back')}}
                        </button>
                        <button id="btn_process" type="submit" class="btn green button-submit">{{ __('button.submit')}}
                            <i class="fa fa-check"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>

@endsection

@section('after_scripts')

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
                    window.location.href = '{{ route('others.suggestion') }}';
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