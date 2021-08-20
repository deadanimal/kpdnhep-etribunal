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

?>
<body>
	
	<h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.company_name_year')}} {{ __('new.on_year') .' '.$year.' '. __('new.based_state')}}<br>
( {{ __('new.until').' '.date('d/m/Y') }} )<br></h3>
	
		<table class="border collapse">
			<tr>
                <th class="bold uppercase border center fit"> {{ __('new.no') }} </th>
                <th class="bold uppercase border center"> {{ __('new.company_name') }}  </th>
                @foreach ($states as $state)
                <th class="rotate uppercase border" style="text-transform: uppercase;">
                    <div><span>{{ $state->state_name }} </span></div>
                </th>
                @endforeach
                <th class="bold uppercase border center fit"> {{ __('new.total') }}</th>
            </tr>
            @foreach ($view_report14 as $index => $report)
            <tr>
                <td class="border center fit">{{ $index+1 }}</td>
                <td class="uppercase border center fit">{{ $report->name }}</td>
                @foreach ($states as $state)
                <td class="uppercase border center fit"> {{ count((clone $view_report14_full)->where('state_id', $state->state_id)->where('user_id', $report->user_id)) }} </td>
                @endforeach
                <td class="uppercase border center fit">{{ count((clone $view_report14_full)->where('user_id', $report->user_id)) }}</td>          
            </tr>
            @endforeach      
            <tr>
                <td class="bold uppercase border center fit" colspan="2">{{__('new.total_all')}}</td>
                @foreach ($states as $state)
                <td class="bold uppercase border center fit"> {{ count((clone $view_report14_full)->where('state_id', $state->state_id)) }} </td>
                @endforeach
                <td class="bold uppercase border center fit"> {{ count($view_report14_full) }} </td>
            </tr>
		</table>
</body>