<?php
// Start a PHP session.
session_start();

//die(app_path()."\\..\\public\\assets\\global\\plugins\\icon-captcha\\php\\captcha.class.php");

// Include the IconCaptcha class.
//require( app_path()."\\..\\public\\assets\\global\\plugins\\icon-captcha\\php\\captcha.class.php" );
require(app_path() . "/../public/assets/global/plugins/icon-captcha/php/captcha.class.php");

// Set the path to the captcha icons. Set it as if you were
// currently in the PHP folder containing the captcha.class.php file.
// ALWAYS END WITH A /
// DEFAULT IS SET TO ../icons/
//IconCaptcha::setIconsFolderPath( app_path()."\\..\\public\\assets\\global\\plugins\\icon-captcha\\icons\\" );
IconCaptcha::setIconsFolderPath(app_path() . "/../public/assets/global/plugins/icon-captcha/icons/");

// Use custom messages as error messages (optional).
// Take a look at the IconCaptcha class to see what each string means.
// IconCaptcha::setErrorMessages(array('', '', '', ''));
?>


@extends('layouts.register')

@section('after_styles')
    {{ Html::style(URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/select2/css/select2.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')) }}
    {{ Html::style(URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')) }}

    {{ Html::style(URL::to('/assets/global/plugins/icon-captcha/style/css/style.css')) }}

    <style type="text/css">
        .has-error .btn.default:not(.btn-outline) {
            border-color: #e73d4a !important;
        }
    </style>
@endsection

@section('content')
    {{ Form::open(['route' => $route, 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}

    @if(Route::current()->getName() == 'citizen')
        <input name="citizenship" type="hidden" value="1">
    @else
        <input name="citizenship" type="hidden" value="0">
    @endif

    <div class="note note-danger mt20"><span class="text-danger sbold"> {{ trans('new.complete_information') }} </span>
    </div>

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
                    @include('auth.individual.detail')
                </div>
            </div>
        </div>

        <div class="col-md-12 hidden">
            <div id="error_msg" class="alert alert-danger" role="alert">
            </div>
        </div>

        <!-- Contact information -->
        <div class="col-md-12">
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
                    @include('auth.individual.contact_info')
                </div>
            </div>
        </div>

    @if(Route::current()->getName() != 'tourist')
        <!-- Address -->
            <div class="col-md-12">
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
                        @include('auth.individual.address')
                    </div>
                </div>
            </div>


            <!-- Mailing Address -->
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green sbold uppercase">D. {{ trans('new.mailing_address') }}</span>
                            <div class="md-checkbox pull-right ml10">
                                <input id="copy_address" name="copy_address" class="md-checkboxbtn" value="1"
                                       type="checkbox">
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
                        @include('auth.individual.mailing_address')
                    </div>
                </div>
            </div>

            <!-- Demo grafi -->
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green sbold uppercase">E. {{ trans('new.demographic') }}</span>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"> </a>
                            <a href="" class="fullscreen"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        @include('auth.individual.demo_info')
                    </div>
                </div>
            </div>
    @endif

    <!-- Security detail -->
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">
                        @if(Route::current()->getName() != 'tourist')
                                F. {{ trans('new.security_details') }}
                            @else
                                C. {{ trans('new.security_details') }}
                            @endif
                        </span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('auth.individual.security_detail')
                </div>
                <div class="clearfix">
                    <div class="col-md-offset-4 col-md-8 mv20">
                        <button type="button" class="btn default" onclick="location.href ='{{ route('login') }}'"><i
                                    class="fa fa-reply mr10"></i>{{ trans('button.back') }}</button>
                        <button type="submit" class="btn green"><i
                                    class="fa fa-paper-plane mr10"></i>{{ trans('button.register') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="partial_register" id="partial_register" value=0>
    {{ Form::close() }}
    @if(Route::current()->getName() == 'citizen')
        <div class="hidden" id="jpn_name"></div>
    @endif
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
      var canSubmit = false
    </script>

    <!-- Initialize the IconCaptcha -->
    <script async type="text/javascript">
      $(window).ready(function () {
        $('.captcha-holder').iconCaptcha({
          captchaTheme: [ 'light', 'dark' ], // Select the theme(s) of the Captcha(s). Available: light, dark
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
          .bind('init.iconCaptcha', function (e, id) { // You can bind to custom events, in case you want to execute some custom code.
            console.log('Event: Captcha initialized', id)
          }).bind('selected.iconCaptcha', function (e, id) {
          console.log('Event: Icon selected', id)
        }).bind('refreshed.iconCaptcha', function (e, id) {
          console.log('Event: Captcha refreshed', id)
        }).bind('success.iconCaptcha', function (e, id) {
          canSubmit = true
          console.log('Event: Correct input', id)
        }).bind('error.iconCaptcha', function (e, id) {
          canSubmit = false
          console.log('Event: Wrong input', id)
        })
      })
    </script>

    <script type="text/javascript">
        @if(Route::current()->getName() == 'citizen')
        $('#name').on('change', function () {
          // check if ic is empty then alert to fill the ic first
          if ($('#identification_no').val() == '') {
            swal({
              title: "{{ __('new.error') }}",
              text: "{{ __('new.error_missing_identification_no') }}",
              type: 'error'
            })

            return
          }

          var param = { 'ic': $('#identification_no').val(), 'name': $('#name').val().replace(/\s/g, '').toUpperCase() }

          // compare between ic and name
          $.ajax({
            url: "{{ route('integration-myidentity-check-ic-public') }}",
            type: 'POST',
            data: param,
            datatype: 'json',
            success: function (data) {
              console.log(data);

              if (data. != jpn_name) {
                swal("{{ __('new.error') }}", "{{ __('new.name_mismatched') }}", 'error')
                $('#error_msg').html("{{ __('new.error') }}! {{ __('new.name_mismatched') }}")
                $('#error_msg').parent().removeClass('hidden')
              } else {
                $('#error_msg').html('')
                $('#error_msg').parent().addClass('hidden')
                return
              }

              {{--if (data.ReplyIndicator == 0 || data.RecordStatus == "{{ __('new.died') }}") {--}}

              {{--  // if(data.Message != "" && data.Message != null) {--}}
              {{--  //     swal("{{ __('new.error') }}", data.Message, "error");--}}
              {{--  //     $("#error_msg").html("{{ __('new.error') }}! "+data.Message);--}}
              {{--  // }--}}
              {{--  // else {--}}
              {{--  swal("{{ __('new.error') }}", "{{ __('new.invalid_ic') }}", 'error')--}}
              {{--  $('#error_msg').html("{{ __('new.error') }}! {{ __('new.invalid_ic') }}")--}}
              {{--  // }--}}

              {{--  $('#error_msg').parent().removeClass('hidden')--}}
              {{--} else if (data.ResidentialStatus != "{{ __('new.citizen') }}") {--}}
              {{--  swal({--}}
              {{--      title: "{{ __('new.error') }}",--}}
              {{--      text: "{{ __('new.register_as_noncitizen') }}",--}}
              {{--      type: 'error'--}}
              {{--    },--}}
              {{--    function () {--}}
              {{--      window.location.href = '{{ route('register.noncitizen') }}'--}}
              {{--    })--}}
              {{--} else {--}}
              {{--  $('#error_msg').parent().addClass('hidden')--}}
              {{--  $('#error_msg').html('')--}}
              {{--  $('#jpn_name').html(data.Name)--}}
              {{--}--}}
            },
            error: function (xhr, ajaxOptions, thrownError) {
              //swal("Unexpected Error!", thrownError, "error");
              //alert(thrownError);
            }
          })

          {{--if (name != jpn_name) {--}}
          {{--  swal("{{ __('new.error') }}", "{{ __('new.name_mismatched') }}", 'error')--}}
          {{--  $('#error_msg').html("{{ __('new.error') }}! {{ __('new.name_mismatched') }}")--}}
          {{--  $('#error_msg').parent().removeClass('hidden')--}}
          {{--} else {--}}
          {{--  $('#error_msg').html('')--}}
          {{--  $('#error_msg').parent().addClass('hidden')--}}
          {{--}--}}
        })

        $('#identification_no').on('change', function () {
          var nric = $(this).val() // 890101065555
          var year = nric.substr(0, 2)
          var month = nric.substr(2, 2)
          var day = nric.substr(4, 2)

          if (year >= 00 && year <= 30) {
            if (year != '') {
              year = 20 + year
            }
          }

          if (year >= 31 && year <= 99) {
            year = 19 + year
          }

          var dob2 = year + '-' + month + '-' + day
          dob3 = day + '/' + month + '/' + year
          console.log(dob3)
          var gender = nric.substr(11, 1) // 1 = L, 2 = P % 2) == 0) {
          if ((gender % 2) == 0) {
            var gender_value = '2'
          } else {
            var gender_value = '1'
          }

          if (month > 12 || day > 31) {
            swal(" {{ trans('swal.error') }} !", " {{ trans('swal.ic_not_exist') }} ", 'error')
            $(this).val('')
            $('#date_of_birth').val('')
            $('#gender_id').val('').trigger('change.select2')
          } else if (year != '' || month != '' || day != '') {
            $('#date_of_birth').val(dob3)
            $('#gender_id').val(gender_value).trigger('change.select2')
          } else {
            $(this).val('')
            $('#date_of_birth').val('')
            $('#gender_id').val('').trigger('change.select2')
          }

          if (getAge(dob2) < 18) {
            swal({
                title: "{{ __('new.sorry') }}!",
                text: "{{ __('new.18yo_max_msg') }}",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#4e8ea5',
                confirmButtonText: "{{ __('new.return_login') }}",
                closeOnConfirm: false
              },
              function (isConfirm) {
                if (isConfirm) {
                  location.href = "{{ url('/') }}"
                }
              })
            $('#error_msg').html("{{ __('new.sorry') }}! {{ __('new.18yo_max_msg') }}")
            $('#error_msg').parent().removeClass('hidden')
          }

          var id_no = $('#identification_no').val()

          $.ajax({
            url: "{{ route('integration-myidentity-checkic', ['ic'=>'']) }}/" + id_no + '?validate=true',
            type: 'POST',
            datatype: 'json',
            success: function (data) {
              if (data.ReplyIndicator == 0 || data.RecordStatus == "{{ __('new.died') }}") {

                // if(data.Message != "" && data.Message != null) {
                //     swal("{{ __('new.error') }}", data.Message, "error");
                //     $("#error_msg").html("{{ __('new.error') }}! "+data.Message);
                // }
                // else {
                swal("{{ __('new.error') }}", "{{ __('new.invalid_ic') }}", 'error')
                $('#error_msg').html("{{ __('new.error') }}! {{ __('new.invalid_ic') }}")
                // }

                $('#error_msg').parent().removeClass('hidden')
              } else if (data.ResidentialStatus != "{{ __('new.citizen') }}") {
                swal({
                    title: "{{ __('new.error') }}",
                    text: "{{ __('new.register_as_noncitizen') }}",
                    type: 'error'
                  },
                  function () {
                    window.location.href = '{{ route('register.noncitizen') }}'
                  })
              } else {
                $('#error_msg').parent().addClass('hidden')
                $('#error_msg').html('')
                $('#jpn_name').html(data.Name)
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              //swal("Unexpected Error!", thrownError, "error");
              //alert(thrownError);
            }
          })


        })

        @endif

        function getAge(dateString) {
          var today = new Date()
          var birthDate = new Date(dateString)
          var age = today.getFullYear() - birthDate.getFullYear()
          var m = today.getMonth() - birthDate.getMonth()
          if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--
          }
          return age
        }

        $.fn.copyAddress = function () {
          $('#address_mailing_street_1').val($('#address_street_1').val())
          $('#address_mailing_street_2').val($('#address_street_2').val())
          $('#address_mailing_street_3').val($('#address_street_3').val())
          $('#address_mailing_postcode').val($('#address_postcode').val())
          $('#address_mailing_state_id').val($('#address_state_id').val()).trigger('change.select2').on('change', function (e) {
            console.log(e)
            var state = e.target.value

            $.get('{{  URL::to('state?state_id=') }}' + state, function (data) {
              var $district = $('#address_mailing_district_id')

              $district.find('option').remove().end()
              $district.removeAttr('disabled').end()
              $district.append('<option value>{{ trans("dropdown.choose_district") }}</option>')

              $.each(data, function (index, district) {
                $district.append('<option value="' + district.district_id + '">' + district.district + '</option>')
              })
              var district_id = $('#address_district_id').val()
              $district.val(district_id).find('option[value="' + district_id + '"]').attr('selected', true)
            })
          }).change()
        }

        $('#mailing_address').hide()
        $('#address input[type=\'text\'], #address select').change(function () {
          console.log(!$('#copy_address').is(':checked'))
          if (!$('#copy_address').is(':checked')) {
            $.fn.copyAddress()
          }
        })

        $('#copy_address').change(function () {
          if (this.checked) {
            $('#mailing_address').show()
            $('#mailing_address input[type=\'text\']').val('')
            $('#address_mailing_state_id').val('').trigger('change.select2').change()
            // $("#address_mailing_district_id").val('').trigger('change.select2');
          } else {
            $('#mailing_address').hide()
            $.fn.copyAddress()
          }
        })

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

        $('#submitForm').submit(function (e) {

          e.preventDefault()

          if (!canSubmit) {
            swal("{{ trans('swal.error') }}", "{{ __('swal.captcha_invalid') }}!", 'error')
            return
          }

          var form = $(this)
          $.ajax({
            url: form.attr('action'),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: form.attr('method'),
            data: new FormData(form[ 0 ]),
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            beforeSend: function () {
              App.blockUI({ boxed: !0 })
            },
            success: function (data) {
              if (data.status == 'ok') {
                window.onkeydown = window.onfocus = null
                App.unblockUI()
                swal({
                    title: "{{ __('swal.success') }}",
                    text: data.message,
                    type: 'success'
                  },
                  function () {
                    window.location.href = '{{ route('login') }}'
                  })
              } else {
                App.unblockUI()
                var inputError = []

                console.log(data.message[ Object.keys(data.message)[ 0 ] ])
                if ($('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':radio') || $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':checkbox')) {
                  var input = $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']')
                } else {
                  var input = $('#' + Object.keys(data.message)[ 0 ])
                }

                $('html,body').animate(
                  { scrollTop: input.offset().top - 100 },
                  'slow', function () {
                    window.onkeydown = window.onfocus = null
                    swal(" {{ trans('swal.error') }} ", data.message[ Object.keys(data.message)[ 0 ] ], 'error')
                    input.focus()
                  }
                )

                $.each(data.message, function (key, data) {
                  if ($('input[name=\'' + key + '\']').is(':radio') || $('input[name=\'' + key + '\']').is(':checkbox')) {
                    var input = $('input[name=\'' + key + '\']')
                  } else {
                    var input = $('#' + key)
                  }
                  var parent = input.parents('.form-group')
                  parent.removeClass('has-success')
                  parent.addClass('has-error')
                  parent.find('.help-block').html(data[ 0 ])
                  // parent.find('i').remove();
                  // parent.find('.input-icon').append('<i class="fa fa-exclamation-triangle"></i>');
                  inputError.push(key)
                })

                $.each(form.serializeArray(), function (i, field) {
                  if ($.inArray(field.name, inputError) === -1) {
                    if ($('input[name=\'' + field.name + '\']').is(':radio') || $('input[name=\'' + field.name + '\']').is(':checkbox')) {
                      var input = $('input[name=\'' + field.name + '\']')
                    } else {
                      var input = $('#' + field.name)
                    }
                    var parent = input.parents('.form-group')
                    parent.removeClass('has-error')
                    parent.addClass('has-success')
                    // parent.find('i').remove();
                    // parent.find('.input-icon').append('<i class="fa fa-check"></i>');
                    parent.find('.help-block').html('')
                  }
                })
              }
            },
            error: function (xhr) {
              console.log(xhr.status)
            }
          })
          return false
        })


        $('#identification_no').on('input', function (e) {
          var identification_no = this.value
          var timer
          clearTimeout(timer)
          timer = setTimeout(function () {
            if (identification_no.length >= 5) {
              $.ajax({
                url: "{{route('register.checkicpassport')}}",
                type: 'POST',
                data: {
                  identification_no: identification_no,
                  _token: '{{csrf_token()}}'
                },
                success: function (response) {
                  if (response.status == 'ok') {
                    $.each(response.data, function (key, data) {
                      if ($('input[name=\'' + key + '\']').is(':radio') || $('input[name=\'' + key + '\']').is(':checkbox')) {
                        var input = $('input[name=\'' + key + '\']')
                      } else {
                        var input = $('#' + key)
                      }

                      if (input.is('select')) {
                        if (input == '#address_district_id')
                          setInterval(function () {
                            input.val(data).trigger('change.select2')
                          }, 7000)
                        else
                          input.val(data).trigger('change.select2')
                      } else {
                        input.val(data)
                      }
                    })
                  } else {
                    var identification_no = $('#identification_no').val()
                    //$('#submitForm')[0].reset();
                    $('#identification_no').val(identification_no)
                  }
                  $('#partial_register').val(response.partial_register)
                }
              })
            }
          }, 100)
        })

        @if(Route::current()->getName() == 'noncitizen')
        $('#race_id').val(6).trigger('change')

        $('#identification_no').on('change', function () {
          var letters = /^([0-9]|[a-z])+([0-9a-z]+)$/i
          var passport = $(this).val()

          if (!passport.match(letters)) {
            swal("{{ trans('swal.error') }}", "{{ __('swal.alphanumeric') }}!", 'error')
          }
        })

        $('#date_of_birth').on('change', function () {
          var dob = $('#date_of_birth').datepicker('getDate')

          if (getAge(dob) < 18) {
            swal({
                title: "{{ __('new.sorry') }}!",
                text: "{{ __('new.18yo_max_msg') }}",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#4e8ea5',
                confirmButtonText: "{{ __('new.return_login') }}",
                closeOnConfirm: false
              },
              function (isConfirm) {
                if (isConfirm) {
                  location.href = "{{ url('/') }}"
                }
              })
            $('#error_msg').html("{{ __('new.sorry') }}! {{ __('new.18yo_max_msg') }}")
            $('#error_msg').parent().removeClass('hidden')
          }
        })
        @endif
    </script>
@endsection
