<?php
    use App\CaseModel\ClaimCase;
    $user_male = (clone $users)->where('gender_id', 1)->get();
    $user_female = (clone $users)->where('gender_id', 2)->get();
    $user_male = $user_male->filter(function ($value) {
        $case = ClaimCase::where('claim_case_id', $value->user_id)->get()->count();
        return $case > 0;
    });

    $user_female = $user_female->filter(function ($value) {
        $case = ClaimCase::where('claim_case_id', $value->user_id)->get()->count();
        return $case > 0;
    });

    $locale = App::getLocale();
    $age_lang = 'age_'.$locale;
    
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

    .second_header th {

        background-color: #E87E04 !important;
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
                <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.profile_claimant_year') .' '.$year }}<br>
( {{ __('new.until').' '.date('d/m/Y') }} )<br></div>

                <div class="table-scrollable">
                    <table class="table table-bordered table-hover data table-export">
                        <thead>
                            <tr>
                                <th width="3%" rowspan="2"> {{ __('new.no') }} </th>
                                <th rowspan="2"> {{ __('new.age') }}  </th>
                                @foreach ($states as $index => $state )
                                <th colspan="2" style="text-transform: uppercase;"> {{ $state->state_name }} </th>
                                @endforeach
                                <th colspan="2"> {{ __('new.total') }}</th>
                                <th rowspan="2"> {{ __('new.overall') }}</th>
                                <th rowspan="2"> {{ __('new.percentage') }}</th>
                            </tr>
                            <tr class="second_header">
                                @foreach ($states as $index => $state )
                                <th> {{ __('new.m')}} </th>
                                <th> {{ __('new.f') }} </th>
                                @endforeach
                                <th> {{ __('new.m') }} </th>
                                <th> {{ __('new.f') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ages as $index => $age)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td style="text-align: left;"> {{ $age->$age_lang }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=', $age->start_age)->where('age','<=', $age->end_age);
                                    $user_state_f = (clone $user_female)->where('age','>=',$age->start_age)->where('age','<=', $age->end_age);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                   
                                ?>
                                <td> {{ count($male_state) }} </td>
                                <td> {{ count($female_state) }}  </td>
                                @endforeach
                                <td> {{ count($user_state_m) }} </td>
                                <td> {{ count($user_state_f) }} </td>
                                <td> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td>
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">{{__('new.total')}}</td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $total_male_state = (clone $user_male)->where('user_public.address_state_id', $state->state_id);
                                    $total_female_state = (clone $user_female)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td> {{ count($total_male_state) }} </td>
                                <td> {{ count($total_female_state) }} </td>
                                @endforeach
                                <td> {{ count($user_male) }} </td>
                                <td> {{ count($user_female) }}</td>
                                <td> {{ count($user_male)+count($user_female) }} </td>
                                <td> 
                                    @if( count($user_male) > 0 || count($user_female) > 0) 100.00 
                                    @else 0.00
                                    @endif
                                </td>
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
        <a type="button" class="btn default" href='{{ route("report.list", ["page" => 3]) }}'>
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
                <h4 class="modal-title">{{ trans('new.report22') }}</h4>
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
    location.href = "{{ url('') }}/report/report22/export/pdf?{!! http_build_query(request()->input()) !!}";
}

function exportExcel() {
    location.href = "{{ url('') }}/report/report22/export/excel?{!! http_build_query(request()->input()) !!}";
}

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            "{{ __('new.less_than_20')}}",
            "21-25 {{ __('new.year')}}",
            "26-30 {{ __('new.year')}}",
            "31-35 {{ __('new.year')}}",
            "36-40 {{ __('new.year')}}",
            "41-45 {{ __('new.year')}}",
            "46-50 {{ __('new.year')}}",
            "51-55 {{ __('new.year')}}",
            "56-60 {{ __('new.year')}}",
            "61-65 {{ __('new.year')}}",
            "66-70 {{ __('new.year')}}",
            "71-75 {{ __('new.year')}}",
            "76-80 {{ __('new.year')}}",
            "81-85 {{ __('new.year')}}",
            "86-90 {{ __('new.year')}}",
            "91-95 {{ __('new.year')}}",
            "{{ __('new.no_record_age')}}"
        ],
        datasets: [{
            label: '{{ __("new.male")}}',
            data: [
            {{ count((clone $user_male)->where('age','>=', 1)->where('age','<=', 20)) }} ,
            {{ count((clone $user_male)->where('age','>=',21)->where('age','<=', 25)) }} ,
            {{ count((clone $user_male)->where('age','>=',26)->where('age','<=', 30)) }} ,
            {{ count((clone $user_male)->where('age','>=',31)->where('age','<=', 35)) }} ,
            {{ count((clone $user_male)->where('age','>=',36)->where('age','<=', 40)) }} ,
            {{ count((clone $user_male)->where('age','>=',41)->where('age','<=', 45)) }} ,
            {{ count((clone $user_male)->where('age','>=',46)->where('age','<=', 50)) }} ,
            {{ count((clone $user_male)->where('age','>=',51)->where('age','<=', 55)) }} ,
            {{ count((clone $user_male)->where('age','>=',56)->where('age','<=', 60)) }} ,
            {{ count((clone $user_male)->where('age','>=',61)->where('age','<=', 65)) }} ,
            {{ count((clone $user_male)->where('age','>=',66)->where('age','<=', 70)) }} ,
            {{ count((clone $user_male)->where('age','>=',71)->where('age','<=', 75)) }} ,
            {{ count((clone $user_male)->where('age','>=',76)->where('age','<=', 80)) }} ,
            {{ count((clone $user_male)->where('age','>=',81)->where('age','<=', 85)) }} ,
            {{ count((clone $user_male)->where('age','>=',86)->where('age','<=', 90)) }} ,
            {{ count((clone $user_male)->where('age','>=',91)->where('age','<=', 95)) }} ,
            {{ count((clone $user_male)->where('age', 0)) }}
            ],
            backgroundColor: 'rgba(255, 99, 132, 1)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
        },
        {
            label: '{{ __("new.female")}}',
            data: [
            {{ count((clone $user_female)->where('age','>=', 1)->where('age','<=', 20)) }} ,
            {{ count((clone $user_female)->where('age','>=',21)->where('age','<=', 25)) }} ,
            {{ count((clone $user_female)->where('age','>=',26)->where('age','<=', 30)) }} ,
            {{ count((clone $user_female)->where('age','>=',31)->where('age','<=', 35)) }} ,
            {{ count((clone $user_female)->where('age','>=',36)->where('age','<=', 40)) }} ,
            {{ count((clone $user_female)->where('age','>=',41)->where('age','<=', 45)) }} ,
            {{ count((clone $user_female)->where('age','>=',46)->where('age','<=', 50)) }} ,
            {{ count((clone $user_female)->where('age','>=',51)->where('age','<=', 55)) }} ,
            {{ count((clone $user_female)->where('age','>=',56)->where('age','<=', 60)) }} ,
            {{ count((clone $user_female)->where('age','>=',61)->where('age','<=', 65)) }} ,
            {{ count((clone $user_female)->where('age','>=',66)->where('age','<=', 70)) }} ,
            {{ count((clone $user_female)->where('age','>=',71)->where('age','<=', 75)) }} ,
            {{ count((clone $user_female)->where('age','>=',76)->where('age','<=', 80)) }} ,
            {{ count((clone $user_female)->where('age','>=',81)->where('age','<=', 85)) }} ,
            {{ count((clone $user_female)->where('age','>=',86)->where('age','<=', 90)) }} ,
            {{ count((clone $user_female)->where('age','>=',91)->where('age','<=', 95)) }} ,
            {{ count((clone $user_female)->where('age', 0)) }}
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
                    labelString: '{{ __("new.total_user")}}',
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
                    labelString: '{{ __("new.age_class")}}',
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