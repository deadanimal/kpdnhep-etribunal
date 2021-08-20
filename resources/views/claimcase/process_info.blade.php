@if($claim_case->form1_id) @if($claim_case->form1->form_status_id == 17)
    <div class="portlet light bordered form-fit">
        <div class="portlet-body form">
            <form action="#" class="form-horizontal form-bordered ">
                <div class="form-body">

                    <div class="form-group" style="display: flex;">
                        <div class="col-md-12">
                            <span class="bold" style="align-items: stretch;">{{ trans('form1.process_info') }}</span>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;"> {{ trans('form1.process_date') }}</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claim_details">{{$date['form1_filing_date'] ?? $date['form2_filing_date'] ?? '-'}}</span>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ trans('form1.matured_date') }}</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claim_details">{{ $date['form1_matured_date'] ?? $date['form2_matured_date'] ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ trans('form1.category_claim') }}</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claim_details">{{ $claim_case->form1->classification->category->$category_lang or '' }}</span>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ trans('form1.classification_claim') }}</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claim_details">{{ $claim_case->form1->classification->$classification_lang or '' }}</span>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ trans('form1.type_offence') }}</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claim_details"><strong>{{ $claim_case->form1->offence_type->offence_code or '' }}</strong><br>{{ $claim_case->form1->offence_type->$offence_lang or '' }}</span>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4" style="padding-top: 13px;">{{ trans('new.branch') }}</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claim_details">{{ $claim_case->branch->branch_name or '' }}</span>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ trans('form1.psu_incharged') }}</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claim_details">{{ $claim_case->psu->name or '' }}</span>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endif @endif