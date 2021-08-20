@if($obj['ReplyIndicator'] == 1)
<style>
    .modal-body {
		padding: 0px;
	}
	
	.watermark {
		background-image:url("{{ url('/images/ttpm_watermark.png') }}");
		background-repeat:no-repeat;
    }
	
    .control-label-custom  {
        padding-top: 15px !important;
    }
</style>

<div class="modal fade" id="modalMyIdentity" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <label style="font-size: 18px">{{ __('new.search_myidentity') }}</label>
            </div>
            <div class="modal-body col-md-offset-1" style="padding: 10px; position: relative;"> 
                <div class="row" style="margin: 0px;">
                    <div class="col-md-4 col-sm-6 col-xs-12" style="text-align: center;">
                        <div class="mt-element-card mt-element-overlay">
                            <div class="mt-card-item">
                                <div class="mt-card-avatar mt-overlay-1">
                                    <img @if($obj['Photo'] != "") src="data:image/png;base64, {{ $obj['Photo'] }}" @else src="{{ url('images/user.png') }}" @endif />
                                </div>
                                <div class="mt-card-content">
                                    <h3 class="mt-card-name">{{ $obj['Name'] }}</h3>
                                    <p class="mt-card-desc font-red bold">

                                        {{ \App\IntegrationModel\MyIdentity\StatusRecord::where('code', $obj['RecordStatus'])->first()->status }}
                                        {!! $obj['DateOfDeath'] ? '<br>('.date('d/m/Y', strtotime($obj['DateOfDeath'])).')' : "" !!}</p>
                                    <p class="mt-card-desc font-grey-mint">
                                        {{ trim($obj['ResidentialStatus']) != "" ? \App\IntegrationModel\MyIdentity\Citizenship::where('code', $obj['ResidentialStatus'])->first()->citizenship : "-" }}
                                    </p>
                                    <p class="mt-card-desc font-grey-mint"><span class="bold">{{ __('new.nric')}} :</span> {{ $obj['ICNumber'] }}</p>
                                    <p class="mt-card-desc font-grey-mint"><span class="bold">{{ __('new.old_nric')}} :</span> {{ $obj['OldICnumber'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 watermark">
                        <div class="form-horizontal form-bordered" role="form">

                            <div class="form-body">
                               
                                <div class="form-group form-md-line-input">
                                    <div class="col-md-10">
                                        <span class="font-green-sharp bold">{{ __('form1.contact_info')}}</span><br>
                                        <span class="bold">{{ __('new.email')}} :</span> {{ $obj['EmailAddress'] }}<br>
                                        <span class="bold">{{ __('new.phone_mobile')}} :</span> {{ $obj['MobilePhoneNumber'] }}</br>
                                    </div>  
                                </div>

                                <div class="form-group form-md-line-input">
                                    <div class="col-md-10">
                                        <span class="font-green-sharp bold">{{ __('form1.additional_info')}}</span><br>
                                        <span class="bold">{{ __('new.date_of_birth') }} : </span> {{ date("d/m/Y", strtotime($obj['DateOfBirth'])) }}<br>
                                        <span class="bold">Gender :</span> {{ \App\IntegrationModel\MyIdentity\Gender::where('code', $obj['Gender'])->first()->gender }}</br>
                                        <span class="bold">{{ __('new.race') }} : </span> {{ \App\IntegrationModel\MyIdentity\Race::where('code', $obj['Race'])->first()->race }}</br>
                                        <span class="bold">{{ __('new.religion') }} : </span> {{ trim($obj['Religion']) != "" ? \App\IntegrationModel\MyIdentity\Religion::where('code', $obj['Religion'])->first()->religion : '-' }} </br>
                                    </div>  
                                </div>

                                
                                <div class="form-group form-md-line-input">
                                    <div class="col-md-10">
                                        <span class="font-green-sharp bold">{{ __('form1.permanent_address')}}</span><br>
                                        {{ $obj['PermanentAddress1'] }},
                                        {{ $obj['PermanentAddress2'] != "" ? $obj['PermanentAddress2']."," : "" }}
                                        {{ $obj['PermanentAddress3'] != "" ? $obj['PermanentAddress3']."," : "" }}
                                        {{ $obj['PermanentAddressPostcode'] }}
                                        {{ \App\IntegrationModel\MyIdentity\City::where('code', $obj['PermanentAddressCityCode'])->first()->city }},
                                        {{ $obj['PermanentAddressCityDesc'] }},
                                        {{ \App\IntegrationModel\MyIdentity\State::where('code', $obj['PermanentAddressStateCode'])->first()->state }}
                                        
                                    </div>  
                                </div>
                                <div class="form-group form-md-line-input">
                                    <div class="col-md-10" style="padding-top: 6px;">
                                        <span class="font-green-sharp bold">{{ __('form1.mailing_address')}}</span><br>
                                        {{ $obj['CorrespondenceAddress1'] }},
                                        {{ $obj['CorrespondenceAddress2'] != "" ? $obj['CorrespondenceAddress2']."," : "" }}
                                        {{ $obj['CorrespondenceAddress3'] != "" ? $obj['CorrespondenceAddress3']."," : "" }}
                                        {{ $obj['CorrespondenceAddress4'] != "" ? $obj['CorrespondenceAddress4']."," : "" }}
                                        {{ $obj['CorrespondenceAddress5'] != "" ? $obj['CorrespondenceAddress5']."," : "" }}
                                        {{ $obj['CorrespondenceAddressPostcode'] }}
                                        
                                        {{ trim($obj['CorrespondenceAddressCityCode']) != "" ? \App\IntegrationModel\MyIdentity\City::where('code', trim($obj['CorrespondenceAddressCityCode']))->first()->city.',' : ""}}
                                        
                                        {{ $obj['CorrespondenceAddressStateCode'] != "" ? \App\IntegrationModel\MyIdentity\State::where('code', $obj['CorrespondenceAddressStateCode'])->first()->state : "" }}
                                        
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: whitesmoke;">
              <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('button.back')}}</button>
            </div>  
        </div>
    </div>
</div>

<script>
    $("#modalMyIdentity").modal("show");
</script>
@else
<script>
    swal('{{ __("new.error") }}', '{{ property_exists($obj, "Message") ? $obj['Message'] : __("swal.user_not_found")}}', 'error');
</script>
@endif