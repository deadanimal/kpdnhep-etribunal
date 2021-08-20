<?php
$allow = false;

if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) {
    if (Auth::user()->ttpm_data->branch_id == $case->branch_id) {
        $allow = true;
    } else {
        $allow = false;
    }
} else {
    $allow = true;
}
?>

<table class='table table-bordered' style="width: 100%; margin: 0px; border: 0px;">
    <!-- START: TOP -->
    <tr style="font-weight: bold; background-color: {{ ($case->form4->count() > 0 && ($case->form4->last()->hearing_position_id == 4 || $case->form4->last()->hearing_position_id == 6)) || $case->stop_notice ? '#ffcbcb' : '#d6dce4' }}; ">
        <td rowspan="2" style="text-align: center;" style="width: 10%;">{{ $i+1 }}.</td>
        <td class="clickme" style="width: 40%;">
            {{ $case->case_no }}
            <a class="btn btn-primary btn-xs" href="{{ route('claimcase-view', [$case->claim_case_id]) }}"><i
                        class="glyphicon glyphicon-new-window"></i></a>
        </td>

        <td style="text-align: center; width: 30%;">

        </td>

        <td style="text-align: center; width: 20%;">
            Status: {{$case->is_finished ? __('new.finished') : __('new.not_finished_yet')}}
        </td>
    </tr>
    <!-- END: TOP -->
    <!-- START: CASE DATA -->
    <tr>
        <td colspan="3">
            {{ __('form1.submit_date') }}: {{ $case->form1->filing_date != null ? date('d/m/Y', strtotime($case->form1->filing_date." 00:00:00")) : '-' }}<br>
            {{ __('new.filing_date') }}: {{ $case->form1->processed_at != null ? date('d/m/Y', strtotime($case->form1->processed_at)) : '-' }}<br>
            {{ __('new.last_date') }}
            : {{ $case->form1->matured_date ? date('d/m/Y', strtotime($case->form1->matured_date." 00:00:00")) : "-" }}
            <br>
            {{ __('new.completed_at')}}:
            @if( $case->form4->count() > 0 )
                @if ($case->form4->last()->award_id )
                    {{ date('d/m/Y', strtotime($case->form4->last()->award->award_date." 00:00:00")) }}
                @elseif($case->form4->last()->hearing_status_id == 1 )
                    {{ date('d/m/Y', strtotime($case->form4->last()->hearing->hearing_date." 00:00:00")) }}
                @else -
                @endif
            @elseif( $case->stop_notice)
                {{ date('d/m/Y', strtotime($case->stop_notice->stop_notice_date." 00:00:00")) }}

            @else -
            @endif

        </td>
    </tr>
    <!-- END: CASE DATA -->
    <!-- START: PYM -->
    <tr>
        <td style="text-align: center; vertical-align: middle;">[PYM]</td>
        <td>
            * {{ $case->claimant_address ? $case->claimant_address->name : "-" }}
        </td>
        <td style="">
            <a type="button" class="btn btn-primary btn-xs"
               href="{{ route('form1-view', ['claim_case_id' => $case->claim_case_id]) }}"><i
                        class='fa fa-search'></i> {{ __('home_user.f1')}}</a>
        </td>
        <td style="text-align: center; vertical-align: middle;">
            @if($case->form4->count() > 0)
                @if($case->form4->last()->form12)
                    <a type="button" class="btn btn-primary btn-xs"
                       href="{{ route('form12-view', $case->form4->last()->form12->form12_id) }}"><i
                                class='fa fa-search'></i> {{ __('new.view_f12')}}</a>
                @endif
            @endif
        </td>
    </tr>
    <!-- END: PYM -->
    <!-- START: P -->
    @foreach($case->multiOpponents as $i => $cco)
        <tr>
            <td style="text-align: center;">[P{{$i+1}}]</td>
            <td>
                {{ $cco->opponent_address->name ?? "-" }} ({{ $cco->opponent_address->identification_no ?? "-" }})
                <br>{{ __('new.hearing_date') }}:
                @if( $cco->form4->count() > 0 )
                    @if ($cco->form4->last()->award_id )
                        {{ date('d/m/Y', strtotime($cco->form4->last()->award->award_date." 00:00:00")) }}
                    @elseif($cco->form4->last()->hearing || $cco->form4->last()->hearing_status_id == 1 )
                        {{ date('d/m/Y', strtotime($cco->form4->last()->hearing->hearing_date." 00:00:00")) }}
                    @else
                        -
                    @endif
                @elseif( $cco->stop_notice)
                    {{ date('d/m/Y', strtotime($cco->stop_notice->stop_notice_date." 00:00:00")) }}
                @else
                    -
                @endif
                <br>{{ __('new.completed_at')}}:
                @if( $cco->form4->count() > 0 )
                    @if ($cco->form4->last()->award_id )
                        {{ date('d/m/Y', strtotime($cco->form4->last()->award->award_date." 00:00:00")) }}
                    @elseif($cco->form4->last()->hearing_status_id == 1 )
                        {{ date('d/m/Y', strtotime($cco->form4->last()->hearing->hearing_date." 00:00:00")) }}
                    @else
                        -
                    @endif
                @elseif( $case->stop_notice)
                    {{ date('d/m/Y', strtotime($case->stop_notice->stop_notice_date." 00:00:00")) }}
                @else
                    -
                @endif
            </td>
            <td style="border-right-width: 1px;">
                <!-- START: F2 -->
                @if($cco->form2)
                    <a type="button" class="btn btn-primary btn-xs"
                       href="{{ route('form2-view', ['claim_case_id' => $cco->id]) }}"><i
                                class='fa fa-search'></i> {{ __('home_user.f2')}}</a>
                @else
                    @if($case->form1->form_status_id==17 && $allow && !$cco->form2)
                        <a type="button" class="btn btn-default btn-xs"
                           href="{{ route('form2-create', ['claim_case_id' => $cco->id]) }}"><i
                                    class='fa fa-pencil'></i> {{ __('home_user.f2')}}</a>
                    @endif
                @endif
            <!-- START: F3 -->
                @if($cco->form2)
                    @if($cco->form2->form3)
                        <a type="button" class="btn btn-primary btn-xs"
                           href="{{ route('form3-view', ['claim_case_id' => $cco->id]) }}"><i
                                    class='fa fa-search'></i> {{ __('home_user.f3')}}</a>
                    @else
                        @if(($cco->claim_case_id != null && $cco->claimCase->case_status_id == 4) && $allow && !$cco->form2->form3_id && $cco->form2->counterclaim_id)
                            <a type="button" class="btn btn-default btn-xs"
                               href="{{ route('form3-create', ['claim_case_id' => $cco->id]) }}"><i
                                        class='fa fa-pencil'></i> {{ __('home_user.f3')}}</a>
                        @endif
                    @endif
                @endif
            <!-- START: F4 -->
                @if($case->case_status_id > 1)
                    @if($cco->form4->count() > 0)
                        <a class="btn green-jungle btn-xs"
                           href='{{ route("form4-export", ["form4_id"=>$cco->form4->last()->form4_id, "form_no"=>4, "format"=>"pdf"]) }}'>
                            <i class="glyphicon glyphicon-download-alt"></i> {{__('home_user.f4')}}
                        </a>
                    @else
                        @if(!$case->stop_notice)
                            <a class="btn btn-warning btn-xs" href='{{ url("hearing/without_hearing_date") }}'>
                                <i class="glyphicon glyphicon glyphicon-saved"></i> {{__('home_user.f4')}}
                            </a>
                        @endif
                    @endif
                @endif
            <!-- START: F12 -->
                @if($case->case_status_id > 1 && $cco->form4->count() > 0 && $cco->form4->last()->form12_id != null)
                    <a class="btn green-jungle btn-xs"
                       href='{{ route("form4-export", ["form4_id"=>$cco->form4->last()->form4_id, "form_no"=>12, "format"=>"pdf"]) }}'>
                        <i class="glyphicon glyphicon-download-alt"></i> {{__('home_user.f12')}}
                    </a>
                @endif
            </td>
            <td style="text-align: center; width: 20%;">
                Status: <a
                        @if($cco->form4->count() > 0) href="{{ route('form4-status-update-view', [$cco->form4->last()->form4_id]) }}"
                        @endif id='status{{ $cco->id }}'>
                    @if($cco->stop_notice)
                        {{ __('new.revoked') }}
                    @elseif($cco->form4->count() > 0)
                        @if($cco->form4->last()->award_id)
                            Award
                            @if( $cco->form4->last()->award->award_type == 10)
                                @if($cco->form4->last()->award->f10_type_id == 1)
                                    10K
                                @elseif($cco->form4->last()->award->f10_type_id == 2)
                                    10
                                @elseif($cco->form4->last()->award->f10_type_id == 3)
                                    10T
                                @else
                                    10B
                                @endif
                            @else
                                {{ $cco->form4->last()->award->award_type }}
                            @endif
                        @else
                            {{ $cco->form4->last()->hearing_position ? $cco->form4->last()->hearing_position->$hearing_position_lang : '-' }}
                        @endif
                    @else
                        -
                    @endif
                </a>
            </td>
        </tr>
