<?php

//dd($award_disobey->first()->award_type);
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

            <div class="portlet light bordered form-fit">
                <div class="portlet-body" style="margin: 20px;">
                    <div id='title'
                         style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                        {{ __('new.tribunal')}}<br>
                        {{ Request::has('date_start') ? Request::get('date_start') : date('d/m/Y') }}
                        {{ __('new.until') }}
                        {{ Request::has('date_end') ? Request::get('date_end') : date('d/m/Y') }}<br>
                        @if(isset($state_id))
                          {{__('new.state')}} :
                          {{
                            !empty($state_id)
                            ? (
                              array_has($states, $state_id)
                              ? $states[$state_id]
                              : ''
                            ) : 'SEMUA NEGERI'
                          }}
                          <br>
                        @endif
                    </div>

                    <table class="table table-bordered table-hover data">
                        <thead>
                        <tr>
                            <th width="3%"> {{ __('new.no') }} </th>
                            <th> {{ __('new.disobey_report') }}  </th>
                            <th> {{ __('new.total_complaints') }}</th>
                            <th> %</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $form5 = (clone $award_disobey)->where('award_type', 5);
                        $form6 = (clone $award_disobey)->where('award_type', 6);
                        $form7 = (clone $award_disobey)->where('award_type', 7);
                        $form8 = (clone $award_disobey)->where('award_type', 8);
                        $form9 = (clone $award_disobey)->where('award_type', 9);
                        $form10 = (clone $award_disobey)->where('award_type', 10);
                        ?>
                        <tr>
                            <td>1</td>
                            <td style="text-align: left;">{{ __('new.form5') }}</td>
                            <td><a onclick="viewComplaints(5)">{{ count($form5) }}</a></td>
                            <td>
                                @if (  count($award_disobey) != 0)
                                    {{ number_format ( count($form5) / count($award_disobey)*100, 2,'.','') }}
                                @else
                                    0.00
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td style="text-align: left;">{{ __('new.form6') }}</td>
                            <td><a onclick="viewComplaints(6)">{{ count($form6) }}</a></td>
                            <td>
                                @if (  count($award_disobey) != 0)
                                    {{ number_format ( count($form6) / count($award_disobey)*100, 2,'.','') }}
                                @else
                                    0.00
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td style="text-align: left;">{{ __('new.form7') }}</td>
                            <td><a onclick="viewComplaints(7)">{{ count($form7) }}</a></td>
                            <td>
                                @if (  count($award_disobey) != 0)
                                    {{ number_format ( count($form7) / count($award_disobey)*100, 2,'.','') }}
                                @else
                                    0.00
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td style="text-align: left;">{{ __('new.form8') }}</td>
                            <td><a onclick="viewComplaints(8)">{{ count($form8) }}</a></td>
                            <td>
                                @if (  count($award_disobey) != 0)
                                    {{ number_format ( count($form8) / count($award_disobey)*100, 2,'.','') }}
                                @else
                                    0.00
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td style="text-align: left;">{{ __('new.form9') }}</td>
                            <td><a onclick="viewComplaints(9)">{{ count($form9) }}</a></td>
                            <td>
                                @if (  count($award_disobey) != 0)
                                    {{ number_format ( count($form9) / count($award_disobey)*100, 2,'.','') }}
                                @else
                                    0.00
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td style="text-align: left;">{{ __('new.form10') }}</td>
                            <td><a onclick="viewComplaints(10)">{{ count($form10) }}</a></td>
                            <td>
                                @if (  count($award_disobey) != 0)
                                    {{ number_format ( count($form10) / count($award_disobey)*100, 2,'.','') }}
                                @else
                                    0.00
                                @endif
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">{{__('new.total')}}</td>
                            <td><a onclick="viewComplaints(10)" style="color: #fff">{{ count($award_disobey) }}</a></td>
                            <td>@if (  count($award_disobey) != 0) 100.00 @else 0.00 @endif</td>
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
                    <h4 class="modal-title">{{ trans('new.report7') }}</h4>
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
        location.href = "{{ url('') }}/report/report7/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report7/export/excel?{!! http_build_query(request()->input()) !!}"
      }

      function viewComplaints(award_type) {
        // $('#modalDiv').load("{{ url('/report') }}/report7/" + award_type + "/complaints?year={{Request::get('year')}}")
        $('#modalDiv').load("{{ url('/report') }}/report7/" + award_type + "/complaints?year={{Request::get('year')}}&date_start={{ Request::get('date_start')}}&date_end={{ Request::get('date_end')}}&state_id={{ Request::get('state_id')}}")
      }

      var ctx = document.getElementById('myChart').getContext('2d')
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
            '5', '6', '7', '8', '9', '10'
          ],
          datasets: [ {
            label: '{{ trans("new.complaints") }}',
            data: [

                {{ count($form5) }},

                {{ count($form6) }},

                {{ count($form7) }},

                {{ count($form8) }},

                {{ count($form9) }},

                {{ count($form10) }}


            ],
            backgroundColor: 'rgba(255, 99, 132, 1)',
            borderColor: 'rgba(255,99,132,1)',
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
                labelString: '{{ trans("new.total_complaints") }}'
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
                labelString: '{{ trans("new.award_type") }}'
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

    </script>
@endsection