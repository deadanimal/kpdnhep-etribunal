@if($attachments)
    @if($attachments->count() > 0)
        <div class="portlet light bordered form-fit">
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">
                    <div class="form-body">

                        <div class="form-group" style="display: flex;">
                            <div class="col-md-12">
                                <span class="bold"
                                      style="align-items: stretch;">{{ trans('form1.attachment_list')}}</span>
                            </div>
                        </div>
                        @foreach($attachments as $att)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">
                                    <a target="_blank"
                                       href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}'
                                       class='btn dark btn-outline'><i
                                                class='fa fa-download'></i> {{ trans('button.download')}}</a>
                                </div>
                                <div class="col-xs-8 font-green-sharp"
                                     style="align-items: stretch; overflow-wrap: break-word;">
                                    <span id="view_claim_details">{{ $att->attachment_name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    @endif
@endif