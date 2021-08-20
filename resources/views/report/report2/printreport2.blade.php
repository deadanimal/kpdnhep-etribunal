<head>
    <style>
        table {
            width: 100%;
            margin-top: 20px;
            padding: 5px;

        }
        td, th {
            font-family: serif !important;
            padding: 5px;
            font-size: 17px;
            line-height: 25px;
        }
        span, a, p, h1, h3 {
            font-family: serif !important;
        }
        span, a, p {
            font-size: 20px;
            line-height: 25px;
        }
        p {
            text-indent: 30px;
        }
        .collapse {
            border-collapse: collapse;
        }
        .underline {
            text-decoration-line: underline;
            text-decoration-style: dotted;
        }
        .justify {
            text-align: justify;
        }
        .bold {
            font-weight: bold;
        }
        .border {
            border: 1px solid black;
        }
        .borderbold {
            border: 2px solid black;
        }
        .uppercase {
            text-transform: uppercase;
        }
        .lowercase {
            text-transform: lowercase;
        }
        .italic {
            font-style: italic;
        }
        .camelcase {
            text-transform: capitalize;
        }
        .left {
            text-align: left;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .break {
            page-break-before: always;
            margin-top: 25px;
        }
        .divider {
            width: 5px;
            vertical-align: top;
        }
        .no-padding {
            padding: 0px;
        }
        .fit {
            max-width:1%;
            white-space:nowrap;
        }
        .absolute-center {
            margin: auto;
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
        }
        .top {
            vertical-align: top;
        }
        .center {
            text-align: center;
        }
        .parent {
            position: relative;
        }
        .child {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

</head>
<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = 'month_'.$locale;

$GLOBALS['total'] = $report2->sum('register');

function calcPercentage($val){
    if($GLOBALS['total'] == 0)
        return "0.0%";

    else {
        return number_format($val/$GLOBALS['total']*100, 1,'.','')."%";
    }
}

?>
<body>

<h3 class="center uppercase" id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}} <br>
    {{ __('new.report2_1') }} @if ( $month ){{ __('new.month') .' '.$month->$month_lang }}@endif {{ __('new.year') .' '.$year }} {{ __('new.report2_2')}} <br>
    ( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>

<table class="border collapse">
    <tr class="border">
        <th rowspan="3" class="border uppercase center fit" style="width: 5%"> {{ __('new.no') }} </th>
        <th rowspan="3" class="border uppercase fit"> {{ __('new.state') }}  </th>
        <th rowspan="3" class="border uppercase center fit"> {{ __('new.register') }} </th>
        <th colspan="2" class="border uppercase fit"> {{ __('new.claim_type') }} </th>
        <th colspan="4" class="border uppercase fit"> {{ __('new.form') }} </th>
        <th colspan="12" class="border uppercase fit"> {{ __('new.solution_method') }} </th>
        <th rowspan="3" class="border uppercase fit" style="width: 10%"> {!! __('new.total') !!}  </th>
        <th rowspan="3" class="border uppercase fit"> {{ __('new.reminder') }} </th>
    </tr>
    <tr>
        <th rowspan="2" class="border center fit"> B </th>
        <th rowspan="2" class="border center fit"> P </th>
        <th rowspan="2" class="border center fit"> B2 </th>
        <th rowspan="2" class="border center fit"> B3 </th>
        <th rowspan="2" class="border center fit"> B11 </th>
        <th rowspan="2" class="border center fit"> B12 </th>
        <th rowspan="2" class="border center fit"> NH </th>
        <th rowspan="2" class="border center fit"> TB </th>
        <th rowspan="2" class="uppercase border center fit"> {{ __('new.revoked_cancel')}} </th>
        <th colspan="2" class="uppercase border center fit"> {{ __('new.negotiation') }} </th>
        <th colspan="7" class="uppercase border center fit"> {{ __('new.hearing') }} </th>
    </tr>
    <tr>
        <th class="border center fit"> B6 </th>
        <th class="border center fit"> B9 </th>
        <th class="border center fit"> B5 </th>
        <th class="border center fit"> B7 </th>
        <th class="border center fit"> B8 </th>
        <th class="border center fit"> B10 </th>
        <th class="border center fit"> B10K </th>
        <th class="border center fit"> B10T </th>
        <th class="border center fit"> B10B </th>
    </tr>
    @foreach( $states as $index => $state )
        <?php
        $report = null;
        foreach($report2 as $rep) {
            if($rep->state_id == $state->state_id) {
                $report = $rep;
                break;
            }
        }

        // $report = null;
        // foreach($report2 as $rep) {
        //  	if($rep->state_id == $state->state_id) {
        //      	$report = $rep;
        //      	break;
        //     }
        //  }
        $report = (clone $report2)->where('state_id', $state->state_id);
        ?>
        <tr class="border">
            <td class="center fit"> {{$index+1}} </td>
            <td class="border center fit" style="text-align: left; text-transform: uppercase;"> {{ $state->state_name }} </td>
            <td class="border center fit"> {{ $report ? $report->register : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->b : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->p : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->f2 : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->f3 : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->f11 : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->f12 : '0' }} </td>
            <td class="border center fit">{{ $report ? $report->stop_notice : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->revoked : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->canceled : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f6 : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f9 : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f5 : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f7 : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f8 : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f10 : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f10k : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f10t : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->f10b : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->complete : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->balance : '0' }}</td>
            <td class="border center fit"> {{ $report ? $report->sum('register') : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->sum('b') : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->sum('p') : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->sum('f2') : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->sum('f3') : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->sum('f11') : '0' }} </td>
            <td class="border center fit"> {{ $report ? $report->sum('f12') : '0' }} </td>
            <td class="border center fit">{{ $report ? $report->sum('stop_notice') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('revoked') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('canceled') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f6') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f9') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f5') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f7') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f8') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f10') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f10k') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f10t') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('f10b') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('complete') : '0' }}</td>
            <td class="border center fit">{{ $report ? $report->sum('balance') : '0' }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2" class="border uppercase center fit">{{__('new.total')}}</td>
        <td class="border center fit"> {{ $report2->sum('register') }}</td>
        <td class="border center fit"> {{ $report2->sum('b') }}</td>
        <td class="border center fit"> {{ $report2->sum('p') }}</td>
        <td class="border center fit"> {{ $report2->sum('f2') }}</td>
        <td class="border center fit"> {{ $report2->sum('f3') }}</td>
        <td class="border center fit"> {{ $report2->sum('f11') }}</td>
        <td class="border center fit"> {{ $report2->sum('f12') }}</td>
        <td class="border center fit"> {{ $report2->sum('stop_notice') }}</td>
        <td class="border center fit"> {{ $report2->sum('revoked') }} </td>
        <td class="border center fit"> {{ $report2->sum('canceled') }}</td>
        <td class="border center fit"> {{ $report2->sum('f6') }}</td>
        <td class="border center fit"> {{ $report2->sum('f9') }}</td>
        <td class="border center fit"> {{ $report2->sum('f5') }}</td>
        <td class="border center fit"> {{ $report2->sum('f7') }}</td>
        <td class="border center fit"> {{ $report2->sum('f8') }}</td>
        <td class="border center fit"> {{ $report2->sum('f10') }}</td>
        <td class="border center fit"> {{ $report2->sum('f10k') }}</td>
        <td class="border center fit"> {{ $report2->sum('f10t') }}</td>
        <td class="border center fit"> {{ $report2->sum('f10b') }}</td>
        <td class="border center fit"> {{ $report2->sum('complete') }} </td>
        <td class="border center fit"> {{ $report2->sum('balance') }}</td>
    </tr>
    <tr>
        <td class="bold uppercase border center fit" colspan="2">{{__('new.percentage')}}</td>
        <td class="bold uppercase border center fit">100%</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('b')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('p')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f2')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f3')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f11')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f12')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('stop_notice')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('revoked')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('canceled')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f6')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f9')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f5')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f7')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f8')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f10')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f10k')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f10t')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('f10b')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('complete')) }}</td>
        <td class="bold uppercase border center fit">{{ calcPercentage($report2->sum('balance')) }}</td>
    </tr>
</table>
</body>
