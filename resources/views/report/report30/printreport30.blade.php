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
$locale = App::getLocale();
$month_lang = "month_".$locale;
?>
<body>
	
	  <h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal') }} <br>
{{ __('new.report30') .' '.__('new.on') }} @if( $month ){{ __('new.month') .' '. $month->$month_lang }}@endif {{ __('new.year') .' '. $year }} {{ __('new.at_2').' '.__('new.at_hq') }} <br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>
	
		<table class="border collapse">
						<tr>
                            <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.no') }} </th>
                            <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.state')}} </th>
                            <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.total_filings')}} </th>
                            <th class="bold uppercase border center fit" colspan="2"> {{ __('new.filing_method')}} </th>
                        </tr>
                        <tr>
                            <th class="bold uppercase border center fit"> {!! __('new.online_counter') !!} </th>
                            <th class="bold uppercase border center fit"> {!! __('new.online_not_counter') !!} </th>
                        </tr>
                        @foreach ($states as $index=>$state)
                        <?php
                            $case_state =(clone $claimcases)->get()->where('state_id', $state->state_id);
                            $online_counter_state = (clone $claimcases)->whereRaw('claim_case.created_by_user_id = claim_case.claimant_user_id')->get()->where('state_id', $state->state_id);
                            $online_notcounter_state = (clone $claimcases)->whereRaw('claim_case.created_by_user_id != claim_case.claimant_user_id')->get()->where('state_id', $state->state_id);

                            $online_counter = (clone $claimcases)->whereRaw('claim_case.created_by_user_id = claim_case.claimant_user_id')->get();
                            $online_notcounter = (clone $claimcases)->whereRaw('claim_case.created_by_user_id != claim_case.claimant_user_id')->get();

                        ?>
                        <tr>
                            <td class="uppercase border center fit"> {{ $index+1 }} </td>
                            <td class="uppercase border center fit" style="text-align: left; text-transform: uppercase;">{{ $state->state_name }}</td>
                            <td class="uppercase border center fit"> {{ count($case_state) }} </td>
                            <td class="uppercase border center fit"> {{ count($online_counter_state) }} </td>
                            <td class="uppercase border center fit"> {{ count($online_notcounter_state) }} </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="bold uppercase border center fit" colspan="2"> {{ __('new.total')}}</td>
                            <td class="bold uppercase border center fit"> {{ count($claimcases->get()) }}</td>
                            <td class="bold uppercase border center fit"> {{ count($online_counter) }} </td>
                            <td class="bold uppercase border center fit"> {{ count($online_notcounter) }}</td>
                        </tr>
                        <tr>
                            <td class="bold uppercase border center fit" colspan="2"> {{ __('new.percentage')}}</td>
                            <td class="bold uppercase border center fit"> @if( count($claimcases->get()) != 0 ) 100.00 @else 0.00 @endif %</td>
                            <td class="bold uppercase border center fit"> @if( count($claimcases->get()) != 0 ) {{ number_format ( count($online_counter)/count($claimcases->get())*100, 2,'.','') }} @else 0.00 @endif %</td>
                            <td class="bold uppercase border center fit"> @if( count($claimcases->get()) != 0 ) {{ number_format ( count($online_notcounter)/count($claimcases->get())*100, 2,'.','') }} @else 0.00 @endif %</td>
                        </tr>
		</table>
</body>