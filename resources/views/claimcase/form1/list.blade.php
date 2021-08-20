<?php
$locale = App::getLocale();
$status_lang = "form_status_desc_" . $locale;
$month_lang = "month_" . $locale;
?>

@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>

    <style>
        .nowrap {
            white-space: nowrap;
        }
    </style>

@endsection

@section('heading', 'Roles')


@section('content')
    <div class="row margin-top-10">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ trans('form1.form1_list') }}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div style="margin-bottom: 20px;">
                    <form method='get' action=''>
                        <div id="search-form" class="form-inline">
                            <div class="form-group mb10">
                                <label for="status">{{ trans('hearing.status') }}</label>
                                <select id="status" class="form-control" name="status" style="margin-right: 10px;">
                                    <option value="" selected disabled hidden>-- {{ __('form1.all_status') }}--
                                    </option>
                                    <option @if(Request::get('status') == 0) selected @endif value="0">
                                        -- {{ __('form1.all_status') }} --
                                    </option>
                                    @foreach($status as $i=>$stat)
                                        <option
                                                @if(Request::get('status') == $stat->form_status_id) selected @endif
                                        value="{{ $stat->form_status_id }}">{{ $stat->$status_lang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb10">
                                <label for="branch">{{ trans('hearing.branch') }}</label>
                                <select id="branch" class="form-control" name="branch" style="margin-right: 10px;">
                                    <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }}--
                                    </option>
                                    <option @if(Request::get('branch') == 0) selected @endif value="0">
                                        -- {{ __('form1.all_branch') }} --
                                    </option>
                                    @foreach($branches as $i=>$branch)
                                        <option @if(Request::get('branch') == $branch->branch_id) selected
                                                @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br class='hidden-xs hidden-sm'>
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
                    <table id="roles" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th>{!! trans('form1.list_filing_date') !!}</th>
                            <th>{!! trans('form1.submit_date') !!}</th>
                            <th>{!! trans('form1.list_matured_date') !!}</th>
                            <th>{{ trans('form1.claim_no') }}</th>
                            <th>{{ trans('form1.claimant') }}</th>
                            <th>{{ trans('form1.opponent') }}</th>
                            <th>{{ trans('form1.status') }}</th>
                            <th>{{ trans('form1.action') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ trans('form1.form1_details') }}</h4>
                </div>
                <div class="modal-body" id="modalbodyperanan">
                    <div style="text-align: center;">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="fpxModal" class="modal fade modal-lg" role="dialog" style="width: 100%;">
        <div class="modal-dialog" style="width: 1000px; max-width: 100%;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><img src='{{ url("/images/logo_fpx.png") }}' style="height: 30px;"/></h4>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <div class="loader"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('button.close') }}</button>
                    <a id='btnProceedFPX' class="btn green-sharp" onclick='submit()'>{{ trans('button.proceed') }}</a>
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

    <script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

    <!--sweetalert -->
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <!--end sweetalert -->
    <script type="text/javascript">

      $('#fpxModal').on('hidden.bs.modal', function () {
        $('#fpxModal .modal-body').html('<div style="text-align: center;"><div class="loader"></div></div>')
      })

      $('body').on('click', '.btnModalPeranan', function () {
        $('#modalperanan').modal('show')
          .find('#modalbodyperanan')
          .load($(this).attr('value'))
      })
      $('#modalperanan').on('hidden.bs.modal', function () {
        $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>')
      })

      function choosePaymentMethod(id) {
        $('#modalDiv').load("{{ url('/') }}/payment/case/" + id + '/1')
      }

      var TableDatatablesButtons = function () {

        var initTable1 = function () {
          var table = $('#roles')

          var oTable = table.DataTable({
            'processing': true,
            'serverSide': true,
            stateSave: true,
            'ajax': "{!! Request::fullUrl() !!}",
            'deferRender': true,
            'pagingType': 'bootstrap_full_number',
            'columns': [
              // {data: 'rownum'},
              { data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false },
              { data: 'processed_at', name: 'form1.filing_date', 'orderable': true },
              { data: 'filing_date', name: 'form1.filing_date', 'orderable': true },
              { data: 'matured_date', name: 'form1.matured_date', 'orderable': true },
              {
                data: 'case_no', name: 'case_no', 'orderable': false, 'render': function (data, type, full) {
                  return $('<div/>').html(data).text()
                }
              },
              { data: 'claimant_name', name: 'claimant_address.name', 'orderable': false },
              {
                data: 'opponent_address.name',
                name: 'opponent_address.name',
                'orderable': false,
                'searchable': false,
                'render': function (data, type, full) {
                  return $('<div/>').html(data).text()
                }
              },
              { data: 'status', name: "form1.status.form_status_desc_{{ App::getLocale() }}", 'orderable': false },
              { data: 'action', name: 'action', 'orderable': false, 'searchable': false }
            ],
            'columnDefs': [
              { className: 'nowrap', 'targets': [ 7 ] }
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

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},


            buttons: [
              {
                text: "<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('form1.form1') }} ",
                className: 'btn blue btn-outline', action: function () {
                  window.location.href = "{{ route('form1-create') }}"
                }
              },
                    @if(Auth::user()->user_type_id < 3)
              {
                text: "<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('form1.instant_form1') }} ",
                className: 'btn blue',
                action: function () {
                  $('#modalDiv').load("{{ route('form1-instant') }}")
                }
              },
                    @endif
              {
                extend: 'print',
                className: 'btn dark btn-outline',
                title: function () {
                  return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ trans('form1.form1_list') }}</span>" // #translate
                },
                text: '<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                customize: function (win) {
                  // Style the body..
                  $(win.document.body).css('background-color', '#FFFFFF')

                  $(win.document.body).find('thead').css('background-color', '#DDDDDD')

                  $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit')

                  win.document.title = "{{ trans('form1.form1_list') }}"

                  $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} ' + moment().format('DD/MM/YYYY h:MM A') + '</footer>')
                },
                exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
              }
              // { extend: 'copy', className: 'btn red btn-outline', text:'<i class="fa fa-files-o margin-right-5"></i>Copy' },
              // { extend: 'pdf', className: 'btn green btn-outline', text:'<i class="fa fa-file-pdf-o margin-right-5"></i>PDF' },
              // { extend: 'excel', className: 'btn yellow btn-outline', text:'<i class="fa fa-file-excel-o margin-right-5"></i>Excel' },
              // { extend: 'csv', className: 'btn purple btn-outline', text:'<i class="fa fa-file-excel-o margin-right-5"></i>CSV' },
              // { extend: 'colvis', className: 'btn dark btn-outline', text: '<i class="fa fa-columns margin-right-5"></i>Columns'}
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: false,
            stateSave: true,

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

      function processForm1(id) {
        $('#modalDiv').load("{{ url('/') }}/form1/" + id + '/process')
      }

      function deleteCase(id) {
        swal({
            title: "{{ trans('swal.delete_case') }}",
            text: "{{ trans('swal.sure_delete_case') }}",
            type: 'warning',
            showCancelButton: true,
            closeOnConfirm: false,
            animation: 'fade-out',
            showLoaderOnConfirm: true,
            cancelButtonText: "{{ __('button.cancel') }}",
            confirmButtonText: "{{ __('button.delete') }}"
          },
          function () {

            var _token = $('meta[name="csrf-token"]').attr('content')

            $.ajax({
              url: "{{ url('/') }}/form1/" + id + '/delete',
              type: 'DELETE',
              data: {
                _token: _token,
                id: id
              },
              dataType: 'JSON',
              success: function (data) {
                if (data.status == 'ok') {
                  swal({
                      title: "{{ __('swal.success') }}!",
                      text: "{{ __('swal.success_deleted') }}!",
                      type: 'success',
                      showCancelButton: false,
                      closeOnConfirm: true
                    },
                    function () {
                      swal({
                        text: "{{ __('new.reloading') }}",
                        showConfirmButton: false
                      })
                      location.reload()
                    })
                } else {
                  swal("{{ __('new.error') }}!", "{{ __('new.something_wrong') }}", 'error')
                }
              },
              error: function (xhr, ajaxOptions, thrownError) {
                swal("{{ __('new.unexpected_error') }}!", thrownError, 'error')
              }
            })
          })
      }

      function form2createmodal() {
        console.log('masuk')
      }
    </script>

@endsection