<?php
$locale = App::getLocale();
$classification_lang = "classification_" . $locale;
$offence_lang = "offence_description_" . $locale;
?>
@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>

    <link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}"
          rel="stylesheet" type="text/css"/>

    <link href="{{ URL::to('/assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet"
          type="text/css"/>

    {{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}
    <style>

        #step_4 .control-label, .control-label-custom {
            padding-top: 15px !important;
        }

        .clickme {
            cursor: pointer !important;
        }

        #step_header {
            display: flex;
            flex-wrap: wrap;
        }

        .step_header_item {
            position: relative;
            flex: auto;
            min-width: 130px;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }

        .hidden {
            display: none;
        }

    </style>
@endsection

@section('content')
    <!-- #start -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> {{ __('form1.form1_registration') }}
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
            <div class="mt-element-step">
                <div id="step_header" class="row step-background-thin">
                    <div id="step_header_1"
                         class="step_header_item bg-grey-steel mt-step-col active">
                        <div class="mt-step-number">1</div>
                        <div class="mt-step-title uppercase font-grey-cascade">{{ __('form1.step') }}</div>
                        <div class="mt-step-content font-grey-cascade">{{ __('form1.registration') }}</div>
                    </div>
                    <div id="step_header_2"
                         class="step_header_item bg-grey-steel mt-step-col">
                        <div class="mt-step-number">2</div>
                        <div class="mt-step-title uppercase font-grey-cascade">{{ __('form1.step') }}</div>
                        <div class="mt-step-content font-grey-cascade">{{ __('form1.respondent') }}</div>
                    </div>
                    <div id="step_header_3"
                         class="step_header_item bg-grey-steel mt-step-col">
                        <div class="mt-step-number">3</div>
                        <div class="mt-step-title uppercase font-grey-cascade">{{ __('form1.step') }}</div>
                        <div class="mt-step-content font-grey-cascade">{{ __('form1.statement_claim') }}</div>
                    </div>
                    <div id="step_header_4"
                         class="step_header_item bg-grey-steel mt-step-col">
                        <div class="mt-step-number">4</div>
                        <div class="mt-step-title uppercase font-grey-cascade">{{ __('form1.step') }}</div>
                        <div class="mt-step-content font-grey-cascade">{{ __('form1.verification') }}</div>
                    </div>
                    @if($is_staff)
                        <div id="step_header_5"
                             class="step_header_item bg-grey-steel mt-step-col">
                            <div class="mt-step-number">5</div>
                            <div class="mt-step-title uppercase font-grey-cascade">{{ __('form1.step') }}</div>
                            <div class="mt-step-content font-grey-cascade">{{ __('form1.process_claim') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br>

    @include('claimcase.form1.steps.viewStep1')

    @include('claimcase.form1.steps.viewStep2')

    @include('claimcase.form1.steps.viewStep3')

    @include('claimcase.form1.steps.viewStep4')

    @if($is_staff)
        @include('claimcase.form1.steps.viewStep5')
    @endif

    <div class="row">
        <div class="col-md-12" style="text-align: center; line-height: 80px;">

            <button id="btn_back" onclick="backStep()" class="btn default button-previous hidden">
                <i class="fa fa-angle-left"></i> {{ __('form1.back') }}
            </button>
            <button id="btn_next" onclick="nextStep()" class="btn btn-outline green button-next"> {{ __('form1.next') }}
                <i class="fa fa-angle-right"></i>
            </button>

            @if($is_staff)
                <button id="btn_process" onclick="nextStep()" type="submit"
                        class="btn green button-submit hidden">{{ __('form1.edit') }}
                    <i class="fa fa-check"></i>
                </button>
            @else
                <button id="btn_process" onclick="nextStep()" type="submit"
                        class="btn green button-submit hidden">{{ __('button.send') }}
                    <i class="fa fa-check"></i>
                </button>
            @endif

        </div>
    </div>

    <!-- Modal -->
    <div id="fpxModal" class="modal fade modal-lg" role="dialog" style="width: 100%;">
        <div class="modal-dialog" style="width: 1000px; max-width: 100%;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">FPX</h4>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <div class="loader"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('button.close') }}</button>
                    <a id="btnProceedFPX" class="btn green-sharp" onclick='submit()'>{{ trans('button.proceed') }}</a>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="modalTC" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('fpx.terms_cond') }}</h4>
                </div>
                <div class="modal-body">


                    @if(App::getLocale() == 'en')

                        <strong>Tribunal Jurisdiction</strong><br>
                        <br>
                        <strong>-Tribunal hearing and ordered</strong><br>
                        <br>
                        <ol type="a">
                            <li>Any claim regarding any matter that it had jurisdiction to hear as provided for under
                                the Act;
                            </li>
                            <li>Where the amount claimed must not exceed RM50,000.00; and;</li>
                            <li>Any other matters that the Minister may by order published in the Gazette.</li>
                        </ol>
                        <br>
                        <strong>Limitation of Jurisdiction</strong><br>
                        <br>
                        <ol type="1">
                            <li><strong>The Tribunal does not have jurisdiction to hear any claim-</strong></li>
                            <ol type="a">
                                <li>Arising from personal injury or death;</li>
                                <li>For the recovery of land or any estate or interest in land;</li>
                                <li>That the title to any land or any estate or interest in land, or any franchise;</li>
                                <li><strong>A dispute concerning-</strong></li>
                                <ol type="I">
                                    <li>Rights under a will or settlement, or on intestacy;</li>
                                    <li>Good will;</li>
                                    <li>Any rights in action;</li>
                                </ol>
                                <li>When any tribunal has been established under any other written law to hear and
                                    determine claims about the subject matter of the claim.
                                </li>
                            </ol>
                            <!-- check spelling -->
                            <li>The jurisdiction of the Tribunal shall be limited to a claim based on a cause of action
                                which accrues within three years of the claim.
                            </li>
                        </ol>

                    @else

                        <strong>Bidang Kuasa Tribunal</strong><br>
                        <br>
                        <strong>-Tribunal mendengar dan memutuskan</strong><br>
                        <br>
                        <ol type="a">
                            <li>Apa-apa tuntutan mengenai apa-apa perkara yang ia mempunyai bidang kuasa untuk mendengar
                                seperti diperuntukkan di bawah akta;
                            </li>
                            <li>Di mana jumlah amaun yang dituntut tidak melebihi RM50,000.00; dan;</li>
                            <li>Apa-apa perkara lain yang ditetapkan oleh Menteri melalui perintah yang disiarkan dalam
                                Warta.
                            </li>
                        </ol>
                        <br>
                        <strong>Batasan Bidang Kuasa</strong><br>
                        <br>
                        <ol type="1">
                            <li><strong>Tribunal tidak mempunyai bidang kuasa untuk mendengar apa-apa tuntutan-</strong>
                            </li>
                            <ol type="a">
                                <li>Yang berbangkit daripada kecederaan diri atau kematian;</li>
                                <li>Bagi mendapatkan kembali tanah atau apa-apa estet atau kepentingan mengenai tanah;
                                </li>
                                <li>Yang mempersoalkan hakmilik-hakmilik tanah atau apa-apa estet atau kepentingan
                                    mengenai tanah atau apa-apa francais;
                                </li>
                                <li><strong>Yang mengandungi pertikaian mengenai-</strong></li>
                                <ol type="I">
                                    <li>Hak di bawah satu wasiat atau peruntukan,atau disebabkan kematian tak
                                        berwasiat;
                                    </li>
                                    <li>Nama baik;</li>
                                    <li>Apa-apa hak dalam tindakan;</li>
                                </ol>
                                <li>Apabila mana-mana tribunal telah ditubuhkan melalui mana-mana undang-undang bertulis
                                    lain untuk mendengar dan memutuskan tuntutan-tuntutan tentang perkara yang menjadi
                                    hal perkara tuntutan itu.
                                </li>
                            </ol>
                            <!-- check spelling -->
                            <li>Bidang kuasa Tribunal hendaklah terhad kepada suatu tuntutan yang berasaskan pada suatu
                                kausa tindakan yang terakru dalam masa tiga tahun dari tuntutan itu.
                            </li>
                        </ol>

                    @endif


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            onclick='location.href="{{ route('onlineprocess.form1') }}"'>{{ __('button.close')}}</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('button.agree')}}</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('after_scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}"
            type="text/javascript"></script>


    <script src="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/typeahead/typeahead.bundle.min.js') }}"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    {{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}

    <script>
      var opponent_counter = {{$opponent_counter}}
      loadHearing($('#branch'))

      @if(!$is_staff)
      @if(strpos(Request::url(),'create') !== false)
      $('#modalTC').modal('show')
      @endif
      @endif

      $('#claimant_identification_no').on('keydown', function (e) {
        if ($('#claimant_identification_no').hasClass('numeric')) {
          -1 !== $.inArray(e.keyCode, [ 46, 8, 9, 27, 13, 110, 190 ]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
        }
      })

      $('#opponent_identification_no').on('keydown', function (e) {
        if ($('#opponent_identification_no').hasClass('numeric')) {
          -1 !== $.inArray(e.keyCode, [ 46, 8, 9, 27, 13, 110, 190 ]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
        }
      })

      $('#block_inquiry_info').addClass('hidden')
      @if(isset($case))
      @if($case->inquiry_id)
      $('#block_inquiry_info').removeClass('hidden')
      @endif
      @elseif($inquiry)
      $('#block_inquiry_info').removeClass('hidden')
      @endif

      $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip()

        $('#claimant_postcode').on('blur', function () {
          console.log('claimant_postcode on blur')
          // get data negeri n daerah from api
          $.ajax({
            url: '{{ route('api.postcode.detail') }}?p=' + $(this).val(),
            type: 'GET',
            success: function (data) {
              console.log('success to retrive data', data)
              $('#claimant_state').val(data.postcode.state_id).trigger('change')
              setTimeout(function () {
                $('#claimant_district').val(data.postcode.district_id).trigger('change')
                console.log('claimant_district trigger')
                // $('#claimant_district').val(data.postcode.district_id).trigger('change')
              }, 1000)
            }
          })
          // repopulate data dropdown for negeri n daerah
        })
      })

      $('#fpxModal').on('hidden.bs.modal', function () {
        $('#fpxModal .modal-body').html('<div style="text-align: center;"><div class="loader"></div></div>')
      })

      $('.dropify').dropify({
        messages: {
          'default': '',
          'replace': '',
          'remove': '{!! __("new.dropify_msg_remove") !!}',
          'error': '{!! __("new.dropify_msg_error") !!}'
        },
        error: {
          'fileSize': '{!! __("new.dropify_error_fileSize") !!}',
          'imageFormat': '{!! __("new.dropify_error_imageFormat") !!}'
        }
      })

      $('#claim_amount').on('keyup', function (e) {
        //console.log($('#claim_amount').val());
        if ($('#claim_amount').val() > {{config('tribunal.claim_amount')}}) {
          swal('Opps!', "{{ __('swal.max_25000') }}", 'error')
          $('#claim_amount').val({{config('tribunal.claim_amount')}})
          e.preventDefault()
        }
      })

      function submitOpponent() {
		var idtype = $('#opponent_identity_type').val();
		var idno = $('#opponent_identification_no').val();
		
		if(idno == ""){
			if(idtype == '1'){
				alert('Sila lengkapkan Nombor IC anda');
			}else if(idtype == '2'){
				alert('Sila lengkapkan Nombor Passport anda');
			}else if(idtype == '3'){
				alert('Sila lengkapkan Nombor Syarikat anda');
			}
			return false;
		}
		
        myBlockui()
        var data = $('#opponent-form').serialize() + '&claim_case_id=' + $('#claim_case_id').val() + '&add=1'

        console.log('data', data);
		
		var idtype1 = "{{ __('form1.passport_no') }}";
        var idtype2 = "{{ __('form1.ic_no') }}";
        var idtype3 = "{{ __('form1.company_no') }}";

        $.ajax({
          url: '{{ route('form1-partial2') }}',
          type: 'POST',
          data: data,
          dataType: 'json', // lowercase is always preferered though jQuery does it, too.
          success: function (data) {
			console.log('opponent_address',data.user.opponent_address.is_company);
			//========ftest=========
			if(data.user.opponent_address.is_company == 0){
				if(data.user.opponent_address.nationality_country_id != 129){
					$('.osd_idtype').html(idtype1);
				}else{
					$('.osd_idtype').html(idtype2);
				}
				$('.osd_isCompanyHomePhoneDiv').html(data.user.opponent_address.phone_home);
				$('.osd_isCompanyHomePhone').show();
				$('.osd_isCompanyHomePhoneDiv').html(data.user.opponent_address.phone_mobile);
				$('.osd_isCompanyMobilePhone').show();
			}else{
				$('.osd_idtype').html(idtype3);
			}
			$('.osd_id').html(data.user.identification_no);
			if(data.user.opponent_address.is_company == 0 && data.user.opponent_address.nationality_country_id != 129){
				$('.osd_countryNonCitizenDiv').show();
				$('.osd_countryNonCitizen').html(data.user.opponent_address.nationality_country_id); //get country name
			}
			if(data.user.opponent_address.is_company == 1){
				$('.osd_isCompany').show();
				$('.osd_isCompanyOpponentName').html(data.user.opponent_address.name);
			}
			$('.osd_opponentName').html(data.user.opponent_address.name);
			$('.osd_opponentAddress').html(data.user.address_combined);
			$('.osd_opponentPostcode').html(data.user.opponent_address.postcode);
			$('.osd_opponentDistrict').html(data.user.district_fixed);
			$('.osd_opponentState').html(data.user.state_fixed);
			$('.osd_officePhone').html(data.user.opponent_address.phone_office);
			$('.osd_fax').html(data.user.opponent_address.phone_fax);
			$('.osd_email').html(data.user.opponent_address.email);
			//========ftest=========
			
            $('#opponent-form').trigger('reset')
            $('#opponent_state').trigger('change')

            var counter = $('table#complaints_table tbody tr:last td:first').text()

            if (counter == 'Tiada maklumat dijumpai' || counter == 'Tiada maklumat dijumpai' || counter == '') {
              $('table#complaints_table tbody tr').remove()
              counter = 0
            }

            console.log('success to save data', data);

            counter = counter + 1
            $('table#complaints_table tbody').append('<tr>' +
              '<td>' + (parseInt(counter)) + '</td>' +
              '<td><strong>' + data.user.name + '</strong></td>' +
              '<td>' + data.user.identity + '</td>' +
              '<td><button target="_blank" onclick="removeOpponent(' + data.user.cco_id + ')">' +
              '<i class="fa fa-trash"></i></button>' +
              '</td>' +
              '</tr>');
			  
			$("#addPenentangBtn").prop("disabled",true);
			$("#createPenentangMsg").show();

            console.log('counter', counter);
 
            if (counter != 0) {
              $('#btn_next').show()
            } else {
              $('#btn_next').hide()
            }

            $.unblockUI()
          }
        })
      }

      function removeOpponent(cco_id) {
        if (confirm('{{ __('new.destroy_data') }}')) {
          myBlockui()

          $.ajax({
            url: '/form1/partialcreate2/' + cco_id + '/destroy',
            type: 'GET',
            success: function (data) {
              console.log('success to remove data', data)
              $('table#complaints_table tbody tr').remove()
              if (data.ccos.length > 0) {
                var counter = 0
                $.each(data.ccos, (index, item) => {
                  $('table#complaints_table tbody').append('<tr>' +
                    '<td>' + (parseInt(counter) + 1) + '</td>' +
                    '<td><strong>' + item.opponent.name + '</strong></td>' +
                    '<td>' + (item.opponent.public_data.individual.identification_no || item.opponent.public_data.company.identification_no) + '</td>' +
                    '<td><button target="_blank" onclick="removeOpponent(' + item.id + ')">' +
                    '<i class="fa fa-trash"></i></button>' +
                    '</td>' +
                    '</tr>');
                })
              } else {
                $('#btn_next').hide()
              }
			  $("#addPenentangBtn").prop("disabled",false);
			  $("#createPenentangMsg").hide();
              $.unblockUI()
            }
          })
        }
      }

      function updateReview() {
        console.log('updateReview')

        // Inquiry Info
        $('#view_inquiry_no').text($('#inquiry_no').val())

        $('#view_extra_claimant_identification_no').text($('#extra_claimant_identification_no').val())
        $('#view_extra_claimant_nationality').text($('#extra_claimant_nationality option:selected').text())
        $('#view_extra_claimant_name').text($('#extra_claimant_name').val())
        $('#view_extra_claimant_relationship').text($('#extra_claimant_relationship option:selected').text())

        // Claimant Info
        $('#view_claimant_identification_no').text($('#claimant_identification_no').val())
        $('#view_claimant_nationality').text($('#claimant_nationality option:selected').text())
        $('#view_claimant_name').text($('#claimant_name').val())
        $('#view_claimant_email').text($('#claimant_email').val())
        $('#view_claimant_phone_mobile').text($('#claimant_phone_mobile').val())
        $('#view_claimant_phone_office').text($('#claimant_phone_office').val())
        $('#view_claimant_phone_home').text($('#claimant_phone_home').val())
        $('#view_claimant_phone_fax').text($('#claimant_phone_fax').val())
        $('#view_claimant_street1').text($('#claimant_street1').val())
        $('#view_claimant_street2').text($('#claimant_street2').val())
        $('#view_claimant_street3').text($('#claimant_street3').val())
        $('#view_claimant_state').text($('#claimant_state option:selected').text())
        $('#view_claimant_district').text($('#claimant_district option:selected').text())
        $('#view_claimant_subdistrict').text($('#claimant_subdistrict option:selected').text())
        $('#view_claimant_postcode').text($('#claimant_postcode').val())

        $('#view_claimant_mailing_street1').text($('#claimant_mailing_street1').val())
        $('#view_claimant_mailing_street2').text($('#claimant_mailing_street2').val())
        $('#view_claimant_mailing_street3').text($('#claimant_mailing_street3').val())
        $('#view_claimant_mailing_state').text($('#claimant_mailing_state option:selected').text())
        $('#view_claimant_mailing_district').text($('#claimant_mailing_district option:selected').text())
        $('#view_claimant_mailing_subdistrict').text($('#claimant_mailing_subdistrict option:selected').text())
        $('#view_claimant_mailing_postcode').text($('#claimant_mailing_postcode').val())

        // Opponent Info
        // $('#view_opponent_identification_no').text($('#opponent_identification_no').val())
        // $('#view_opponent_nationality').text($('#opponent_nationality option:selected').text())
        // $('#view_opponent_name').text($('#opponent_name').val())
        // $('#view_opponent_email').text($('#opponent_email').val())
        // $('#view_opponent_phone_mobile').text($('#opponent_phone_mobile').val())
        // $('#view_opponent_phone_office').text($('#opponent_phone_office').val())
        // $('#view_opponent_phone_home').text($('#opponent_phone_home').val())
        // $('#view_opponent_phone_fax').text($('#opponent_phone_fax').val())
        // $('#view_opponent_street1').text($('#opponent_street1').val())
        // $('#view_opponent_street2').text($('#opponent_street2').val())
        // $('#view_opponent_street3').text($('#opponent_street3').val())
        // $('#view_opponent_state').text($('#opponent_state option:selected').text())
        // $('#view_opponent_district').text($('#opponent_district option:selected').text())
        // $('#view_opponent_postcode').text($('#opponent_postcode').val())

        // Transaction Info
        $('#view_is_online_transaction').text($('#is_online_transaction').val())
        $('#view_purchased_date').text($('#purchased_date').val())
        $('#view_purchased_item').text($('#purchased_item').val())
        $('#view_purchased_brand').text($('#purchased_brand').val())
        $('#view_purchased_amount').text($('#purchased_amount').val())

        // Claim Info
        $('#view_claim_details').text($('#claim_details').val())
        $('#view_claim_amount').text($('#claim_amount').val())
        $('#view_is_online_transaction').text(isYesNo($('input[name="is_online_transaction"]:checked').val()))
        $('#view_is_filed_on_court').text(isYesNo($('input[name="is_filed_on_court"]:checked').val()))
        $('#view_case_name').text($('#case_name').val())
        $('#view_case_place').text($('#case_place').val())
        $('#view_case_status').text($('#case_status').val())
        $('#view_case_created_at').text($('#case_created_at').val())

          @if(!$is_staff)
          $('#view_preferred_ttpm_branch').text($('#preferred_ttpm_branch option:selected').text())
          @endif

          if ($('input[name="is_filed_on_court"]:checked').val() != 1)
            $('.is_filed').addClass('hidden')
          else
            $('.is_filed').removeClass('hidden')

        // Process Info
        $('#view_filing_date').text($('#filing_date').val())
        $('#view_matured_date').text($('#matured_date').val())
        $('#view_claim_category').text($('#claim_category option:selected').text())
        $('#view_claim_classification').text($('#claim_classification option:selected').text())
        $('#view_claim_offence').text($('#claim_offence option:selected').text())

          @if(strpos(Request::url(),'edit') !== false)
          $('#view_hearing_date').text($('#hearing_date').val())
          @else
          $('#view_hearing_date').text($('#hearing_date option:selected').text())
          @endif

          $('.attachment_list').addClass('hidden')

        if (file1)
          if (file1[ 0 ]) {
            $('#attachment_list_1').removeClass('hidden')
            $('#attachment_list_1').find('span').text(file1[ 0 ].name)
            //console.log(file1[0].name);
          }

        if (file2)
          if (file2[ 0 ]) {
            $('#attachment_list_2').removeClass('hidden')
            $('#attachment_list_2').find('span').text(file2[ 0 ].name)
            //console.log(file1[0].name);
          }

        if (file3)
          if (file3[ 0 ]) {
            $('#attachment_list_3').removeClass('hidden')
            $('#attachment_list_3').find('span').text(file3[ 0 ].name)
            //console.log(file1[0].name);
          }

        if (file4)
          if (file4[ 0 ]) {
            $('#attachment_list_4').removeClass('hidden')
            $('#attachment_list_4').find('span').text(file4[ 0 ].name)
            //console.log(file1[0].name);
          }

        if (file5)
          if (file5[ 0 ]) {
            $('#attachment_list_5').removeClass('hidden')
            $('#attachment_list_5').find('span').text(file5[ 0 ].name)
            //console.log(file1[0].name);
          }
      }

      function isYesNo(bin) {
        if (bin == 1)
          return "{{ __('form1.yes') }}"
        else
          return "{{ __('form1.no') }}"
      }

      function changeOpponentType() {
        var type_id = $('#opponent_identity_type').val()

        if (type_id == 1) // Citizen
          isOpponentCitizen()
        else if (type_id == 2) // Non-Citizen
          isOpponentNonCitizen()
        else if (type_id == 3) // Company
          isOpponentCompany()
      }

      function changeClaimantType() {
        var type_id = $('#claimant_identity_type').val()

        if (type_id == 1) // Citizen
          isClaimantCitizen()
        else if (type_id == 2) // Non-Citizen
          isClaimantNonCitizen()
        else if (type_id == 3) // Company
          isClaimantCompany()
      }

      function changeExtraClaimantType() {
        var type_id = $('#extra_claimant_identity_type').val()

        if (type_id == 1) { // Citizen
          $('#row_extra_claimant_nationality').hide()
          $('#extra_claimant_nationality').val(129).toggle('change')
          isClaimantCitizen('extra')
        } else if (type_id == 2) { // Non-Citizen
          $('#row_extra_claimant_nationality').show()
          isClaimantNonCitizen('extra')
        }
      }


      // CONDITION: Opponent
      function isOpponentCompany() {
        $('#row_opponent_nationality, #row_view_opponent_nationality').addClass('hidden')
        //$("#required_opponent_phone_office").html(" * ");
        // Change required attributes as well
        //$("#required_opponent_phone_mobile").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        $('#label_view_opponent_identification_no').text("{{ __('form1.company_no') }} :") // Translate plz

        $('#btn_opponent_myidentity').addClass('hidden')
        $('#btn_opponent_ecbis').removeClass('hidden')
        $('#btn_opponent_ecbis').parent().css('display', 'table-cell')

        $('#row_opponent_phone_mobile, #row_opponent_phone_home, #row_view_opponent_phone_mobile, #row_view_opponent_phone_home').addClass('hidden')

        $('#opponent_identification_no').removeClass('numeric')
        $('#opponent_identification_no').removeAttr('maxlength')
      }

      function isOpponentCitizen() {
        $('#row_opponent_nationality, #row_view_opponent_nationality').addClass('hidden')
        //$("#required_opponent_phone_office").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        //$("#required_opponent_phone_mobile").html(" * ");
        // Change required attributes as well
        $('#label_view_opponent_identification_no').text("{{ __('form1.ic_no') }} :") // Translate plz
        $('#btn_opponent_myidentity').removeClass('hidden')
        $('#btn_opponent_ecbis').addClass('hidden')
        $('#btn_opponent_ecbis').parent().css('display', 'table-cell')

        $('#row_opponent_phone_mobile, #row_opponent_phone_home, #row_view_opponent_phone_mobile, #row_view_opponent_phone_home').removeClass('hidden')

        $('#opponent_identification_no').addClass('numeric')
        $('#opponent_identification_no').attr('maxlength', '12')
      }

      function isOpponentNonCitizen() {
        $('#row_opponent_nationality, #row_view_opponent_nationality').removeClass('hidden')
        //$("#required_opponent_phone_office").html(" &nbsp;&nbsp; ");
        // Change required attributes as well
        //$("#required_opponent_phone_mobile").html(" * ");
        // Change required attributes as well
        $('#label_view_opponent_identification_no').text("{{ __('form1.passport_no') }} :") // Translate plz
        $('#btn_opponent_myidentity').addClass('hidden')
        $('#btn_opponent_ecbis').addClass('hidden')
        $('#btn_opponent_ecbis').parent().css('display', 'table-column')

        $('#row_opponent_phone_mobile, #row_opponent_phone_home, #row_view_opponent_phone_mobile, #row_view_opponent_phone_home').removeClass('hidden')

        $('#opponent_identification_no').removeClass('numeric')
        $('#opponent_identification_no').removeAttr('maxlength')
      }

      // CONDITION: Claimant
      function isClaimantCompany() {
        $('#label_view_claimant_identification_no, #label_claimant_identification_no').text("{{ __('form1.company_no') }} :") // Translate plz
        $('#row_view_claimant_nationality, #row_claimant_nationality').addClass('hidden')
        $('#required_claimant_phone_office').html(' * ')
        $('#required_claimant_phone_mobile').html(' &nbsp;&nbsp; ')
        $('#btn_claimant_myidentity').addClass('hidden')
        $('#btn_claimant_ecbis').removeClass('hidden')
        $('#btn_claimant_ecbis').parent().css('display', 'table-cell')

        $('#row_claimant_phone_mobile, #row_claimant_phone_home, #row_view_claimant_phone_mobile, #row_view_claimant_phone_home').addClass('hidden')

        $('#claimant_identification_no').removeClass('numeric')
        $('#claimant_identification_no').removeAttr('maxlength')
      }

      function isClaimantCitizen() {
        $('#label_view_claimant_identification_no, #label_claimant_identification_no').text("{{ __('form1.ic_no') }} :") // Translate plz
        $('#row_view_claimant_nationality, #row_claimant_nationality').addClass('hidden')
        $('#required_claimant_phone_office').html(' &nbsp;&nbsp; ')
        $('#required_claimant_phone_mobile').html(" ** {{ __('new.at_least_one') }} ")
        $('#btn_claimant_myidentity').removeClass('hidden')
        $('#btn_claimant_ecbis').addClass('hidden')
        $('#btn_claimant_ecbis').parent().css('display', 'table-cell')

        $('#row_claimant_phone_mobile, #row_claimant_phone_home, #row_view_claimant_phone_mobile, #row_view_claimant_phone_home').removeClass('hidden')

        $('#claimant_identification_no').addClass('numeric')
        $('#claimant_identification_no').attr('maxlength', '12')
      }

      function isClaimantNonCitizen() {
        $('#label_view_claimant_identification_no, #label_claimant_identification_no').text("{{ __('form1.passport_no') }} :") // Translate plz
        $('#row_view_claimant_nationality, #row_claimant_nationality').removeClass('hidden')
        $('#required_claimant_phone_office').html(' &nbsp;&nbsp; ')
        $('#required_claimant_phone_mobile').html(" ** {{ __('new.at_least_one') }} ")
        $('#btn_claimant_myidentity').addClass('hidden')
        $('#btn_claimant_ecbis').addClass('hidden')
        $('#btn_claimant_ecbis').parent().css('display', 'table-column')

        $('#row_claimant_phone_mobile, #row_claimant_phone_home, #row_view_claimant_phone_mobile, #row_view_claimant_phone_home').removeClass('hidden')

        $('#claimant_identification_no').removeClass('numeric')
        $('#claimant_identification_no').removeAttr('maxlength')
      }

      var current_step = 0

      function goToStep(no) {
          @if(strpos(Request::url(),'edit') !== false)
            current_step = no - 1
        nextStep()
          @endif
      }

      function updateButton() {
        console.log('updateButton')
        $('#btn_back, #btn_next').removeClass('hidden')
        $('#btn_process').addClass('hidden')

        if (current_step == 1)
          $('#btn_back, #btn_process').addClass('hidden')
                @if($is_staff)
        else if (current_step == 5) {
          $('#btn_next').addClass('hidden')
          $('#btn_process').removeClass('hidden')
        }
                @else
        else if (current_step == 4) {
          $('#btn_next').addClass('hidden')
          $('#btn_process').removeClass('hidden')
        }
          @endif
      }

      function nextStep() {
        console.log('nextStep')
        if (current_step <= $('#step_header').children().length) {

          var loadNext = false

          if (current_step > 0 && current_step < 4) {
            loadNext = updatePartial(current_step).then(function () {
              return true
            }, function () {
              return false
            })
            console.log(loadNext)
          } else if (current_step == 4) {
            loadNext = uploadAttachment()
          } else if (current_step == 5) {
            loadNext = submitForm()
          } else {
            loadNext = true
          }


          if (loadNext) {
            resetStep()

            current_step++

            $('#step_' + current_step).removeClass('hidden')
            $('#step_header_' + current_step).addClass('active')

            for (var i = 0; i < current_step; i++)
              $('#step_header_' + i).addClass('done')

            $('html, body').animate({ scrollTop: 0 }, 'slow')
            updateButton()
          }

          if ({{auth()->user()->user_type_id}} == 3 && current_step == 3 && ($('#attachment_1').data('default-file') == undefined)
        )
          {
            $('#btn_next').hide()
          }

          if (current_step == 2 && opponent_counter === 0) {
            $('#btn_next').hide()
          } else {
            console.log('opponent_counter', opponent_counter)
          }
        }
      }

      function backStep() {
        if (current_step > 1) {
          if (current_step == 3) {
            $('#btn_next').show()
          }
          var loadNext = false

          // if(current_step < 4)
          //     loadNext = updatePartial(current_step);
          // else
          loadNext = true

          if (loadNext) {

            resetStep()

            current_step--

            $('#step_' + current_step).removeClass('hidden')
            $('#step_header_' + current_step).addClass('active')

            for (var i = 0; i < current_step; i++)
              $('#step_header_' + i).addClass('done')

            $('html, body').animate({ scrollTop: 0 }, 'slow')
            updateButton()
          }
        }
      }

      function resetStep() {
        $('.step_item').addClass('hidden')
        $('.step_header_item').removeClass('done')
        $('.step_header_item').removeClass('active')
      }

      console.log('initialize')
      updateReview()

      // Initialize Condition

      @if(!$is_staff)
      @if($user->public_data->user_public_type_id == 2) //Company
      isClaimantCompany()
      @elseif($user->public_data->individual->nationality->country_id == 129) //Individual-Malaysia
      isClaimantCitizen()
      @else
      isClaimantNonCitizen()
      @endif
      @else
      isClaimantCitizen()
      @endif

      resetStep()
      nextStep()
      isOpponentCitizen()

      $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip()

        $('#claimant_mailing_postcode').on('blur', function () {
          // get data negeri, daerah, bandar from api
          $.ajax({
            url: '{{ route('api.postcode.detail') }}?p=' + $(this).val(),
            type: 'GET',
            success: function (data) {
              console.log('success to retrive data', data)
              $('#claimant_mailing_state').val(data.postcode.state_id).trigger('change')
              setTimeout(function () {
                $('#claimant_mailing_district').val(data.postcode.district_id).trigger('change')
              }, 1000)
            }
          })
          // repopulate data dropdown for negeri n daerah
        })
      })

      $(document).ready(function () {

        $('#opponent_postcode').on('blur', function () {
          // myBlockui()
          // get data negeri n daerah from api
          $.ajax({
            url: '{{ route('api.postcode.detail') }}?p=' + $(this).val(),
            type: 'GET',
            success: function (data) {
              console.log('success to retrive data', data)
              $('#opponent_state').val(data.postcode.state_id).trigger('change')
              setTimeout(function () {
                $('#opponent_district').val(data.postcode.district_id).trigger('change')
              }, 500)
            }
          }).always(function () {
            $.unblockUI()
          })
        })
      })

      function updatePartial(no) {
        return new Promise(function (resolve, reject) {
          myBlockui()

          console.log('open')
          switch (no) {
            case 1:
              var urlpost = "{{ route('form1-partial1') }}"
              break
            case 2:
              var urlpost = "{{ route('form1-partial2') }}"
              break
            case 3:
              var urlpost = "{{ route('form1-partial3') }}"
              break
            default:
              reject()
          }

          // replace all ' to ` to overcome WAF block rule.
          $('#claim_details').val($('#claim_details').val().replace('\'', '`'))
          var data = $('form').serialize()
          // + '&claim_case_id=' + $('#claim_case_id').val()

          var res = new Promise(function (resolve, reject) {
            $.ajax({
              url: urlpost,
              type: 'POST',
              data: data,
              datatype: 'json'
            }).then(function (data) {
              console.log(data)
              if (data.result == 'Success') {
                // Update claim_case_id
                if (data.claim_case_id != '') {
                  $('#claim_case_id').val(data.claim_case_id)
                }

                resolve()
              } else {
                console.log(data)
                swal("{{ trans('swal.error') }}!", data.error_msg, 'error')
                $.unblockUI()
                backStep()
                reject()
                var inputError = []

                // console.log(Object.keys(data.message)[ 0 ])
                if ($('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':radio') || $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':checkbox')) {
                  var input = $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']')
                } else {
                  var input = $('#' + Object.keys(data.message)[ 0 ])
                }

                $('html,body').animate(
                  { scrollTop: input.offset().top - 100 },
                  'slow', function () {
                    //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
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
                    parent.find('.help-block').html('')
                  }
                })
                reject()
              }
            }, function (xhr, ajaxOptions, thrownError) {
              swal("{{ trans('swal.unexpected_error') }}!", thrownError, 'error')
              reject()
            }).always(function () {
              $.unblockUI()
            })
          })

          res.then(function () {
            resolve()
          }, function (err) {
            reject()
          })
        })
      }


      //////////////////////////////////// Attachment Section ////////////////////////////////////////

      // Variable to store your files
      var file1, file2, file3, file4, file5
      var file1_info = 0, file2_info = 0, file3_info = 0, file4_info = 0, file5_info = 0

      @if(auth()->user()->user_type_id == 3)
          @if($attachments)
              @if($attachments->get(0))
                file1_info = 1
               @endif
              @if($attachments->get(1))
                file2_info = 1
              @endif
              @if($attachments->get(2))
                file3_info = 1
              @endif
              @if($attachments->get(3))
                file4_info = 1
              @endif
              @if($attachments->get(4))
                file5_info = 1
              @endif
          @endif

          // Add events. Grab the files and set them to our variable
          $('#attachment_1').on('change', function (event) {
            file1 = event.target.files
            file1_info = 2
            console.log('attachment_1')
            updateReview()
            $('#btn_next').show()
          })

          $('#attachment_2').on('change', function (event) {
            file2 = event.target.files
            file2_info = 2
            console.log('attachment_2')
            updateReview()
            $('#btn_next').show()
          })

          $('#attachment_3').on('change', function (event) {
            file3 = event.target.files
            file3_info = 2
            console.log('attachment_3')
            updateReview()
            $('#btn_next').show()
          })

          $('#attachment_4').on('change', function (event) {
            file4 = event.target.files
            file4_info = 2
            console.log('attachment_4')
            updateReview()
            $('#btn_next').show()
          })

          $('#attachment_5').on('change', function (event) {
            file5 = event.target.files
            file5_info = 2
            console.log('attachment_5')
            updateReview()
            $('#btn_next').show()
          })
      @else
          // Add events. Grab the files and set them to our variable
          $('#attachment_1').on('change', function (event) {
            file1 = event.target.files
            file1_info = 2
            console.log('attachment_1')
            updateReview()
            $('#btn_next').show()
          })

          $('#attachment_2').on('change', function (event) {
            file2 = event.target.files
            file2_info = 2
            console.log('attachment_2')
            updateReview()
            $('#btn_next').show()
          })

          $('#attachment_3').on('change', function (event) {
            file3 = event.target.files
            file3_info = 2
            console.log('attachment_3')
            updateReview()
            $('#btn_next').show()
          })

          $('#attachment_4').on('change', function (event) {
            file4 = event.target.files
            file4_info = 2
            console.log('attachment_4')
            updateReview()
            $('#btn_next').show()
          })

          $('#attachment_5').on('change', function (event) {
            file5 = event.target.files
            file5_info = 2
            console.log('attachment_5')
            updateReview()
            $('#btn_next').show()
          })
      @endif

      $('.dropify-clear').on('click', function () {
        $(this).siblings('input').trigger('change')
        console.log('remove button clicked!')
        $('#btn_next').hide()
      })

      // Catch the form submit and upload the files
      function uploadAttachment() {

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData()
        $.each(file1, function (key, value) {
          data.append('attachment_1', value)
        })

        $.each(file2, function (key, value) {
          data.append('attachment_2', value)
        })

        $.each(file3, function (key, value) {
          data.append('attachment_3', value)
        })

        $.each(file4, function (key, value) {
          data.append('attachment_4', value)
        })

        $.each(file5, function (key, value) {
          data.append('attachment_5', value)
        })

        data.append('claim_case_id', $('#claim_case_id').val())
        data.append('file1_info', file1_info)
        data.append('file2_info', file2_info)
        data.append('file3_info', file3_info)
        data.append('file4_info', file4_info)
        data.append('file5_info', file5_info)

        var res = $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          url: '{{ route("form1-attachment") }}',
          type: 'POST',
          data: data,
          cache: false,
          async: false,
          dataType: 'json',
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request
          success: function (data, textStatus, jqXHR) {
            if (data.result == 'Success') {
              // Update claim_case_id
              if (data.claim_case_id != '')
                $('#claim_case_id').val(data.claim_case_id)

                @if(!$is_staff)
                if (!data.paid) {
                  swal({
                      title: "{{ trans('swal.success') }}",
                      text: "{{ trans('swal.data_saved') }} ",
                      type: 'success',
                      showCancelButton: true,
                      confirmButtonText: "{{ trans('swal.proceed_payment') }}",
                      cancelButtonText: "{{ trans('swal.save_draft') }}",
                      closeOnConfirm: true,
                      closeOnCancel: true
                    },
                    function (isConfirm) {
                      if (isConfirm) {
                        $('#modalDiv').load("{{ url('/') }}/payment/case/" + data.claim_case_id + '/1');
                        //location.href="{{ route('onlineprocess.form1') }}";
                      } else {
                        location.href = "{{ route('onlineprocess.form1', ['status' => 17]) }}"
                      }
                    })
                } else {
                  swal({
                      title: "{{ trans('swal.success') }}",
                      text: "{{ trans('swal.data_saved') }}",
                      type: 'success',
                      showCancelButton: false,
                      confirmButtonText: "{{ trans('swal.back_list') }}",
                      closeOnConfirm: false
                    },
                    function () {
                      location.href = "{{ route('onlineprocess.form1', ['status' => 17]) }}"
                    })
                }
                @endif
            } else swal("{{ trans('swal.error') }}!", data.error_msg, 'error')
          },
          error: function (jqXHR, textStatus, errorThrown) {
            // Handle errors here
            swal("{{ trans('swal.unexpected_error') }}!", thrownError, 'error')
            //alert(thrownError);
          }
        })

          @if(!$is_staff)
            return false
          @endif


          if (res.responseJSON && res.responseJSON.result == 'Success') {
            console.log('return true')
            return true
          } else {
            console.log('return false')
            return false
          }
      }

      //////////////////////////////////////////////////////////////////////////////////////////

      function submitForm() {

        $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          url: "{{ route('form1-final') }}",
          type: 'POST',
          data: $('form').serialize(),
          datatype: 'json',
          async: false,
          success: function (data) {
            if (data.result == 'Success') {

              swal({
                  title: data.case_no,
                  text: "{{ trans('swal.claim_success') }}!",
                  type: 'success',
                  showCancelButton: false,
                  closeOnConfirm: true
                },
                function () {
                  swal({
                    text: "{{ trans('swal.reload') }}..",
                    showConfirmButton: false
                  })
                  location.href = "{{ route('onlineprocess.form1', ['status' => 17]) }}"
                })

            } else {
              var inputError = []

              // console.log(Object.keys(data.message)[ 0 ])
              if ($('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':radio') || $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':checkbox')) {
                var input = $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']')
              } else {
                var input = $('#' + Object.keys(data.message)[ 0 ])
              }

              $('html,body').animate(
                { scrollTop: input.offset().top - 100 },
                'slow', function () {
                  //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
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
                  parent.find('.help-block').html('')
                }
              })
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            swal("{{ trans('swal.unexpected_error') }}!", thrownError, 'error')
            //alert(thrownError);
          }
        })

        return false
      }

      function loadHearing(item) {
        var filing_date = $('#filing_date').val()
        var branch = $(item).val()
        $('#hearing_date').empty()

        $('#hearing_date').append('<option value="" disabled selected>--{{ trans('hearing.please_choose')}}--</option>')

        $.get('/branch/' + branch + '/hearings?date=' + filing_date)
          .then(function (data) {
            $.each(data, function (key, hearings) {
              $.each(hearings, function (k, hearing) {
                // console.log(hearing)
                if (hearing.hearing_room === null)
                  $('#hearing_date').append('<option value=\'' + hearing.hearing_id + '\'>' + hearing.hearing_date + ' ' + hearing.hearing_time + '</option>')
                else
                  $('#hearing_date').append('<option value=\'' + hearing.hearing_id + '\'>' + hearing.hearing_date + ' ' + hearing.hearing_time + ' (' + hearing.hearing_venue + ' : ' + hearing.hearing_room + ')</option>')
              })
            })
            $('#hearing_date').removeAttr('disabled')
          }, function (err) {
            console.error(err)
          })

        $('#psu').empty()

        if (typeof branch != 'undefined') {
          $.ajax({
            url: "{{ url('/') }}/branch/" + branch + '/psus',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
              $('#psu').append('<option disabled selected>---</option>')
              $.each(data.psus, function (key, psu) {
                $('#psu').append('<option value=\'' + psu.user_id + '\'>' + psu.name + '</option>')
              })
            },
            error: function (xhr, ajaxOptions, thrownError) {
              //swal("Unexpected Error!", thrownError, "error");
              //alert(thrownError);
            }
          })
        }

        $('#hearing_venue_id').empty()

        $.ajax({
          url: "{{ url('/') }}/branch/" + branch + '/venues',
          type: 'GET',
          datatype: 'json',
          success: function (data) {
            $('#hearing_venue_id').append('<option disabled selected>---</option>')
            $.each(data.venues, function (key, venue) {
              if (venue.is_active == 1)
                $('#hearing_venue_id').append('<option key=\'' + key + '\' value=\'' + venue.hearing_venue_id + '\'>' + venue.hearing_venue + '</option>')
            })

          }
        })
      }

      function toggleDiv(element) {
        $(element).parents('.portlet').find('.portlet-body').slideToggle()

        if ($(element).prop('checked'))
          $('.extra').removeClass('hidden')
        else
          $('.extra').addClass('hidden')
      }

      function loadDistricts(state_input_id, district_input_id) {
        console.log('loadDistricts')
        var state_id = $('#' + state_input_id).val()
        $('#' + district_input_id).empty()

        if (state_id != null) {
          $.ajax({
            url: "{{ url('/') }}/state/" + state_id + '/districts',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
              $.each(data.state_districts, function (key, district) {
                $('#' + district_input_id).append('<option value=\'' + district.district_id + '\'>' + district.district + '</option>')
              })
              updateReview()
            },
            error: function (xhr, ajaxOptions, thrownError) {
              //swal("Unexpected Error!", thrownError, "error");
              //alert(thrownError);
            }
          })
        }
      }

      function loadSubdistricts(state_input_id, district_input_id, subdistrict_input_id) {
        console.log('loadSubdistricts')
        var state_id = $('#' + state_input_id).val()
        var district_id = $('#' + district_input_id).val()
        $('#' + subdistrict_input_id).empty()

        if (state_id != null && district_id != null) {
          $.ajax({
            url: "{{ url('/') }}/state/" + state_id + '/districts/' + district_id + '/subdistricts',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
              $.each(data.state_subdistricts, function (key, subdistrict) {
                $('#' + subdistrict_input_id).append('<option value=\'' + key + '\'>' + subdistrict + '</option>')
              })
              updateReview()
            },
            error: function (xhr, ajaxOptions, thrownError) {
              //swal("Unexpected Error!", thrownError, "error");
              //alert(thrownError);
            }
          })
        }
      }

      // Initialization
      var offence_p = []
      var offence_b = []

      // Insert data into array
      @foreach ($offences_b as $offence)
      offence_b.push({
        'id': "{{ $offence->offence_type_id }}",
        'name': "{{ $offence->offence_code.' '.$offence->$offence_lang }}"
      })
      @endforeach
      @foreach ($offences_p as $offence)
      offence_p.push({
        'id': "{{ $offence->offence_type_id }}",
        'name': "{{ $offence->offence_code.' '.$offence->$offence_lang }}"
      })

      @endforeach

      function loadOffence() {
        console.log('loadOffence')
        var cat = $('#claim_category').val()
        $('#claim_offence').empty()

        if (cat == 1) {
          $.each(offence_b, function (key, data) {
            $('#claim_offence').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
          })
        } else {
          $.each(offence_p, function (key, data) {
            $('#claim_offence').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
          })
        }

      }

      // Initialization
      @foreach ($categories as $category)
      var cat{{ $category->claim_category_id }} = []
      @endforeach

      // Insert data into array
      @foreach ($classifications as $classification)
      cat{{ $classification->category_id }}.push({
        'id': "{{ $classification->claim_classification_id }}",
        'name': "{{ $classification->$classification_lang }}"
      })

      @endforeach

      function loadClassification() {
        console.log('loadClassification')
        var cat = $('#claim_category').val()
        $('#claim_classification').empty()

          @foreach ($categories as $category)
          if (cat == {{ $category->claim_category_id }}) {
            $.each(cat{{ $category->claim_category_id }}, function (key, data) {
              $('#claim_classification').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
            })
          }
          @endforeach

          @if($case && $case->form1_id && $case->form1->offence_type_id != null)
          @else
          loadOffence()
          @endif

          updateReview()

      }

      function togglePostal() {
        var method = $('#payment_method').val()

        if (method == 3)
          $('#row_postalorder_no').removeClass('hidden')
        else
          $('#row_postalorder_no').addClass('hidden')
      }

      @if($is_staff)

      function checkEcbisOpponent() {
        var id_no = $('#opponent_identification_no').val()
        if (!id_no)
          return
        $('#btn_next').removeClass('hidden')

        // myBlockui()

        $.ajax({
          url: "{{ route('integration-ssm-check') }}",
          type: 'POST',
          data: { regno: $('#opponent_identification_no').val() },
          datatype: 'json',
          success: function (data) {
            console.log(data)
            if (data.status == 'ok') {
              toastr.success(data.data.message)

              $('#opponent_name').val(data.data.name)
              $('#opponent_identity_type').val(3).trigger('change')

              $('#opponent_street1').val(data.data.address_1)
              $('#opponent_street2').val(data.data.address_2)
              $('#opponent_street3').val(data.data.address_3)
              $('#opponent_postcode').val(data.data.postcode)
              $('#opponent_state').val(data.data.state).trigger('change')
              $('#opponent_district').val('').trigger('change')
            } else {
              toastr.error(data.data.message)
            }
          },
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          error: function (xhr, ajaxOptions, thrownError) {
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
          }
        })
      }

      function checkMyIdentityOpponent() {
        var id_no = $('#opponent_identification_no').val()
        if (!id_no)
          return

        $.ajax({
          url: "{{ route('integration-myidentity-checkic', ['ic'=>'']) }}/" + id_no,
          type: 'POST',
          datatype: 'json',
          success: function (data) {
            if (data.ReplyIndicator == 1) {
              toastr.success('{{ __("swal.user_found") }}!')

              $('#opponent_name').val(data.Name)
              $('#opponent_identity_type').val(1).trigger('change')

              $('#opponent_street1').val(data.PermanentAddress1)
              $('#opponent_street2').val(data.PermanentAddress2)
              $('#opponent_street3').val(data.PermanentAddress3)
              $('#opponent_postcode').val(data.PermanentAddressPostcode)
              $('#opponent_email').val(data.EmailAddress)
              $('#opponent_phone_mobile').val(data.MobilePhoneNumber)

              // console.log('state: ' + (data.PermanentAddressStateCode).replace(/\b0+/g, ''))

              $('#opponent_state').val((data.PermanentAddressStateCode).replace(/\b0+/g, '')).trigger('change')
              $('#opponent_district').val((data.PermanentAddressCityCode).trim()).trigger('change')

              $('#opponent_myidentity_info').html("{{ __('new.residentialstatus') }}: <span class='font-green-sharp'>" + data.ResidentialStatus + "</span><br>{{ __('new.recordstatus') }}: <span class='font-green-sharp'>" + data.RecordStatus + '</span>')

              if (data.RecordStatus == "{{ __('new.died') }}") {
                swal("{{ __('new.recordstatus') }}", data.RecordStatus, 'error')
                $('#btn_next').addClass('hidden')
              } else {
                $('#btn_next').removeClass('hidden')
              }

            } else {
              toastr.error('{{ __("swal.user_not_found") }}!')
              $('#opponent_myidentity_info').html('')
              $('#btn_next').addClass('hidden')

              $('#opponent_name').val('')
              $('#opponent_street1').val('')
              $('#opponent_street2').val('')
              $('#opponent_street3').val('')
              $('#opponent_postcode').val('')
              $('#opponent_email').val('')
              $('#opponent_phone_mobile').val('')

              $('#opponent_state').val().trigger('change')
              $('#opponent_district').val().trigger('change')
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
            $('#btn_next').removeClass('hidden')
          }
        })
      }

      function checkEcbisClaimant() {
        var id_no = $('#claimant_identification_no').val()
        if (!id_no)
          return

        $('#btn_next').removeClass('hidden')

        $.ajax({
          url: "{{ route('integration-ecbis-checkcompanyno', ['company_no'=>'']) }}/" + id_no,
          type: 'GET',
          datatype: 'json',
          success: function (data) {
            if (data.status != 'Not found!') {
              toastr.success('{{ __("swal.user_found") }}!')

              $('#claimant_name').val(data.company.nama_syrkt)
              $('#claimant_identity_type').val(3).trigger('change')

              $('#claimant_street1').val(data.PermanentAddress1)
              $('#claimant_street2').val(data.PermanentAddress2)
              $('#claimant_street3').val(data.PermanentAddress3)
              $('#claimant_postcode').val(data.PermanentAddressPostcode)
              $('#claimant_email').val(data.EmailAddress)
              $('#claimant_phone_mobile').val(data.MobilePhoneNumber)
            } else {
              toastr.error('{{ __("swal.user_not_found") }}!')
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
          }
        })
      }

      function checkMyIdentityExtraClaimant() {
        var id_no = $('#extra_claimant_identification_no').val()

        if (!id_no)
          return

        $.ajax({
          url: "{{ route('integration-myidentity-checkic', ['ic'=>'']) }}/" + id_no,
          type: 'POST',
          datatype: 'json',
          success: function (data) {
            if (data.ReplyIndicator == 1) {
              toastr.success('{{ __("swal.user_found") }}!')
              $('#extra_claimant_name').val(data.Name)
              $('#extra_claimant_identity_type').val(1).trigger('change')
            } else {
              toastr.error('{{ __("swal.user_not_found") }}!')
              $('#extra_claimant_name').val('')
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
          }
        })
      }

      function checkMyIdentityClaimant() {
        var id_no = $('#claimant_identification_no').val()

        if (!id_no)
          return

        $.ajax({
          url: "{{ route('integration-myidentity-checkic', ['ic'=>'']) }}/" + id_no,
          type: 'POST',
          datatype: 'json',
          success: function (data) {
            if (data.ReplyIndicator == 1) {
              toastr.success('{{ __("swal.user_found") }}!')

              $('#claimant_name').val(data.Name)
              $('#claimant_identity_type').val(1).trigger('change')

              $('#claimant_street1').val(data.PermanentAddress1)
              $('#claimant_street2').val(data.PermanentAddress2)
              $('#claimant_street3').val(data.PermanentAddress3)
              $('#claimant_postcode').val(data.PermanentAddressPostcode)
              $('#claimant_email').val(data.EmailAddress)
              $('#claimant_phone_mobile').val(data.MobilePhoneNumber)

              //console.log("state: "+(data.PermanentAddressStateCode).replace(/\b0+/g, ''));

              $('#claimant_state').val((data.PermanentAddressStateCode).replace(/\b0+/g, '')).trigger('change')
              $('#claimant_district').val((data.PermanentAddressCityCode).trim()).trigger('change')

              $('#claimant_myidentity_info').html("{{ __('new.residentialstatus') }}: <span class='font-green-sharp'>" + data.ResidentialStatus + "</span><br>{{ __('new.recordstatus') }}: <span class='font-green-sharp'>" + data.RecordStatus + '</span>')

              if (data.RecordStatus == "{{ __('new.died') }}") {
                swal("{{ __('new.recordstatus') }}", data.RecordStatus, 'error')
                $('#btn_next').addClass('hidden')
              } else if (data.ResidentialStatus != "{{ __('new.citizen') }}") {
                $('#claimant_identity_type').val(2).trigger('change')

                swal("{{ __('new.information') }}", "{{ __('new.user_id_noncitizen') }}", 'info')

                $('#btn_next').removeClass('hidden')
              } else {
                $('#btn_next').removeClass('hidden')
              }
            } else {
              toastr.error('{{ __("swal.user_not_found") }}!')
              $('#claimant_myidentity_info').html('')
              $('#btn_next').removeClass('hidden')

              $('#claimant_name').val('')
              $('#claimant_street1').val('')
              $('#claimant_street2').val('')
              $('#claimant_street3').val('')
              $('#claimant_postcode').val('')
              $('#claimant_email').val('')
              $('#claimant_phone_mobile').val('')

              $('#claimant_state').val().trigger('change')
              $('#claimant_district').val().trigger('change')
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
            $('#btn_next').removeClass('hidden')
          }
        })
      }

      function checkOpponent() {
        console.log('checkOpponent')
        $('#btn_next').removeClass('hidden')

        if ($('#claimant_identification_no').val() == $('#opponent_identification_no').val()) {
          $('#opponent_identification_no').val('')
          swal("{{ __('new.sorry') }}", "{{ __('swal.same_id_error') }}", 'error')
          return
        }

        var id_no = $('#opponent_identification_no').val()

        $.ajax({
          url: "{{ route('form1-checkopponent') }}",
          type: 'GET',
          data: {
            id_no: id_no
          },
          datatype: 'json',
          success: function (data) {
            if (data.result == 'Exist') {

              $('#opponent_name').val(data.user_data.name)
              $('#opponent_phone_office').val(data.user_data.phone_office)
              $('#opponent_phone_fax').val(data.user_data.phone_fax)
              $('#opponent_email').val(data.user_data.email)

              $('#opponent_street1').val(data.user_data.public_data.address_mailing_street_1)
              $('#opponent_street2').val(data.user_data.public_data.address_mailing_street_2)
              $('#opponent_street3').val(data.user_data.public_data.address_mailing_street_3)
              $('#opponent_postcode').val(data.user_data.public_data.address_mailing_postcode)

              if (data.user_data.public_data.address_mailing_state_id != null) {
                $('#opponent_state').val(data.user_data.public_data.address_mailing_state_id).trigger('change') //Check

                setTimeout(function () {
                  $('#opponent_district').val(data.user_data.public_data.address_mailing_district_id).trigger('change') //Check
                }, 1000)

              } else {
                $('#opponent_state').val('').trigger('change') //Check
                $('#opponent_district').val('').trigger('change') //Check
              }

              if (data.user_data.public_data.user_public_type_id == 1) { // Individual

                $('#opponent_nationality').val(data.user_data.public_data.individual.nationality_country_id).trigger('change') //Check
                $('#opponent_phone_home').val(data.user_data.public_data.individual.phone_home)
                $('#opponent_phone_mobile').val(data.user_data.public_data.individual.phone_mobile)

                if (data.user_data.public_data.individual.nationality_country_id == 129) //Malaysia
                  $('#opponent_identity_type').val(1).trigger('change')
                else
                  $('#opponent_identity_type').val(2).trigger('change')

              } else $('#opponent_identity_type').val(3).trigger('change')

              // Change ID type
              // Change nationality list
            } else {
              // ECBIS
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
          }
        })

        updateReview()
      }

      function checkClaimant() {
        console.log('checkClaimant')

        var id_no = $('#claimant_identification_no').val()
        var identityType = $('#claimant_identity_type').val()

        // check umur first
        if (id_no.length >= 5 && identityType === '1') {
          console.log('masuk')

          var nric = id_no // 890101065555
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

          var today = new Date()
          var birthDate = new Date(dob2)
          var age = today.getFullYear() - birthDate.getFullYear()

          console.log(age)

          if (age < 18) {
            swal({
              title: "{{ __('new.sorry') }}!",
              text: "{{ __('new.18yo_max_msg') }}",
              type: 'error',
              showCancelButton: true,
              confirmButtonColor: '#4e8ea5',
              closeOnConfirm: true
            })
            $('#error_msg').html("{{ __('new.sorry') }}! {{ __('new.18yo_max_msg') }}")
            $('#error_msg').parent().removeClass('hidden')
          }
        }

        $('#btn_next').removeClass('hidden')

        $.ajax({
          url: "{{ route('form1-checkopponent') }}",
          type: 'GET',
          data: {
            id_no: id_no
          },
          datatype: 'json',
          success: function (data) {
            if (data.result == 'Exist') {
              $('#claimant_name').val(data.user_data.name)
              $('#claimant_phone_office').val(data.user_data.phone_office)
              $('#claimant_phone_fax').val(data.user_data.phone_fax)
              $('#claimant_email').val(data.user_data.email)

              $('#claimant_street1').val(data.user_data.public_data.address_street_1)
              $('#claimant_street2').val(data.user_data.public_data.address_street_2)
              $('#claimant_street3').val(data.user_data.public_data.address_street_3)
              $('#claimant_postcode').val(data.user_data.public_data.address_postcode)

              if (data.user_data.public_data.address_mailing_state_id != null) {
                $('#claimant_state').val(data.user_data.public_data.address_mailing_state_id).trigger('change') //Check
                $('#claimant_mailing_street1').val(data.user_data.public_data.address_mailing_street_1)
                $('#claimant_mailing_street2').val(data.user_data.public_data.address_mailing_street_2)
                $('#claimant_mailing_street3').val(data.user_data.public_data.address_mailing_street_3)
                $('#claimant_mailing_postcode').val(data.user_data.public_data.address_mailing_postcode)

                if (data.user_data.public_data.address_state_id != null) {
                  $('#claimant_state').val(data.user_data.public_data.address_state_id).trigger('change') //Check
                  $('#claimant_mailing_state').val(data.user_data.public_data.address_mailing_state_id).trigger('change') //Check

                  setTimeout(function () {
                    $('#opponent_district').val(data.user_data.public_data.address_district_id).trigger('change') //Check
                  }, 1000)

                } else {
                  $('#claimant_state').val('').trigger('change') //Check
                  $('#claimant_district').val('').trigger('change') //Check
                  $('#claimant_mailing_state').val('').trigger('change') //Check
                  $('#claimant_mailing_district').val('').trigger('change') //Check
                }

                if (data.user_data.public_data.user_public_type_id == 1) { // Individual

                  $('#claimant_nationality').val(data.user_data.public_data.individual.nationality_country_id).trigger('change') //Check
                  $('#claimant_phone_home').val(data.user_data.public_data.individual.phone_home)
                  $('#claimant_phone_mobile').val(data.user_data.public_data.individual.phone_mobile)

                  if (data.user_data.public_data.individual.nationality_country_id == 129) //Malaysia
                    $('#claimant_identity_type').val(1).trigger('change')
                  else
                    $('#claimant_identity_type').val(2).trigger('change')

                } else $('#claimant_identity_type').val(3).trigger('change')
              }
            }
          }
        })

        updateReview()
      }

      function checkExtraClaimant() {
        console.log('checkExtraClaimant')

        var id_no = $('#extra_claimant_identification_no').val()

        $.ajax({
          url: "{{ route('form1-checkopponent') }}",
          type: 'GET',
          data: {
            id_no: id_no
          },
          datatype: 'json',
          success: function (data) {
            if (data.result == 'Exist') {

              $('#extra_claimant_name').val(data.user_data.name)

              if (data.user_data.public_data.user_public_type_id == 1) { // Individual

                $('#extra_claimant_nationality').val(data.user_data.public_data.individual.nationality_country_id).trigger('change')

                if (data.user_data.public_data.individual.nationality_country_id == 129) //Malaysia
                  $('#extra_claimant_identity_type').val(1).trigger('change')
                else
                  $('#extra_claimant_identity_type').val(2).trigger('change')

              }

              // Change ID type
              // Change nationality list
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //swal("Unexpected Error!", thrownError, "error");
            //alert(thrownError);
          }
        })

        updateReview()
      }

      @else
      function checkOpponent() {

        $('#btn_next').removeClass('hidden')

        if ($('#claimant_identification_no').val() == $('#opponent_identification_no').val()) {
          $('#opponent_identification_no').val('')
          swal("{{ __('new.sorry') }}", "{{ __('swal.same_id_error') }}", 'error')
          return
        }
      }

      @endif


      @if(isset($case))
      @if($case->opponent_user_id)
      @if($case->opponent->public_data->user_public_type_id == 2)
      $('#opponent_identity_type').val(3).trigger('change')
      @elseif($case->opponent->public_data->individual->nationality_country_id == 129)
      $('#opponent_identity_type').val(1).trigger('change')
      @else
      $('#opponent_identity_type').val(2).trigger('change')
      @endif
      @endif

      @if($case->extra_claimant_id)
      $('#has_extra_claimant').prop('checked', true).trigger('change')

      @if($case->extra_claimant->nationality_country_id == 129)
      $('#extra_claimant_identity_type').val(1).trigger('change')
      @else
      $('#extra_claimant_identity_type').val(2).trigger('change')
      @endif

      $('#extra_claimant_identification_no').val('{{ $case->extra_claimant->identification_no }}').trigger('change')
      $('#extra_claimant_nationality').val({{ $case->extra_claimant->nationality_country_id }}).trigger('change')
      $('#extra_claimant_name').val('{{ $case->extra_claimant->name }}').trigger('change')
      $('#extra_claimant_relationship').val({{ $case->extra_claimant->relationship_id }}).trigger('change')
      @endif

      @if($case->form1_id)

      $('#filing_date').val('{{ date("d/m/Y", strtotime($case->form1->filing_date)) }}').trigger('change')
      $('#matured_date').val('{{ date("d/m/Y", strtotime($case->form1->matured_date)) }}').trigger('change')

      @if($case->form1->is_online_purchased == 1)
      $('#is_online_transaction_yes').prop('checked', true)
      @else
      $('#is_online_transaction_no').prop('checked', true)
      @endif

      $('#purchased_date').val('{{ $inquiry->form1->purchased_date or "" ? date("d/m/Y", strtotime($case->form1->purchased_date." 00:00:00")) : "" }}')
      $('#purchased_item').html('{{ preg_replace("/[\r\n]+/", "&#13;", $case->form1->purchased_item_name) }}')
      $('#purchased_brand').val('{{ $case->form1->purchased_item_brand }}')
      $('#purchased_amount').val('{{ $case->form1->purchased_amount }}')
      $('#claim_details').html('{{ preg_replace("/[\r\n]+/", "&#13;", $case->form1->claim_details) }}')
      $('#claim_amount').val('{{ $case->form1->claim_amount }}')

      @if($case->form1->court_case_id)
      $('#is_filed_on_court_yes').prop('checked', true)

      $('#case_name').val('{{ $case->form1->court_case->court_case_name }}')
      $('#case_status').val('{{ $case->form1->court_case->court_case_status }}')
      $('#case_place').html('{{ preg_replace("/[\r\n]+/", "&#13;", $case->form1->court_case->court_case_location) }}')
      $('#case_created_at').val('{{ $case->form1->court_case->filing_date or "" ? date("d/m/Y", strtotime($case->form1->court_case->filing_date." 00:00:00")) : "" }}')
      @else
      $('#is_filed_on_court_no').prop('checked', true)
      @endif

      @if($is_staff)
      @if($case->form1->claim_classification_id)
      $('#claim_category').val({{$case->form1->classification->category_id}}).trigger('change')
      $('#claim_classification').val({{$case->form1->claim_classification_id}}).trigger('change')
      @if($case->form1->offence_type_id != null)
      $('#claim_offence').val({{$case->form1->offence_type_id}}).trigger('change')
      @endif
      @endif

      @if($case->form1->payment_id)
      @if(!$case->form1->payment->payment_fpx_id OR false)
      @if($case->form1->payment->payment_postalorder_id)
      $('#payment_method').val(3).trigger('change')
      @else
      $('#payment_method').val(2).trigger('change')
      @endif
      @endif
      @endif

      @endif
      @endif

      @if($case->opponent_address_id)
      $('#opponent_state').val({{ $case->opponent_address->state_id }}).trigger('change')
      $('#opponent_district').val({{ $case->opponent_address->district_id }}).trigger('change')
      @endif



      @elseif($inquiry)

      @if($inquiry->opponent_user_extra_id)
      @if($inquiry->opponent->relationship_id == 3)
      $('#opponent_identity_type').val(3).trigger('change')
      @elseif($inquiry->opponent->nationality_country_id == 129)
      $('#opponent_identity_type').val(1).trigger('change')
      @else
      $('#opponent_identity_type').val(2).trigger('change')
      @endif
      @endif

      @if($inquiry->form1_id)

      @if($inquiry->form1->is_online_purchased == 1)
      $('#is_online_transaction_yes').prop('checked', true)
      @else
      $('#is_online_transaction_no').prop('checked', true)
      @endif

      @if($inquiry->form1->purchased_date)
      $('#purchased_date').val('{{ $inquiry->form1->purchased_date or "" ? date("d/m/Y", strtotime($inquiry->form1->purchased_date." 00:00:00")) : "" }}')
      @endif

      $('#purchased_item').html('{{ preg_replace("/[\r\n]+/", "&#13;", $inquiry->form1->purchased_item_name) }}')
      $('#purchased_brand').val('{{ $inquiry->form1->purchased_item_brand }}')
      $('#purchased_amount').val('{{ $inquiry->form1->purchased_amount }}')
      $('#claim_details').html('{{ preg_replace("/[\r\n]+/", "&#13;", $inquiry->form1->claim_details) }}')
      $('#claim_amount').val('{{ $inquiry->form1->claim_amount }}')
      @if($inquiry->form1->court_case_id)
      $('#is_filed_on_court_yes').prop('checked', true)

      $('#case_name').val('{{ $inquiry->form1->court_case->court_case_name }}')
      $('#case_status').val('{{ $inquiry->form1->court_case->court_case_status }}')
      $('#case_place').html('{{ preg_replace("/[\r\n]+/", "&#13;", $inquiry->form1->court_case->court_case_location) }}')
      @if($inquiry->form1->court_case->filing_date)
      $('#case_created_at').val('{{ $inquiry->form1->court_case->filing_date or "" ? date("d/m/Y", strtotime($inquiry->form1->court_case->filing_date." 00:00:00")) : "" }}')
      @endif
      @else
      $('#is_filed_on_court_no').prop('checked', true)
      @endif
      @endif
      @endif

      @if($case)
      $(document).ready(function () {
        setTimeout(function () {
            @if($case->hearing_venue_id)
            $('#hearing_venue_id').val({{ $case->hearing_venue_id }}).trigger('change')
            @endif

            @if($case->psu_user_id)
            $('#psu').val({{ $case->psu_user_id }}).trigger('change')
            @endif
        }, 1000)
      })
      @endif

      function toggleOpponentInfo(counter) {
        $('#opponent_info_' + counter).slideToggle()
      }
    </script>
@endsection
