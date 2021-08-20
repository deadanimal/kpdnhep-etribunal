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
$user_male = (clone $users)->where('gender_id', 1)->get();
$user_female = (clone $users)->where('gender_id', 2)->get();


?>
<body>
	
	  <h3 id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.profile_claimant_year') .' '.$year }}<br>
( {{ __('new.until').' '.date('d/m/Y') }} )<br></h3>
	
		<table class="border collapse">
							<tr>
                                <th class="bold uppercase border center fit" width="3%" rowspan="2"> {{ __('new.no') }} </th>
                                <th class="bold uppercase border center fit" rowspan="2"> {{ __('new.age') }}  </th>
                                @foreach ($states as $index => $state )
                                <th class="bold uppercase border center fit bold" colspan="2" style="text-transform: uppercase;"> {{ $state->state_name }} </th>
                                @endforeach
                                <th class="bold uppercase border center fit bold" colspan="2"> {{ __('new.total') }}</th>
                                <th class="bold uppercase border center fit bold" rowspan="2"> {{ __('new.overall') }}</th>
                                <th class="bold uppercase border center fit bold" rowspan="2"> {{ __('new.percentage') }}</th>
                            </tr>
                            <tr class="second_header">
                                @foreach ($states as $index => $state )
                                <th class="bold uppercase border center fit"> {{ __('new.m')}} </th>
                                <th class="bold uppercase border center fit"> {{ __('new.f') }} </th>
                                @endforeach
                                <th class="bold uppercase border center fit"> {{ __('new.m') }} </th>
                                <th class="bold uppercase border center fit"> {{ __('new.f') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td class="uppercase border center fit">1</td>
                                <td class="uppercase border center fit" style="text-align: left;"> {{ __('new.less_than_20') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','<=',20);
                                    $user_state_f = (clone $user_female)->where('age','<=',20);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                   
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }}  </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">2</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 21-25 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    
                                    $user_state_m = (clone $user_male)->where('age','>=',21)->where('age','<=', 25);
                                    $user_state_f = (clone $user_female)->where('age','>=',21)->where('age','<=', 25);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">3</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 26-30 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    
                                    $user_state_m = (clone $user_male)->where('age','>=',26)->where('age','<=', 30);
                                    $user_state_f = (clone $user_female)->where('age','>=',26)->where('age','<=', 30);

                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }}  </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">4</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 31-35 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',31)->where('age','<=', 35);
                                    $user_state_f = (clone $user_female)->where('age','>=',31)->where('age','<=', 35);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit" class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">5</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 36-40 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',36)->where('age','<=', 40);
                                    $user_state_f = (clone $user_female)->where('age','>=',36)->where('age','<=', 40);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">6</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 41-45 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',41)->where('age','<=', 45);
                                    $user_state_f = (clone $user_female)->where('age','>=',41)->where('age','<=', 45);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">7</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 46-50 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',46)->where('age','<=', 50);
                                    $user_state_f = (clone $user_female)->where('age','>=',46)->where('age','<=', 50);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">8</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 51-55 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',51)->where('age','<=', 55);
                                    $user_state_f = (clone $user_female)->where('age','>=',51)->where('age','<=', 55);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">9</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 56-60 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',56)->where('age','<=', 60);
                                    $user_state_f = (clone $user_female)->where('age','>=',56)->where('age','<=', 60);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">10</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 61-65 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',61)->where('age','<=', 65);
                                    $user_state_f = (clone $user_female)->where('age','>=',61)->where('age','<=', 65);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);

                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">11</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 66-70 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',66)->where('age','<=', 70);
                                    $user_state_f = (clone $user_female)->where('age','>=',66)->where('age','<=', 70);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">12</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 71-75 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',71)->where('age','<=', 75);
                                    $user_state_f = (clone $user_female)->where('age','>=',71)->where('age','<=', 75);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">13</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 76-80 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    
                                    $user_state_m = (clone $user_male)->where('age','>=',76)->where('age','<=', 80);
                                    $user_state_f = (clone $user_female)->where('age','>=',76)->where('age','<=', 80);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">14</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 81-85 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',81)->where('age','<=', 85);
                                    $user_state_f = (clone $user_female)->where('age','>=',81)->where('age','<=', 85);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">15</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 86-90 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age','>=',86)->where('age','<=', 90);
                                    $user_state_f = (clone $user_female)->where('age','>=',86)->where('age','<=', 90);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">16</td>
                                <td class="uppercase border center fit" style="text-align: left;"> 91-95 {{ __('new.year') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    
                                    $user_state_m = (clone $user_male)->where('age','>=',91)->where('age','<=', 95);
                                    $user_state_f = (clone $user_female)->where('age','>=',91)->where('age','<=', 95);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit">
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="uppercase border center fit">17</td>
                                <td class="uppercase border center fit" style="text-align: left;"> {{ __('new.no_record_age') }} </td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $user_state_m = (clone $user_male)->where('age', 0);
                                    $user_state_f = (clone $user_female)->where('age',0);
                                    $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                                    $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="uppercase border center fit"> {{ count($male_state) }} </td>
                                <td class="uppercase border center fit"> {{ count($female_state) }} </td>
                                @endforeach
                                <td class="uppercase border center fit"> {{ count($user_state_m) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> {{ count($user_state_m)+count($user_state_f) }} </td>
                                <td class="uppercase border center fit"> 
                                    @if(count($users->get()) > 0)
                                        {{ number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') }}
                                    @else 0.00
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="bold uppercase border center fit" colspan="2">{{__('new.total')}}</td>
                                @foreach ($states as $index => $state )
                                <?php
                                    $total_male_state = (clone $user_male)->where('user_public.address_state_id', $state->state_id);
                                    $total_female_state = (clone $user_female)->where('user_public.address_state_id', $state->state_id);
                                ?>
                                <td class="bold uppercase border center fit"> {{ count($total_male_state) }} </td>
                                <td class="bold uppercase border center fit"> {{ count($total_female_state) }} </td>
                                @endforeach
                                <td class="bold uppercase border center fit"> {{ count($user_male) }} </td>
                                <td class="bold uppercase border center fit"> {{ count($user_female) }}</td>
                                <td class="bold uppercase border center fit"> {{ count($user_male)+count($user_female) }} </td>
                                <td class="bold uppercase border center fit"> 100.00 </td>
                            </tr>
		</table>
</body>