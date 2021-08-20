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
    {{ __('new.award_disobey_for') .' '. __('new.year') .' '.$year.' '.__('new.by_prez') }}<br>
    ( {{ __('new.until') .' '.date('d/m/Y') }} )<br>
</h3>

<table class="border collapse">
    <tr class="border">
        <th class="uppercase border center fit" rowspan="3"> {{ __('new.no') }}</th>
        <th class="uppercase border center fit" rowspan="3"> {{ __('new.state') }} </th>
        <th class="uppercase border center fit" colspan="{{ count($presidents) }}"> {{ __('new.president') }} </th>
        <th class="uppercase border center fit" rowspan="3"> {!! __('new.total_disobey') !!} </th>
        <th class="uppercase border center fit" rowspan="3"> {{ __('new.percentage') }} </th>
        <th class="uppercase border center fit" rowspan="3"> {!! __('new.total_filed_completed') !!} </th>
        <th class="uppercase border center fit" rowspan="3"> {!! __('new.claim_remainder') !!} </th>
    </tr>
    <tr>
        <?php $i = 0; ?>
        @foreach ($presidents as $prez)
            @if($prez->user->ttpm_data->president->is_appointed != 0)
                <th class="border center fit" rowspan="2">
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
        <th class="border center fit" colspan="{{ $i }}"> {{ __('new.body')}} </th>
    </tr>
    <tr>
        @foreach ($presidents as $index => $prez)
            @if($prez->user->ttpm_data->president->is_appointed != 1)
                <th class="border center fit">
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
    @foreach( $states as $index => $state )
        <?php
        $award_state = (clone $award_disobey)->with(['form4'])->get()->where('form4.state_id', $state->state_id);

        $case_state = (clone $case_completed)->filter(function ($value) use ($state) {
            return $value->form4->case->branch->branch_state_id == $state->state_id;
        });

        ?>
        <tr>
            <td class="border center fit"> {{ $index+1 }} </td>
            <td class="border center fit"
                style="text-align: left; text-transform: uppercase;"> {{ $state->state_name }} </td>
            @foreach ($presidents as $prez)
                @if($prez->user->ttpm_data->president->is_appointed != 0)
                    <?php
                    $award_prez = (clone $award_state)->where('president_user_id', $prez->user_id);
                    ?>
                    <td class="border center fit"> {{ count($award_prez) }} </td>
                @endif
            @endforeach
            @foreach ($presidents as $prez)
                @if($prez->user->ttpm_data->president->is_appointed == 0)
                    <?php
                    $award_prez = (clone $award_state)->where('president_user_id', $prez->user_id);
                    ?>
                    <td class="border center fit"> {{ count($award_prez) }} </td>
                @endif
            @endforeach
            <td class="border center fit"> {{ count($award_state) }} </td>
            <td class="border center fit">
                @if ( count($award_disobey->get()) >0 )
                    {{ (number_format( (count($award_state)/count($award_disobey->get()))*100 ,2,'.',',')) }}
                @else 0.00
                @endif
            </td>
            <td class="border center fit"> {{ count($case_state) }} </td>
            <td class="border center fit"> {{ count($award_state) - count($case_state) }} </td>
        </tr>
    @endforeach
    <tr>
        <td class="bold uppercase border center fit" colspan="2"> {{ __('new.total') }} </td>
        @foreach ($presidents as $prez)
            @if($prez->user->ttpm_data->president->is_appointed != 0)
                <?php
                $prez = (clone $award_disobey)->get()->where('president_user_id', $prez->user_id);
                ?>
                <td class="bold uppercase border center fit"> {{ count($prez) }} </td>
            @endif
        @endforeach
        @foreach ($presidents as $prez)
            @if($prez->user->ttpm_data->president->is_appointed == 0)
                <?php
                $prez = (clone $award_disobey)->get()->where('president_user_id', $prez->user_id);
                ?>
                <td class="bold uppercase border center fit"> {{ count($prez) }} </td>
            @endif
        @endforeach
        <td class="bold uppercase border center fit"> {{ count($award_disobey->get()) }} </td>
        <td class="bold uppercase border center fit"> 100.00</td>
        <td class="bold uppercase border center fit"> {{ count($case_completed) }} </td>
        <td class="bold uppercase border center fit"> {{ count( $award_disobey->get() ) - count($case_completed) }} </td>
    </tr>
</table>
</body>