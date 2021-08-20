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
$month_lang = 'month_'.$locale;
?>


<body>
	
	<h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}} <br>
{{ __('new.judicial_review_award') . ' '.$year }} @if( $month ){{ __('new.month').' '.$month->$month_lang }}@endif <br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>
	
		<table class="border collapse">
			<tr>
                <th class="bold border uppercase center fit"> {{ __('new.no') }} </th>
                <th class="bold border uppercase center fit"> {{ __('new.state') }}  </th>
                <th class="bold border uppercase center fit"> {{ __('new.total') }} </th>
            </tr>
                @foreach ($states as $index => $state)
                <?php
                   $juriview_state = (clone $judicial_review)->where('state_id', $state->state_id);
                ?>
            <tr>
                <td class="border center fit">{{ $index+1 }}</td>
                <td class="border uppercase center fit">{{ $state->state_name }}</td>
                <td class="border uppercase center fit">{{ count($juriview_state) }}</td>
                                
            </tr>
                @endforeach            

            <tr>
                <td class="bold border uppercase center fit" colspan="2">{{__('new.total')}}</td>
                <td class="bold border uppercase center fit">{{ count($judicial_review) }}</td>
            </tr>
		</table>
</body>