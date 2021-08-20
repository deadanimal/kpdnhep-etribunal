<head>
    <style>
        table {
            width: 100%;
            margin-top: 20px;
            padding: 5px;

        }

        th.rotate {
            /* Something you can count on */
            height: 250px;
            white-space: nowrap;
        }

        th.rotate > div {
            -moz-transform: translate(15px, 100px) rotate(270deg);
            -webkit-transform: translate(15px, 100px) rotate(270deg);
            -o-transform: translate(15px, 100px) rotate(270deg);
            -ms-transform: translate(15px, 100px) rotate(270deg);
            transform: /* Magic Numbers */ translate(15px, 100px) /* 45 is really 360 - 45 */ rotate(270deg);

            width: 10px;
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
            max-width: 1%;
            white-space: nowrap;
        }

        .absolute-center {
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
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
$month_lang = 'month_' . $locale;

?>
<body>

<h3 id='title'
    style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}
    <br>
    {{ __('new.report2_1')}} @if ( $month){{ __('new.month') .' '.$month->$month_lang }}@endif {{ __('new.year') .' '.$year }}
    <br>
    {{ __('new.report25')}}<br>
    ( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>

<table class="border collapse">
    <thead>
    <tr>
        <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.no') }} </th>
        <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.state') }} </th>
        <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.reg_case') }} </th>
        <th class="bold uppercase border center fit" colspan="7"> {{ __('new.type') }} </th>
        <th class="bold uppercase border center fit" rowspan="2"> {!! __('new.total_form') !!} </th>
        <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.reminder') }} </th>
    </tr>
    <tr>
        <th class="bold uppercase border center fit"> {!! __('new.stop_revoked') !!} </th>
        <th class="bold uppercase border center fit"> 5</th>
        <th class="bold uppercase border center fit"> 6</th>
        <th class="bold uppercase border center fit"> 7</th>
        <th class="bold uppercase border center fit"> 8</th>
        <th class="bold uppercase border center fit"> 9</th>
        <th class="bold uppercase border center fit"> 10</th>
    </tr>
    </thead>
    <tbody>
    @foreach ( $states as $index => $state )
        <?php
        $report = (clone $report25)->where('state_id', $state->state_id);
        ?>
        <tr>
            <td> {{ $index+1 }} </td>
            <td style="text-align: left; text-transform: uppercase;"> {{ $state->state_name }} </td>
            <td> {{ $report ? $report->sum('register') : '0' }} </td>
            <td>
                <a onclick="viewStopNotice( {{ $state->state_id }} )"> {{ $report ? $report->sum('revoked_stopnotice') : '0' }}  </a>
            </td>
            <td> {{ $report ? $report->sum('award5') : '0' }} </td>
            <td> {{ $report ? $report->sum('award6') : '0' }} </td>
            <td> {{ $report ? $report->sum('award7') : '0' }} </td>
            <td> {{ $report ? $report->sum('award8') : '0' }} </td>
            <td> {{ $report ? $report->sum('award9') : '0' }} </td>
            <td> {{ $report ? $report->sum('award10') : '0' }} </td>
            <td> {{ $report ? $report->sum('total') : '0' }} </td>
            <td> {{ $report ? $report->sum('balance') : '0' }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td class="bold uppercase border center fit" colspan="2">{{__('new.total')}}</td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('register') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('revoked_stopnotice') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('award5') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('award6') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('award7') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('award8') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('award9') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('award10') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('total') }} </td>
        <td class="bold uppercase border center fit"> {{ $report25->sum('balance') }} </td>
    </tr>
    </tfoot>
</table>
</body>