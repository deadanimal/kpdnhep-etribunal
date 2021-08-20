@extends('layouts.app')

@section('after_styles')
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/select2/css/select2.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}
{{ Html::style(URL::to('/css/custom.css')) }}
@endsection

@section('content')
<!-- BEGIN REGISTRATION WARGANEGARA FORM -->

<form class="form-horizontal" id="submit_form" role="form" method="POST" enctype="multipart/form-data" action="{{route('updateprofile', Auth::user()->user_id)}}">
    {{ csrf_field() }}
    
    <div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
        <h3>{{trans('new.my_profile')}}</h3>
        <p>{{trans('new.user_details')}}</p>
    </div>

    <div class="row">

        {{-- Detail --}}
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">A. {{ trans('new.user_acc') }}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                   @include('profile.staffDetail')
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">B. {{ trans('new.user_details') }}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                   @include('profile.staffInformation')

                </div>
            </div>
        </div>
    </div>






    <div class="form-actions">
        <div class="row">
            <div class="col-md-12" style="text-align: center">
                <button type="button" id="register-back-btn" class="btn default button-previous" onclick="history.back()"><i class="fa fa-reply"></i>{{trans('new.back')}}</button>&emsp;
                <button type="submit" id="submit-btn" class="btn btn-success uppercase" ><i class="fa fa-paper-plane"></i>{{trans('new.update')}}</button>
            </div>
        </div>
    </div>
</form>
@endsection
@section('after_scripts')
{{ Html::script(URL::to('/assets/global/plugins/select2/js/select2.full.min.js')) }}
{{ Html::script(URL::to('/assets/pages/scripts/components-select2.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')) }}
{{ Html::script(URL::to('/assets/pages/scripts/components-date-time-pickers.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
<script type="text/javascript">
$('.dropify').dropify({
    messages: {
        'default': '{!! __("new.dropify_msg_default") !!}',
        'replace': '{!! __("new.dropify_msg_replace") !!}',
        'remove': '{!! __("new.dropify_msg_remove") !!}',
        'error': '{!! __("new.dropify_msg_error") !!}'
    },
    error: {
        'fileSize': '{!! __("new.dropify_error_fileSize") !!}',
        'imageFormat': '{!! __("new.dropify_error_imageFormat") !!}'
    }
});

$('#identification_no').attr('readonly','readonly');

$('#designation').prop('disabled', true);
$('#branch_name').prop('disabled', true);
$('#username').prop('disabled', true);

$('#designation_id').attr('disabled', 'disabled');
$('#designation_type_id').on('change', function(e){


    console.log(e);
    var designation = e.target.value;

    $.get('/e-tribunal-v2.2/public/admin/designation?designation_type_id=' + designation, function(data) {
        var $designation_id = $('#designation_id');

        $designation_id.find('option').remove().end();
        $designation_id.removeAttr("disabled").end();
        $designation_id.append('<option value>{{ trans("dropdown.choose_district")}}</option>');

        $.each(data, function(index, designation_id) {
            $designation_id.append('<option value="' + designation_id.designation_id + '">' + designation_id.designation + '</option>');
        });
    });
}).change();


$("#submit_form").submit(function(e){

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
                    location.reload();
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
                        swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
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