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
        <h3>{{trans('new.my_profile')}}</h3>
        <p>{{trans('new.user_details')}}</p>
    </div>

    <div class="row">

        {{-- Detail --}}
        @if($userPublic->user_public_type_id == 2)
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
                    @include('profile.detailCompany')

                </div>
            </div>
        </div>
        @else
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
                    @include('profile.detail')
                </div>
            </div>
        </div>
        @endif

        {{-- Contact information --}}
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
                    @include('profile.contact_info')
                </div>
            </div>
        </div>

       {{--  Address --}}
       @if(!empty($userPublicIndividual))
       @if($userPublicIndividual->is_tourist != 1)
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
                @include('profile.address')
                </div>
            </div>
        </div>



        {{--  Mailing Address --}}
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">D. {{ trans('new.mailing_address') }}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse" data-original-title="" title=""> </a>
                        <a href="" class="fullscreen" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body" id="mailing_address">
                @include('profile.mailing_address')
                </div>
            </div>
        </div>
        @endif
        @endif

        @if($userPublic->user_public_type_id == 2)

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
                @include('profile.address')
                </div>
            </div>
        </div>



        {{--  Mailing Address --}}
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">D. {{ trans('new.mailing_address') }}</span>
                        <div class="md-checkbox pull-right ml10">
                            <input id="copy_address" name="copy_address" class="md-checkboxbtn" value="1" type="checkbox">
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
                @include('profile.mailing_address')
                </div>
            </div>
        </div>
        @endif

        <!-- Demo grafi -->
        @if(!empty($userPublicIndividual))
        @if($userPublicIndividual->is_tourist != 1)
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
                @include('profile.demo_info')
                </div>
            </div>
        </div>
        @endif
        @endif

        {{-- {{dd($masterDesignation)}} --}}
        @if($userPublic->user_public_type_id == 2)
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">E. {{ trans('new.rep_info') }}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="" class="fullscreen"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                @include('profile.rep_info')
                </div>
            </div>
        </div>
        @endif






    <div class="form-actions">
        <div class="row">
            <div class="col-md-12" style="text-align: center">
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
<script type="text/javascript">

$('#representative_identification_type').on('change', function(){
    if( $('#representative_identification_type').val() == 1 ) { // IC
        $('#row_representative_nationality_country_id').addClass('hidden');
    }
    else { // Passport
        $('#row_representative_nationality_country_id').removeClass('hidden');
    }
});

$('#company_no, #identification_no, #username').attr('readonly','readonly');


// $(window).on('load', function(){
//     $("#address_district_id").val({{$userPublic->address_district_id}});
//     $("#address_mailing_district_id").val({{$userPublic->address_district_id}});

// });
@if(!empty($userPublicIndividual))
@if($userPublicIndividual->nationality_country_id == 129 )
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
        swal("{{ trans('swal.error') }}","{{ trans('swal.ic_not_exist') }}", "error");
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
});
@endif
@endif


// $.fn.copyAddress = function(){
//     $("#address_mailing_street_1").val($("#address_street_1").val());
//     $("#address_mailing_street_2").val($("#address_street_2").val());
//     $("#address_mailing_street_3").val($("#address_street_3").val());
//     $("#address_mailing_postcode").val($("#address_postcode").val());
//     $("#address_mailing_state_id").val($("#address_state_id").val()).trigger('change.select2').on('change', function(e){
//         console.log(e);
//         var state = e.target.value;

//         $.get('state?state_id=' + state, function(data) {
//             var $district = $("#address_mailing_district_id");

//             $district.find('option').remove().end();
//             $district.removeAttr("disabled").end();
//             $district.append('<option value>Pilih Daerah</option>');

//             $.each(data, function(index, district) {
//                 $district.append('<option value="' + district.district_id + '">' + district.district + '</option>');
//             });
//             var district_id = $("#address_district_id").val();
//             $district.val(district_id).find('option[value="' + district_id +'"]').attr('selected', true);
//         });
//     }).change();
// }

// $("#mailing_address").hide();
// $("#address input[type='text'], #address select").change(function(){
//     console.log(!$("#copy_address").is(':checked'));
//     if (!$("#copy_address").is(':checked')) {
//         $.fn.copyAddress();
//     }
// });

// $("#copy_address").change(function(){
//     if (this.checked) {
//         $("#mailing_address").show();
//         $("#mailing_address input[type='text']").val('');
//         $("#address_mailing_state_id").val('').trigger('change.select2').change();
//         // $("#address_mailing_district_id").val('').trigger('change.select2');
//     } else {
//         $("#mailing_address").hide();
//         $.fn.copyAddress();
//     }
// });

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
                    window.location.href = '{{ route('home') }}';
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