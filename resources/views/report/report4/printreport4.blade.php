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
$total_diff=0;
$total_percentage=0;

?>
<body>
	
	<h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.differences_year')}} {{ __('new.between_year') .' '.$start_year.' '. __('new.and') .' '.$end_year.' '. __('new.at_2')}} {{ __('new.at_hq')}}<br>
( {{ __('new.until') .' '.date('d/m/Y')}} )<br></h3>
	
		<table class="border collapse">
			<tr class="border">
				<th class="uppercase border center fit" width="3%"> {{ __('new.no') }} </th>
				<th class="uppercase border center fit"> {{ __('new.state') }}  </th>
				<th class="uppercase border center fit"> {{ __('new.filing_year') .' '.$start_year }} </th>
				<th class="uppercase border center fit"> {{ __('new.filing_year') .' '.$end_year }}</th>
				<th class="uppercase border center fit"> {{ __('new.differences') }}</th>
				<th class="uppercase border center fit"> % </th>
			</tr>
			@foreach( $states as $index => $state )

				<?php
					$case1_state = (clone $case1)->where('state_id', $state->state_id);
					$case2_state = (clone $case2)->where('state_id', $state->state_id);
					$total_diff += (count($case2_state)-count($case1_state));
					if(count($case1)+count($case2))
						$percentage = number_format ((count($case2_state)+count($case1_state)) / (count($case1)+count($case2))*100, 2,'.','');
					else
						$percentage = 0.00;

					$total_percentage += $percentage;
				?>
            <tr> 
                <td class="border center fit">{{ $index+1 }}</td>
				<td class="border center fit" style="text-align: left; text-transform: uppercase;">{{ $state->state_name }}</td>
				<td class="border center fit"> {{ count($case1_state) }} </td>
				<td class="border center fit"> {{ count($case2_state) }} </td>
				<td class="border center fit"> {{ count($case2_state)-count($case1_state) }} </td>
				<td class="border center fit"> {{ $percentage }}</td>	
            </tr>                       
            @endforeach                                          
            <tr>
                <td class="bold uppercase border center fit" colspan="2">{{__('new.total')}}</td>
				<td class="bold uppercase border center fit"> {{ count($case1) }} </td>
				<td class="bold uppercase border center fit"> {{ count($case2) }} </td>
				<td class="bold uppercase border center fit"> {{ $total_diff }} </td>
				<td class="bold uppercase border center fit"> {{ $total_percentage }}</td>           
            </tr>
		</table>
</body>