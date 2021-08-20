<?php

//dd($award_disobey->first()->award_type);
?>
@extends('layouts.app')

@section('after_styles')
<style type="text/css">
    .data th,td {
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

<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">

        <div class="portlet light bordered">
            <div class="portlet-body" style="margin: 20px;">
                <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.award_disobey_for') .' '. __('new.year') .' '.$year.' '.__('new.by_prez') }}<br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br>
                </div>

                <div class='table-scrollable'>
                    <table class="table table-bordered table-hover data table-export">
                        <thead>
                            <tr>
                                <th rowspan="3"> {{ __('new.no') }}</th>
                                <th rowspan="3"> {{ __('new.state') }} </th>
                                <th colspan="{{ count($presidents) }}"> {{ __('new.president') }} </th>
                                <th rowspan="3"> {!! __('new.total_disobey') !!} </th>
                                <th rowspan="3"> {{ __('new.percentage') }} </th>
                                <th rowspan="3"> {!! __('new.total_filed_completed') !!} </th>
                                <th rowspan="3"> {!! __('new.claim_remainder') !!} </th>
                            </tr>
                            <tr>
                                <?php $i=0; ?>
                                @foreach ($presidents as $prez)
                                @if($prez->user->ttpm_data->president->is_appointed != 0)
                                <th rowspan="2"> 
                                     @if( $prez->user->ttpm_data )
                                        @if( $prez->user->ttpm_data->president )
                                            @if( $prez->user->ttpm_data->president->president_code )
                                                {{ $prez->user->ttpm_data->president->president_code }} 
                                            @endif
                                        @endif
                                        @else "-"
                                    @endif 
                                </th>
                                @else
                                    <?php $i++; ?>
                                @endif
                                @endforeach
                                <th colspan="{{ $i }}"> {{ __('new.body')}} </th>
                            </tr>
                            <tr>
                                @foreach ($presidents as $index => $prez)
                                @if($prez->user->ttpm_data->president->is_appointed != 1)
                                <th> 
                                    @if( $prez->user->ttpm_data )
                                        @if( $prez->user->ttpm_data->president )
                                            @if( $prez->user->ttpm_data->president->president_code )
                                                {{ $prez->user->ttpm_data->president->president_code }} 
                                            @endif
                                        @endif
                                        @else "-"
                                    @endif
                                </th>
                                @endif
                                @endforeach
                            </tr>
        
                        </thead>
                        <tbody>
                            @foreach( $states as $index => $state )
                            <?php
                                $award_state = (clone $award_disobey)->with(['form4'])->get()->where('form4.state_id', $state->state_id);

                                $case_state = (clone $case_completed)->filter(function ($value) use ($state) {
                                    return $value->form4->case->branch->branch_state_id == $state->state_id;
                                });
                              
                            ?>
                            <tr>
                                <td> {{ $index+1 }} </td>
                                <td style="text-align: left; text-transform: uppercase;"> {{ $state->state_name }} </td>

                                @foreach ($presidents as $prez)
                                @if($prez->user->ttpm_data->president->is_appointed != 0)
                                <?php
                                    $award_prez = (clone $award_state)->where('president_user_id', $prez->user_id);
                                ?>
                                <td> {{ count($award_prez) }} </td>
                                @endif
                                @endforeach


                                @foreach ($presidents as $prez)
                                @if($prez->user->ttpm_data->president->is_appointed == 0)
                                <?php
                                    $award_prez = (clone $award_state)->where('president_user_id', $prez->user_id);
                                ?>
                                <td> {{ count($award_prez) }} </td>
                                @endif
                                @endforeach


                                <td> {{ count($award_state) }} </td>
                                <td> 
                                    @if ( count($award_disobey->get()) >0 )
                                    {{ (number_format( (count($award_state)/count($award_disobey->get()))*100 ,2,'.',',')) }} 
                                    @else 0.00
                                    @endif
                                </td>
                                <td> {{ count($case_state) }} </td>
                                <td> {{ count($award_state) - count($case_state) }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                                <td colspan="2"> {{ __('new.total') }} </td>
                                @foreach ($presidents as $prez)
                                @if($prez->user->ttpm_data->president->is_appointed != 0)
                                <?php
                                    $prez = (clone $award_disobey)->get()->where('president_user_id', $prez->user_id);
                                ?>
                                <td> {{ count($prez) }} </td>
                                @endif
                                @endforeach
                                @foreach ($presidents as $prez)
                                @if($prez->user->ttpm_data->president->is_appointed == 0)
                                <?php
                                    $prez = (clone $award_disobey)->get()->where('president_user_id', $prez->user_id);
                                ?>
                                <td> {{ count($prez) }} </td>
                                @endif
                                @endforeach
                                <td> {{ count($award_disobey->get()) }} </td>
                                <td> @if(count($award_disobey->get()) != 0 ) 100.00 @else 0.00 @endif </td>
                                <td> {{ count($case_completed) }} </td>
                                <td> {{ count( $award_disobey->get() ) - count($case_completed) }} </td>
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
        <a type="button" class="btn default" href='{{ route("report.list", ["page" => 1]) }}'>
            <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
        </a>
        <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
        <button type="button" class="btn purple btn-outline" onclick="exportExcel()"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
        <button type="button" class="btn yellow-gold btn-outline" data-toggle="modal" data-target="#graphModal"><i class="fa fa-bar-chart mr10"></i>{{ trans('button.graph') }}</button>
    </div>
</div>

<div id="graphModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('new.report8') }}</h4>
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

<script src="{{ URL::to('/assets/global/plugins/Chart.min.js') }}"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->

<script>
function exportPDF() {
    location.href = "{{ url('') }}/report/report8/export/pdf?{!! http_build_query(request()->input()) !!}";
}

function exportExcel() {
    location.href = "{{ url('') }}/report/report8/export/excel?{!! http_build_query(request()->input()) !!}";
}

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            @foreach( $states as $index => $state )
            "{{ $state->state }}",
            @endforeach
        ],
        datasets: [{
            label: '{{ __("new.award_disobey")}}',
            data: [
            @foreach( $states as $index => $state )
            <?php
                $case1_state = (clone $award_disobey)->with(['form4'])->get()->where('form4.state_id', $state->state_id);
            ?>
            {{ count($case1_state) }},
            @endforeach
            ],
            backgroundColor: 'rgba(255, 99, 132, 1)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
        },
        {
            label: '{{ __("new.finished")}}',
            data: [
            @foreach( $states as $index => $state )
            <?php
                $case2_state = (clone $case_completed)->filter(function ($value) use ($state) {
                    return $value->form4->case->branch->branch_state_id == $state->state_id;
                });
            ?>
            {{ count($case2_state) }},
            @endforeach
            ],
            backgroundColor: 'rgba(54, 162, 235, 1)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        "hover": {
            "animationDuration": 0
        },
        "animation": {
            "duration": 1,
            "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                        var data = dataset.data[index];
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        },
        legend: {
            "display": false
        },
        tooltips: {
            "enabled": false
        },
        scales: {
            yAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: '{{ trans("new.total_claim") }}',
                },
                ticks: {
                    beginAtZero:true,
                    autoSkip: false
                }
            }],
            xAxes: [{
                stacked: false,
                beginAtZero: true,
                scaleLabel: {
                    display: true,
                    labelString: '{{ trans("new.state") }}',
                },
                ticks: {
                    stepSize: 1,
                    min: 0,
                    autoSkip: false
                }
            }]
        }
    }
});

