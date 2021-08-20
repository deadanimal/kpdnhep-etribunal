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
                <td style="width:25%"><b> {{ trans('holiday.holiday_name') }} </b></td>
                <td>{{$holiday->holiday_name or ''}}</td>
            </tr>
            <tr> 
                <td style="width:25%"><b> {{ trans('holiday.holiday_date_start') }} </b></td>
                <td>{{ date('m/d/Y', strtotime($holiday->holiday_date_start)) }}</td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('holiday.holiday_date_end') }} </b></td>
                <td>{{ date('m/d/Y', strtotime($holiday->holiday_date_end)) }}</td>
            </tr>
            <tr>
                <td style="width:25%" rowspan="2"><b> {{ trans('holiday.region') }} </b></td>
                
                <td>
                    <div class="col-md-12">
                        <div class="md-checkbox-inline">
                        @foreach($region  as $r)
                            <div class="md-checkbox">
                                <input name="region[]" type="checkbox" id="region{{ $r->region_id}}" disabled="disabled" class="md-check required" value="{{$r->region_id }}">
                                <label for="region{{ $r->region_id }}">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ $r->region_name }} </label>
                            </div><br>
                        @endforeach
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                     <div class="col-md-5">
                        <div class="md-checkbox-inline">
                        <?php $countp=1; ?>
                        @foreach($state as $index => $r)
                        @if($countp <= 8)
                            <div class="md-checkbox">
                                <input name="state[]" type="checkbox" id="checkbox{{ $r->state_id}}" disabled="disabled" class="md-check required" value="{{$r->state_id }}">
                                <label for="checkbox{{ $r->state_id }}">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ $r->state_name }} </label>
                            </div><br>
                        @endif
                        <?php $countp++; ?>
                        @endforeach
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="md-checkbox-inline">
                        <?php $countp=1; ?>
                        @foreach($state as $index => $r)
                        @if($countp >= 9)
                            <div class="md-checkbox">
                                <input name="state[]" type="checkbox" id="checkbox{{ $r->state_id}}" disabled="disabled" class="md-check required" value="{{$r->state_id }}">
                                <label for="checkbox{{ $r->state_id }}">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ $r->state_name }} </label>
                            </div><br>
                        @endif
                        <?php $countp++; ?>
                        @endforeach
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script src="{{ URL::to('/assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
@foreach($holidaystate as $hs)
  var k = "{{$hs->state_id or ''}}";
  var abc = '#checkbox' + k;
    $(abc).prop('checked', true);
@endforeach
</script>

<script type="text/javascript">
@foreach($holidayregion as $hs)
  var k = "{{$hs->region_id or ''}}";
  var abc = '#region' + k;
    $(abc).prop('checked', true);
@endforeach
</script>