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

?>
<body>
	
	 <h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.total_claim_finish')}} {{ $day }} {{ __('new.day')}}
{{ __('new.from_start_hearing_date')}} {{ $year }} @if( $month ){{ __('new.month').' '.$month->$month_lang }}@endif <br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>
	
		<table class="border collapse">
			<tr class="border">
				<th class="uppercase border center fit" width="3%"> {{ __('new.no') }} </th>
                <th class="uppercase border center fit"> {{ __('new.state') }}  </th>
                <th class="uppercase border center fit"> {!! __('new.total_filings') !!}</th>
                <th class="uppercase border center fit"> {!! __('new.total_finish_before') !!} {{ $day }} {{ __('new.day')}}</th>
                <th class="uppercase border center fit"> {!! __('new.total_finish_after') !!} {{ $day }} {{ __('new.day')}}</th>
			</tr>
			@foreach( $states as $index => $state )
				<?php
					$case_state = (clone $report5)->where('state_id', $state->state_id);
                    $case_completed_before = (clone $case_state)->where('days_completed', '<=', $day);
                    $case_completed_after = (clone $case_state)->where('days_completed', '>=', $day);
				?>
            <tr> 
                <td class="border center fit">{{ $index+1 }}</td>
                <td class="border center fit" style="text-align: left; text-transform: uppercase;">{{ $state->state }}</td>
                <td class="border center fit">{{ $case_state->count() }}</td>
                <td class="border center fit">{{ $case_completed_before->count() }}</td>
                <td class="border center fit">{{ $case_completed_after->count() }}</td>
            </tr>                       
            @endforeach  
             	<?php
                    $case_completed_before = (clone $report5)->where('days_completed', '<=', $day);
                    $case_completed_after = (clone $report5)->where('days_completed', '>=', $day);
            	?>                                        
            <tr>
                <td class="bold uppercase border center fit" colspan="2">{{__('new.total')}}</td>
                <td class="bold uppercase border center fit">{{ $report5->count() }} (100%)</td>
                <td class="bold uppercase border center fit">{{ $case_completed_before->count() }} ( @if( $report5->count() > 0 ){{ number_format ( $case_completed_before->count()/$report5->count()*100, 2,'.','') }}@else 0.00 @endif %)
                </td>
                <td class="bold uppercase border center fit">{{ $case_completed_after->count() }} (@if( $report5->count() != 0 ){{ number_format ( $case_completed_after->count()/$report5->count()*100, 2,'.','') }}@else 0.00 @endif %)
                </td>         
            </tr>
		</table>
</body>