var myDataTables = $('table').DataTable( {
    dom: 'Bfrtip',
    ordering: false,
    processing: false,
    serverSide: false,
    searching: false,
    bInfo : false,
    paging: false,
    buttons: [
        {
            extend: 'excel',
            className: 'btn yellow btn-outline hidden',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: $('#title').html().replace( /<br>/g, " " ),
            text:'<i class="fa fa-file-excel-o margin-right-5"></i> Excel'
        },
        {
            extend: 'pdfHtml5',
            className: 'btn green btn-outline hidden',
            orientation: 'landscape',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: '',
            text:'<i class="fa fa-file-pdf-o margin-right-5"></i> Print As PDF',
            customize: function ( doc ) {
                // Splice the image in after the header, but before the table
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 12 ],
                    alignment: 'center',
                    text: $('#title').html().replace( /<br>/g, " " ),
                } );
                // Data URL generated by http://dataurl.net/#dataurlmaker
            }
        },
    ],
    language: {
        "aria": {
            "sortAscending": ": {{ trans('new.sort_asc') }}",
            "sortDescending": ": {{ trans('new.sort_desc') }}"
        },
        "processing": "<span class=\"font-md\">{{ trans('new.process_data') }}</span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
        "emptyTable": "{{ trans('new.empty_table') }}",
        "info": "{{ trans('new.info_data') }}",
        "infoEmpty": "{{ trans('new.no_data_found') }}",
        "infoFiltered": "{{ trans('new.info_filtered') }}",
        "lengthMenu": "{{ trans('new.length_menu') }}",
        "search": "{{ trans('new.search') }}",
        "zeroRecords": "{{ trans('new.zero_record') }}"
    },


} );

function exportTo(buttonSelector){
    $(".buttons-"+buttonSelector).click();
}
</script>

@endsection