<?php
$total_diff=0;
$total_percentage=0;
?>

@extends('layouts.app')

@section('after_styles')

<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

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

    svg {
        width: 100% !important;
        height: 100% !important;
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

			<div class="portlet-body" style="padding: 20px;">

				<div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.differences_year')}} {{ __('new.between_year') .' '.$start_year.' '. __('new.and') .' '.$end_year.' '. __('new.at_2')}} {{ __('new.at_hq')}}<br>
( {{ __('new.until') .' '.date('d/m/Y')}} )<br></div>

				<table class="table table-bordered table-hover data table-export">
					<thead>
						<tr>
							<th width="3%"> {{ __('new.no') }} </th>
							<th> {{ __('new.state') }}  </th>
							<th> {{ __('new.filing_year') .' '.$start_year }} </th>
							<th> {{ __('new.filing_year') .' '.$end_year }}</th>
							<th> {{ __('new.differences') }}</th>
							<th> % </th>
						</tr>
					</thead>
					<tbody>
						@foreach( $states as $index => $state )
						<tr>
							<td>{{ $index+1 }}</td>
							<td style="text-align: left; text-transform: uppercase;">{{ $state->state }}</td>
							<td>
                                <a onclick="viewdrilldown({{ $state->state_id }}, {{ $start_year }})">
                                    {{ $template_states[$state->state_id]['old'] }}
                                </a>
                            </td>
							<td>
                                <a onclick="viewdrilldown({{ $state->state_id }}, {{ $end_year }})">
                                    {{ $template_states[$state->state_id]['new'] }}
                                </a>
                            </td>
							<td>
                                {{ $template_states[$state->state_id]['diff'] }}
                            </td>
							<td>
                                {{ $template_states[$state->state_id]['pct'] }}
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2">{{__('new.total')}}</td>
							<td> {{ $template_states['total']['old'] }} </td>
							<td> {{ $template_states['total']['new'] }}</td>
							<td> {{ $template_states['total']['diff'] }} </td>
							<td></td>
						</tr>
					</tfoot>
				</table>

			</div>
		</div>
	</div>
</div>
<div class="row hide-print">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">
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
                <h4 class="modal-title">{{ trans('new.report4') }}</h4>
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

<script src="{{ URL::to('//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<script src="{{ URL::to('/assets/global/plugins/Chart.min.js') }}"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
{{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
<!-- END PAGE LEVEL SCRIPTS -->

<script>
function exportPDF() {
    location.href = "{{ url('') }}/report/report4/export/pdf?{!! http_build_query(request()->input()) !!}";
}
function exportExcel() {
    location.href = "{{ url('') }}/report/report4/export/excel?{!! http_build_query(request()->input()) !!}";
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
            label: '{{ $start_year }}',
            data: [
                @foreach( $states as $index => $state )
                {{$template_states[$state->state_id]['new']}},
                @endforeach
            ],
            backgroundColor: 'rgba(255, 99, 132, 1)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
        },
        {
            label: '{{ $end_year }}',
            data: [
                @foreach( $states as $index => $state )
                {{$template_states[$state->state_id]['old']}},
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

    function viewdrilldown(state_id, year) {
        // $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form1?year={{Request::get('year')}}&month={{ Request::get('month')}}");
        $("#modalDiv").load("{{ url('/report/report4/viewdd/show') }}?state_id="+state_id+"&year="+year+"&start_year={{Request::get('start_year')}}&end_year={{ Request::get('end_year')}}");
    }
</script>

@endsection