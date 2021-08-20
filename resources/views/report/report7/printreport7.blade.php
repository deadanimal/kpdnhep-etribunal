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


?>
<body>

<h3 id='title'
    style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}
    <br>
    {{ __('new.award_type_year') .' '.$date_start .' - '.$date_end }} <br>
    ( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>

<table class="border collapse">
    <tr class="border">
        <th class="uppercase border center fit" width="3%"> {{ __('new.no') }} </th>
        <th class="uppercase border center fit"> {{ __('new.award_type') }}  </th>
        <th class="uppercase border center fit"> {{ __('new.total_complaints') }}</th>
        <th class="uppercase border center fit"> %</th>
    </tr>
    <?php
    $form5 = (clone $award_disobey)->where('award_type', 5);
    $form6 = (clone $award_disobey)->where('award_type', 6);
    $form7 = (clone $award_disobey)->where('award_type', 7);
    $form8 = (clone $award_disobey)->where('award_type', 8);
    $form9 = (clone $award_disobey)->where('award_type', 9);
    $form10 = (clone $award_disobey)->where('award_type', 10);
    ?>
    <tr>
        <td class="border center fit">1</td>
        <td class="border center fit" style="text-align: left;">{{ __('new.form5') }}</td>
        <td class="border center fit">{{ count($form5) }}</td>
        <td class="border center fit">
            @if (  count($award_disobey) != 0)
                {{ number_format ( count($form5) / count($award_disobey)*100, 2,'.','') }}
            @else
                0.00
            @endif
        </td>
    </tr>
    <tr>
        <td class="border center fit">2</td>
        <td class="border center fit" style="text-align: left;">{{ __('new.form6') }}</td>
        <td class="border center fit"><a onclick="viewComplaints(6)">{{ count($form6) }}</a></td>
        <td class="border center fit">
            @if (  count($award_disobey) != 0)
                {{ number_format ( count($form6) / count($award_disobey)*100, 2,'.','') }}
            @else
                0.00
            @endif
        </td>
    </tr>
    <tr>
        <td class="border center fit">3</td>
        <td class="border center fit" style="text-align: left;">{{ __('new.form7') }}</td>
        <td class="border center fit"><a onclick="viewComplaints(7)">{{ count($form7) }}</a></td>
        <td class="border center fit">
            @if (  count($award_disobey) != 0)
                {{ number_format ( count($form7) / count($award_disobey)*100, 2,'.','') }}
            @else
                0.00
            @endif
        </td>
    </tr>
    <tr>
        <td class="border center fit">4</td>
        <td class="border center fit" style="text-align: left;">{{ __('new.form8') }}</td>
        <td class="border center fit"><a onclick="viewComplaints(8)">{{ count($form8) }}</a></td>
        <td class="border center fit">
            @if (  count($award_disobey) != 0)
                {{ number_format ( count($form8) / count($award_disobey)*100, 2,'.','') }}
            @else
                0.00
            @endif
        </td>
    </tr>
    <tr>
        <td class="border center fit">5</td>
        <td class="border center fit" style="text-align: left;">{{ __('new.form9') }}</td>
        <td class="border center fit"><a onclick="viewComplaints(9)">{{ count($form9) }}</a></td>
        <td class="border center fit">
            @if (  count($award_disobey) != 0)
                {{ number_format ( count($form9) / count($award_disobey)*100, 2,'.','') }}
            @else
                0.00
            @endif
        </td>
    </tr>
    <tr>
        <td class="border center fit">6</td>
        <td class="border center fit" style="text-align: left;">{{ __('new.form10') }}</td>
        <td class="border center fit"><a onclick="viewComplaints()">{{ count($form10) }}</a></td>
        <td class="border center fit">
            @if (  count($award_disobey) != 0)
                {{ number_format ( count($form10) / count($award_disobey)*100, 2,'.','') }}
            @else
                0.00
            @endif
        </td>
    </tr>
    <tr>
        <td class="bold uppercase border center fit" colspan="2">{{__('new.total')}}</td>
        <td class="bold uppercase border center fit">{{ count($award_disobey) }}</td>
        <td class="bold uppercase border center fit">100</td>
    </tr>
</table>
</body>