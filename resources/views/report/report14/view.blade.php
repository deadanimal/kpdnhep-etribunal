@extends('layouts.app')

@section('after_styles')

    <style type="text/css">
        .data th, td {
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

        th.rotate {
            /* Something you can count on */
            height: 150px;
            white-space: nowrap;
        }

        th.rotate > div {
            transform: /* Magic Numbers */ translate(0px, 50px) /* 45 is really 360 - 45 */ rotate(270deg);
            width: 10px;
        }

    </style>
@endsection

@section('content')
    <!-- #start -->

    <!-- BEGIN PAGE TITLE-->

    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-body" style="margin: 20px;">
                    <div id='title'
                         style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                        {{ __('new.tribunal')}}<br>
                        {{ __('new.company_name_year')}} <br>
                        {{ Request::has('date_start') ? Request::get('date_start') : date('d/m/Y') }}
                        {{ __('new.until') }}
                        {{ Request::has('date_end') ? Request::get('date_end') : date('d/m/Y') }}<br>
                        @if(isset($state_id) && !empty($state_id))
                            {{__('new.state')}} {{$state_list[$state_id]}}<br>
                        @endif
                    </div>

                    <div class='table-responsive'>
                        <table class="table table-bordered table-hover data">
                            <thead>
                            <tr>
                                <th width="3%"> {{ __('new.no') }} </th>
                                <th> {{ __('new.company_name') }}  </th>
                                @foreach ($states as $state)
                                    @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                                        <th class="rotate" style="text-transform: uppercase;">
                                            <div><span>{{ $state->state_name }} </span></div>
                                        </th>
                                    @endif
                                @endforeach
                                <th> {{ __('new.total') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($view_report14 as $index => $report)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td style="text-align: left; text-transform: uppercase;">{{ $report->name }}</td>
                                    @foreach ($states as $state)
                                        @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                                            <td> {{ count((clone $view_report14_full)->where('state_id', $state->state_id)->where('user_id', $report->user_id)) }} </td>
                                        @endif
                                    @endforeach
                                    <td>
                                        <a onclick="viewCompany( {{ $report->user_id }} )"> {{ count((clone $view_report14_full)->where('user_id', $report->user_id)) }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2">{{__('new.total_all')}}</td>
                                @foreach ($states as $state)
                                    @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                                        <td> {{ count((clone $view_report14_full)->where('state_id', $state->state_id)) }} </td>
                                    @endif
                                @endforeach
                                <td> {{ count($view_report14_full) }} </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 hide-print" style="text-align: center; line-height: 80px;">
            <a type="button" class="btn default" href='{{ route("report.list", ["page" => 2]) }}'>
                <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
            </a>
            <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i
                        class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
            <button type="button" class="btn purple btn-outline" onclick="exportExcel()"><i
                        class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
        </div>
    </div>
@endsection

@section('after_scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->


    <script type="text/javascript">

      function exportPDF() {
        location.href = "{{ url('') }}/report/report14/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report14/export/excel?{!! http_build_query(request()->input()) !!}"
      }

      function viewCompany(company) {
        $('#modalDiv').load("{{ url('/report') }}/report14/" + company + "/company?claim_classification={{Request::get('claim_classification')}}&year={{Request::get('year')}}")
      }

      var myDataTables = $('table').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        processing: false,
        serverSide: false,
        searching: false,
        bInfo: false,
        paging: false,
        buttons: [
          {
            extend: 'excel',
            className: 'btn yellow btn-outline hidden',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: $('#title').html().replace(/<br>/g, ' '),
            text: '<i class="fa fa-file-excel-o margin-right-5"></i> Excel'
          },
          {
            extend: 'pdfHtml5',
            className: 'btn green btn-outline hidden',
            orientation: 'landscape',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: '',
            text: '<i class="fa fa-file-pdf-o margin-right-5"></i> Print As PDF',
            customize: function (doc) {
              // Splice the image in after the header, but before the table
              doc.content.splice(1, 0, {
                margin: [ 0, 0, 0, 12 ],
                alignment: 'center',
                text: $('#title').html().replace(/<br>/g, ' ')
              })
              // Data URL generated by http://dataurl.net/#dataurlmaker
            }
          }
        ],
        language: {
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
        }

      })

      function exportTo(buttonSelector) {
        $('.buttons-' + buttonSelector).click()
      }

    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection