<?php
$locale = App::getLocale();
$month_lang = 'month_' . $locale;
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

    <style>
        .nowrap {
            white-space: nowrap;
        }
    </style>

@endsection

@section('content')
    <!-- DB BASE -->
    <div class="row margin-top-10">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ trans('form11.witness_summons_list') }}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div style="margin-bottom: 20px;">
                    <form method='get' action=''>
                        <div id="search-form" class="form-inline">
                            <div class="form-group mb10">
                                <label for="branch">{{ trans('hearing.branch') }}</label>
                                <select id="branch" class="form-control" name="branch" style="margin-right: 10px;">
                                    <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }}--
                                    </option>
                                    <option value="0" @if(Request::get('branch') == 0) selected @endif >
                                        -- {{ __('form1.all_branch') }} --
                                    </option>
                                    @foreach($branches as $i=>$branch)
                                        <option @if(Request::get('branch') == $branch->branch_id) selected
                                                @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb10">
                                <label for="year">{{ trans('hearing.year') }} </label>
                                <select id="year" class="form-control" name="year" style="margin-right: 10px;">
                                    <option value="0" selected disabled hidden>-- {{ __('form1.all_year') }} --</option>
                                    <option value="0">-- {{ __('form1.all_year') }} --</option>
                                    @foreach($years as $i=>$year)
                                        <option @if($input['year'] == $year) selected
                                                @endif value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <br class='hidden-xs hidden-sm'>
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
                                <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="portlet-body">
                    <table id="form11" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th>{{ trans('new.claim_no') }}</th>
                            <th>{{ trans('form11.created_at') }}</th>
                            <th>{!! trans('form1.filing_date_form1') !!}</th>
                            <th>{{ trans('new.hearing_date') }}</th>
                            <th>{{ trans('new.opponent_name') }}</th>
                            <th>{{ trans('new.witness_name') }}</th>
                            <th>{{ trans('new.action') }}</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>


        <div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" id="modalbodyperanan">
                        <div style="text-align: center;">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('after_scripts')
            <script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}"
                    type="text/javascript"></script>
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
              $('body').on('click', '.btnModalPeranan', function () {
                $('#modalperanan').modal('show')
                  .find('#modalbodyperanan')
                  .load($(this).attr('value'))
              })
              $('#modalperanan').on('hidden.bs.modal', function () {
                $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>')
              })
            </script>
            <script type="text/javascript">
              var TableDatatablesButtons = function () {

                var initTable1 = function () {
                  var table = $('#form11')

                  //DB BASE
                  var oTable = table.DataTable({
                    'processing': true,
                    'serverSide': true,
                    'ajax': "{!! Request::fullUrl() !!}",
                    'deferRender': true,
                    'pagingType': 'bootstrap_full_number',
                    'columns': [
                      { data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false },
                      {
                        data: 'case_no', name: 'form4.case.case_no', 'render': function (data, type, full) {
                          return $('<div/>').html(data).text()
                        }
                      },
                      { data: 'created_at_form11', name: 'created_at' },
                      { data: 'processed_at_form1', name: 'form4.claimCase.form1.processed_at' },
                      { data: 'hearing_date', name: 'form4.hearing.hearing_date' },
                      { data: 'opponent_name', name: 'form4.claimCaseOpponent.opponent_address.name' },
                      { data: 'witness_name', name: 'userWitness.name' },
                      { data: 'action', name: 'action', 'orderable': false, 'searchable': false }
                    ],
                    'columnDefs': [
                      { className: 'nowrap', 'targets': [ 3 ] }
                    ],
                    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
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

                    // Or you can use remote translation file
                    //"language": {
                    //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                    //},


                    buttons: [
                      {
                        text: "<i class=\"fa fa-plus margin-right-5\"></i>  {{ __('form11.reg_witness')}} ",
                        className: 'btn blue btn-outline',
                        action: function () {
                          window.location.href = "{{ route('form11-find') }}"
                        }
                      },
                      {
                        extend: 'print',
                        className: 'btn dark btn-outline',
                        title: function () {
                          return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>  {{ __('form11.list_witness')}}</span>" // #translate
                        },
                        text: '<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                        customize: function (win) {
                          // Style the body..
                          $(win.document.body).css('background-color', '#FFFFFF')

                          $(win.document.body).find('thead').css('background-color', '#DDDDDD')

                          $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit')

                          win.document.title = "{{ trans('new.list_stop_notice') }}"
                          $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} ' + moment().format('DD/MM/YYYY h:MM A') + '</footer>')


                        },
                        exportOptions: {
                          columns: [ 0, 1, 2, 3 ]
                        }
                      },
                      /*
                      {
                          extend: 'print',
                          className: 'btn dark btn-outline',
                          title: function(){
                              return "{{ trans('new.list_branch') }}";
                    },
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                },*/
                      // { extend: 'copy', className: 'btn red btn-outline', text:'<i class="fa fa-files-o margin-right-5"></i>Copy' },
                      // { extend: 'pdf', className: 'btn green btn-outline', text:'<i class="fa fa-file-pdf-o margin-right-5"></i>PDF' },
                      // { extend: 'excel', className: 'btn yellow btn-outline', text:'<i class="fa fa-file-excel-o margin-right-5"></i>Excel' },
                      // { extend: 'csv', className: 'btn purple btn-outline', text:'<i class="fa fa-file-excel-o margin-right-5"></i>CSV' },
                      // { extend: 'colvis', className: 'btn dark btn-outline', text: '<i class="fa fa-columns margin-right-5"></i>Columns'}
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

                    'dom': '<\'row\' <\'col-md-12\'B>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>' // horizobtal scrollable datatable

                    // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                    // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
                    // So when dropdowns used the scrollable div should be removed.
                    //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                  })
                }

                return {

                  //main function to initiate the module
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

              function processStopNotice(id) {
                $('#modalDiv').load("{{ url('/') }}/form11/" + id + '/process')
              }

            </script>

@endsection