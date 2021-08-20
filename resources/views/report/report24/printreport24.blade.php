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
$total_state = 0;

?>
<body>
	
	  <h3 id='title' class="caption-subject uppercase bold center">{{ __('new.record_entry_call') }} {{ __('new.year') .' '.$year }}
            </h3>
	
		<table class="border collapse">
			<th width="auto" class="bold uppercase border center" >{{ __('new.month') }}</th>
                @if(count($states) > 1)
                	@foreach ($states as $state)
            <th class="rotate uppercase border" style="text-transform: uppercase;">
                <div><span>{{ $state->state_name }} </span></div>
            </th>
                	@endforeach
                @else
                	@foreach ($states as $state)
            <th width="auto" class="bold uppercase border center" >{{ $state->state_name }}</th>
                	@endforeach
                @endif
                @if(request()->state == 0)
            <th class="bold uppercase border center"><center>{{ __('new.total')}}</center></th>
                @endif

                @foreach( $months as $month )
                <?php
                     $inquiry_month = (clone $inquiries)->whereMonth('created_at', $month->month_id)->get();
                     //dd(count($inquiries));
                ?>

            <tr>
                <td class="uppercase border center">{{ $month->$month_lang }}</td>
                @foreach($states as $state)
                    <?php
                        $inquiry_state = (clone $inquiry_month)->where('state_id', $state->state_id);
                        $total_state += count($inquiry_state);
                    ?>
                <td class="uppercase border center">{{ count($inquiry_state) }}</td>
                @endforeach
                @if(request()->state == 0)
                <td class="uppercase border center">{{ count($inquiry_month) }}</td>
                @endif
            </tr>
                @endforeach
		</table>
</body>