@endforeach
<!-- END: P -->
</table>

@foreach($case->multiOpponents as $i => $cco)
    @if($cco->form4->count() > 0)
        @if($cco->form4->last()->hearing_position_id)
            <script>
              $('#status{{ $cco->id }}').popover({
                trigger: 'focus',
                placement: 'bottom',
                html: true,
                container: 'body',
                title: '{{ __("home_user.information") }}',
                content: '<b>{{ __("form1.hearing_date") }}:</b> {{ $cco->last_form4 ? date("d/m/Y h:i A", strtotime($cco->last_form4->hearing->hearing_date." ".$cco->last_form4->hearing->hearing_time)) : "-" }}<br>' +
                  '<b>PSU:</b> {{ $cco->last_form4 ? ($cco->last_form4->psus->count() > 0 ? $cco->last_form4->psus->first()->psu->name : "-") : "-" }}<br>' +
                  '<b>{{ __("form1.reason") }}:</b> {{ $cco->last_form4 ? ($cco->last_form4->hearing_position_reason_id ? $cco->last_form4->hearing_position_reason->$hearing_position_reason_lang : "-") : "-" }}<br>' +
                  '<b>{{ __("hearing.president_name") }}:</b> {{ $cco->last_form4 ? ($cco->last_form4->president_user_id ? $cco->last_form4->president->name : ($cco->last_form4->hearing->president ? $cco->last_form4->hearing->president->name : "-")) : "-" }}<br>' +
                  '<b>{{ __("new.award_value") }}:</b> {{ $cco->last_form4 ? ($cco->last_form4->award ? number_format($cco->last_form4->award->award_value,2,".",",") : "-" ) : "-" }}'
              })


              $('#status{{ $cco->id }}').on('mouseenter', function () {
                $(this).popover('show')
              }).on('mouseout', function () {
                $(this).popover('hide')
              })
            </script>
        @endif
    @endif
@endforeach