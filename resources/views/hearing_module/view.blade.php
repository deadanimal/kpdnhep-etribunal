<link href="{{ URL::to('/assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .sweet-overlay{z-index:50000;}.sweet-alert{z-index:50001;}  .swal-modal{z-index:50002;}
    .hardleft {left: 0px!important;
        top: 0px!important;
        align-content: center;
        position: relative!important;   
        max-height: 400px;
        min-height: 400px;
        max-width: 240px;
        min-width: 240px;}

    input[disabled="disabled"] {
        pointer-events: none;
    }
</style>
<div class="portlet-body">
    <table class="table table-striped table-bordered table-advance table-hover">
       <tbody>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.president_name') }} </b></td>
                <td>{{$schedule->president->name or ''}}</td>
            </tr>
            <tr> 
                <td style="width:25%"><b> {{ trans('hearing.state') }} </b></td>
                <td>{{$schedule->state->state or ''}}</td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.ttpm_branch') }} </b></td>
                <td>{{$schedule->branch->branch_name or ''}}</td>            </tr>
            <tr> 
                <td style="width:25%"><b>{{ trans('hearing.place_hearing') }} </b></td>
                <td>{{$schedule->hearing_room->venue->hearing_venue or ''}}</td>
            </tr>
            <tr> 
                <td style="width:25%"><b>{{ trans('hearing.hearing_room') }} </b></td>
                <td>{{$schedule->hearing_room->hearing_room or ''}}</td>
            </tr>
            <tr> 
                <td style="width:25%"><b>{{ trans('hearing.hearing_date') }} </b></td>
                <td>{{ date('d/m/Y', strtotime(strtr($schedule->hearing_date, '-', '/'))) }}</td>
            </tr>
            <tr> 
                <td style="width:25%"><b>{{ trans('hearing.time') }} </b></td>
                <td>{{ date('h:i a', strtotime($schedule->hearing_time)) }}</td>
            </tr>
        </tbody>
    </table>
</div>
<script src="{{ URL::to('/assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>
