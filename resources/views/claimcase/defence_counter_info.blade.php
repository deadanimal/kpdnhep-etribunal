<div class="portlet light bordered form-fit">
    <div class="portlet-body form">
        <form action="#" class="form-horizontal form-bordered ">
            <div class="form-body">

                <div class="form-group" style="display: flex;">
                    <div class="col-md-12">
                        <span class="bold"
                              style="align-items: stretch;">{{ __('form2.defence_counterclaim_info') }} </span>
                    </div>
                </div>
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4">{{ __('form2.statement_defence') }} :</div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="view_defence_statement">{{ $claim_case_oppo->form2->defence_statement }}</span>
                    </div>
                </div>


                @if($claim_case_oppo->form2->counterclaim_id)
                    <div class="form-group is_counterclaim" style="display: flex;">
                        <div class="col-md-12">
                            <span class="bold" style="align-items: stretch;">{{ __('form2.counterclaim') }} </span>
                        </div>
                    </div>
                    <div class="form-group is_counterclaim" style="display: flex;">
                        <div class="control-label col-xs-4">{{ __('form2.total_counterclaim') }} :</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_total_counterclaim">{{ number_format($claim_case_oppo->form2->counterclaim->counterclaim_amount, 2, '.', ',') }}</span>
                        </div>
                    </div>
                    <div class="form-group is_counterclaim" style="display: flex;">
                        <div class="control-label col-xs-4">{{ __('form2.counterclaim_statements') }} :</div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_counterclaim_desc">{{ $claim_case_oppo->form2->counterclaim->counterclaim_statement }}</span>
                        </div>
                    </div>
                @endif

            </div>
        </form>
    </div>
</div>