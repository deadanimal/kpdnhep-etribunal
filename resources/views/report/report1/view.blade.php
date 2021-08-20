<?php
use Carbon\Carbon;
use App\CaseModel\Form4;

$locale = App::getLocale();
$category_lang = 'category_' . $locale;
$position_lang = 'position_' . $locale;
$position_reason_lang = 'position_reason_' . $locale;
$reason_lang = 'reason_' . $locale;
$date = date('d/m/Y');

$psu = array();

if ($cases) {
    foreach ($cases as $key => $case) {
        $form4psus = Form4::with('psus.psu')->where('form4_id', $case->form4_id)->first();
        foreach($form4psus['psus'] as $psu_datum){
            $psu[$psu_datum->psu_user_id] = $psu_datum->psu->name;
        }
    }
}

if ($waived) {
    foreach ($waived as $key => $f12) {
        $form4psus = Form4::with('psus.psu')->where('form4_id', $f12->form4_id)->first();
        foreach($form4psus['psus'] as $psu_datum){
            $psu[$psu_datum->psu_user_id] = $psu_datum->psu->name;
        }
    }
}

if ($postponed) {
    foreach ($postponed as $key => $p) {
        $form4psus = Form4::with('psus.psu')->where('form4_id', $p->form4_id)->first();
        foreach($form4psus['psus'] as $psu_datum){
            $psu[$psu_datum->psu_user_id] = $psu_datum->psu->name;
        }
    }
}

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
    <style type="text/css">
        .data th, .data td {
            text-align: center;
            text-transform: uppercase;
            font-size: smaller !important;
        }

        .data th {
            vertical-align: middle !important;
            background-color: #428bca !important;
            color: #ffffff;
        }

        tfoot {
            vertical-align: middle !important;
            background-color: #428bca;
            color: #ffffff;
        }

        .absolute-center {
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        .top {
            vertical-align: top;
        }
    </style>
@endsection

@section('content')
    <!-- #start -->

    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered form-fit">
                <div class="portlet-body" style="margin: 20px;">
                    <div style="text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                        {{ __('new.tribunal') }}<br>
                        {{ __('new.daily_report') }}<br>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <form method='get' action='' id='filter'>
                                <div id="search-form" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="date" class="control-label col-md-3"> {{ __('new.date_start')}}:
                                                <span> &nbsp;&nbsp; </span>
                                            </label>
                                            <div class="col-md-2">
                                                <div class="input-group input-medium date date-picker"
                                                     style="margin-right: 10px;" data-date-format="dd/mm/yyyy"
                                                     style="width: 250px;">
                                                    <input class="form-control datepicker" readonly=""
                                                           name="hearing_date" id="hearing_date"
                                                           data-date-format="dd/mm/yyyy" type="text"
                                                           value="{{ Request::has('hearing_date') ? Request::get('hearing_date') : date('d/m/Y') }}"/>
                                                    <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                            <label for="hearing_day" class="control-label col-md-2"> {{ __('new.day')}}:
                                                <span> &nbsp;&nbsp; </span>
                                            </label>
                                            <div id='day' class="col-md-3" style="margin-top: 7px;">
                                                {{ localeDay(date('l', strtotime( Request::has('hearing_date') ? Carbon::createFromFormat('d/m/Y', Request::get('hearing_date'))->toDateString() : date('Y-m-d')))) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="branch" class="control-label col-md-3">{{ trans('new.branch')}}:
                                                <span> &nbsp;&nbsp; </span>
                                            </label>
                                            <div class="col-md-5">
                                                <select id="branch_id" class="form-control" name="branch_id"
                                                        style="margin-right: 10px;">
                                                    <option value="" selected>-- {{ __('form1.all_branch') }}--
                                                    </option>
                                                    <option value="">-- {{ __('form1.all_branch') }} --</option>
                                                    @foreach($branches as $i=>$branch)
                                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="venue"
                                                   class="control-label col-md-3">{{ trans('new.hearing_venue')}} :
                                                <span> &nbsp;&nbsp;</span>
                                            </label>
                                            <div class="col-md-5">
                                                <select id="hearing_venue_id" class="form-control"
                                                        name="hearing_venue_id" style="margin-right: 10px;">
                                                    <option value="" selected>-- {{ __('new.all_places') }} --</option>
                                                    <option value="">-- {{ __('new.all_places') }} --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="venue"
                                                   class="control-label col-md-3">{{ trans('new.hearing_room')}} :
                                                <span> &nbsp;&nbsp;</span>
                                            </label>
                                            <div class="col-md-5">
                                                <select id="hearing_room_id" class="form-control" name="hearing_room_id"
                                                        style="margin-right: 10px;">
                                                    <option value="" selected>-- {{ __('new.all_rooms') }} --</option>
                                                    <option value="">-- {{ __('new.all_rooms') }} --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="president"
                                                   class="control-label col-md-3">{{ trans('new.president')}} :
                                                <span style="color: red;"> * </span>
                                            </label>
                                            <div class="col-md-5">
                                                <select id="president_user_id" class="form-control select2 bs-select"
                                                        name="president_user_id" style="margin-right: 10px;">
                                                    <option value="" selected disabled hidden>-- {{ __('new.all') }}--
                                                    </option>
                                                    <option value="">-- {{ __('new.all') }} --</option>
                                                    @foreach($presidents as $i=>$prez)
                                                        <option @if(Request::get('president_user_id') == $prez->user_id) selected
                                                                @endif value="{{ $prez->user_id }}">{{ $prez->user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="approval"
                                                   class="control-label col-md-3">{{ trans('new.status')}} :
                                                <span> &nbsp;&nbsp; </span>
                                            </label>
                                            <div class="col-md-5">
                                                <select id="approval" onchange="updateStatus()"
                                                        class="form-control select2 bs-select" name="approval"
                                                        style="margin-right: 10px;">
                                                    <option value="0" selected>{{ __('new.not_approved') }}</option>
                                                    <option value="1">{{ __('new.approved') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="time" class="control-label col-md-3">{{ trans('new.time')}} :
                                                <span> &nbsp;&nbsp; </span>
                                            </label>
                                            <div class="col-md-5" style="display: inline-flex; ">
                                                <div class="input-icon" class="col-md-2" style="margin-right: 5px;">
                                                    <i class="fa fa-clock-o"></i>
                                                    <input type="text" id='start_time' name="start_time"
                                                           class="form-control timepicker timepicker-default"
                                                           value="{{ Request::has('start_time') ? Request::get('start_time') : '' }}">
                                                </div>
                                                <div style="margin-top: 8px;">{{ ' '.__('new.until').' '}}</div>
                                                <div class="input-icon" class="col-md-2" style="margin-left: 5px;">
                                                    <i class="fa fa-clock-o"></i>
                                                    <input type="text" id='end_time' name="end_time"
                                                           class="form-control timepicker timepicker-default"
                                                           value="{{ Request::has('end_time') ? Request::get('end_time') : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group hide-print" style="text-align: center;">
                                            <a type="button" class="btn default"
                                               href='{{ route("report.list", ["page" => 1]) }}'>
                                                <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
                                            </a>
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">{{ trans('button.reset') }}</button>
                                            <button class="btn btn-primary"
                                                    type="submit">{{ trans('button.submit')}}</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    @if( Request::has('president_user_id') && ($cases->count() > 0 || $waived->count() > 0 || $postponed->count() > 0))
                        <h5 style="font-weight: bold; margin-top: 30px;">1. {{ __('new.claim_fixed')}} :</h5>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover data table-export">
                                <thead>
                                <tr>
                                    <th style="width: 10%">{{ __('new.no') }}</th>
                                    <th style="width: 25%">{{ __('new.claim_no') }}</th>
                                    <th style="width: 15%">{{ __('new.type') }}</th>
                                    <th>{{ __('new.position') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cases as $index => $case )
                                    <?php
                                    ?>
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td style="text-align: left">
                                            <a href="{{ route('claimcase-view', [ $case->claim_case_id ]) }} "> {{ $case->case_no }} </a>
                                        </td>
                                        <td>{{ $case->$category_lang }}</td>
                                        <td style="text-align: left">
                                            @if($case->position_id == 1 || $case->position_id == 2)
                                                <span style="font-weight: bold;">{{ $case->$position_lang }}
                                                    @if($case->form4->form4_next)
                                                        @if($case->form4->form4_next->hearing)

                                                            {{ __('new.to2')." ".Carbon::parse($case->form4->form4_next->hearing->hearing_date)->format('d/m/Y') }}
                                                        @else -
                                                        @endif
                                                    @else -
                                                    @endif
                                    </span>
                                            @elseif($case->position_id == 3 || $case->position_id == 5)
                                                <span style="font-weight: bold;">{{ __('new.award') .' '. __('new.form') }} {{ $case->award_type }}  </span>
                                                <br>
                                                <span> {{ $case->award_description }} </span>
                                            @else
                                                <span style="font-weight: bold;"> {{ $case->$position_lang }}  </span>
                                                <br>
                                                <span> {{ $case->hearing_details }} </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if ( count($cases) == 0)
                                    <tr>
                                        <td colspan="4"> {{ __('new.no_record_age')}} </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>


                        <h5 style="font-weight: bold; margin-top: 30px;">2. {{ __('form12.waive_award_f12')}} :</h5>
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover data table-export">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%">{{ __('new.no') }}</th>
                                        <th style="width: 25%">{{ __('new.claim_no') }}</th>
                                        <th style="width: 15%">{{ __('new.type') }}</th>
                                        <th>{{ __('new.position') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($waived as $index => $f12 )
                                        <?php
                                        ?>
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td style="text-align: left">
                                                <a href="{{ route('claimcase-view', [ $f12->claim_case_id ]) }} "> {{ $f12->case_no }} </a>
                                            </td>
                                            <td>{{ $f12->$category_lang }}</td>
                                            <td style="text-align: left">
                                                @if($f12->position_id == 1 || $f12->position_id == 2)
                                                    <span style="font-weight: bold;">{{ $f12->$position_lang }}
                                                        @if($f12->form4->form4_next)
                                                            @if($f12->form4->form4_next->hearing)

                                                                {{ __('new.to2')." ".Carbon::parse($f12->form4->form4_next->hearing->hearing_date)->format('d/m/Y') }}
                                                            @else -
                                                            @endif
                                                        @else -
                                                        @endif
                                    </span>
                                                @elseif($f12->position_id == 3 || $f12->position_id == 5)
                                                    <span style="font-weight: bold;">{{ __('new.award') .' '. __('new.form') }} {{ $f12->award_type }}  </span>
                                                    <br>
                                                    <span> {{ $f12->award_description }} </span>
                                                @else
                                                    <span style="font-weight: bold;"> {{ $f12->$position_lang }}  </span>
                                                    <br>
                                                    <span> {{ $f12->hearing_details }} </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ( count($waived) == 0)
                                        <tr>
                                            <td colspan="4"> {{ __('new.no_record_age')}} </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>


                            <h5 style="font-weight: bold; margin-top: 30px;">3. {{ __('new.postponed')}} :</h5>
                                <div class="table-scrollable">
                                    <table class="table table-bordered table-hover data table-export">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%">{{ __('new.no') }}</th>
                                            <th style="width: 25%">{{ __('new.claim_no') }}</th>
                                            <th style="width: 15%">{{ __('new.type') }}</th>
                                            <th>{{ __('new.position') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($postponed as $index => $p )
                                            <?php
                                            ?>
                                            <tr>
                                                <td>{{ $index+1 }}</td>
                                                <td style="text-align: left">
                                                    <a href="{{ route('claimcase-view', [ $p->claim_case_id ]) }} "> {{ $p->case_no }} </a>
                                                </td>
                                                <td>{{ $p->$category_lang }}</td>
                                                <td style="text-align: left">
                                                    <span>{{ $p->$position_lang }} - {{ $p->$reason_lang }} </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ( count($postponed) == 0)
                                            <tr>
                                                <td colspan="4"> {{ __('new.no_record_age')}} </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div style="margin-top: 30px;">
                                    <span style="font-weight: bold; font-size: 14px">4. {{ __('new.psu')}} :</span>
                                    @foreach($psu as $id => $psu_name)
                                        {{ $psu_name }},
                                    @endforeach
                                </div>

                                <h5 style="font-weight: bold; margin-top: 30px">{{ __('new.date') }}<span
                                            style="font-weight: normal"> : {{Carbon::createFromFormat('d/m/Y', Request::get('hearing_date'))->format('d-m-Y')}} </span></h5>
                                <div class="md-checkbox">
                                    <input id="approval_checkbox" name="approval_checkbox" class="md-checkboxbtn"
                                           type="checkbox"
                                           @if (Request::get('approval') == 1 || Request::get('approval_checkbox') == 1 ) value="1"
                                           checked @else value="0" @endif onchange="updateLabel()">
                                    <label for="approval_checkbox">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        <span style="position: relative;">
                            {{ __('new.approved') }}
                        </span>
                                    </label>
                                </div>

                                <div style="margin-top: 60px; text-align: center; width: 350px; position: relative; z-index: 9999999 !important;">
                                    ................................................<br>
                                    <img class="absolute-center row_approval"
                                         style="width: 200px; bottom: 120%; z-index: -1;"
                                         @if(Request::get('president_user_id')) @if($cases->count())src="{{ route('general-getsignature', ['ttpm_user_id' => $cases->first()->president_user_id]) }}"
                                            @endif @endif />
                                    <span class='bold uppercase top'>@if(Request::get('president_user_id')) {{ $cases->count() > 0 ? $cases->first()->president_name : '' }} @endif</span><br>
                                    <span class='uppercase'>{{ __('new.president') }}<br>{{ __('new.tribunal') }}<br></span>
                                </div>


                    @endif
                </div>
            </div>
        </div>
    </div>
    @if( Request::has('president_user_id') )
        <div class="row hide-print">
            <div class="col-md-12" style="text-align: center; line-height: 80px;">
                <a type="button" class="btn default" href='{{ route("report.list", ["page" => 1]) }}'>
                    <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
                </a>
                <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i
                            class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
            <!-- <button type="button" class="btn purple btn-outline export-excel"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button> -->
            </div>
        </div>
    @endif
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
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    {{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
    <!-- END PAGE LEVEL SCRIPTS -->
    <script type="text/javascript">
      function exportPDF() {
        location.href = "{{ url('') }}/report/report1/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      $(document).ready(function () {
          @if(!Request::has('start_time'))
          $('#start_time').val('')
          @endif

          @if(!Request::has('end_time'))
          $('#end_time').val('')
          @endif

          @if(Request::has('approval'))
          $('#approval').val({{ Request::get('approval') }}).trigger('change')
          @endif

          @if(Request::has('branch_id'))
          $('#branch_id').val({{ Request::get('branch_id') }}).trigger('change')
          @endif

          @if(Request::has('hearing_venue_id'))
          $('#hearing_venue_id').val({{ Request::get('hearing_venue_id') }}).trigger('change')
          @endif

          @if(Request::has('hearing_room_id'))
          $('#hearing_room_id').val({{ Request::get('hearing_room_id') }}).trigger('change')
          @endif

      })

      var weekday = new Array(7)
      weekday[ 0 ] = "{{ __('new.sun')}}"
      weekday[ 1 ] = "{{ __('new.mon')}}"
      weekday[ 2 ] = "{{ __('new.tue')}}"
      weekday[ 3 ] = "{{ __('new.wed')}}"
      weekday[ 4 ] = "{{ __('new.thur')}}"
      weekday[ 5 ] = "{{ __('new.fri')}}"
      weekday[ 6 ] = "{{ __('new.sat')}}"

      $('.datepicker').on('change', function () {

        var dateString = $(this).val() // Oct 23

        if (dateString) {
          var dateParts = dateString.split('/')
          var dateObject = new Date(dateParts[ 2 ], dateParts[ 1 ] - 1, dateParts[ 0 ])

          var n = weekday[ dateObject.getDay() ]

          $('#day').html(n)

          //console.log(n);
        }
      })


      function updateStatus() {

        var status = $('#approval').val()


        if (status == 0) {
          $('.row_approval').addClass('hidden')
          $('#approval_checkbox').prop('checked', false)
        } else {
          $('.row_approval').removeClass('hidden')
          $('#approval_checkbox').prop('checked', true)
        }

      }

      updateStatus()

      function updateLabel() {

        var label = $('input[name="approval_checkbox"]:checked').val() ? 1 : 0

        if (label == 0) {
          $('#approval_label').html("{{ __('new.not_approved') }}")
          $('.row_approval').addClass('hidden')
          $('#approval').val(0).trigger('change')
          $('#filter').submit()

        } else {
          $('.row_approval').removeClass('hidden')
          $('#approval_label').html("{{ __('new.approved') }}")
          $('#approval').val(1).trigger('change')
          $('#filter').submit()
        }

      }

      updateStatus()

      var data = null

      $('#branch_id').on('change', function () {
        var branch_id = $('#branch_id').val()

        if (branch_id == '') {
          $('#hearing_venue_id').html("<option disabled selected>-- {{ __('new.all_places') }} --</option>")
          $('#hearing_room_id').html("<option disabled selected>-- {{ __('new.all_rooms') }} --</option>")
          return
        }

        $.ajax({
          url: "{{ url('/') }}/branch/" + branch_id + '/venues',
          type: 'GET',
          async: false,
          success: function (res) {

            data = res

            $('#hearing_venue_id').empty()
            $('#hearing_room_id').empty()
            $('#hearing_venue_id').append('<option disabled selected>---</option>')
            $.each(data.venues, function (key, venue) {
              if (venue.is_active == 1)
                $('#hearing_venue_id').append('<option key=\'' + key + '\' value=\'' + venue.hearing_venue_id + '\'>' + venue.hearing_venue + '</option>')
            })

          }
        })
      })

      $('#hearing_venue_id').on('change', function () {
        hearing_venue_id = $('#hearing_venue_id option:selected').attr('key')

        //console.log(data.branches[branch_id].venues[hearing_venue_id]);

        $('#hearing_room_id').empty()
        $('#hearing_room_id').append('<option disabled selected>---</option>')
        $.each(data.venues[ hearing_venue_id ].rooms, function (key, room) {
          if (room.is_active == 1)
            $('#hearing_room_id').append('<option key=\'' + key + '\' value=\'' + room.hearing_room_id + '\'>' + room.hearing_room + '</option>')
        })

      })

      @if(Request::has('branch') == $branch->branch_id)
      $('#branch_id').val({{ Request::get('branch') }}).trigger('change')
      @endif

      @if(Request::has('hearingplace') == $branch->branch_id)
      $('#hearing_venue_id').val({{ Request::get('hearing_place') }}).trigger('change')
      @endif

      @if(Request::has('hearingRoom') == $branch->branch_id)
      $('#hearing_room_id').val({{ Request::get('hearing_room') }}).trigger('change')
        @endif
    </script>
@endsection