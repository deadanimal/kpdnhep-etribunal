<div id="modalDaftar" class="modal fade modal-scroll in" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">{{ __('login.account_registration') }}</h4>
            </div>
                <div class="modal-body">
                <div class="portlet-body">
                    <div>
                        <h4 class="block">{{ __('login.fill_info_reg1') }}</h4>
                        <p>{{ __('login.fill_info_reg2') }}</p>
                    </div>
                    <hr>
                    <div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 text-center">
                                <img src="{{ URL::to('/assets/pages/img/etribunalv2/register-public.png') }}">
                            
                                <div class="mt-card-content">
                                    <h3 class="mt-card-name">{{ __('login.user_individual') }}</h3>
                                    <p class="mt-card-desc break-word plr40">{{ __('login.register_msg_individual') }}</p>
                                </div>
                                
                                <div class="form-group">
                                    <a class="btn blue btn-outline btn-md" href="{{ route('citizen') }}">{{ __('login.citizen') }}</a>
                                </div>

                                <div class="form-group">
                                    <a class="btn blue btn-outline btn-md" href="{{ route('noncitizen') }}">{{ __('login.noncitizen') }}</a>
                                </div>

                            </div>
                            <div class="col-lg-6 col-md-6 text-center">
                                <img src="{{ URL::to('/assets/pages/img/etribunalv2/register-company.png') }}">
                            
                                <div class="mt-card-content">
                                    <h3 class="mt-card-name">{{ __('login.user_company_rep') }}</h3>
                                    <p class="mt-card-desc plr40">{{ __('login.register_msg_company') }}</p>
                                </div>

                                <div class="form-group">
                                    <a class="btn blue btn-outline btn-md" href="{{ route('company') }}">{{ __('new.company') }}</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-reply mr10"></i>{{ __('button.back') }}</button>
            </div>
        </div>
    </div>
</div>