<div class="portlet light bordered form-fit">
    <div class="portlet-body form">
        <form action="#" class="form-horizontal form-bordered ">
            <div class="form-body">
                <div class="form-group" style="display: flex;">
                    <div class="col-xs-12 font-green-sharp" style="align-items: stretch;">
                        <span class="bold" style="align-items: stretch;">{{ __('form4.list_hearing') }}</span>
                    </div>
                </div>
                <div class="form-group" style="">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="table_hearings">
                        <thead>
                        <tr>
                            <th> {{ __('form4.no')}} </th>
                            <th> {{ __('new.opponent_name')}} </th>
                            <th> {{ __('form4.date')}} </th>
                            <th> {{ __('form4.location')}} </th>
                            <th> {{ __('form4.status')}} </th>
                            <th> {{ __('form4.list_forms')}} </th>
                            <th> {{ __('form4.action')}} </th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($claim_case->form4)
                            @foreach($claim_case->form4 as $i => $form4)
                                <tr class="odd gradeX">
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $form4->claimCaseOpponent->opponent_address->name ?? '-' }}</td>
                                    <td>{{ date('d/m/Y h:i A', strtotime($form4->hearing->hearing_date." ".$form4->hearing->hearing_time)) }}</td>
                                    <td>{{ $form4->hearing->hearing_room ? $form4->hearing->hearing_room->hearing_room : '-' }}</td>
                                    <td>{{ $form4->hearing_status ? $form4->hearing_status->$status_lang : "-" }}</td>
                                    <td>
                                        <div class="btn-group" style="position: relative;">
                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                    type="button" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="fa fa-download"></i> {{ __('form4.form4')}}
                                            </button>
                                            <ul class="dropdown-menu pull-left" role="menu"
                                                style="position: inherit;">
                                                <li>
                                                    <a href="{{ route('form4-export', ['form4_id'=>$form4->form4_id, 'form_no'=>4, 'format'=>'pdf']) }}">
                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('form4-export', ['form4_id'=>$form4->form4_id, 'form_no'=>4, 'format'=>'docx']) }}">
                                                        <i class="fa fa-file-text-o"></i> DOCX
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    @if($form4->hearing_status_id == 1)
                                        @if($form4->hearing_position_id == 4)
                                            <!-- Surat Dibatalkan -->
                                                <br>
                                                <div class="btn-group" style="position: relative;">
                                                    <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                            type="button" data-toggle="dropdown"
                                                            aria-expanded="false">
                                                        <i class="fa fa-download"></i> {{ __('form4.canceled_letter')}}
                                                    </button>
                                                    <ul class="dropdown-menu pull-left" role="menu"
                                                        style="position: inherit;">
                                                        <li>
                                                            <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>8, "format"=>"pdf"]) }}'><i
                                                                        class="fa fa-file-pdf-o"></i> PDF
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>8, "format"=>"docx"]) }}'><i
                                                                        class="fa fa-file-text-o"></i> DOCX
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                        @else
                                            @if($form4->award_id)
                                                <!-- Surat Serahan Award -->
                                                    <br>
                                                    <div class="btn-group" style="position: relative;">
                                                        <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                type="button" data-toggle="dropdown"
                                                                aria-expanded="false">
                                                            <i class="fa fa-download"></i> {{ __('form4.award_submission_letter')}}
                                                        </button>
                                                        <ul class="dropdown-menu pull-left" role="menu"
                                                            style="position: inherit;">
                                                            <li>
                                                                <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>7, "format"=>"pdf"]) }}'><i
                                                                            class="fa fa-file-pdf-o"></i>
                                                                    PDF
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>7, "format"=>"docx"]) }}'><i
                                                                            class="fa fa-file-text-o"></i>
                                                                    DOCX
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <!-- Surat Bersama Award -->
                                                    @if($form4->case->opponent_user_id == $user->user_id || $user->user_type_id == 2 ||  $user->user_type_id == 1)
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs m-b-5 dropdown-toggle {{$form4->form_status_id == 35 ? 'btn-danger' : 'btn-default'}}"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('form4.letter_with_award_p')}}
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>5, "format"=>"pdf"]) }}'><i
                                                                                class="fa fa-file-pdf-o"></i>
                                                                        PDF
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    @if($form4->award->award_type != 9 && $form4->award->award_type != 10)
                                                                        <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>5, "format"=>"docx"]) }}'><i
                                                                                    class="fa fa-file-text-o"></i>
                                                                            DOCX
                                                                        </a>
                                                                    @else
                                                                        <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>9, "format"=>"docx"]) }}'><i
                                                                                    class="fa fa-file-text-o"></i>
                                                                            DOCX
                                                                        </a>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if($form4->case->claimant_user_id == $user->user_id || $user->user_type_id == 2 || $user->user_type_id == 1)
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('form4.letter_with_award_pym')}}
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>6, "format"=>"pdf"]) }}'><i
                                                                                class="fa fa-file-pdf-o"></i>
                                                                        PDF
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    @if($form4->award->award_type != 9 && $form4->award->award_type != 10)
                                                                        <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>6, "format"=>"docx"]) }}'><i
                                                                                    class="fa fa-file-text-o"></i>
                                                                            DOCX
                                                                        </a>
                                                                    @else
                                                                        <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>10, "format"=>"docx"]) }}'><i
                                                                                    class="fa fa-file-text-o"></i>
                                                                            DOCX
                                                                        </a>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if($form4->award->award_type == 5)
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('new.form')}}
                                                                5
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>5, "format"=>"pdf"]) }}'>
                                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>5, "format"=>"docx"]) }}'>
                                                                        <i class="fa fa-file-text-o"></i>
                                                                        DOCX
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if($form4->award->award_type == 6)
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('new.form')}}
                                                                6
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>6, "format"=>"pdf"]) }}'>
                                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>6, "format"=>"docx"]) }}'>
                                                                        <i class="fa fa-file-text-o"></i>
                                                                        DOCX
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if($form4->award->award_type == 7)
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('new.form')}}
                                                                7
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>7, "format"=>"pdf"]) }}'>
                                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>7, "format"=>"docx"]) }}'>
                                                                        <i class="fa fa-file-text-o"></i>
                                                                        DOCX
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if($form4->award->award_type == 8)
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('new.form')}}
                                                                8
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>8, "format"=>"pdf"]) }}'>
                                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>8, "format"=>"docx"]) }}'>
                                                                        <i class="fa fa-file-text-o"></i>
                                                                        DOCX
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if($form4->award->award_type == 9)
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('new.form')}}
                                                                9
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>9, "format"=>"pdf"]) }}'>
                                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>9, "format"=>"docx"]) }}'>
                                                                        <i class="fa fa-file-text-o"></i>
                                                                        DOCX
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if($form4->award->award_type == 10)

                                                        @if ($form4->award->f10_type_id != 1)
                                                            <br>
                                                            <div class="btn-group"
                                                                 style="position: relative;">
                                                                <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                        type="button" data-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                    <i class="fa fa-download"></i>
                                                                    @if ($form4->award->f10_type_id == 2)
                                                                        {{ __('new.form')}} 10
                                                                    @elseif ($form4->award->f10_type_id == 3)
                                                                        {{ __('new.form')}} 10T
                                                                    @elseif ($form4->award->f10_type_id == 4)
                                                                        {{ __('new.form')}} 10B
                                                                    @endif
                                                                </button>
                                                                <ul class="dropdown-menu pull-left"
                                                                    role="menu" style="position: inherit;">
                                                                    <li>
                                                                        <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>10, "format"=>"pdf"]) }}'>
                                                                            <i class="fa fa-file-pdf-o"></i>
                                                                            PDF
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>10, "format"=>"docx"]) }}'>
                                                                            <i class="fa fa-file-text-o"></i>
                                                                            DOCX
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        @else
                                                            <br>
                                                            <div class="btn-group"
                                                                 style="position: relative;">
                                                                <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                        type="button" data-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                    <i class="fa fa-download"></i> {{ __('new.form')}}
                                                                    10K
                                                                </button>
                                                                <ul class="dropdown-menu pull-left"
                                                                    role="menu" style="position: inherit;">
                                                                    <li>
                                                                        <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>"10k", "format"=>"pdf"]) }}'>
                                                                            <i class="fa fa-file-pdf-o"></i>
                                                                            PDF
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href='{{ route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>"10k", "format"=>"docx"]) }}'>
                                                                            <i class="fa fa-file-text-o"></i>
                                                                            DOCX
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        @if ($form4->award->f10_type_id == 3)
                                                            <br>
                                                            <div class="btn-group"
                                                                 style="position: relative;">
                                                                <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                        type="button" data-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                    <i class="fa fa-download"></i> {{ __('form4.form10_rejected')}}
                                                                </button>
                                                                <ul class="dropdown-menu pull-left"
                                                                    role="menu" style="position: inherit;">
                                                                    <li>
                                                                        <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>3, "format"=>"pdf"]) }}'><i
                                                                                    class="fa fa-file-pdf-o"></i>
                                                                            PDF
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>3, "format"=>"docx"]) }}'><i
                                                                                    class="fa fa-file-text-o"></i>
                                                                            DOCX
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if($form4->case->stop_notice)
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('form4.notice_of_discontinuance')}}
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("stopnotice-export", ["stop_notice_id"=>$form4->case->stop_notice->stop_notice_id,"type"=>"notice", "format"=>"pdf"]) }}'><i
                                                                                class="fa fa-file-pdf-o"></i>
                                                                        PDF</a>
                                                                </li>
                                                                <li>
                                                                    <a href='{{ route("stopnotice-export", ["stop_notice_id"=>$form4->case->stop_notice->stop_notice_id,"type"=>"notice", "format"=>"docx"]) }}'><i
                                                                                class="fa fa-file-text-o"></i>
                                                                        DOCX</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <br>
                                                        <div class="btn-group" style="position: relative;">
                                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                <i class="fa fa-download"></i> {{ __('new.letter').' '.__('form4.notice_of_discontinuance')}}
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu"
                                                                style="position: inherit;">
                                                                <li>
                                                                    <a href='{{ route("stopnotice-export", ["stop_notice_id"=>$form4->case->stop_notice->stop_notice_id,"type"=>"letter", "format"=>"pdf"]) }}'><i
                                                                                class="fa fa-file-pdf-o"></i>
                                                                        PDF</a>
                                                                </li>
                                                                <li>
                                                                    <a href='{{ route("stopnotice-export", ["stop_notice_id"=>$form4->case->stop_notice->stop_notice_id,"type"=>"letter", "format"=>"docx"]) }}'><i
                                                                                class="fa fa-file-text-o"></i>
                                                                        DOCX</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <br>

                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                        @if($form4->hearing_status_id == 2)
                                            <br>
                                            <div class="btn-group" style="position: relative;">
                                                <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                        type="button" data-toggle="dropdown"
                                                        aria-expanded="false">
                                                    <i class="fa fa-download"></i> {{ __('form4.postponed')}}
                                                </button>
                                                <ul class="dropdown-menu pull-left" role="menu"
                                                    style="position: inherit;">
                                                    <li>
                                                        <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>4, "format"=>"pdf"]) }}'><i
                                                                    class="fa fa-file-pdf-o"></i> PDF
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href='{{ route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>4, "format"=>"docx"]) }}'><i
                                                                    class="fa fa-file-text-o"></i> DOCX
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($form4->case->case_status_id != 8)
                                            @if(!$form4->case->stop_notice)
                                                <a href='{{ route("stopnotice-create", ["claim_case_id"=>$form4->claim_case_opponent_id]) }}'
                                                   class="btn btn-xs btn-danger m-b-5"><i
                                                            class="fa fa-plus"></i> {{ __('form4.notice_of_discontinuance')}}
                                                </a>
                                            @endif
                                        @endif

                                        @if($user->user_type_id != 3)
                                            @if($form4->hearing_status_id == 2)
                                                <a href='{{ route("form11-create", ["form4_ids"=>$form4->form4_id]) }}'
                                                   class="btn btn-xs btn-success m-b-5"><i
                                                            class="fa fa-file-text"></i>{{ __('form4.form11')}}
                                                </a>
                                            @endif


                                            @if($form4->award_id)
                                                @if($form4->award->award_type != 9 && $form4->award->award_type != 10)
                                                    <a href='{{ route("form12-create", ["form4_id"=>$form4->form4_id]) }}'
                                                       class="btn btn-xs btn-success m-b-5"><i
                                                                class="fa fa-file-text"></i>{{ __('form4.form12')}}
                                                    </a>
                                                @endif
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>