<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = 'month_' . $locale;

$total_percent = 0;
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
                <div class="portlet-body" style="margin: 20px;">
                    <div id='title'
                         style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                        {{ __('new.tribunal')}}<br>
                        {{ __('new.total_f2_year') }}<br>
                        {{ Request::has('date_start') ? Request::get('date_start') : date('d/m/Y') }}
                        {{ __('new.until') }}
                        {{ Request::has('date_end') ? Request::get('date_end') : date('d/m/Y') }}<br></div>

                    <table class="table table-bordered table-hover data table-export">
                        <thead>
                        <tr>
                            <th width="3%"> {{ __('new.no') }} </th>
                            <th> {{ __('new.state') }}  </th>
                            <th> {!! __('new.total_reg') !!}</th>
                            <th> {!! __('new.total_opponent') !!}</th>
                            <th> {!! __('new.total_f2') !!}</th>
                            <th> %</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($states as $index => $state)
                            @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                            <?php
                            $case_state = (clone $case)->where('state_id', $state->state_id);
                            $form2_state = (clone $form2)->where('state_id', $state->state_id);
                            if ((count($case) * 2 + count($form2)) != 0)
                                $total_percent += (count($case_state) * 2 + count($form2_state)) / (count($case) * 2 + count($form2)) * 100;
                            ?>
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td style="text-align: left; text-transform: uppercase;">{{ $state->state }}</td>
                                <td>
                                  <a onclick="viewdrilldown({{ $state->state_id }})">
                                    {{ count($case_state) }}
                                  </a>
                                </td>
                                <td>
                                  <a onclick="viewdrilldown({{ $state->state_id }})">
                                    {{ count($case_state) }}
                                  </a>
                                </td>
                                <td>
                                  {{ count($form2_state) }}
                                </td>
                                <td>
                                    @if ( (count($case)*2+count($form2)) != 0)
                                        {{ number_format ( ( count($case_state)*2+count($form2_state) )/( count($case)*2+count($form2) )*100, 2,'.','') }}
                                    @else 0.00
                                    @endif

                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">{{__('new.total')}}</td>
                            <td>{{ count($case) }}</td>
                            <td>{{ count($case) }}</td>
                            <td>{{ count($form2) }}</td>
                            <td>{{ $total_percent }}</td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 hide-print" style="text-align: center; line-height: 80px;">
            <a type="button" class="btn default" href='{{ route("report.list", ["page" => 1]) }}'>
                <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
            </a>
            <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i
                        class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
            <button type="button" class="btn purple btn-outline" onclick="exportExcel()"><i
                        class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
            <button type="button" class="btn yellow-gold btn-outline" data-toggle="modal" data-target="#graphModal"><i
                        class="fa fa-bar-chart mr10"></i>{{ trans('button.graph') }}</button>
        </div>
    </div>
    <div id="graphModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('new.report6')}}</h4>
                </div>
                <div class="modal-body">
                    <canvas id="myChart" width="400" height="300"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('button.close') }}</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('after_scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->

    <script src="{{ URL::to('/assets/global/plugins/Chart.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
      function exportPDF() {
        location.href = "{{ url('') }}/report/report6/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report6/export/excel?{!! http_build_query(request()->input()) !!}"
      }

      var ctx = document.getElementById('myChart').getContext('2d')
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
              @foreach( $states as $index => $state )
                '{{ $state->state }}',
              @endforeach
          ],
          datasets: [ {
            label: '{{ __("new.total_filings") }}',
            data: [
                @foreach( $states as $index => $state )
                <?php
                $case_state = (clone $case)->where('state_id', $state->state_id);
                ?>
                {{ count($case_state) }},
                @endforeach
            ],
            backgroundColor: 'rgba(255, 99, 132, 1)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
          },
            {
              label: '{!! str_replace("<br>", " ", __("new.total_opponent")) !!}',
              data: [
                  @foreach( $states as $index => $state )
                  <?php
                  $case_state = (clone $case)->where('state_id', $state->state_id);
                  ?>
                  {{ count($case_state) }},
                  @endforeach
              ],
              backgroundColor: 'rgba(54, 162, 235, 1)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: '{{ __("new.total_filings") .' '. __("new.form")}} 2',
              data: [
                  @foreach( $states as $index => $state )
                  <?php
                  $form2_state = (clone $form2)->where('state_id', $state->state_id);
                  ?>
                  {{ count($form2_state) }},
                  @endforeach
              ],
              backgroundColor: 'rgba(255, 206, 86, 1)',
              borderColor: 'rgba(255, 206, 86, 1)',
              borderWidth: 1
            } ]
        },
        options: {
          'hover': {
            'animationDuration': 0
          },
          'animation': {
            'duration': 1,
            'onComplete': function () {
              var chartInstance = this.chart,
                ctx = chartInstance.ctx

              ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily)
              ctx.textAlign = 'center'
              ctx.textBaseline = 'bottom'

              this.data.datasets.forEach(function (dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i)
                meta.data.forEach(function (bar, index) {
                  var data = dataset.data[ index ]
                  ctx.fillText(data, bar._model.x, bar._model.y - 5)
                })
              })
            }
          },
          legend: {
            'display': false
          },
          tooltips: {
            'enabled': false
          },
          scales: {
            yAxes: [ {
              scaleLabel: {
                display: true,
                labelString: '{{ __("new.total_claim")}}'
              },
              ticks: {
                beginAtZero: true,
                autoSkip: false
              }
            } ],
            xAxes: [ {
              stacked: false,
              beginAtZero: true,
              scaleLabel: {
                display: true,
                labelString: '{{ __("new.state")}}'
              },
              ticks: {
                stepSize: 1,
                min: 0,
                autoSkip: false
              }
            } ]
          }
        }
      })

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

      function viewdrilldown(state_id) {
        // $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form1?year={{Request::get('year')}}&month={{ Request::get('month')}}");
        $("#modalDiv").load("{{ url('/report/report6/viewdd/show') }}?date_start={{ Request::get('date_start')}}&date_end={{ Request::get('date_end')}}&state_id="+state_id);
      }
    </script>

@endsection