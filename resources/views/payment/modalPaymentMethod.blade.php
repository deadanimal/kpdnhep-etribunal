<!-- Modal -->

<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}"
      rel="stylesheet" type="text/css"/>

<style>
    .bootstrap-tagsinput {
        width: 100%;
    }
</style>

<div id="paymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('form1.select_payment') }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{ trans('form1.payment_method') }}<span
                                    style="color:red;">*</span></label>
                        <div class="col-md-7" style="z-index: 10099 !important;">
                            <select id="payment_method" class="form-control" onchange="changePaymentMethod()">
                                <option value="" disabled selected>---</option>
                                @if(env("CONF_FPX_ENABLE"))
                                    <option value="1">{{ __('form1.online_payment') }}</option>
                                @endif
                                <option value="2">{{ __('form1.pay_counter') }}</option>
                                <option value="3">{{ __('form1.postal_order') }}</option>
                            </select>
                        </div>
                    </div>

                    @if(env("CONF_FPX_ENABLE"))
                        <div id="info1" class="alert alert-warning hidden"
                             style="background-color: #fcfcfc; color: #2f95aa;">
                            <strong>{{ __('form1.online_payment') }}</strong><br>
                            {{ __('form1.remarks_online_payment1') }}:
                            <ul>
                                <li>Affin Bank</li>
                                <li>Alliance Bank</li>
                                <li>Ambank</li>
                                <li>CIMB Bank</li>
                                <li>Bank Islam</li>
                                <li>Hong Leong Bank</li>
                                <li>Maybank</li>
                                <li>Public Bank</li>
                                <li>RHB Bank</li>
                                <li>Standard Chartered</li>
                                <li>UOB Bank</li>
                            </ul>
                            <small class="font-green-sharp">* {{ __('form1.remarks_online_payment2') }}</small><br><br>
                            <img src="{{ url('images/logo_fpx.png') }}" style="height: 50px">
                        </div>
                    @endif

                    <div id="info2" class="alert alert-warning hidden"
                         style="background-color: #fcfcfc; color: #2f95aa;">
                        <strong>{{ __('form1.pay_counter') }}</strong><br>
                        {{ __('form1.remarks_pay_counter') }}<br><br>
                        <span style="font-weight: bold; font-style: italic;">
                        <span class='branch_name'>{{ $branch->branch_name }}</span><br>
                        <span class='branch_address'>{{ $branch->branch_address }}</span><br>
                        <span class='branch_address2'>{{ $branch->branch_address2 }}</span><br>
                        <span class='branch_address3'>{{ $branch->branch_address3 }}</span><br>
                        <span class='branch_postcode'>{{ $branch->branch_postcode }}</span> <span
                                    class='branch_district'>{{ $branch->district->district }}</span>, <span
                                    class='branch_state'>{{ $branch->state->state }}</span>
                    </span>
                    </div>

                    <div id="info3" class="alert alert-warning hidden"
                         style="background-color: #fcfcfc; color: #2f95aa;">
                        <strong>{{ __('form1.postal_order') }}</strong><br>
                        1. {{ __('form1.remarks_postal_order1') }}<br>
                        2. {{ __('form1.remarks_postal_order2') }}:<br>
                        3. {{ __('form1.remarks_postal_order3') }}<br>
                        4. {{ __('form1.remarks_postal_order4') }}<br><br>
                        <span style="font-weight: bold; font-style: italic;">
                        <span class='branch_name'>{{ $branch->branch_name }}</span><br>
                        <span class='branch_address'>{{ $branch->branch_address }}</span><br>
                        <span class='branch_address2'>{{ $branch->branch_address2 }}</span><br>
                        <span class='branch_address3'>{{ $branch->branch_address3 }}</span><br>
                        <span class='branch_postcode'>{{ $branch->branch_postcode }}</span> <span
                                    class='branch_district'>{{ $branch->district->district }}</span>, <span
                                    class='branch_state'>{{ $branch->state->state }}</span>
                    </span>
                        <br><br>
                        <small class="font-green-sharp">* {{ __('form1.remarks_postal_order5') }}</small>
                    </div>
                    <form id='form_postalorder'>
                        <div id="row_postalorder_no" class="form-group hidden">
                            <label class="col-md-4 control-label">{{ trans('form1.postal_no') }} <span
                                        style="color:red;">*</span></label>
                            <div class="col-md-7">
                                <input id='postalorder_no' class="form-control" type="text" data-role="tagsinput">
                                <small style="font-style: italic; color: grey;">{{ __('new.use_comma_separator') }}</small>
                            </div>
                        </div>
                        <div id="row_postalorder_date" class="form-group hidden">
                            <label class="col-md-4 control-label">{{ trans('form1.date') }} <span
                                        style="color:red;">*</span></label>
                            <div class="col-md-7">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input id='postalorder_date'
                                           class="form-control form-control-inline date-picker datepicker clickme"
                                           readonly=""
                                           data-date-format="dd/mm/yyyy"
                                           type="text"
                                           value=""/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
                <a class="btn green-sharp" onclick='selectedPaymentMethod()'>{{ trans('button.next') }}</a>
            </div>
        </div>

    </div>
