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

?>
<body>
	
	<h3 id='title' class="caption-subject uppercase bold center">{{ __('new.record_seminar') }} {{ __('new.year') .' '.$year }}</h3> 
	
		<table class="border collapse">
            <tr>
                <th class="bold uppercase border center">{{ __('new.state') }} / {{ __('new.branch') }} </th>
                <th class="bold uppercase border center">{{ __('new.total_seminar') }}</th>
                <th class="bold uppercase border center">{{ __('new.total_participant') }}</th>
            </tr>
			@foreach( $states as $state )

            <?php
                // dapatkan value bagi curren
                $val = (clone $record_seminar)->where('state_id', $state->state_id);
            ?>

            <tr align="border">
                <td class="uppercase border center">{{ $state->state_name }}</td>
                <td class="uppercase border center">{{ $val->get()->count() > 0 ?  $val->first()->total_seminar : '0'}}</td>
                <td class="uppercase border center">{{ $val->get()->count() > 0 ?  $val->first()->total_participant : '0'}}</td>
            </tr>
            @endforeach
		</table>
</body>