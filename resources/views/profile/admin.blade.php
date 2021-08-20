@extends('layouts.app')

@section('after_styles')
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/select2/css/select2.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')) }}
{{ Html::style(URL::to('/css/custom.css')) }}
@endsection

@section('content')
<!-- BEGIN REGISTRATION WARGANEGARA FORM -->

<form class="form-horizontal" id="submit_form" role="form" method="POST" action="{{route('updateprofile', Auth::user()->user_id)}}">
    {{ csrf_field() }}
   
    <div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3>{{ trans('home_admin.admin_profile') }}</h3>
        <p>{{ trans('home_admin.view_edit') }}</p>
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
                   @include('profile.adminDetail')
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-5 col-md-7">
                <button type="button" id="register-back-btn" class="btn default button-previous" onclick="history.back()"><i class="fa fa-reply margin-right-10"></i>{{trans('new.back')}}</button>&emsp;
                <button type="submit" id="submit-btn" class="btn btn-success uppercase" ><i class="fa fa-paper-plane margin-right-10"></i>{{trans('new.update')}}</button>
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

<script>

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
                    title: "{{ __('swal.success') }}",
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
                        swal("{{ __('swal.error') }}!","{{ __('swal.fill_required') }}", "error");
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