<div id="step_2" class="row step_item">
    <div class="col-md-12 ">
        <!-- Defense and counterclaim Details-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.defence_towards_counterclaim') }}</span>
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
                            <label for="defence_counterclaim"
                                   class="control-label col-xs-4"> {{ trans('form3.defence_towards_counterclaim') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea onchange="updateReview()" id="defence_counterclaim"
                                          name="defence_counterclaim" class="form-control" rows="5"
                                          placeholder="">@if($claim_case_opponent->form2->form3_id){{ preg_replace("/[\r\n]+/", "&#13;", $claim_case_opponent->form2->form3->defence_counterclaim_statement) }}@endif</textarea>
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