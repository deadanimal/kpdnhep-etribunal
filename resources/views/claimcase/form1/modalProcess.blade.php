<?php

$locale = App::getLocale();
$category_lang = "category_" . $locale;
$classification_lang = "classification_" . $locale;
$offence_lang = "offence_description_" . $locale;
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

    .no-shadow {
        box-shadow: unset !important;
    }

    .panel-add:hover .panel {
        border: 1px solid #2ab4c0 !important;
        background-color: rgba(42, 180, 192, 0.2) !important;
    }

    .panel-add:hover span {
        color: #2ab4c0 !important;
        font-size: 18px;
        -webkit-transition: all 0.3s ease;
        -moz-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
        -ms-transition: all 0.3s ease;
    }

    .case-panel {
        padding-right: 0px;
        padding-left: 0px;
    }

    .case-panel .portlet {
        margin: 15px;
    }

    @media (max-width: 500px) {
        .case-panel {
            padding-right: 15px;
        }
    }

    .btn-action {
        position: absolute !important;
        right: 30px;
    }

    .label {
        padding: 3px 4px 3px !important;
    }

    .parent {
        position: relative;
    }

    .child {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .list-status > .btn {
        font-size: 11px !important;
        text-transform: capitalize !important;
        font-weight: normal !important;
    }

    .list-status li a {
        font-size: small !important;
        text-transform: capitalize !important;
        font-weight: normal !important;
    }

    .list-status .dropdown-menu {
        min-width: 160px !important;
    }

    .form-horizontal .form-group.form-md-line-input {
        margin: 0px !important;
    }
</style>

<div id="processModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('button.process') }} {{ __('form1.form1') }}</h4>
            </div>
            <div class="modal-body" style='background-color: #eef1f5; padding: 0px;'>

                <div class='row'>
                    <div class='col-xs-12'>

                        <div class="col-lg-6 col-sm-12" style='padding: 0px;'>
                            <form class="form-horizontal" role="form" style='background-color: white;'>
                                <div class="form-body" style="padding-bottom: 10px;">

                                    <div id="row_filing_date" class="form-group form-md-line-input">
                                        <label for="filing_date" id="label_filing_date"
                                               class="control-label col-md-5">{{ __('form1.filing_date') }} :
                                            <span class="required"> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-6">
                                            <div class="input-group date" data-date-format="dd/mm/yyyy">
                                                <input type='hidden' name='claim_case_id'
                                                       value='{{ $case->claim_case_id }}'>
                                                <input class="form-control form-control-inline date-picker datepicker clickme"
                                                       name="filing_date" id="filing_date" readonly=""
                                                       data-date-end-date="0d" data-date-format="dd/mm/yyyy" type="text"
                                                       value="{{ date('d/m/Y') }}"/>
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
                                                       name="matured_date" id="matured_date" readonly=""
                                                       data-date-start-date="+0d" data-date-format="dd/mm/yyyy"
                                                       type="text"
                                                       value="{{ \Carbon\Carbon::now()->addDays( env('CONF_F1_MATURED_DURATION', 14) )->format('d/m/Y') }}"/>
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
                                            @if($case->form1->payment ? $case->form1->payment->payment_fpx_id OR false : false)
                                                <input type="hidden" class="form-control" id="payment_method"
                                                       name="payment_method" value="1"/>
                                                <input type="text" readonly class="form-control"
                                                       value="{{ __('form1.online_payment') }}"/>
                                            @else
                                                <select onchange='togglePostal()' required
                                                        class="form-control select2 bs-select" id="payment_method"
                                                        name="payment_method" data-placeholder="---">
                                                    <option value="" disabled selected>---</option>
                                                    <option value="2">{{ __('form1.pay_counter') }}</option>
                                                    <option value="3">{{ __('form1.postal_order') }}</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>

                                    <div id="row_postalorder_no" class="form-group form-md-line-input hidden">
                                        <label for="postalorder_no" id="label_claimant_name" style="padding-top: 0px"
                                               class="control-label col-md-5">{{ __('form1.postal_no') }} :
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="postalorder_no"
                                                   name="postalorder_no" data-role="tagsinput"
                                                   @if($case)
                                                   @if($case->form1_id)
                                                   @if($case->form1->payment_id)
                                                   @if($case->form1->payment->payment_postalorder_id)
                                                   value="{{ $case->form1->payment->postalorder->postalorder_no }}"
                                                   @elseif($case->form1->payment->payment_fpx_id)
                                                   readonly
                                                    @endif
                                                    @endif
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
                                                   @if($case)
                                                   @if($case->form1_id)
                                                   @if($case->form1->payment_id)
                                                   @if($case->form1->payment->receipt_no) value="{{ $case->form1->payment->receipt_no }}"
                                                   @endif

                                                   @if($case->form1->payment->payment_fpx_id OR false)
                                                   readonly
                                                    @endif
                                                    @endif
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
                                                       @if($case)
                                                       @if($case->form1_id)
                                                       @if($case->form1->payment_id)
                                                       @if($case->form1->payment->paid_at) value="{{ date('d/m/Y', strtotime($case->form1->payment->paid_at)) }}"
                                                       @else value="{{ date('d/m/Y') }}"
                                                       @endif


                                                       @if($case->form1->payment->payment_fpx_id OR false)
                                                       disabled
                                                       @endif
                                                       @else value="{{ date('d/m/Y') }}"
                                                       @endif
                                                       @else value="{{ date('d/m/Y') }}"
                                                       @endif
                                                       @else value="{{ date('d/m/Y') }}"
                                                        @endif
                                                />
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div id="row_claim_category" class="form-group form-md-line-input">
                                        <label for="claim_category" id="label_claim_category"
                                               class="control-label col-md-5">{{ __('form1.category_claim') }} :
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select required onchange="loadClassification()"
                                                    class="form-control select2 bs-select" id="claim_category"
                                                    name="claim_category" data-placeholder="---">
                                                <option value="" disabled selected>---</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->claim_category_id }}">{{ $category->$category_lang }}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div id="row_claim_classification" class="form-group form-md-line-input">
                                        <label for="claim_classification" id="label_claim_classification"
                                               class="control-label col-md-5">{{ __('form1.classification_claim') }} :
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select required class="form-control select2 bs-select"
                                                    id="claim_classification" name="claim_classification"
                                                    data-placeholder="---">
                                                <option value="" disabled selected>---</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div id="row_claim_offence" class="form-group form-md-line-input">
                                        <label for="claim_offence" id="row_claim_offence"
                                               class="control-label col-md-5">{{ __('form1.type_offence') }} :
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select required class="form-control select2 bs-select" id="claim_offence"
                                                    name="claim_offence" data-placeholder="---">
                                                <option value="" disabled selected>---</option>
                                                @foreach ($offences as $offence)
                                                    <option
                                                            @if($case)
                                                            @if($case->form1_id)
                                                            @if($case->form1->offence_type_id)
                                                            @if($case->form1->offence_type_id == $offence->offence_type_id) selected
                                                            @endif
                                                            @endif
                                                            @endif
                                                            @endif
                                                            value="{{ $offence->offence_type_id }}">{{ $offence->offence_code }}
                                                        - {{ $offence->$offence_lang }}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <hr>


                                    <div id="row_branch" class="form-group form-md-line-input">
                                        <label for="branch" id="row_claim_offence"
                                               class="control-label col-md-5">{{ trans('new.branch')}} :
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select onchange='loadHearing(this)' required
                                                    class="form-control select2 bs-select" id="branch_id" name="branch"
                                                    data-placeholder="---">
                                                <option value="" disabled selected>---</option>
                                                @foreach ($branches as $branch)
                                                    <option
                                                            @if($case->branch_id == $branch->branch_id)
                                                            selected
                                                            @endif
                                                            value="{{ $branch->branch_id }}">{{ $branch->branch_name }} @if($branch->is_hq)
                                                            (HQ)@endif</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div id="row_venue" class="form-group form-md-line-input">
                                        <label for="hearing_venue_id"
                                               class="control-label col-md-5">{{ __('new.place_hearing') }} :
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select required class="form-control select2 bs-select"
                                                    id="hearing_venue_id" name="hearing_venue_id"
                                                    data-placeholder="---">
                                                <option value="" disabled selected>---</option>
                                                @foreach ($hearing_venues as $venue)
                                                    @if($venue->is_active == 1)
                                                        <option
                                                                @if($case)
                                                                @if($case->hearing_venue_id)
                                                                @if($case->hearing_venue_id == $venue->hearing_venue_id) selected
                                                                @endif
                                                                @endif
                                                                @endif
                                                                value="{{ $venue->hearing_venue_id }}">{{ $venue->hearing_venue }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <label for="psu"
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

                                    <div id="row_hearing_date" class="form-group form-md-line-input">
                                        <label for="hearing_date" id="label_hearing_date"
                                               class="control-label col-md-5">{{ __('form1.hearing_date') }} :
                                            <span class="required"> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select class="form-control select2-allow-clear bs-select" id="hearing_date"
                                                    name="hearing_date" data-placeholder="---">
                                                <option value="" disabled selected>---</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>


                        <div class="col-lg-6 col-sm-12 case-panel" style="padding-right: 0px;">

                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-folder-alt  font-green-sharp"></i>
                                        <span class="caption-subject bold font-green-sharp uppercase"> @include('claimcase.transaction_info_prosesb1') </span>
                                        <span class="caption-helper"></span>
                                    </div>
                                </div>
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-folder-alt  font-green-sharp"></i>
                                        <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('home_user.history_case') }} </span>
                                        <span class="caption-helper"></span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id='claim' class='row'>
                                        @if(count($claim) == 0)
                                            <div class="panel-group col-xs-12">
                                                <div class="panel panel-default no-shadow"
                                                     style="border: 1px solid #eee;">
                                                    <div class="panel-body parent"
                                                         style="text-align: center; height: 120px;">
                                                        <span class='font-grey-salt child'
                                                              style="cursor: default;">{{ trans('home_user.no_available_case') }}</span>
                                                        <!-- <button class='btn green-sharp btn-xs'>View</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($claim as $i=>$c)

                                                <div class="panel-group col-xs-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <a href='{{ route("claimcase-view", [$c->claim_case_id]) }}'
                                                               class='bold font-grey-mint' style="font-size: 16px;"><i
                                                                        class='icon-check'
                                                                        style="margin-right: 10px;"></i>{{ $c->case_no }}
                                                            </a>
                                                            <small class='label no-shadow pull-right'
                                                                   style='background-color: #a0d046'>{{ $c->status->case_status }}</small>
                                                            <br>
                                                            <small class='font-grey-mint'>{{ trans('home_user.against') }}
                                                                : @if($c->opponent_user_id){{ $c->opponent->name }}@endif</small>
                                                            <br>
                                                            @if( $c->case_status_id == 2 )
                                                                <small class='font-green-sharp'>
                                                                    * {{ trans('home_user.status_2_claim') }}</small>
                                                            @elseif( $c->case_status_id == 4 )
                                                                <small class='font-red-thunderbird'>
                                                                    * {{ trans('home_user.status_4_claim') }}</small>
                                                            @elseif( $c->case_status_id == 6 )
                                                                <small class='font-green-sharp'>
                                                                    * {{ trans('home_user.status_6_claim') }}</small>
                                                            @elseif( $c->case_status_id == 7 )
                                                                <small class='font-grey-mint'>
                                                                    * {{ trans('home_user.status_7_claim') }}</small>
                                                            @elseif( $c->case_status_id == 8 )
                                                                <small class='font-grey-mint'>
                                                                    * {{ trans('home_user.status_8_claim') }}</small>
                                                            @elseif( $c->case_status_id == 9 )
                                                                <small class='font-grey-mint'>
                                                                    * {{ trans('home_user.status_9_claim') }}</small>
                                                        @endif
                                                        <!-- <button class='btn green-sharp btn-xs'>View</button> -->
                                                        </div>
                                                        <div class="panel-footer">
                                                            <a class='btn btn-xs
                                                @if($c->form1_id)
                                                                    btn-primary' target="_blank" data-toggle="tooltip"
                                                               title="{{ trans('home_user.view_f1') }}"
                                                               href="{{ route('form1-view', ['claim_case_id' => $c->claim_case_id]) }}"
                                                               @else
                                                               btn-default' disabled
                                                            @endif
                                                            >{{ trans('home_user.f1') }}</a>

                                                            <a class='btn btn-xs
                                                @if($c->form1_id)
                                                            @if($c->form1->form2_id)
                                                                    btn-primary' target="_blank" data-toggle="tooltip"
                                                               title="{{ trans('home_user.view_f2') }}"
                                                               href="{{ route('form2-view', ['claim_case_id' => $c->claim_case_id]) }}"
                                                               @else
                                                               btn-default' disabled
                                                            @endif
                                                            @else
                                                                btn-default' disabled
                                                            @endif
                                                            >{{ trans('home_user.f2') }}</a>

                                                            <a class='btn btn-xs
                                                @if($c->form1_id)
                                                            @if($c->form1->form2_id)
                                                            @if($c->form1->form2->form3_id)
                                                                    btn-primary' target="_blank" data-toggle="tooltip"
                                                               title="{{ trans('home_user.view_f3') }}"
                                                               href="{{ route('form3-view', ['claim_no' => $c->claim_case_id]) }}"
                                                               @else
                                                               btn-default' disabled
                                                            @endif
                                                            @else
                                                                btn-default' disabled
                                                            @endif
                                                            @else
                                                                btn-default' disabled
                                                            @endif
                                                            >{{ trans('home_user.f3') }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach

                                        @endif
                                    </div>
                                    @if(count($claim) > 4)
                                        <div class='row'>
                                            <div class='col-xs-12'>
                                                <ul class="pagination pull-right" id="pagination-claim"></ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

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

<script src="{{ URL::to('/assets/global/plugins/jquery.twbsPagination.min.js') }}" type="text/javascript"></script>

<script>
  $('#processModal').modal('show')

  loadHearing($('#branch_id'))

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

    var cat = $('#claim_category').val()
    $('#claim_classification').empty()

      @foreach ($categories as $category)
      if (cat == {{ $category->claim_category_id }}) {
        $.each(cat{{ $category->claim_category_id }}, function (key, data) {
          $('#claim_classification').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
        })
      }
      @endforeach

      loadOffence()

  }

  function togglePostal() {
    var method = $('#payment_method').val()

    if (method == 3)
      $('#row_postalorder_no').removeClass('hidden')
    else
      $('#row_postalorder_no').addClass('hidden')
  }

  @if($case->form1->claim_classification_id)
  $('#claim_classification').val({{$case->form1->claim_classification_id}}).trigger('change')
  $('#claim_category').val({{$case->form1->classification->category_id}}).trigger('change')
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

  @if(count($claim) > 4)
  // Claim Case - Current
  $(function () {
    window.pagObj = $('#pagination-claim').twbsPagination({
      totalPages: {{ ceil(count($claim)/4) }},
      visiblePages: 3,
      first: '<span aria-hidden="true">&laquo;</span>',
      last: '<span aria-hidden="true">&raquo;</span>',
      next: '<span aria-hidden="true">&rsaquo;</span>',
      prev: '<span aria-hidden="true">&lsaquo;</span>',
      onPageClick: function (event, page) {
        //console.info(page + ' (from options)');
        var n = ((page - 1) * 4) + 1

        console.log('Total Claim: ' + $('#claim .panel-group').length)

        $('#claim .panel-group').addClass('hidden')
        $('#claim .panel-group:nth-child(' + (n + 0) + ')').removeClass('hidden')
        $('#claim .panel-group:nth-child(' + (n + 1) + ')').removeClass('hidden')
        $('#claim .panel-group:nth-child(' + (n + 2) + ')').removeClass('hidden')
        $('#claim .panel-group:nth-child(' + (n + 3) + ')').removeClass('hidden')
        $('#claim').parents('.portlet').animate({ scrollTop: 0 }, 2000)
      }
    })
  })

  @endif

  function loadHearing(item) {
    var branch = $(item).val()
    $('#hearing_date').empty()
    var today = new Date()

    $.get('/branch/' + branch + '/hearings?date=' + today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear())
      .then(function (data) {
        $.each(data, function (key, hearings) {
          $.each(hearings, function (k, hearing) {
            console.log(hearing)
            $('#hearing_date').append('<option value="">---</option>')
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

  function submitProcess() {

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
              title: "{{ trans('swal.success') }}",
              text: data.case_no + "\n{{ trans('swal.claim_success') }}!",
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