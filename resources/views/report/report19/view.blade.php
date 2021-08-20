<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = 'month_'.$locale;
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
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span id='title' class="caption-subject uppercase bold">{{ __('new.ttpm_assmbly')}} </span> 
                </div>
                <div class="tools"> 
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div style="margin-bottom: 20px;">
                <form method='get' action=''>
                    <div id="search-form" class="form-inline">
                        <div class="form-group mb10">
                            <label for="branch">{{ trans('hearing.branch') }}</label>
                            <select id="branch" class="form-control" name="branch" style="margin-right: 10px;">
                                <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }} --</option>
                                <option value="0" @if(Request::get('branch') == 0) selected @endif >-- {{ __('form1.all_branch') }} --</option>
                                @foreach($branches as $i=>$branch)
                                <option @if(Request::get('branch') == $branch->branch_id) selected @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb10">
                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="portlet-body" style="margin: 20px;">
                <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.ttpm_assmbly')}} @if ($month){{ __('new.for'). ' '.__('new.month') .' '.$month->$month_lang}}@else {{ __('new.throughout')}}@endif {{ __('new.year') .' '.$year }}<br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></div>
                <div class='table-scrollable'>
                    <table class="table table-bordered table-hover data">
                        <thead>
                            <tr>
                                <th> {{ __('new.no') }} </th>
                                <th> {{ __('new.location') }} </th>
                                @foreach ($presidents as $prez )
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
                                @endforeach
                                <th> {{ __('new.total') }}</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ( $rooms as $index => $room)
                            <tr>
                                <td> {{ $i }} </td>
                                <td style="text-align: left; text-transform: uppercase;"> {{ $room->venue->hearing_venue.' - '.$room->hearing_room }} </td>
                                @foreach ($presidents as $prez )
                                <?php
                                    $hearing_room = (clone $hearing)->where('hearing_room_id', $room->hearing_room_id);
                                    $hearing_prez = (clone $hearing_room)->where('president_user_id', $prez->user_id);
                                ?>
                                <td> {{ count($hearing_prez) }} </td>
                                @endforeach
                                <td> {{ count($hearing_room) }} </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                                <td colspan="2"> {{ __('new.total') }} </td>
                                @foreach ($presidents as $prez )
                                <?php
                                    $prez = (clone $hearing)->where('president_user_id', $prez->user_id);
                                ?>
                                <td> {{ count($prez) }} </td>
                                @endforeach
                                <td> {{ count($hearing) }} </td>
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
                <h4 class="modal-title">{{ trans('new.report19') }}</h4>
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
    location.href = "{{ url('') }}/report/report19/export/pdf?{!! http_build_query(request()->input()) !!}";
}

function exportExcel() {
    location.href = "{{ url('') }}/report/report19/export/excel?{!! http_build_query(request()->input()) !!}";
}
    
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
        @foreach( $presidents as $prez )
            @if( $prez->user->ttpm_data )
                @if( $prez->user->ttpm_data->president )
                    @if( $prez->user->ttpm_data->president->president_code )
                        "{{ $prez->user->ttpm_data->president->president_code }}",
                    @endif
                @endif
            @else "-",
            @endif
        @endforeach
        ],
        datasets: [{
            label: '{{ __("new.total_hearing")}}',
            data: [
            @foreach( $presidents as $prez )
            <?php
                $hearings = (clone $hearing)->where('president_user_id', $prez->user_id);
            ?>
            {{ count($hearings) }},
            @endforeach
            ],
            backgroundColor: 'rgba(255, 99, 132, 1)',
            borderColor: 'rgba(255,99,132,1)',
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
                    labelString: '{{ __("new.total_hearing")}}',
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
                    labelString: '{{ __("new.president")}}',
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