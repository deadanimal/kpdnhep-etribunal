<?php
$count = 0;
$rep_list=array();

if($form4->attendance){
	if($form4->attendance->representative->count() > 0){
		foreach($form4->attendance->representative as $rep){
			if($rep->is_representing_claimant  == 0  && $rep->is_present){
				$count += 1;
				array_push($rep_list, $rep->name);
				array_push($rep_list, $rep->identification_no);
				if($rep->designation_id)
				array_push($rep_list, $rep->designation->designation_en);
				elseif($rep->relation_id)
				array_push($rep_list, $rep->relation->relation_en);
			}	
		}
	}
}
			
?>
<style type="text/css">
	table {
		width: 100%;
		margin: 30px;

	}

	tr, td {
		vertical-align: top;
		line-height: 25px;
	}
</style>

<table>
	<tr>
		<td colspan="3" style="text-align: center; font-weight: bold; padding-bottom: 15px;">CLAIM NO. : {{ $form4->case->case_no }}</td>
	</tr>
	<tr>
		<td style="width:40%">DATE / TIME </td>
		<td style="width:1%">:</td>
		<td style="width:59%"> {{ date('d/m/Y', strtotime($form4->hearing->hearing_date)) }} {{ date('h:i A', strtotime($form4->hearing->hearing_time)) }} </td>
	</tr>
	<tr>
		<td>PRESIDENT</td>
		<td>:</td>
		<td> {{ $form4->president_user_id ? $form4->president->name : '' }}</td>
	</tr>
	@if($form4->attendance)
	<tr>
		<td>ASSISTANT SECRETARY</td>
		<td>:</td>
		<td>
			@if($form4->attendance->minutes->count() > 0)
				@foreach($form4->attendance->minutes as $index => $attendance_psu)
					@if($attendance_psu->psu)
					{{ $index+1 }}. {{ $attendance_psu->psu->name }}<br>
					@endif
				@endforeach
			@endif
		</td>
	</tr>
	@endif
	<tr>
		<td>CLAIMANT</td>
		<td>:</td>
		<td>@if($form4->attendance)
				@if($form4->attendance->is_claimant_present == 1)
					Present
				@else
					Absent
				@endif
			@endif
		</td>
	</tr>
	<tr>
		<td>NAME</td>
		<td>:</td>
		<td> {{ $form4->case->claimant->name }} </td>
	</tr>
	<tr>
		<td>IDENTITY CARD NO.</td>
		<td>:</td>
		<td>{{ $form4->case->claimant->username }}</td>
	</tr>
	<tr>
		<td>PROOF OF SUBMISSION</td>
		<td>:</td>
		<td>@if( count($form4->case->submission) > 1 )
				@if ( $form4->case->submission->first()->is_claimant_submit == 1 )
					@if ($form4->case->submission->first()->category)
						Claimant : {{ $form4->case->submission->first()->category->category_en }} <br>
					@endif
					@if ($form4->case->submission->last()->category)
						Opponent : {{ $form4->case->submission->last()->category->category_en }}
					@endif
				@else
					@if ($form4->case->submission->first()->category)
						Opponent : {{ $form4->case->submission->first()->category->category_en }} <br>
					@endif
					@if ($form4->case->submission->last()->category)
						Claimant : {{ $form4->case->submission->last()->category->category_en }}
					@endif
				@endif
			@elseif ( count($form4->case->submission) == 1 )
				@if ( $form4->case->submission->first()->is_claimant_submit == 1 )
					@if ($form4->case->submission->first()->category)
						Claimant : {{ $form4->case->submission->first()->category->category_en }} <br>
					@endif
				@else
					@if ($form4->case->submission->first()->category)
						Opponent : {{ $form4->case->submission->last()->category->category_en }}
					@endif
				@endif
			@endif
		</td>
	</tr>
	<tr>
		<td>OPPONENT</td>
		<td>:</td>
		<td>@if($form4->attendance)
				@if($form4->opponent->public_data->user_public_type_id == 1)
					{{ $form4->attendance->is_opponent_present == 1 ? 'Present' : 'Absent' }}
				@else
					{{ count($rep_list) > 0 ? 'Present' : 'Absent' }}
				@endif
			@endif
		</td>
	</tr>
	<tr>
		<td>NAME</td>
		<td>:</td>
		<td>@if($form4->opponent->public_data->user_public_type_id == 1)
				{{ $form4->opponent->name }}
			@elseif( $count > 0)
				{{ $rep_list[0] }}
			@endif
		</td>
	</tr>
	<tr>
		<td>
			IDENTITY CARD NO.		
		</td>
		<td>:</td>
		<td>@if($form4->opponent->public_data->user_public_type_id == 1)
				{{ $form4->opponent->username }}
			@elseif( $count > 0)
				{{ $rep_list[1] }}
			@endif
		</td>
	</tr>
	@if($form4->opponent->public_data->user_public_type_id == 2)
	<tr>
		<td>DESIGNATION</td>
		<td>:</td>
		<td>
			@if( $count > 0)
				{{ $rep_list[2] }}
			@endif
		</td>
	</tr>
	@endif
	

</table>