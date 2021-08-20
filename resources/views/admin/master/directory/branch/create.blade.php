@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

{{ Html::style(URL::to('/css/custom.css')) }}
@endsection

@section('content')
<!-- #start -->

<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"> 
    <small></small>
</h1>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->

@if(strpos(Request::url(),'edit') !== false)
{{ Form::open(['route' => 'master.directory.branch.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'master.directory.branch.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif
<input type="hidden" name="directory_branch_id" value="{{ $directoryBranch->directory_branch_id }}">
<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3> {{ trans('new.directory_branch_info') }} </h3>
    <span> {{ trans('home_staff.fill_in') }} </span>
</div>

<div class="row">
    <!-- Detail -->
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-green"></i>
                    <span class="caption-subject font-green sbold uppercase"> {{ trans('new.details') }} </span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"> </a>
                    <a href="" class="fullscreen"> </a>
                </div>
            </div>
            <div class="portlet-body">

                {{ textInput($errors, 'text', $directoryBranch, 'directory_branch_head', trans('master.directory_branch_head'), true) }}

                {{ textInput($errors, 'text', $directoryBranch, 'address_1', trans('master.directory_branch_address'), true) }}

                {{ textInput($errors, 'text', $directoryBranch, 'address_2', ' ' ) }}

                {{ textInput($errors, 'text', $directoryBranch, 'address_3', ' ' ) }}

                {{ textInput($errors, 'text', $directoryBranch, 'postcode', trans('master.directory_branch_postcode'), true) }}

                {{ masterSelect($errors, $states, $directoryBranch, 'state_id', 'state_id', 'state', trans('master.directory_branch_state'), true) }}

                {{ masterSelect($errors, false, $directoryBranch, 'district_id', 'district_id', 'district', trans('master.directory_branch_district'), true) }}

                {{ textInput($errors, 'text', $directoryBranch, 'directory_branch_email', trans('master.directory_branch_email'), true) }}
                {{ textInput($errors, 'text', $directoryBranch, 'directory_branch_tel', trans('master.directory_branch_tel'), true) }}
                {{ textInput($errors, 'text', $directoryBranch, 'directory_branch_faks', trans('master.directory_branch_faks'), true) }}

                <div class="clearfix">
                    <div class="col-md-offset-4 col-md-8 mv20">
                        <button type="button" class="btn default" onclick="location.href ='{{ route('master.directory.branch') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
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

    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/dropify/js/dropify.min.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script type="text/javascript">

@include('components.js.ajaxdistrict',[
    'scriptTag' => false,
    'district_id' => '#district_id',
    'state_id' => '#state_id',
    'inputEmpty' => $directoryBranch->district_id
])


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
                        window.location.href = '{{ route('master.directory.branch') }}';
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

