<?php

use Carbon\Carbon;

?>

<!-- Modal -->
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
      type="text/css"/>

<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}"
      rel="stylesheet" type="text/css"/>

<style>
    .bootstrap-tagsinput {
        width: 100%;
    }
</style>

<div id="processModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('button.process') }} {{ __('form2.form2') }}</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-body">

                        <div id="row_filing_date" class="form-group form-md-line-input">
                            <label for="filing_date" id="label_filing_date"
                                   class="control-label col-md-5">{{ __('form1.filing_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input type='hidden' name='claim_case_id' value='{{ $case->id }}'>
                                    <input class="form-control form-control-inline date-picker datepicker clickme"
                                           name="filing_date" id="filing_date" readonly="" data-date-end-date="0d"
                                           data-date-format="dd/mm/yyyy" type="text" value="{{ date('d/m/Y') }}"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <div id="row_matured_date" class="form-group form-md-line-input">
                            <label for="matured_date" id="label_matured_date"
                                   class="control-label col-md-5">{{ __('form1.matured_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme"
                                           name="matured_date" id="matured_date" readonly="" data-date-start-date="+0d"
                                           data-date-format="dd/mm/yyyy" type="text"
                                           value="{{ Carbon::now()->addDays( env('CONF_F2_MATURED_DURATION', 14) )->format('d/m/Y') }}"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div id="row_payment_method" class="form-group form-md-line-input">
                            <label for="payment_method" id="row_claim_offence"
                                   class="control-label col-md-5">{{ __('form1.payment_method') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                @if($case->form2->payment->payment_fpx_id OR false)
                                    <input type="hidden" class="form-control" id="payment_method" name="payment_method"
                                           value="1"/>
                                    <input type="text" readonly class="form-control"
                                           value="{{ __('form1.online_payment') }}"/>
                                @else
                                    <select onchange='togglePostal()' required class="form-control select2 bs-select"
                                            id="payment_method" name="payment_method" data-placeholder="---">
                                        <option value="" disabled selected>---</option>
                                        <option value="2">{{ __('form1.pay_counter') }}</option>
                                        <option value="3">{{ __('form1.postal_order') }}</option>
                                    </select>
                                @endif
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_postalorder_no" class="form-group form-md-line-input hidden">
                            <label for="postalorder_no" id="label_claimant_name" style="padding-top: 0px"
                                   class="control-label col-md-5">{{ __('form1.postal_no') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="postalorder_no" name="postalorder_no"
                                       data-role="tagsinput"
                                       @if($case && $case->form2 && $case->form2->payment)
                                            @if($case->form2->payment->payment_postalorder_id)
                                            value="{{ $case->form2->payment->postalorder->postalorder_no }}"
                                            @elseif($case->form2->payment->payment_fpx_id)
                                            readonly
                                            @endif
                                        @endif
                                />
                                <small style="font-style: italic; color: grey;">{{ __('new.use_comma_separator') }}</small>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_receipt_no" class="form-group form-md-line-input">
                            <label for="receipt_no" id="label_claimant_name" style="padding-top: 0px"
                                   class="control-label col-md-5">{{ __('form1.receipt_no') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="receipt_no" name="receipt_no"
                                       @if($case && $case->form2 && $case->form2->payment)
                                       @if($case->form2->payment->receipt_no)
                                       value="{{ $case->form2->payment->receipt_no }}"
                                       @endif
                                       @if($case->form2->payment->payment_fpx_id OR false)
                                       readonly
                                        @endif
                                        @endif

                                />
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="row_payment_date" class="form-group form-md-line-input">
                            <label for="payment_date" id="label_filing_date"
                                   class="control-label col-md-5">{{ __('form1.payment_date') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme"
                                           name="payment_date" id="payment_date" readonly=""
                                           data-date-format="dd/mm/yyyy" type="text"
                                           @if($case && $case->form2 && $case->form2->payment)
                                               @if($case->form2->payment->paid_at)
                                               value="{{ date('d/m/Y', strtotime($case->form2->payment->paid_at)) }}"
                                               @else
                                               value="{{ date('d/m/Y') }}"
                                               @endif

                                               @if($case->form2->payment->payment_fpx_id OR false)
                                               disabled
                                               @endif
                                           @else
                                           value="{{ date('d/m/Y') }}"
                                           @endif
                                    />
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div id="row_psu" class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence"
                                   class="control-label col-md-5">{{ trans('form1.psu_incharged')}} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2 bs-select" id="psu" name="psu"
                                        data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($psus as $psu)
                                        <option
                                                @if($case)
                                                @if($case->psu_user_id)
                                                @if($case->psu_user_id == $psu->user_id) selected
                                                @endif
                                                @endif
                                                @endif
                                                value="{{ $psu->user_id }}">{{ $psu->user->name }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
                <a class="btn green-sharp" onclick='submitProcess()'>{{ trans('button.process') }}</a>
            </div>
        </div>

    </div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}"
        type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
  $('#processModal').modal('show')

  function togglePostal() {
    var method = $('#payment_method').val()

    if (method == 3)
      $('#row_postalorder_no').removeClass('hidden')
    else
      $('#row_postalorder_no').addClass('hidden')
  }

  @if($case->form2->payment)
  @if(!$case->form2->payment->payment_fpx_id)
  @if($case->form2->payment->payment_postalorder_id)
  $('#payment_method').val(3).trigger('change')
  @else
  $('#payment_method').val(2).trigger('change')

  @endif
  @endif
  @endif

  function submitProcess() {

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url: "{{ route('form2-final') }}",
      type: 'POST',
      data: $('form').serialize(),
      datatype: 'json',
      async: false,
      success: function (data) {
        if (data.result == 'Success') {

          swal({
              title: "{{ trans('swal.success') }}",
              text: "{{ trans('swal.process_success') }}!",
              type: 'success',
              showCancelButton: false,
              closeOnConfirm: true
            },
            function () {
              swal({
                text: "{{ trans('swal.reload') }}..",
                showConfirmButton: false
              })
              location.reload()
            })

        } else {
          var inputError = []

          console.log(Object.keys(data.message)[ 0 ])
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

</script>