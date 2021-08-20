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
			border: 1px solid;
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
$month_lang = 'abbrev_'.$locale;
$month_list = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
?>
<body>
	
	 <h3 id='title' class="caption-subject uppercase bold center">{{ __('new.record_book') }} {{ __('new.year') .' '.$year }}</h3>     
	
		<table id="report10" class="border collapse">
  
                <thead align="center">
                    <th width="auto" >{{ __('new.state') }}</th>
                    @foreach($months as $month)
                        <th>
                            <div><span>{{ $month->$month_lang }} </span></div>
                        </th>
                    @endforeach
                    <th><center>{{ __('new.total')}}</center></th>
                </thead>
                <tbody align="center">
                    @foreach($states as $state)
                    <?php
                        $total = 0;
                         // dd($recordbooks->get());
                    ?>
                     <tr align="center">
                        <td style="vertical-align: middle;">{{ $state->state_name }}</td>
                        <?php
                            $val_state = (clone $recordbooks)->where('state_id', $state->state_id); 
                        ?>
                         @foreach( $months as $i => $month )
                         <?php
                            $val = $month_list[$i];
                            if($val_state->first())
                                $total += $val_state->first()->$val;
                        ?>
                        <td>
                            @if($val_state->first())
                                @if($val_state->first()->$val > 0)
                                    {{ $val_state->first()->$val }}
                                @else
                                    0
                                @endif
                            @else
                                0
                            @endif 
                        </td>
                        @endforeach
                        <td  style="vertical-align: middle;">{{ $total }} </td>
                    </tr>
                    @endforeach

                </tbody>

        </table>
</body>