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
                        <span class="caption-subject bold uppercase"> {{ __('hearing.hearing_list') }} </span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table id="hearing_list" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <div style="padding: 10px; text-align: center;">
                                @if(!auth()->user()->hasRole('presiden'))
                                    {{ __('new.branch') }} : <b>{{ Auth::user()->ttpm_data->branch->branch_name }}</b>
                                    <br>
                                @endif
                                {{ __('new.date_time') }} :
                                <b>{{ date('d/m/Y h:i A', strtotime(request()->hearing_date.' '.(request()->hearing_time ? request()->hearing_time : '00:00:00'))) }}</b>
                            </div>
                        </tr>
                        <tr>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th>{{ __('new.claim_no') }}</th>
                            <th>{{ __('form1.claimant_name') }}</th>
                            <th>{{ __('new.filing_date') }}</th>
                            <th>{{ __('new.classification') }}</th>
                            <th>{{ __('new.president') }}</th>
                            <th>{{ __('new.action') }}</th>
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
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <!--sweetalert -->
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <!--end sweetalert -->

    <script type="text/javascript">
      var TableDatatablesButtons = function () {

        var initTable1 = function () {
          var table = $('#hearing_list')

          var oTable = table.DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': "{!! Request::fullUrl() !!}",
            'deferRender': true,
            'pagingType': 'bootstrap_full_number',
            'columns': [
              { data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false },
              { data: 'filing_date_form1_raw', name: 'filing_date', visible: false, searchable: false },
              {
                data: 'case_no', name: 'case.case_no', orderable: false, 'render': function (data, type, full) {
                  return $('<div/>').html(data).text()
                }
              },
              { data: 'claimant_name', name: 'case.claimant_address.name', orderable: false },
              { data: 'filing_date', name: 'filing_date ', orderable: false },
              {
                data: 'classification',
                name: "case.form1.classification.classification_{{ App::getLocale() }}",
                orderable: false,
                searchable: false
              },
              { data: 'president_name', name: 'hearing.president.name', orderable: false },
              { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            'orderFixed': [ 1, 'asc' ],
            'language': {
              'aria': {
                'sortAscending': ": {{ trans('new.sort_asc') }}",
                'sortDescending': ": {{ trans('new.sort_desc') }}"
              },
              'processing': "<span class=\"font-md\">{{ trans('new.process_data') }}</span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
              'emptyTable': "{{ trans('new.empty_table') }}",
              'info': "{{ trans('new.info_data') }}",
              'infoEmpty': "{{ trans('new.no_data_found') }}",
              'infoFiltered': "{{ trans('new.info_filtered') }}",
              'lengthMenu': "{{ trans('new.length_menu') }}",
              'search': "{{ trans('new.search') }}",
              'zeroRecords': "{{ trans('new.zero_record') }}"
            },

            buttons: [],

            responsive: false,
            stateSave: true,

            // "paging": true, //disable pagination

            'order': [
              [ 2, 'asc' ]
            ],

            'lengthMenu': [
              [ 5, 10, 15, 20, 50 ],
              [ 5, 10, 15, 20, 50 ] // change per page values here
            ],
            // set the initial value
            'pageLength': 10,

            'dom': '<\'row\' <\'col-md-12\'B>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>' // horizobtal scrollable datatable

          })
        }

        return {

          init: function () {
            if (!jQuery().dataTable) {
              return
            }
            initTable1()
          }
        }
      }()

      jQuery(document).ready(function () {
        TableDatatablesButtons.init()
      })

    </script>

@endsection