</div>

<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
        type="text/javascript"></script>
		
<script src="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::to('/assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
<?php /* ?>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}"
        type="text/javascript"></script>
<?php */ ?>
<script>
$(document).ready(function(){
	$('#paymentModal').modal('show');
});
  //$('#paymentModal').modal('show')

  $('#postalorder_date').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true
  })

  function selectedPaymentMethod() {
    var method = $('#payment_method').val()

    if (method == 1) { // fpx
      $.ajax({
        url: "{{ url('/') }}/form{{ $form_no }}/{{ $claim_case_id }}/payfpx",
        type: 'GET',
        datatype: 'json',
        success: function (data) {
          if (data.result == 'ok') {
            $('#fpxModal').on('shown.bs.modal', function () {
              $('#fpxModal .modal-body').load('{{ url("/") }}/payment/fpx/modal/' + data.payment_id)
            })
            $('#paymentModal').modal('hide')
            $('#fpxModal').modal('show')
          } else {
            swal("{{ trans('swal.error') }}!", "{{ trans('swal.payment_id_not_found') }}", 'error')
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          swal("{{ trans('swal.unexpected_error') }}!", thrownError, 'error')
        }
      })
    } else if (method == 2) { // counter
      $.ajax({
        url: "{{ url('/') }}/form{{ $form_no }}/{{ $claim_case_id }}/paycounter",
        type: 'GET',
        datatype: 'json',
        success: function (data) {
          if (data.result == 'ok') {
            $('#paymentModal').modal('hide')
            swal({
                title: "{{ trans('swal.success') }}",
                text: "{{ trans('swal.process_completed') }}!",
                type: 'success',
                showCancelButton: false,
                closeOnConfirm: true
              },
              function () {
                swal({
                  text: "{{ trans('swal.reload') }}..",
                  showConfirmButton: false
                })
                location.href = "{{ url('/') }}/onlineprocess/form{{ $form_no }}/?status={{ $form_no == 1 ? '15' : '20' }}"
              })
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          swal("{{ trans('swal.unexpected_error') }}!", thrownError, 'error')
        }
      })
    } else { // postal order
      $.ajax({
        url: "{{ url('/') }}/form{{ $form_no }}/{{ $claim_case_id }}/paypostalorder",
        type: 'POST',
        data: {
          postalorder_no: $('#postalorder_no').val(),
          postalorder_date: $('#postalorder_date').val()
        },
        datatype: 'json',
        success: function (data) {
          if (data.result == 'ok') {
            $('#paymentModal').modal('hide')
            swal({
                title: "{{ trans('swal.success') }}",
                text: "{{ trans('swal.process_completed') }}!",
                type: 'success',
                showCancelButton: false,
                closeOnConfirm: true
              },
              function () {
                swal({
                  text: "{{ trans('swal.reload') }}..",
                  showConfirmButton: false
                })
                location.href = "{{ url('/') }}/onlineprocess/form{{ $form_no }}/?status={{ $form_no == 1 ? '15' : '20' }}"
              })
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          swal("{{ trans('swal.unexpected_error') }}!", thrownError, 'error')
        }
      })
    }
  }

  function changePaymentMethod() {
    if ($('#payment_method').val() == 3) {
      $('#row_postalorder_no').removeClass('hidden')
      $('#row_postalorder_date').removeClass('hidden')
    } else {
      $('#row_postalorder_no').addClass('hidden')
      $('#row_postalorder_date').addClass('hidden')
    }

    $('.alert').addClass('hidden')
    $('#info' + $('#payment_method').val()).removeClass('hidden')
  }

</script>