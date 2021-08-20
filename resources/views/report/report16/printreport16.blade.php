<?php
$locale = App::getLocale();
$month_lang = "month_".$locale;
$classification_lang = "classification_".$locale;
$category_lang = "category_".$locale;

$total = 0;
$dualtotal = 0;
$a = 1;

function getTitle() {
	$locale = App::getLocale();
	$category_lang = "category_".$locale;

    $title = __('new.tribunal').'<br>'.__('new.claim_category').' ';

    if( request()->get('category') > 0 ) {
        $title .= "(".(\App\MasterModel\MasterClaimCategory::find(request()->get('category'))->$category_lang).") ";
    }

    $title .= __('new.filed_each_state').'<br>'.__('new.year').' '.(request()->get('year') ? request()->get('year') : date('Y')).' ';

    if( request()->get('month') > 0 ) {
        $title .= __('new.month').' '.request()->get('month');
    }

    $title .= "<br>( ".__('new.until').' '.date('d/m/Y')." )";

    return strtoupper($title);    
}
?>

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
    	-moz-transform: translate(5px, 100px) rotate(270deg);
    	-webkit-transform: translate(5px, 100px) rotate(270deg);
    	-o-transform: translate(5px, 100px) rotate(270deg);
    	-ms-transform: translate(5px, 100px) rotate(270deg);
    	transform: 
    	/* Magic Numbers */
    	translate(5px, 100px)
    	/* 45 is really 360 - 45 */
    	rotate(270deg);

    	width: 20px;
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
<body>
	
	   <h3 style="text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                    {!! getTitle() !!}<br><br>
                </h3>
	
		<table class="border collapse">
			<tr>
                <th class="bold uppercase border center fit"> {{ __('new.no') }} </th>
                <th class="bold uppercase border center fit"> {{ __('inquiry.claim_classification') }} </th>
                @foreach ($states as $state)
                <th class="bold uppercase border center rotate">
                <div><span>{{ $state->state_name }} </span></div>
                </th>
                @endforeach
                <th class="bold uppercase border center fit"> {{ __('new.total') }} </th>
                <th class="bold uppercase border center fit"> % </th>
            </tr>
                @foreach($classifications as $index => $classification)
                    <?php
                        $case_class = (clone $case)->where('classification_id', $classification->claim_classification_id);
                    ?>
            <tr>
                <td class="uppercase border center">{{ $a++ }}</td>
                <td class="uppercase border" style="text-align: left; text-transform: uppercase;"> {{ $classification->$classification_lang }}</td>
                	@foreach($states as $state)
                    <?php
                        $class_state = (clone $case_class)->where('state_id', $state->state_id);
                        $total += count($class_state);
                    ?>
                <td class="uppercase border center"> {{ count($class_state) }} </td>
                	@endforeach
                <td class="uppercase border center"> {{ count($case_class) }} </td>
                <td class="uppercase border center"> @if(count($case) > 0)
                    {{ number_format( count($case_class)/count($case)*100, 2,'.',',') }}%
                    @else
                    0
                    @endif </td>
            </tr>
                @endforeach
            <tr>
                <td colspan="2" class="uppercase border center bold">{{__('new.total')}}</td>
                @foreach($states as $state)
                    <?php
                        $state_count = (clone $case)->where('state_id', $state->state_id);
                    ?>
                <td class="uppercase border center bold">{{ count($state_count) }}</td>
                @endforeach
                <td class="uppercase border center bold">{{ $total }}</td>
                <td class="uppercase border center bold">100%</td>
            </tr>
		</table>
</body>