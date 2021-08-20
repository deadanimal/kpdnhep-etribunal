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
    	transform: 
    	/* Magic Numbers */
    	translate(15px, 100px)
    	/* 45 is really 360 - 45 */
    	rotate(270deg);

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

?>
<body>
	
	 <h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}} <br>
{{ __('new.report32') }} 
@if ( $month ){{ __('new.month') .' '.$month->$month_lang }}@endif {{ __('new.year') .' '.$year }}<br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>
	
		<table class="border collapse">
						<tr>
                            <th class="bold uppercase border center fit" width="3%" rowspan="2"> {{ __('new.no') }} </th>
                            <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.state') }}  </th>
                            <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.register') }} </th>
                            <th class="bold uppercase border center fit" colspan="4"> {{ __('new.award') }} </th>
                            <th class="bold uppercase border center fit" rowspan="2"> {!! __('new.total_finish_with_award') !!}  </th>
                        </tr>
                        <tr>
                            <th class="bold uppercase border center fit"> 5 </th>
                            <th class="bold uppercase border center fit"> 7 </th>
                            <th class="bold uppercase border center fit"> 8 </th>
                            <th class="bold uppercase border center fit"> 10 </th>                       
                        </tr>
                        @foreach( $states as $index => $state )
                        <?php
                            $case_state =(clone $cases)->get()->where('state_id', $state->state_id);
                            $award = (clone $cases)->get()->where('state_id', $state->state_id);

                            $award_state = (clone $award)->filter(function ($value) {
                                if( count($value->form4) > 0 )
                                    if ($value->form4->last()->award)
                                        if($value->form4->last()->award_id != 6 && $value->form4->last()->award_id != 9 )
                                        return $value->form4;
                           });

                            $award_amount = (clone $cases)->get()->filter(function ($value) {
                                if( count($value->form4) > 0 )
                                    if ($value->form4->last()->award)
                                        return $value->form4;
                           });

                            $award5_state = (clone $award)->where('award_type', 5);
                            $award7_state = (clone $award)->where('award_type', 7);
                            $award8_state = (clone $award)->where('award_type', 8);
                            $award10_state = (clone $award)->where('award_type', 10);

                            $award5 = (clone $cases)->get()->where('award_type', 5);
                            $award7 = (clone $cases)->get()->where('award_type', 7);
                            $award8 = (clone $cases)->get()->where('award_type', 8);
                            $award10 = (clone $cases)->get()->where('award_type', 10);

                        ?>
                        <tr>
                            <td class="uppercase border center fit"> {{$index+1}} </td>
                            <td style="text-align: left; text-transform: uppercase;"> {{ $state->state }}</td>
                            <td class="uppercase border center fit"> {{ count($case_state) }} </td>
                            <td class="uppercase border center fit"> {{ count($award5_state) }} </td>
                            <td class="uppercase border center fit"> {{ count($award7_state) }} </td>
                            <td class="uppercase border center fit"> {{ count($award8_state) }} </td>
                            <td class="uppercase border center fit"> {{ count($award10_state) }} </td>
                            <td class="uppercase border center fit"> {{ count($award_state) }} </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="bold uppercase border center fit" colspan="2">{{__('new.total')}} ({{__('new.percentage')}})</td>
                            <td class="bold uppercase border center fit"> {{ count($cases->get()) }} (100%) </td>
                            <td class="bold uppercase border center fit"> {{ count($award5) }} (@if( count($award_amount) > 0 ) {{ (number_format(count($award5)/count($award_amount)*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                            <td class="bold uppercase border center fit"> {{ count($award7) }} (@if( count($award_amount) > 0 ) {{ (number_format(count($award7)/count($award_amount)*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                            <td class="bold uppercase border center fit"> {{ count($award8) }} (@if( count($award_amount) > 0 ) {{ (number_format(count($award8)/count($award_amount)*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                            <td class="bold uppercase border center fit"> {{ count($award10) }} (@if( count($award_amount) > 0 ) {{ (number_format(count($award10)/count($award_amount)*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                            <td class="bold uppercase border center fit"> {{ count($award_amount) }} (@if( count($cases->get()) > 0 ) {{ (number_format(count($award_amount)/count($cases->get())*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                        </tr>
		</table>
</body>