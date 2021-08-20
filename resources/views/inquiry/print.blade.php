<?php
$locale = App::getLocale();
$method_lang = "method_".$locale;
$type_lang = "type_".$locale;
$category_lang = "category_".$locale;
$classification_lang = "classification_".$locale;
$feedback_lang = "feedback_".$locale;
?>

<style>
	table {
	    border-collapse: collapse;
	    border: 1px solid black;
	    width: 100%;
	}

	th, td {
	    padding: 5px;
	    text-align: left;
	    border: 1px solid black;
	}
</style>


<h1>{{ trans('inquiry.inquiry_info') }}</h1>

<table>
	<tr>
		<td style="width: 30%">{{ trans('inquiry.inquiry_method')}} :</td>
		<td>{{ $inquiry->method->$method_lang }}</td>
	</tr>
	<tr>
		<td>{{ trans('inquiry.inquiry_date')}} :</td>
		<td>{{ date('d/m/Y', strtotime($inquiry->created_at)) }}</td>
	</tr>
	<tr>
		<td>{{ trans('inquiry.inquiry_type')}} :</td>
		<td>{{ $inquiry->type->$type_lang }}</td>
	</tr>





	<tr>
		<td colspan="2" style="font-weight: bold;">{{ trans('inquiry.inquiry_parties') }}</td>
	</tr>
	<tr>
		<td>@if($inquiry->inquired_by->public_data->user_public_type_id == 2)
				{{ trans('inquiry.company_no')}} :
			@elseif($inquiry->inquired_by->public_data->individual->nationality_country_id == 129)
				{{ trans('inquiry.ic_no')}} :
			@else
				{{ trans('inquiry.passport_no')}} :
			@endif</td>
		<td>{{ $inquiry->inquired_by->username }}</td>
	</tr>
	@if($inquiry->inquired_by->user_public_type_id == 1)
		@if($inquiry->inquired_by->public_data->individual->nationality_country_id != 129)
			<tr>
				<td>{{ trans('inquiry.nationality')}} :</td>
				<td>{{ $inquiry->inquired_by->public_data->individual->nationality->country }}</td>
			</tr>
		@endif
	@endif
	<tr>
		<td>{{ trans('inquiry.name')}} :</td>
		<td>{{ $inquiry->inquired_by->name }}</td>
	</tr>







	@if($inquiry->inquired_by->user_public_type_id == 1)
		<tr>
			<td colspan="2" style="font-weight: bold;">{{ trans('inquiry.contact_info') }}</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.address')}} :</td>
			<td>{{ $inquiry->inquired_by->public_data->address_mailing_street_1 }}<br>{{ $inquiry->inquired_by->public_data->address_mailing_street_2 }}<br>{{ $inquiry->inquired_by->public_data->address_mailing_street_3 }}</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.postcode')}} :</td>
			<td>{{ $inquiry->inquired_by->public_data->address_postcode }}</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.district')}} :</td>
			<td>@if($inquiry->inquired_by->public_data->address_district_id){{ $inquiry->inquired_by->public_data->district->district }}@endif</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.state')}} :</td>
			<td>@if($inquiry->inquired_by->public_data->address_state_id){{ $inquiry->inquired_by->public_data->state->state }}@endif</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.home_phone')}} :</td>
			<td>{{ $inquiry->inquired_by->public_data->individual->phone_home }}</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.mobile_phone')}} :</td>
			<td>{{ $inquiry->inquired_by->public_data->individual->phone_mobile }}</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.office_phone')}} :</td>
			<td>{{ $inquiry->inquired_by->phone_office }}</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.fax')}} :</td>
			<td>{{ $inquiry->inquired_by->phone_fax }}</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.email')}} :</td>
			<td>{{ $inquiry->inquired_by->email }}</td>
		</tr>
	@endif



	@if($inquiry->inquiry_msg)
		<tr>
			<td colspan="2" style="font-weight: bold;">{{ trans('inquiry.inquiry_info') }}</td>
		</tr>
		<tr>
			<td>{{ trans('inquiry.inquiry_msg')}} :</td>
			<td>{{ $inquiry->inquiry_msg }}</td>
		</tr>



	@else
		@if($inquiry->opponent_user_extra_id)
			<tr>
				<td colspan="2" style="font-weight: bold;">{{ trans('inquiry.opponent_info') }}</td>
			</tr>
			<tr>
				<td>@if($inquiry->opponent->nationality_country_id == 129)
						{{ trans('inquiry.ic_no')}} :
					@else
						{{ trans('inquiry.passport_no')}} :
					@endif</td>
				<td>{{ $inquiry->opponent->identification_no }}</td>
			</tr>
			@if($inquiry->opponent->nationality_country_id != 129)
				<tr>
					<td>{{ trans('inquiry.nationality')}} :</td>
					<td>{{ $inquiry->opponent->nationality->country }}</td>
				</tr>
			@endif
			<tr>
				<td>{{ trans('inquiry.name')}} :</td>
				<td>{{ $inquiry->opponent->name }}</td>
			</tr>
		@endif

		@if($inquiry->form1_id)
			<tr>
				<td colspan="2" style="font-weight: bold;">{{ __('form1.transaction_info') }}</td>
			</tr>
			<tr>
				<td>{{ __('form1.online_purchased') }} :</td>
				<td>@if($inquiry->form1->is_online_purchased == 1)
						{{ trans('inquiry.yes')}}
					@else
						{{ trans('inquiry.no')}}
					@endif</td>
			</tr>
			<tr>
				<td>{{ __('form1.transaction_date') }} :</td>
				<td>{{ $inquiry->form1->purchased_date }}</td>
			</tr>
			<tr>
				<td>{{ __('form1.purchased_used') }} :</td>
				<td>{{ $inquiry->form1->purchased_item_name }}</td>
			</tr>
			<tr>
				<td>{{ __('form1.brand_model') }} :</td>
				<td>{{ $inquiry->form1->purchased_item_brand }}</td>
			</tr>
			<tr>
				<td>{{ __('form1.amount_paid') }} :</td>
				<td>{{ $inquiry->form1->purchased_amount ? number_format($inquiry->form1->purchased_amount, 2, '.', ',') : "-" }}</td>
			</tr>




			<tr>
				<td colspan="2" style="font-weight: bold;">{{ __('form1.claim_info') }}</td>
			</tr>
			<tr>
				<td>{{ __('form1.particular_claim') }} :</td>
				<td>{{ $inquiry->form1->claim_details }}</td>
			</tr>
			<tr>
				<td>{{ __('form1.amount_claim') }} :</td>
				<td>{{ $inquiry->form1->claim_amount ? number_format($inquiry->form1->claim_amount, 2, '.', ',') : "-" }}</td>
			</tr>
			<tr>
				<td>{{ __('form1.prev_court') }} :</td>
				<td>@if( $inquiry->form1->court_case_id )
						{{ trans('inquiry.yes')}}
					@else
						{{ trans('inquiry.no')}}
					@endif</td>
			</tr>
			@if($inquiry->form1_id OR false)
				@if($inquiry->form1->court_case_id OR false)
					<tr>
						<td colspan="2" style="font-weight: bold;">{{ __('form1.court_info') }}</td>
					</tr>
					<tr>
						<td>{{ __('form1.court_name') }} :</td>
						<td>{{ $inquiry->form1->court_case->court_case_name }}</td>
					</tr>
					<tr>
						<td>{{ __('form1.status_case') }} :</td>
						<td>{{ $inquiry->form1->court_case->court_case_status }}</td>
					</tr>
					<tr>
						<td>{{ __('form1.place_case') }} :</td>
						<td>{{ $inquiry->form1->court_case->court_case_location }}</td>
					</tr>
					<tr>
						<td>{{ __('form1.filing_date') }} :</td>
						<td>@if($inquiry->form1->court_case->filing_date){{ date('d/m/Y', strtotime($inquiry->form1->court_case->filing_date)) }}@endif</td>
					</tr>
				@endif
			@endif
		@endif
	@endif




	@if($inquiry->inquiry_form_status_id != 9)
		<tr>
			<td colspan="2" style="font-weight: bold;">{{ trans('inquiry.inquiry_process') }}</td>
		</tr>
		<tr>
			<td>{{ __('inquiry.processed_by') }} :</td>
			<td>{{ $inquiry->processed_by->name ?? "" }} ({{ $inquiry->processed_by_user_id != null ? $inquiry->processed_by->ttpm_data->branch->branch_name : '' }})</td>
		</tr>
		<tr>
			<td>{{ __('inquiry.processed_at') }} :</td>
			<td>{{ $updated_at ?? "" }}</td>
		</tr>
		<tr>
			<td>{{ __('form1.category_claim') }} :</td>
			<td>{{ $inquiry->form1->classification->category->$category_lang ?? "" }}</td>
		</tr>
		<tr>
			<td>{{ __('form1.classification_claim') }} :</td>
			<td>{{ $inquiry->form1->classification->$classification_lang ?? "" }}</td>
		</tr>
		@if($inquiry->inquiry_feedback_id)
			<tr>
				<td>{{ trans('inquiry.feedback')}} :</td>
				<td>{{ $inquiry->feedback->$feedback_lang }}</td>
			</tr>
		@endif
		@if(!$inquiry->inquiry_feedback_id == 2)
			<tr>
				<td>{{ trans('inquiry.reason')}} :</td>
				<td>@if($inquiry->jurisdiction_organization_id == 1)
						{{ trans('inquiry.outside_jurisdiction')}}
					@else
						{{ trans('inquiry.any_other')}}
					@endif</td>
			</tr>
			@if(!$inquiry->jurisdiction_organization_id)
				<tr>
					<td>{{ trans('inquiry.org_jurisdiction')}} :</td>
					<td>{{ $inquiry->organization->organization ?? '' }}</td>
				</tr>
			@endif
		@endif
	@endif
	<tr>
		<td>{{ trans('inquiry.feedback_msg')}} :</td>
		<td>{{ $inquiry->inquiry_feedback_msg }}</td>
	</tr>


</table>