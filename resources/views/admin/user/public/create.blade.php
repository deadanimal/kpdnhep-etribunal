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
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/select2/css/select2.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/icon-captcha/style/css/style.css')) }}
<style type="text/css">
.has-error .btn.default:not(.btn-outline) {border-color: #e73d4a !important;}
</style>
@endsection

@section('content')

{{ Form::open(['route' => $route, 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}

@if(Route::current()->getName() == 'public.create.citizen' || $type == 'citizen')
    <input name="citizenship" type="hidden" value="1">
@else
    <input name="citizenship" type="hidden" value="0">
@endif

    <div class="note note-danger mt20"><span class="text-danger sbold"> {{ trans('new.complete_information') }} </span></div>

    <div class="row">

        <!-- Detail -->
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">A. {{ trans('new.details') }}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('common.register.detail')
                </div>
            </div>
        </div>

        <!-- Contact information -->
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">B. {{ trans('new.contact_info') }}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('common.register.contact_info')
                </div>
            </div>
        </div>

       <!-- Address -->
       <div class="col-md-12" >
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase"> C. {{ trans('new.address') }}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body" id="address">
                @include('common.register.address')
                </div>
            </div>
        </div>


        <!-- Mailing Address -->
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">D. {{ trans('new.mailing_address') }}</span>
                        <div class="md-checkbox pull-right ml10">
                            <input id="copy_address" name="copy_address" class="md-checkboxbtn" value="1" @if(!empty($userPublic->address_mailing_street_1)) checked @endif type="checkbox">
                            <label for="copy_address">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ trans('new.different_address') }}
                            </label>
                        </div>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse" data-original-title="" title=""> </a>
                        <a href="" class="fullscreen" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body" id="mailing_address">                    
                @include('common.register.mailing_address')
                </div>
            </div>
        </div>
      
        <!-- Demo grafi -->
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">@if(Route::current()->getName() == 'public.create.company' || $type == 'company')
                        E. {{ trans('new.rep_info') }}
                        @else
                        E. {{ trans('new.demographic') }}
                        @endif
                        </span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                @if(Route::current()->getName() == 'public.create.company' || $type == 'company')
                @include('common.register.rep_info')
                @else
                @include('common.register.demo_info')
                @endif
                </div>
            </div>
        </div>

        @if($type == NULL)
        <!-- Security detail -->
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">
                        F. {{ trans('new.security_details') }}
                        </span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                @include('common.register.security_detail')
                </div>
            </div>
        </div>
        @endif

        <div class="clearfix">
            <div class="col-md-12" style="text-align: center">
                <button type="button" class="btn default" onclick="location.href ='{{ route('public') }}'"><i class="fa fa-reply mr10"></i>{{ trans('button.back') }}</button>
                @if(strpos(Request::url(),'edit') !== false)
                <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.update') }}</button>
                @else
                <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.register') }}</button>
                @endif
            </div>
        </div>
    </div>

</div>

{{ Form::close() }}
@endsection

@section('after_scripts')
{{ Html::script(URL::to('/assets/global/plugins/select2/js/select2.full.min.js')) }}
{{ Html::script(URL::to('/assets/pages/scripts/components-select2.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')) }}
{{ Html::script(URL::to('/assets/pages/scripts/components-date-time-pickers.min.js')) }}

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

// $("#identification_no").on('change',function(){
//     var id_no = $("#identification_no").val();

//     $.ajax({
//         url: "{{ route('integration-ecbis-checkcompanyno', ['company_no'=>'']) }}/"+id_no,
//         type: 'GET',
//         datatype: 'json',
//         success: function(data){
//             if(data.status != "Not found!") {
//                 $("#name").val(data.company.nama_syrkt);
//             }
//             else {
//                 // MyIdentity
//                 $.ajax({
//                     url: "{{ route('integration-myidentity-checkic', ['ic'=>'']) }}/"+id_no,
//                     type: 'GET',
//                     datatype: 'json',
//                     success: function(data){
//                         if(data.ReplyIndicator == 1) {
//                             $("#name").val(data.Name);
//                         }
//                     },
//                     error: function(xhr, ajaxOptions, thrownError){
//                         //swal("Unexpected Error!", thrownError, "error");
//                         //alert(thrownError);
//                     }
//                 });
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError){
//             //swal("Unexpected Error!", thrownError, "error");
//             //alert(thrownError);
//         }
//     });
// });


@if(Route::current()->getName() == 'public.create.citizen' || $type == 'citizen')
$("#identification_no").on('change', function(){
    var nric = $(this).val(); // 890101065555
    var year = nric.substr(0, 2);
    var month = nric.substr(2, 2);
    var day = nric.substr(4, 2);

    if(year >= 00 && year <= 30) {
        if (year != '') {
            year = 20+year;
        }
    }

    if(year >= 31 && year <= 99) {
        year = 19+year;
    }

    var dob2 = year + "-" + month + "-" + day;
    dob3 = day + "/" + month + "/" + year;
    console.log(dob3);
    var gender = nric.substr(11,1); // 1 = L, 2 = P % 2) == 0) {
        if((gender % 2) == 0){
            var gender_value = "2"
        }
        else{
            var gender_value = "1"
        }

    if (month > 12 || day > 31) {
        swal(" {{ trans('swal.error') }} "," {{ trans('swal.ic_not_exist') }} ", "error");
        $(this).val('');
        $("#date_of_birth").val('');
        $("#gender_id").val('').trigger('change.select2');
    } else if (year != '' || month != '' || day != ''){
        $("#date_of_birth").val(dob3);
        $("#gender_id").val(gender_value).trigger('change.select2');
    } else {
        $(this).val('');
        $("#date_of_birth").val('');
        $("#gender_id").val('').trigger('change.select2');
    }

    @if(Route::current()->getName() == 'public.create.citizen' || $type == 'citizen')
    var id_no = $("#identification_no").val();

    $.ajax({
        url: "{{ route('integration-myidentity-checkic', ['ic'=>'']) }}/"+id_no+"?validate=true",
        type: 'POST',
        datatype: 'json',
        success: function(data){
            if(data.ReplyIndicator == 0 || data.RecordStatus == "{{ __('new.died') }}") {
                swal("{{ __('new.error') }}", "{{ __('new.invalid_ic') }}", "error");
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
        }
    });
    @endif
});
@endif

$.fn.copyAddress = function(){
    $("#address_mailing_street_1").val($("#address_street_1").val());
    $("#address_mailing_street_2").val($("#address_street_2").val());
    $("#address_mailing_street_3").val($("#address_street_3").val());
    $("#address_mailing_postcode").val($("#address_postcode").val());
    $("#address_mailing_state_id").val($("#address_state_id").val()).trigger('change.select2').on('change', function(e){
        console.log(e);
        var state = e.target.value;

        $.get('{{  URL::to('state?state_id=') }}' + state, function(data) {
            var $district = $("#address_mailing_district_id");

            $district.find('option').remove().end();
            $district.removeAttr("disabled").end();
            $district.append('<option value> {{ trans("dropdown.choose_district") }}</option>');

            $.each(data, function(index, district) {
                $district.append('<option value="' + district.district_id + '">' + district.district + '</option>');
            });
            var district_id = $("#address_district_id").val();
            $district.val(district_id).find('option[value="' + district_id +'"]').attr('selected', true);
        });
    }).change();
}

@if(!empty($userPublic->address_mailing_street_1))
$("#mailing_address").show();
@else
$("#mailing_address").hide();
@endif

$("#address input[type='text'], #address select").change(function(){
    console.log(!$("#copy_address").is(':checked'));
    if (!$("#copy_address").is(':checked')) {
        $.fn.copyAddress();
    }
});

$("#copy_address").change(function(){
    if (this.checked) {
        $("#mailing_address").show();
        $("#mailing_address input[type='text']").val('');
        $("#address_mailing_state_id").val('').trigger('change.select2').change();
        // $("#address_mailing_district_id").val('').trigger('change.select2');
    } else {
        $("#mailing_address").hide();
        $.fn.copyAddress();
    }
});

@if($userPublic != NULL)
    @include('components.js.ajaxdistrict',[
        'scriptTag' => false,
        'district_id' => '#address_district_id',
        'state_id' => '#address_state_id',
        'inputEmpty' => $userPublic->address_district_id
    ])

    @include('components.js.ajaxdistrict',[
        'scriptTag' => false,
        'district_id' => '#address_mailing_district_id',
        'state_id' => '#address_mailing_state_id',
        'inputEmpty' => $userPublic->address_mailing_district_id
    ])
@else
    @include('components.js.ajaxdistrict',[
        'scriptTag' => false,
        'district_id' => '#address_district_id',
        'state_id' => '#address_state_id',
    ])

    @include('components.js.ajaxdistrict',[
        'scriptTag' => false,
        'district_id' => '#address_mailing_district_id',
        'state_id' => '#address_mailing_state_id',
    ])
@endif

@if($userPublicCompany)
@if($userPublicCompany->representative_nationality_country_id == 129) 
$("#representative_nationality_country_id").parents('.form-group').hide();
@endif 
@endif

$("#representative_identification_type").on('change', function(){
    var label = $("label[for='representative_identification_no']");
    if(this.value==1){
        label.html('{{ __("form1.ic_no") }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i>');
        $("#representative_nationality_country_id").parents('.form-group').hide();
    } else {
        label.html('{{ __("form1.passport_no") }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i>');
        $("#representative_nationality_country_id").parents('.form-group').show();
    }
});

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
            App.blockUI({boxed:!0})
        },
        success: function(data) {
            if(data.status=='ok'){
                App.unblockUI();
                swal({
                    title: "{{ __('new.success') }}",
                    text: data.message, 
                    type: "success"
                },
                function () {
                    window.location.href = '{{ route('public') }}';
                });
            } else {
                App.unblockUI();
                var inputError = [];

                console.log(data.message[Object.keys(data.message)[0]]);
                if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
                    var input = $("input[name='"+Object.keys(data.message)[0]+"']");
                } else {
                    var input = $('#'+Object.keys(data.message)[0]);
                }

                $('html,body').animate(
                    {scrollTop: input.offset().top - 100},
                    'slow', function() {
                        swal("{{ __('new.error') }}!",data.message[Object.keys(data.message)[0]], "error");
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
                    // parent.find('i').remove();
                    // parent.find('.input-icon').append('<i class="fa fa-exclamation-triangle"></i>');
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
                        // parent.find('i').remove();
                        // parent.find('.input-icon').append('<i class="fa fa-check"></i>');
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