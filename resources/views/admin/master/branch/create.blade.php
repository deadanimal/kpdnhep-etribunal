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
{{ Form::open(['route' => 'master.branch.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'master.branch.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif
<input type="hidden" name="branch_id" value="{{ $branch->branch_id }}">
<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3> {{ trans('new.branch_info') }} </h3>
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
                
            	{{ textInput($errors, 'text', $branch, 'branch_name', trans('new.branch_name'), true) }}

            	{{ textInput($errors, 'text', $branch, 'branch_code', trans('new.branch_code'), true) }}

            	{{ textInput($errors, 'text', $branch, 'branch_address', trans('new.street').' (MY)', true) }}

            	{{ textInput($errors, 'text', $branch, 'branch_address2', ' ' ) }}

            	{{ textInput($errors, 'text', $branch, 'branch_address3', ' ' ) }}

                {{ textInput($errors, 'text', $branch, 'branch_address_en', trans('new.street').' (EN)', true) }}

                {{ textInput($errors, 'text', $branch, 'branch_address2_en', ' ' ) }}

                {{ textInput($errors, 'text', $branch, 'branch_address3_en', ' ' ) }}

            	{{ textInputNumeric($errors, 'text', $branch, 'branch_postcode', trans('new.postcode'), true) }}

            	{{ masterSelect($errors, $states, $branch, 'branch_state_id', 'state_id', 'state', trans('new.state'), true) }}

				{{ masterSelect($errors, false, $branch, 'branch_district_id', 'district_id', 'district', trans('new.district'), true) }}

            	{{ textInputNumeric($errors, 'text', $branch, 'branch_office_phone', trans('new.phone_office'), true) }}

            	{{ textInputNumeric($errors, 'text', $branch, 'branch_office_fax', trans('new.phone_fax') ) }}

            	{{ textInput($errors, 'text', $branch, 'branch_emel', trans('new.email'), true) }}

            	<div class="form-group form-md-line-input">
				    <label for="language" class="control-label col-md-4"> {{ trans('new.is_headquarter') }} </label>
				    <div class="col-md-6">
				        <div class="md-radio-inline">
				        	<div class="md-radio">
				        		<input id="is_hq_yes" required name="is_hq" @if($branch->is_hq == 1) checked @endif type="radio" value="1">
				        		<label for="is_hq_yes">
				        			<span></span>
				        			<span class="check"></span>
				        			<span class="box"></span> {{ trans('form1.yes') }}
				        		</label>
				        	</div>
				        	<div class="md-radio">
				        		<input id="is_hq_no" required name="is_hq" @if($branch->is_hq == 0) checked @endif type="radio" value="0">
				        		<label for="is_hq_no">
				        			<span></span>
				        			<span class="check"></span>
				        			<span class="box"></span> {{ trans('form2.no') }}
				        		</label>
				        	</div>
				        </div>
				    </div>
				</div>

            </div>
            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="button" class="btn default" onclick="location.href ='{{ route('master.branch') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
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
    'district_id' => '#branch_district_id',
    'state_id' => '#branch_state_id',
    'inputEmpty' => $branch->branch_district_id
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
                    window.location.href = '{{ route('master.branch') }}';
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

