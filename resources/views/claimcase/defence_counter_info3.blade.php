<div class="portlet light bordered form-fit">
    <div class="portlet-body form">
        <form action="#" class="form-horizontal form-bordered ">
            <div class="form-body">

                <div class="form-group" style="display: flex;">
                    <div class="col-md-12">
                        <span class="bold"
                              style="align-items: stretch;">{{ __('form3.defence_towards_counterclaim') }} </span>
                    </div>
                </div>
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4">{{ trans('form3.defence_towards_counterclaim') }} :</div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="view_defence_statement">{{ $claim_case_opponent->form2->form3->defence_counterclaim_statement }}</span>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>