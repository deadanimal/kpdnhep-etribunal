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
$locale = App::getLocale();
$month_lang = "abbrev_".$locale;
$total_state = 0;

?>
<body>
	
	  <h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.attendance_vsitor') }} {{ Request::get('year') ? Request::get('year') : date('Y') }}<br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>
	
		<table class="border collapse">
			<tr class="border">
				<th class="uppercase border center fit" rowspan="2"> {{ __('new.state') }} </th>
                <th class="uppercase border center fit" colspan="12"> {{ __('new.month') }} </th>
                <th class="uppercase border center fit" rowspan="2"> {{ __('new.total') }} </th>
			</tr>
			<tr>
                @foreach($months as $month)
                <th class="uppercase border center fit"> {{ $month->$month_lang }} </th>
                @endforeach
            </tr>	
            @foreach($states as $state)
                <?php
                    $visitor_state = (clone $visitor)->get()->where('state_id' , $state->state_id);
                    $total_state += count($visitor_state);
                ?>
            <tr>
                <td class="uppercase border center fit"> {{ $state->state_name }}</td>
            	@foreach($months as $month)
                    <?php
                    $visitor_state_month = (clone $visitor)->whereMonth('visitor_datetime',$month->month_id)->get()->where('state_id' , $state->state_id);        
                    ?>
                <td class="border center fit"> {{ count($visitor_state_month) }} </td>
                @endforeach
                <td class="border center fit"> {{ count($visitor_state) }} </td>
            </tr>
            @endforeach
            <tr>
               <td class="bold uppercase border center fit">{{__('new.total')}}</td>
                @foreach($months as $month)
                <?php
                    $visitor_month = (clone $visitor)->whereMonth('visitor_datetime',$month->month_id)->get();
                ?>
                <td class="bold uppercase border center fit"> {{ count($visitor_month) }}</td>
                @endforeach
                <td class="bold uppercase border center fit"> {{ $total_state }} </td>
            </tr>
		</table>
</body>