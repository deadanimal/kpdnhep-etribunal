<?php
use App\MasterModel\MasterBank;
?>

<style>
	.control-label-custom  {
		padding-top: 15px !important;
	}
</style>

<div class="m-heading-1 border-green m-bordered margin-top-10">
	<h3>{{ $description }}</h3>
	<span>{{ trans('fpx.desc_selected_bank') }}.</span>
</div>

<div class="portlet light bordered form-fit">
	<div class="portlet-body form">
		<div class="form-horizontal form-bordered ">
			<div class="form-body">
				<div class="form-group" style="display: flex;">
					<div class="control-label col-xs-4 control-label-custom" style="border-left: none;"> {{ trans('fpx.payment_amount') }} :</div>
					<div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
						<span id="">RM {{ $payment->amount }}</span>
					</div>
				</div>
				<div class="form-group" style="display: flex;">
					<div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.payment_desc') }} :</div>
					<div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
						<span id="">{{ $description }}</span>
					</div>
				</div>
				<div class="form-group" style="display: flex;">
					<div class="control-label col-xs-4 control-label-custom" style="border-left: none;"> {{ trans('fpx.payment_opt') }} :</div>
					<div class="col-xs-8 font-green-sharp" style="align-items: stretch; display: flex; flex-wrap: wrap;">
						<div style="padding-right: 35px; text-align: center;">
							<img src='{{ url("/images/fpx_banks.jpg") }}' style="height: 150px;" />
						</div>
						<div style="padding-left: 15px; margin-top: 20px; font-size: small; color: #555; text-align: center;">
							<img src='{{ url("/images/logo_verisign.jpg") }}' style="height: 50px;" /><br><br>
							FPX {{ trans('fpx.operation_hours') }} : 24/7<br>
							{{ trans('fpx.click') }} <a href='http:///www.myclear.org.my/business-fpx.html'>{{ trans('fpx.here') }}</a> {{ trans('fpx.go_website') }}.
						</div>
					</div>
				</div>
				<div class="form-group" style="display: flex;">
					<div class="control-label col-xs-4 control-label-custom" style="border-left: none; padding-top: 23px !important;"><span style="color: red;">*</span> {{ __('fpx.account_type')}} :</div>
					<div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
						<div class="md-radio-inline" id="same_president">
                            <div class="md-radio">
                                <input id="acc_retail" name="acc_type" class="md-checkboxbtn" type="radio" value="01" checked onchange="updateBankList()">
                                <label for="acc_retail">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('fpx.personal')}}
                                </label>
                            </div>
                            <div class="md-radio">
                                <input  id="acc_corporate" name="acc_type" class="checkboxbtn" type="radio" value="02"  onchange="updateBankList()">
                                <label for="acc_corporate">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('fpx.corporate')}}
                                </label>
                            </div>
                        </div>
					</div>
				</div>
				<div class="form-group" style="display: flex;">
					<div class="control-label col-xs-4 control-label-custom" style="border-left: none;"><span style="color: red;">*</span> {{ trans('fpx.choose_bank') }} :</div>
					<div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
						<select id="fpx_bank" name='fpx_bank'  class="form-control " data-placeholder="{{ trans('fpx.select_bank') }}">
							<option value="" disabled selected>{{ trans('fpx.select_bank') }}</option>
						</select>
					</div>
				</div>
				<div class="form-group" style="display: flex;">
					<div class="control-label col-xs-4 control-label-custom" style="border-left: none;">{{ trans('fpx.customer_email') }} :</div>
					<div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
						<input type="email" class="form-control" id="fpx_email" name="fpx_email" placeholder="{{ trans('fpx.write_email') }}" value="{{ $email }}"/>
					</div>
				</div>
				<div class="form-group" style="display: flex;">
					<div class="control-label col-xs-4 control-label-custom" style="border-left: none;"><span style="color: red;">*</span></div>
					<div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
						{{ trans('fpx.click_process') }} <a href='https://www.mepsfpx.com.my/FPXMain/termsAndConditions.jsp' target="_blank">{{ trans('fpx.terms_cond') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="process" class="hidden"></div>

<script>$('#btnProceedFPX').removeClass('hidden');</script>

<script>
var bank_b2g = [];
var bank_c2g = [];

@foreach ($banks_b2g as $bank)
	bank_b2g.push({ "id": "{{ $bank->bank_id }}", "name": "{{ $bank->name }} @if(!array_key_exists($bank->bank_code, $bank_list)) ({{ trans('fpx.offline') }})@endif" });
@endforeach

@foreach ($banks_c2g as $bank)
	bank_c2g.push({ "id": "{{ $bank->bank_id }}", "name": "{{ $bank->name }} @if(!array_key_exists($bank->bank_code, $bank_list)) ({{ trans('fpx.offline') }})@endif" });
@endforeach

function updateBankList() {
	$('#fpx_bank').empty();
    $('#fpx_bank').append('<option value="" disabled selected>{{ trans("fpx.select_bank") }}</option>');

	if( $("input[name=acc_type]:checked").val() == '01' ) {
        $.each(bank_c2g, function(key, data) {
            $('#fpx_bank').append("<option value='" + data.id +"'>" + data.name + "</option>");
        });
	} else {
		$.each(bank_b2g, function(key, data) {
            $('#fpx_bank').append("<option value='" + data.id +"'>" + data.name + "</option>");
        });
	}
}

updateBankList();

function submit() {

    $.ajax({
        url: "{{ route('integration-fpx-process') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {
            bank_id:$('#fpx_bank').val(),
            email:$('#fpx_email').val(),
            payment_id:{{ $payment_id }},
            acc_type:$("input[name=acc_type]:checked").val()
        },
        datatype: 'json',
        success: function(data){
            if(data.result == "ok") {
                 $("#process").load("{{ route('integration-fpx-submit') }}");
            }
        },
        error: function(data){

        }
    });

}
</script>