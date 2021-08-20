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
	
	  <h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.ttpm_assmbly')}} @if ($month){{ __('new.for'). ' '.__('new.month') .' '.$month->$month_lang}}@else {{ __('new.throughout')}}@endif {{ __('new.year') .' '.$year }}<br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></h3>
	
		<table class="border collapse">
			<tr>
                <th class="bold uppercase border center fit"> {{ __('new.no') }} </th>
                <th class="bold uppercase border center fit"> {{ __('new.location') }} </th>
                @foreach ($presidents as $prez )
                <th class="bold uppercase border center fit"> 
                    @if( $prez->user->ttpm_data )
                        @if( $prez->user->ttpm_data->president )
                            @if( $prez->user->ttpm_data->president->president_code )
                                {{ $prez->user->ttpm_data->president->president_code }} 
                            @endif
                        @endif
                    @else "-"
                    @endif
                </th>
                @endforeach
                <th class="bold uppercase border center fit"> {{ __('new.total') }}</th>                                
            </tr>
                @foreach ( $rooms as $index => $room)
            <tr>
                <td class="uppercase border center fit"> {{ $index+1 }} </td>
                <td class="uppercase border center fit" style="text-align: left; text-transform: uppercase;"> {{ $room->venue->hearing_venue.' - '.$room->hearing_room }} </td>
                @foreach ($presidents as $prez )
                    <?php
                        $hearing_room = (clone $hearing)->where('hearing_room_id', $room->hearing_room_id);
                        $hearing_prez = (clone $hearing_room)->where('president_user_id', $prez->user_id);
                    ?>
                <td class="uppercase border center fit"> {{ count($hearing_prez) }} </td>
                @endforeach
                <td class="uppercase border center fit"> {{ count($hearing_room) }} </td>
            </tr>
                @endforeach
            <tr>
                <td class="bold uppercase border center fit" colspan="2"> {{ __('new.total') }} </td>
                @foreach ($presidents as $prez )
                    <?php
                        $prez = (clone $hearing)->where('president_user_id', $prez->user_id);
                    ?>
                <td class="bold uppercase border center fit"> {{ count($prez) }} </td>
                @endforeach
                <td class="bold uppercase border center fit"> {{ count($hearing) }} </td>
            </tr>
		</table>
</body>