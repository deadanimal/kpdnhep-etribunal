<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = "month_" . $locale;
$category_lang = "category_" . $locale;
$classification_lang = "classification_" . $locale;
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

        th.vertical {
            white-space: nowrap;
            position: relative;
        }

        th.vertical > span {
            transform: rotate(-90deg);


        }

    </style>
@endsection

@section('content')
    <!-- #start -->

    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ trans('new.report18') }} </span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="hide-print" style="margin-bottom: 20px;">
                    <form method='get' action='' id="search-form" class="hidden">
                    <span style="line-height: 2; display: inline-flex; text-align: center; margin-bottom: 10px;">
                        <select id="state_id" class="form-control select2 bs-select" name="state_id"
                                style="margin-right: 10px;"
                                placeholder="-- {{ __('new.all_state') }} --">
                                            <option value="" selected>-- {{ __('new.all_state') }} --</option>
                                            @foreach($states->pluck('state_name', 'state_id') as $id => $state)
                                <option @if(Request::get('state_id') == $id ) selected
                                        @endif value="{{ $id }}">{{ $state }}
                                                </option>
                            @endforeach
                                        </select>
                        <select required onchange="loadClassification()" id="category" class="form-control"
                                name="category" style="width: 200px;">
                            <option value="0" selected>-- {{ __('new.all_category') }} --</option>
                            @foreach($categories as $i=>$category)
                                <option @if(Request::get('category') == $category->claim_category_id ) selected
                                        @endif value="{{ $category->claim_category_id }}">{{ $category->$category_lang }}</option>
                            @endforeach
                        </select>
                        <select id="classification" class="form-control" name="classification"
                                style="width: 200px; margin: 0px 15px;">
                            <option value="0" selected>-- {{ __('new.all') }} --</option>
                            @foreach($classifications as $i=>$classification)
                                <option @if(Request::get('classification') == $classification->claim_classification_id ) selected
                                        @endif value="{{ $category->claim_classification_id }}">{{ $classification->$classification_lang }}</option>
                            @endforeach
                        </select>
                        <div class="form-group mb10">
                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                        </div>
                    </span>
                    </form>
                    &nbsp;
                    &nbsp;
                    <div id='title'
                         style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}
                        <br>
                        {{ __('new.claim_value_award')}}<br>
{{--                        ( {{ __('new.until') .' '.date('d/m/Y') }} )<br>--}}
                    </div>

                    <table class="table table-bordered table-hover data">
                        <thead>
                        <tr>
                            <th width="3%"> {{ __('new.no') }} </th>
                            <th> {{ __('new.state') }}  </th>
                            <th> {{ __('home_user.claim_case') }}  </th>
                            <th> {{ __('new.claim_value') }} (RM)</th>
                            <th> {{ __('new.award_value') }} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($states as $index => $state )
                            <?php
                            $report = (clone $report18)->where('state_id', $state->state_id);
                            ?>
                            <tr>
                                <td> {{ $index+1 }} </td>
                                <td style="text-align: left; text-transform: uppercase;">{{ $state->state }}</td>
                                <td style="text-align: left; text-transform: uppercase;">{{ $report->sum('total') }}</td>
                                <td style="text-align: right;"> {{ number_format( $report->sum('claim_amount') ,2,'.',',') }}</td>
                                <td style="text-align: right;"> {{ number_format( $report->sum('award_value') ,2,'.',',') }}  </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">{{__('new.total')}}</td>
                            <td></td>
                            <td style="text-align: right;"> {{ number_format( $report18->sum('claim_amount') ,2,'.',',') }}</td>
                            <td style="text-align: right;"> {{ number_format( $report18->sum('award_value') ,2,'.',',') }}  </td>
                        </tr>
                        </tfoot>
                    </table>
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
                    <h4 class="modal-title">{{ trans('new.report18') }}</h4>
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

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>

      function exportPDF() {
        location.href = "{{ url('') }}/report/report18/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report18/export/excel?{!! http_build_query(request()->input()) !!}"
      }

      // Initialization
              @foreach ($categories as $category)
      var cat{{ $category->claim_category_id }} = []
      @endforeach

      cat1.push({ 'id': '0', 'name': "-- {{ __('new.all') }} --" })
      cat2.push({ 'id': '0', 'name': "-- {{ __('new.all') }} --" })

      // Insert data into array
      @foreach ($classifications as $classification)
      cat{{ $classification->category_id }}.push({
        'id': "{{ $classification->claim_classification_id }}",
        'name': "{{ $classification->$classification_lang }}"
      })

      @endforeach

      function loadClassification() {

        var cat = $('#category').val()
        $('#classification').empty()

          @foreach ($categories as $category)
          if (cat == {{ $category->claim_category_id }}) {
            $.each(cat{{ $category->claim_category_id }}, function (key, data) {
              $('#classification').append('<option value=\'' + data.id + '\'>' + data.name + '</option>')
            })
          }
          @endforeach

      }

      var ctx = document.getElementById('myChart').getContext('2d')
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
              @foreach( $states as $index => $state )
                "{{ $state->state }}",
              @endforeach
          ],
          datasets: [ {
            label: '{{ __("new.claim_amount") }} (RM)',
            data: [
                @foreach( $states as $index => $state )
                <?php
                $report = (clone $report18)->where('state_id', $state->state_id);
                ?>
                {{ $report->sum('claim_amount') }},
                @endforeach
            ],
            backgroundColor: 'rgba(255, 99, 132, 1)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
          },
            {
              label: '{{ __("new.award_value")}} (RM)',
              data: [
                  @foreach( $states as $index => $state )
                  <?php
                  $report = (clone $report18)->where('state_id', $state->state_id);
                  ?>
                  {{ $report->sum('award_value') }},
                  @endforeach
              ],
              backgroundColor: 'rgba(54, 162, 235, 1)',
              borderColor: 'rgba(54, 162, 235, 1)',
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
                labelString: '{{ __("new.total")}} (RM)'
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
    </script>

@endsection