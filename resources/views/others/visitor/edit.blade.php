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

{{ Form::open([
                'name' => 'visitor_store', 
                'id' => 'submitForm', 
                'method' => 'POST', 
                'class' => 'form-horizontal', 
                'route' => 'listing.visitor.update'
            ]) }}

<input type="hidden" name="visitor_id" value="{{ $visitor->visitor_id }}" />
<div class="row">
    <div class="col-md-12">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase">{{ __('form1.visitor_attend_info') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body">

                <div class="form-group form-md-line-input">
                    <label for="identification_no" style="padding-top: 0px" class="control-label col-md-4 col-xs-12 ">
                        {{ __('form1.ic_no') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="identification_no" name="identification_no" value="{{ $visitor->visitor_identification_no }}" />
                        <span class="help-block"></span>
                    </div>
                </div>

                {{-- <!-- <div id="row_claimant_nationality" class="form-group form-md-line-input">
                    <label for="country_id" class="control-label col-md-4">{{ __('form1.nationality') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        {{ Form::country('country_id', [''=> __('form1.please_select')], $visitor->country_id, ['class'=>'form-control select2 bs-select', 'id'=>'country_id']) }}
                        <span class="help-block"></span>
                    </div>
                </div> --> --}}

                <div class="form-group form-md-line-input">
                    <label for="name" class="control-label col-md-4" style="padding-top: 0px"> {{ __('form1.name') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $visitor->visitor_name }}"/>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="reason" class="control-label col-md-4"> {{ __('form1.reason') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        {{ Form::visit_reason('visit_reason_id', [''=> __('form1.please_select') ], $visitor->visitor_reason_id, ['class'=> 'form-control select2 bs-select', 'id'=>'visit_reason_id']) }}
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label for="objective" class="control-label col-md-4" style="padding-top: 0px"> {{ __('form1.remarks') }} :
                        <span class="required"> &nbsp;&nbsp; </span>
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="remarks" name="remarks" value="{{ $visitor->visitor_remarks }}"/>
                        <span class="help-block"></span>
                    </div>
                </div>               

                <div class="form-group form-md-line-input">
                    <label for="date" class="control-label col-md-4">{{ __('new.date_time') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group date form_datetime form_datetime bs-datetime">
                            <input name='visit_datetime' type="text" size="16" class="form-control" value='{{ date("d/m/Y H:i A", strtotime($visitor->visitor_datetime)) }}'>
                            <span class="input-group-addon">
                                <button class="btn default date-set" type="button" >
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group form-md-line-input">
                    <label for="psu" class="control-label col-md-4"> {{ __('form1.psu_assigned') }} :
                        <!--span class="required"> * </span-->
                    </label>
                    <div class="col-md-6" style="margin-top: 8px;">
                        {{ $visitor->psu->name }}
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

    // $(document).ready(function(){

    //     var type_id = '{{ $visitor->visitor_identity_typeid }}';

    //     if(type_id == 1) {
    //         $('#row_claimant_nationality').hide();
    //     } else {
    //         $('#row_claimant_nationality').show();
    //     }
    // });


    // function checkIdentity() {

    //     var type_id = $("#identity_type").val();

    //     if(type_id == 1)
    //         $('#row_claimant_nationality').hide();
    //         // $('#countries').prop('require', true);
    //     else
    //         $('#row_claimant_nationality').show();  
    //         // $('#countries').prop('require', false);

    // }


    // // $("#identity_type").val({{ $visitor->country_id == 129 ? 1 : 2 }}).trigger('change');

    // $(document).ready(function(){
    //     checkIdentity();
    // });


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
                        text: data.message, 
                        type: "success"
                    },
                    function () {
                        window.location.href = '{{ route('listing.visitor') }}';
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

                    $('.form-group').removeClass('has-error');

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