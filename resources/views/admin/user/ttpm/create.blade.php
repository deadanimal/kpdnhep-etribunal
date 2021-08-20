<?php
    // Start a PHP session.
    session_start();

    //die(app_path()."\\..\\public\\assets\\global\\plugins\\icon-captcha\\php\\captcha.class.php");

    // Include the IconCaptcha class.
    //require( app_path()."\\..\\public\\assets\\global\\plugins\\icon-captcha\\php\\captcha.class.php" );
    require( app_path()."/../public/assets/global/plugins/icon-captcha/php/captcha.class.php" );

    // Set the path to the captcha icons. Set it as if you were
    // currently in the PHP folder containing the captcha.class.php file.
    // ALWAYS END WITH A /
    // DEFAULT IS SET TO ../icons/
    //IconCaptcha::setIconsFolderPath( app_path()."\\..\\public\\assets\\global\\plugins\\icon-captcha\\icons\\" );
    IconCaptcha::setIconsFolderPath( app_path()."/../public/assets/global/plugins/icon-captcha/icons/" );

    // Use custom messages as error messages (optional).
    // Take a look at the IconCaptcha class to see what each string means.
    // IconCaptcha::setErrorMessages(array('', '', '', ''));
?>

@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

{{ Html::style(URL::to('/assets/global/plugins/icon-captcha/style/css/style.css')) }}

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
{{ Form::open(['route' => 'ttpm.update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@else
{{ Form::open(['route' => 'ttpm.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
@endif
<input type="hidden" name="user_id" value="{{$findUser->user_id}}">
<div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
    <h3>{{ trans('home_staff.staff_profile') }}</h3>
    <span> {{ trans('home_staff.fill_in') }} </span>
</div>

<div class="row">
    <!-- Detail -->
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
                @include('admin.user.ttpm.create_details')
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">B. {{ trans('home_staff.contact_info') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"> </a>
                    <a href="" class="fullscreen"> </a>
                </div>
            </div>
            <div class="portlet-body">
                @include('admin.user.ttpm.create_information')

            </div>
            <div class="clearfix">
                <div class="col-md-12" style="text-align: center;">
                    <button type="button" class="btn default" onclick="location.href ='{{ route('ttpm') }}'"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                    @if(strpos(Request::url(),'edit') !== false)
                    <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.update') }}</button>
                    @else
                    <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.register') }}</button>
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

<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
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


<!-- Include IconCaptcha script -->
{{ Html::script(URL::to('/assets/global/plugins/icon-captcha/js/script.min.js')) }}

<script type="text/javascript">
    var canSubmit = false;
</script>

<!-- Initialize the IconCaptcha -->
<script async type="text/javascript">
    $(window).ready(function() {
        $('.captcha-holder').iconCaptcha({
            captchaTheme: ["light", "dark"], // Select the theme(s) of the Captcha(s). Available: light, dark
            captchaFontFamily: '', // Change the font family of the captcha. Leaving it blank will add the default font to the end of the <body> tag.
            captchaClickDelay: 500, // The delay during which the user can't select an image.
            captchaHoverDetection: true, // Enable or disable the cursor hover detection.
            showCredits: true, // Show or hide the credits element (please leave it enbled).
            enableLoadingAnimation: true, // Enable of disable the fake loading animation. Doesn't do anything, just looks cool ;)
            loadingAnimationDelay: 1500, // How long the fake loading animation should play.
            requestIconsDelay: 1500, // How long should the script wait before requesting the hashes and icons? (to prevent a high(er) CPU usage during a DDoS attack)
            captchaAjaxFile: '{{ url("/assets/global/plugins/icon-captcha/php/captcha-request.php") }}', // The path to the Captcha validation file.
            captchaMessages: { // You can put whatever message you want in the captcha.
                header: "{{ __('swal.captcha_msg') }}",
                correct: {
                    top: "{{ __('swal.success') }}!",
                    bottom: "{{ __('swal.captcha_valid') }}."
                },
                incorrect: {
                    top: "{{ __('swal.fail') }}!",
                    bottom: "{{ __('swal.captcha_invalid') }}."
                }
            }
        })
        .bind('init.iconCaptcha', function(e, id) { // You can bind to custom events, in case you want to execute some custom code.
            console.log('Event: Captcha initialized', id);
        }).bind('selected.iconCaptcha', function(e, id) {
            console.log('Event: Icon selected', id);
        }).bind('refreshed.iconCaptcha', function(e, id) {
            console.log('Event: Captcha refreshed', id);
        }).bind('success.iconCaptcha', function(e, id) {
            canSubmit = true;
            console.log('Event: Correct input', id);
        }).bind('error.iconCaptcha', function(e, id) {
            canSubmit = false;
            console.log('Event: Wrong input', id);
        });
    });
</script>


<script type="text/javascript">
// $("#designation_id").change(function(){
//     var val = $(this).val();
//     $('.pilihcawangan').hide();
//     switch (val){
//         case '8':
//              $('.pilihcawangan').show();
//         break;
//     }
// });

// var des = "{{$findTTPMUser->designation_id or ''}}";
// if(des == 8){
//     $('.pilihcawangan').show();
// }

$(".input-daterange input").datepicker({
    format: "yyyy",
    autoclose: true,
    minViewMode: "years"
});

var from = parseInt($("#from").val());
$("#to").datepicker('update', new Date((from+3)+"-01-01"));

$("#from").on("change", function(){
    var from = parseInt($("#from").val());

    $("#to").datepicker('update', new Date((from+3)+"-01-01"));

    //$("#to").val(from+3);
});

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

function toggleDuration() {
    var type = $("input[name='is_appointed']:checked").val();

    if(type == 0)
        $("#row_duration").slideUp();
    else
        $("#row_duration").slideDown();
}

function checkPrez() {
    var designation_id = $("#designation_id").val();

    if(designation_id == 4)
        $("#is_president").slideDown();
    else
        $("#is_president").slideUp();
}

checkPrez();
toggleDuration();

$("#submitForm").submit(function(e){

    e.preventDefault();

    if(!canSubmit) {
        swal("{{ trans('swal.error') }}","{{ __('swal.captcha_invalid') }}!", "error");
        return;
    }

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
                    title: " {{ __('new.success') }}",
                    text: data.message, 
                    type: "success"
                },
                function () {
                    window.location.href = '{{ route('ttpm') }}';
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

