<?php
$locale = App::getLocale();
$month_lang = "month_" . $locale;

$total_online = 0;
$total_offline = 0;

?>


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
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ trans('new.report27') }} </span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <div id='title'
                         style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                        {{ __('new.tribunal')}} <br>
                        {{ __('new.filed_online_transaction')}} <br>
                        {{ Request::has('date_start') ? Request::get('date_start') : date('d/m/Y') }}
                        {{ __('new.until') }}
                        {{ Request::has('date_end') ? Request::get('date_end') : date('d/m/Y') }}<br>
                        {{-- @if(isset($state_id)) --}}
                        @if(isset($state_id) && !empty($state_id))
                            {{__('new.state')}} :&nbsp;
                            {{
                                array_has($state_list, $state_id)
                                ? $state_list[$state_id]
                                : ''
                            }}
                        @endif<br>
                    </div>

                    <table class="table table-bordered table-hover data">
                        <thead>
                        <tr>
                            <th rowspan="2"> {{ __('new.state') }} </th>
                            <th rowspan="2"> {{ __('new.total_filings')}} </th>
                            <th colspan="2"> {{ __('new.transaction_method')}} </th>
                        </tr>
                        <tr style="text-transform: uppercase;">
                            <th> {{ __('new.online') }} </th>
                            <th> {{ __('new.offline') }} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($states as $state)
                            @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                            <?php
                            $claimcase = (clone $claimcases)->where('state_id', $state->state_id);
                            $case_online = (clone $claimcase)->where('is_online_purchased', 1);
                            $case_offline = (clone $claimcase)->where('is_online_purchased', 0);

                            $total_online += count($case_online);
                            $total_offline += count($case_offline);
                            ?>
                            <tr>
                                <td style="text-align: left; text-transform: uppercase;"> {{ $state->state }}</td>
                                <td style="text-align: center; text-transform: uppercase;"> {{ count($claimcase) }}</td>
                                <td>{{ count($case_online) }}</td>
                                <td>{{ count($case_offline) }}  </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>{{__('new.total')}}</td>
                            <td> {{ count($claimcases) }}</td>
                            <td> {{ $total_online }}</td>
                            <td> {{ $total_offline }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('new.percentage') }}</td>
                            <td> @if(count($claimcases) > 0) 100 @else 0.00 @endif %</td>
                            <td> @if(count($claimcases) > 0){{ round( $total_online/count($claimcases)*100, 2) }}% @else
                                    0 @endif </td>
                            <td> @if(count($claimcases) > 0) {{ round( $total_offline/count($claimcases)*100, 2) }}
                                % @else 0 @endif</td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 hide-print" style="text-align: center; line-height: 80px;">
            <a type="button" class="btn default" href='{{ route("report.list", ["page" => 3]) }}'>
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

    <!-- END PAGE LEVEL SCRIPTS -->

    <script>

      function exportPDF() {
        location.href = "{{ url('') }}/report/report27/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report27/export/excel?{!! http_build_query(request()->input()) !!}"
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

@endsection