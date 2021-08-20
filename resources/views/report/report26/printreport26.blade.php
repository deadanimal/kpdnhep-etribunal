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
$month_lang = 'month_'.$locale;

?>
<body>
	
	   <h3 id='title' class="caption-subject uppercase bold center">{{ __('new.tribunal')}} <br>
{{ __('new.report26') }} @if ( $month ){{ __('new.month').' '.$month->$month_lang }}@endif {{ __('new.year') .' '.$year }}</h3> 

		<br>
		<br>
		<table class="border collapse">
				<tr>
                    <th class="bold uppercase border center fit"> {{ __('new.branch') }} </th>
                    <th class="bold uppercase border center fit"> {{ __('new.country') }}  </th>
                    <th class="bold uppercase border center fit"> {{ __('new.total_noncitizen') }} </th>
                </tr>
                @foreach ( $report26 as $report )
                <tr>
                    <td class="uppercase border center fit" style="text-align: left; text-transform: uppercase;"> {{ $report->branch }}</td>
                    <td class="uppercase border center fit" style="text-align: left; text-transform: uppercase;"> {{ $report->country }} </td>
                    <td class="uppercase border center fit">{{ $report->noncitizen }}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="bold uppercase border center fit" colspan="2">{{ __('new.total') }}</td>
                    <td class="bold uppercase border center fit">{{ $report26->sum('noncitizen') }}</td>
                </tr>
		</table>
</body>