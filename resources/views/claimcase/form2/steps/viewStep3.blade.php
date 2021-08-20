<div id="step_3" class="row step_item">

    <div class="col-md-12 ">
        <!-- Claim-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.defence') }} &amp; {{ __('form2.counterclaim') }}</span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="defence_statement"
                                   class="control-label col-md-4">{{ __('form2.statement_defence') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea onchange="updateReview()" id="defence_statement" name="defence_statement"
                                          class="form-control" rows="2"
                                          placeholder="">@if($caseOppo->form2){{ preg_replace("/[\r\n]+/", "&#13;", $caseOppo->form2->defence_statement) }}@endif</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="is_counterclaim" class="control-label col-md-4">{{ __('form2.counterclaim') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input onchange="updateReview()" id="is_counterclaim_yes" name="is_counterclaim"
                                               class="md-checkboxbtn" type="radio" value="1">
                                        <label for="is_counterclaim_yes">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>{{ __('form2.yes') }}
                                        </label>
                                    </div>
                                    <div class="md-radio">
                                        <input onchange="updateReview()" id="is_counterclaim_no" name="is_counterclaim"
                                               class="checkboxbtn" checked type="radio" value="0">
                                        <label for="is_counterclaim_no">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>{{ __('form2.no') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='is_counterclaim'
                             style="border: 1px solid black; padding: 0px; margin-bottom: 25px; ">
                            <div class="form-group form-md-line-input is_counterclaim">
                                <label for="total_counterclaim"
                                       class="control-label col-md-4">{{ __('form2.total_counterclaim') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" class="form-control decimal"
                                           id="total_counterclaim" name="total_counterclaim"
                                           @if($case->form2) @if($case->form2->counterclaim_id)
                                           value="{{ $case->form2->counterclaim->counterclaim_amount }}"
                                            @endif @endif
                                    />
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input is_counterclaim">
                                <label for="counterclaim_desc"
                                       class="control-label col-md-4">{{ __('form2.counterclaim_statements') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <textarea onchange="updateReview()" id="counterclaim_desc" name="counterclaim_desc"
                                              class="form-control" maxlength="225" rows="2"
                                              placeholder="">@if($case->form2) @if($case->form2->counterclaim_id){{ preg_replace("/[\r\n]+/", "&#13;", $case->form2->counterclaim->counterclaim_statement) }}@endif @endif</textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <div id="row_supporting_docs" class="form-group form-md-line-input"
                        ">
                        <label id="label_supporting_docs"
                               class="col-md-4 control-label">{{ __('form1.supporting_docs') }} :
                            <span class="required">&nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6">
                            <div class="m-heading-1 border-green m-bordered margin-bottom-10">
                                {!! __('new.dropify_msg') !!}
                            </div>
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_1" name="attachment_1" class="dropify"
                                           @if($attachments) @if($attachments->get(0))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(0)->attachment_id, 'filename' => $attachments->get(0)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_2" name="attachment_2" class="dropify"
                                           @if($attachments) @if($attachments->get(1))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(1)->attachment_id, 'filename' => $attachments->get(1)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_3" name="attachment_3" class="dropify"
                                           @if($attachments) @if($attachments->get(2))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(2)->attachment_id, 'filename' => $attachments->get(2)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_4" name="attachment_4" class="dropify"
                                           @if($attachments) @if($attachments->get(3))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(3)->attachment_id, 'filename' => $attachments->get(3)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_5" name="attachment_5" class="dropify"
                                           @if($attachments) @if($attachments->get(4))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(4)->attachment_id, 'filename' => $attachments->get(4)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
            </form>
        </div>
    </div>
</div>
</div>