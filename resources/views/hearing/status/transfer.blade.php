<?php
$locale = App::getLocale();
$month_lang = "month_" . $locale;
?>
@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>

@endsection

@section('content')
    <div class="row margin-top-10">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ __('new.transfer_entry')}}</span>
                    </div>
                </div>
                <div style="margin-bottom: 20px;">
                    <form method='get' action=''>
                        <div id="search-form" class="form-inline">
                            <!--
                                                    <br class='hidden-xs hidden-sm'> -->
                            <div class="form-group mb10">
                                <label for="year">{{ trans('hearing.year') }} </label>
                                <select id="year" class="form-control" name="year" style="margin-right: 10px;">
                                    <option value="" selected disabled hidden>-- {{ __('form1.all_year') }} --</option>
                                    <option value="">-- {{ __('form1.all_year') }} --</option>
                                    @foreach($years as $i=>$year)
                                        <option @if(Request::get('year') == $year) selected
                                                @endif value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb10">
                                <label for="month">{{ trans('hearing.month') }}</label>
                                <select id="month" class="form-control" name="month" style="margin-right: 10px;">
                                    <option value="" selected disabled hidden>-- {{ __('form1.all_month') }} --</option>
                                    <option value="">-- {{ __('form1.all_month') }} --</option>
                                    @foreach($months as $i=>$month)
                                        <option @if(Request::get('month') == $month->month_id) selected
                                                @endif value="{{ $month->month_id }}">{{ $month->$month_lang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb10">
                                <label for="branch">{{ trans('hearing.branch') }}</label>
                                <select id="branch" class="form-control select2" name="branch"
                                        data-placeholder="--------" onchange="loadHearing(this)">
                                    <option value="" disabled selected>--{{ trans('hearing.please_choose')}}--</option>
                                    @foreach($branches as $b)
                                        <option value="{{$b->branch_id}}">{{$b->branch_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb10">
                                <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="portlet-body">
                    <table id="hearing_status" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th>{{ trans('new.claim_no') }}</th>
                            <th>{{ trans('new.type') }}</th>
                            <th>{{ trans('inquiry.classification') }}</th>
                            <th>{{ trans('new.claimant') }}</th>
                            <th>{{ trans('new.opponent') }}</th>
                            <th>{!! trans('hearing.list_hearing_date') !!}</th>
                            <th>{{ trans('new.position') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('after_scripts')
    <script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

    <!--sweetalert -->
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <!--end sweetalert -->
    <script type="text/javascript">

      $('#branch').val({{ Request::get('branch') }}).trigger('change')

      $('#year, #month').on('change', function () {
        $('#branch').trigger('change')
      })

      function loadHearing(item) {
        var year = $('#year').val()
        var month = $('#month').val()
        var branch = $(item).val()

        console.log(branch)

        $.get('{{url('/')}}/branch/' + branch + '/hearings?year=' + year + '&month=' + month)
          .then(function (data) {
            $.each(data, function (key, hearings) {
              $.each(hearings, function (k, hearing) {
                console.log(hearing)
              })
            })
          }, function (err) {
            console.error(err)
          })
      }

      var TableDatatablesButtons = function () {

        var initTable = function () {
          var table = $('#hearing_status')

          var oTable = table.DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': "{!! Request::fullUrl() !!}",
            'deferRender': true,
            'pagingType': 'bootstrap_full_number',
            'columns': [
              { data: null, 'orderable': false, 'searchable': false },
              { data: "case_no", name:"case_no", 'orderable' : false, 'render': function ( data, type, full ) {
                    return $("<div/>").html(data).text(); 
                }},
              // { data: 'case_no', name: 'case.case_no', 'orderable': false },
              {
                data: 'category',
                name: "case.form1.classification.category.category_{{ App::getLocale() }}",
                'orderable': false
              },
              {
                data: 'classification',
                name: "case.form1.classification.classification_{{ App::getLocale() }}",
                'orderable': false
              },
              { data: 'claimant_name', name: 'case.claimant_address.name', 'orderable': false },
              { data: 'opponent_name', name: 'case.opponent_address.name', 'orderable': false },
              { data: 'hearing_date', name: 'hearing.hearing_date', 'orderable': false },
              { data: 'position', name: 'type', 'orderable': false, 'searchable': false }
            ],
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            'language': {
              'aria': {
                'sortAscending': ": {{ trans('new.sort_asc') }}",
                'sortDescending': ": {{ trans('new.sort_desc') }}"
              },
              'processing': "<span class=\"font-md\">{{ trans('new.process_data') }} </span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
              'emptyTable': "{{ trans('new.empty_table') }}",
              'info': "{{ trans('new.info_data') }}",
              'infoEmpty': "{{ trans('new.no_data_found') }}",
              'infoFiltered': "{{ trans('new.info_filtered') }}",
              'lengthMenu': "{{ trans('new.length_menu') }}",
              'search': "{{ trans('new.search') }}",
              'zeroRecords': "{{ trans('new.zero_record') }}"
            },

            buttons: [
              {
                extend: 'print',
                className: 'btn dark btn-outline',
                title: function () {
                  return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ __('new.status_entry')}}</span>" // #translate
                },
                text: '<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                customize: function (win) {
                  // Style the body..
                  $(win.document.body).css('background-color', '#FFFFFF')

                  $(win.document.body).find('thead').css('background-color', '#DDDDDD')

                  $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit')

                  win.document.title = "{{ __('new.status_entry')}}"

                  $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} ' + moment().format('DD/MM/YYYY h:MM A') + '</footer>')
                },
                exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
              }
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: false,

            //"ordering": false, disable column ordering 
            'paging': true, //disable pagination

            'order': [
              [ 0, 'asc' ]
            ],

            'lengthMenu': [
              [ 5, 10, 15, 20, 50 ],
              [ 5, 10, 15, 20, 50 ] // change per page values here
            ],
            // set the initial value
            'pageLength': 10,

            'dom': '<\'row\' <\'col-md-12\'>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>'
          })
          oTable.on('order.dt search.dt draw.dt', function () {
            var start = oTable.page.info().start
            var info = oTable.page.info()
            oTable.column(0, { order: 'applied' }).nodes().each(function (cell, i) {
              cell.innerHTML = start + i + 1
              oTable.cell(cell).invalidate('dom')
            })
          })
        }

        return {

          //main function to initiate the module
          init: function () {
            if (!jQuery().dataTable) {
              return
            }
            initTable()
          }
        }
      }()

      jQuery(document).ready(function () {
        TableDatatablesButtons.init()
      })
    </script>
@endsection
