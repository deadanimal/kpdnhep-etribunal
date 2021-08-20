@php
    use App\CaseModel\Form4;
    use Carbon\Carbon;
@endphp
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
            max-width: 100%;
            white-space: nowrap;
        }

        .absolute-center {
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
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
    <?php
    $locale = App::getLocale();
    $category_lang = 'category_' . $locale;
    $position_lang = 'position_' . $locale;
    $position_reason_lang = 'position_reason_' . $locale;
    $reason_lang = 'reason_' . $locale;

    $psu = array();

    if ($cases) {
        foreach ($cases as $key => $case) {
            $form4psus = Form4::with('psus.psu')->where('form4_id', $case->form4_id)->first();
            foreach ($form4psus['psus'] as $psu_datum) {
                $psu[$psu_datum->psu_user_id] = $psu_datum->psu->name;
            }
        }
    }

    if ($waived) {
        foreach ($waived as $key => $f12) {
            $form4psus = Form4::with('psus.psu')->where('form4_id', $f12->form4_id)->first();
            foreach ($form4psus['psus'] as $psu_datum) {
                $psu[$psu_datum->psu_user_id] = $psu_datum->psu->name;
            }
        }
    }

    if ($postponed) {
        foreach ($postponed as $key => $p) {
            $form4psus = Form4::with('psus.psu')->where('form4_id', $p->form4_id)->first();
            foreach ($form4psus['psus'] as $psu_datum) {
                $psu[$psu_datum->psu_user_id] = $psu_datum->psu->name;
            }
        }
    }
    ?>
</head>

<body>

<h3 class="center uppercase">{{ __('new.tribunal')}}<br>{{ __('new.daily_report')}}</h3>

<table>
    <tr>
        <td class='top' style="width: 30%">{{ __('new.date')}}</td>
        <td class='divider'>:</td>
        <td class='uppercase' colspan="4">

            {{ $hearing_date }}
        </td>
    </tr>
    <tr>
        <td class='top'>{{ __('new.day')}}</td>
        <td class='divider'>:</td>
        <td class='uppercase' colspan="4">
            {{ localeDay(date('l', strtotime( $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString() : date('Y-m-d')))) }}
        </td>
    </tr>
    <tr>
        <td class='top'>{{ __('new.branch')}}</td>
        <td class='divider'>:</td>
        <td class='uppercase' colspan="4">
            {{ $request->branch_id ? \App\MasterModel\MasterBranch::find($request->branch_id)->branch_name : __('form1.all_branch') }}
        </td>
    </tr>
    <tr>
        <td class='top'>{{ __('new.hearing_place')}}</td>
        <td class='divider'>:</td>
        <td class='uppercase' colspan="4">
            {{ $request->hearing_venue_id ? \App\MasterModel\MasterHearingVenue::find($request->hearing_venue_id)->hearing_venue : __('new.all_places') }}
        </td>
    </tr>
    <tr>
        <td class='top'>{{ __('new.hearing_room')}}</td>
        <td class='divider'>:</td>
        <td class='uppercase' colspan="4">
            {{ $request->hearing_room_id ? \App\MasterModel\MasterHearingRoom::find($request->hearing_room_id)->hearing_room : __('new.all_rooms') }}
        </td>
    </tr>
    <tr>
        <td class='top'>{{ __('new.president')}}</td>
        <td class='divider'>:</td>
        <td class='uppercase' colspan="4">
            {{ $request->president_user_id ? \App\User::find($request->president_user_id)->name : '' }}
        </td>
    </tr>
    <tr>
        <td class='top'>Status</td>
        <td class='divider'>:</td>
        <td class='uppercase' colspan="4">
            @if ($request->approval == 0)
                {{ __('new.not_approved') }}
            @else {{ __('new.approved') }}
            @endif
        </td>
    </tr>
    <tr>
        <td class='top'>{{ __('new.time')}}</td>
        <td class='divider'>:</td>
        <td class='uppercase'>
            {{ $request->start_time ? date('h:i A' , strtotime('2000-01-01 '.$request->start_time)) : ''}}
        </td>
        <td class='top' width="10%">{{ __('new.until')}}</td>
        <td class='divider'>:</td>
        <td class='uppercase'>
            {{ $request->end_time ? date('h:i A' , strtotime('2000-01-01 '.$request->end_time)) : ''}}
        </td>
    </tr>
</table>

<h3>1. {{ __('new.claim_fixed')}} :</h3>
<table class="border collapse">
    <tr class="border">
        <th class="border uppercase center" style="width: 10%">{{ __('new.no') }}</th>
        <th class="border uppercase" style="width: 25%">{{ __('new.claim_no') }}</th>
        <th class="border uppercase center" style="width: 15%">{{ __('new.type') }}</th>
        <th class="border uppercase">{{ __('new.position') }}</th>
    </tr>
    @foreach( $cases as $index => $case )
        <tr class="border">
            <td class="border uppercase top center"> {{ $index+1 }} </td>
            <td class="border uppercase left top"> {{ $case->case_no }} </td>
            <td class="border uppercase top center"> {{ $case->$category_lang }} </td>
            <td class="border uppercase left top">
                @if($case->position_id == 1 || $case->position_id == 2)
                    <span style="font-weight: bold;">{{ $case->$position_lang }}
                        @if($case->form4->form4_next)
                            @if($case->form4->form4_next->hearing)
                                {{ __('new.to2')." ".date('d/m/Y', strtotime($case->form4->form4_next->hearing->hearing_date.' 00:00:00')) }}
                            @else -
                            @endif
                        @else -
                        @endif
                    </span>
                @elseif($case->position_id == 3 || $case->position_id == 5)
                    <span style="font-weight: bold; font-size: 17px">{{ __('new.award') .' '. __('new.form') }} {{ $case->award_type }}  </span>
                    <br>
                    <span style="font-size: 17px"> {{ $case->award_description }} </span>
                @else
                    <span style="font-weight: bold; font-size: 17px"> {{ $case->$position_lang }}  </span><br>
                    <span style="font-size: 17px"> {{ $case->hearing_details }} </span>
                @endif
            </td>
        </tr>
    @endforeach
    @if( count($cases) == 0)
        <tr class="border">
            <td colspan="4" class="center uppercase"> {{ __('new.no_record_age')}}</td>
        </tr>
    @endif

</table>

<h3>2. {{ __('form12.waive_award_f12')}} :</h3>
<table class="border collapse">
    <tr class="border">
        <th class="border uppercase center" style="width: 10%">{{ __('new.no') }}</th>
        <th class="border uppercase" style="width: 25%">{{ __('new.claim_no') }}</th>
        <th class="border uppercase center" style="width: 15%">{{ __('new.type') }}</th>
        <th class="border uppercase">{{ __('new.position') }}</th>
    </tr>
    @foreach( $waived as $index => $f12 )
        <tr class="border">
            <td class="border uppercase top center"> {{ $index+1 }} </td>
            <td class="border uppercase left top"> {{ $f12->case_no }} </td>
            <td class="border uppercase top center"> {{ $f12->$category_lang }} </td>
            <td class="border uppercase left top">
                @if($f12->position_id == 1 || $f12->position_id == 2)
                    <span style="font-weight: bold;">{{ $f12->$position_lang }}
                        @if($f12->form4->form4_next)
                            @if($f12->form4->form4_next->hearing)

                                {{ __('new.to2')." ".$f12->form4->form4_next->hearing->hearing_date }}
                            @else -
                            @endif
                        @else -
                        @endif
	                    </span>
                @elseif($f12->position_id == 3 || $f12->position_id == 5)
                    <span style="font-weight: bold;">{{ __('new.award') .' '. __('new.form') }} {{ $f12->award_type }}  </span>
                    <br>
                    <span> {{ $f12->award_description }} </span>
                @else
                    <span style="font-weight: bold;"> {{ $f12->$position_lang }}  </span><br>
                    <span> {{ $f12->hearing_details }} </span>
                @endif
            </td>
        </tr>
    @endforeach
    @if( count($waived) == 0)
        <tr class="border">
            <td colspan="4" class="center uppercase">{{ __('new.no_record_age')}}</td>
        </tr>
    @endif

</table>

<h3>3. {{ __('new.postponed')}} :</h3>
<table class="border collapse">
    <tr class="border">
        <th class="border uppercase center" style="width: 10%">{{ __('new.no') }}</th>
        <th class="border uppercase" style="width: 25%">{{ __('new.claim_no') }}</th>
        <th class="border uppercase center" style="width: 15%">{{ __('new.type') }}</th>
        <th class="border uppercase">{{ __('new.position') }}</th>
    </tr>
    @foreach( $postponed as $index => $p )
        <tr class="border">
            <td class="border uppercase top center"> {{ $index+1 }} </td>
            <td class="border uppercase left top"> {{ $p->case_no }} </td>
            <td class="border uppercase top center"> {{ $p->$category_lang }} </td>
            <td class="border uppercase left top">
                <span style="font-size: 17px">{{ $p->$position_lang }} - {{ $p->$reason_lang }} </span>
            </td>
        </tr>
    @endforeach
    @if( count($postponed) == 0)
        <tr class="border">
            <td colspan="4" class="center uppercase">{{ __('new.no_record_age')}}</td>
        </tr>
    @endif

</table>

<span style="display: inline-flex; margin-top: 15px;"><span class="bold">4. {{ __('new.psu')}} :</span>
			@foreach($psu as $id => $psu_name)
        {{ $psu_name }},
    @endforeach
		</span><br><br>

<span><span class="bold">{{ __('new.date')}} : </span>{{Carbon::createFromFormat('d/m/Y', $request->hearing_date)->format('d-m-Y')}}</span><br>
<span>
				{{ __('new.approved')}} 
		</span><br><br>

<div class="page-break-before"
     style="margin-top: 60px; text-align: center; width: 350px; position: relative; z-index: 9999999 !important;">
    ................................................<br>
    @if ($request->approval == 1 || $request->approval_checkbox == 1)
        <img class="absolute-center row_approval" style="width: 200px; bottom: 120%; z-index: -1;"
             src="{{ route('general-getsignature', ['ttpm_user_id' => $request->president_user_id]) }}"/>
    @endif
    <span class='bold uppercase top'>{{ $request->president_user_id ? \App\User::find($request->president_user_id)->name : '' }}</span><br>
    <span class='uppercase'>{{ __('new.president')}}<br>{{ __('new.tribunal')}}<br></span>
</div>
</body>