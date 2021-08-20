@extends('layouts.portal.app-v3')

@section('slider')
    @include('portal.slider_v3')
@endsection

@section('content')
    <section id="intro" class="container">
        <div class="row features-block" style="margin-top: 20px">
            <div class="col-lg-9 text-left wow fadeInRight">
                @foreach ($announcements as $index => $announcement)
                    <div class="item {{ $index == 0 ? 'active' : '' }}">
                        <div class="panel panel-success" @if($index > 0) class="hidden" @endif>
                            <div class="panel-heading bold">{{ $announcement['title_'.$l10n] }}</div>
                            <div class="panel-body"
                                 style="background-color: white;">{!! nl2br(strlen($announcement['description_title_'.$l10n]) > 100 ? substr($announcement['description_title_'.$l10n], 0, 100).'... <a href="javascript:;" onclick="openAnnouncement('.$announcement->portal_announcement_id.')" style="font-style: italic; font-weight: bold">Baca Lanjut</a>' : $announcement['description_'.$l10n]) !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-3">
                <a href="/login" class="btn btn-block btn-primary gradient"
                   style="word-wrap: break-word; word-break: normal; white-space: normal;">
                    {{__('portal.register')}}
                </a>
            </div>
        </div>
    </section>

    <section id="intro" class="container">
        <div class="row">
            <div class="col-lg-12 wow fadeInLeft">
                <h2>{{__('portal.pc_s1_title')}}</h2>
                <p style="text-align: justify">
                    {{__('portal.pc_s1_desc')}}
                </p>
            </div>
        </div>
    </section>

    <section id="branches"
             class="features timeline gray-section"
             style="background: url(https://mysafe.kpdnhep.gov.my/img/patterns/triangle.png); margin-top: 20px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>{{__('portal.pc_s6_b1_title')}}</h1>
                    <br>
                    {{-- <p class="text-center" >{{__('portal.pc_s4_b1_desc')}}</p> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="display:flex; flex-wrap: wrap; justify-content: flex-start">
                    @foreach ($directoryBranches as $i => $directory)
                        <div class="flex-width">
                            <h4>{{$directory->state->state}}</h4>
                            <p>
                                Tel: {{ $directory->directory_branch_tel }} <br/>
                                Faks: {{ $directory->directory_branch_faks }} <br>
                                @lang('master.email'): {{ $directory->directory_branch_email }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="container services">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>{{__('portal.pc_s3_b1_title')}}</h1>
                <p class="text-center">{{__('portal.pc_s3_b1_desc')}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h2>{{__('portal.pc_s3_b2_title')}}</h2>
                <p style="text-align: justify;">
                    {{__('portal.pc_s3_b2_desc')}}
                </p>
            </div>
            <div class="col-sm-4">
                <h2>{{__('portal.pc_s3_b3_title')}}</h2>
                <p style="text-align: justify;">
                    {{__('portal.pc_s3_b3_desc')}}
                </p>
            </div>
            <div class="col-sm-4">
                <h2>{{__('portal.pc_s3_b4_title')}}</h2>
                <p style="text-align: justify;">
                    {{__('portal.pc_s3_b4_desc')}}
                </p>
            </div>
        </div>
    </section>

    <section id="features" class="features timeline gray-section"
             style="background: url(https://mysafe.kpdnhep.gov.my/img/patterns/triangle.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>{{__('portal.pc_s4_b1_title')}}</h1>
                    <br>
                    {{-- <p class="text-center" >{{__('portal.pc_s4_b1_desc')}}</p> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.pc_s4_b5_title')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.pc_s4_b5_desc')}}
                    </p>
                    <p><a class="navy-link" href="/files/akta-599-pindaan-1-nov-2019.pdf"
                          role="button">{{__('portal.download')}} &raquo;</a></p>
                </div>
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.membership')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.membership_desc')}}
                    </p>
                    <p><a class="navy-link" href="/portal/ttpm/membership"
                          role="button">{{__('portal.readmore')}} &raquo;</a></p>
                </div>
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.jurisdiction')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.jurisdiction_desc')}}
                    </p>
                    <p><a class="navy-link" href="/portal/ttpm/jurisdiction"
                          role="button">{{__('portal.readmore')}} &raquo;</a></p>
                </div>
            </div>
            <div class="row">
{{--                <div class="col-sm-4 features-text">--}}
{{--                    <h2>{{__('portal.pc_s4_b2_title')}}</h2>--}}
{{--                    <p style="text-align: justify;">--}}
{{--                        {{__('portal.pc_s4_b2_desc')}}--}}
{{--                    </p>--}}
{{--                    <p><a class="navy-link" href="/portal/claim/type"--}}
{{--                          role="button">{{__('portal.readmore')}} &raquo;</a></p>--}}
{{--                </div>--}}
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.pc_s4_b3_title')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.pc_s4_b3_desc')}}
                    </p>
                    <p><a class="navy-link" href="/portal/claim/procedure/filings" role="button">{{__('portal.readmore')}} &raquo;</a>
                    </p>
                </div>
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.pc_s4_b4_title')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.pc_s4_b4_desc')}}
                    </p>
                    <p><a class="navy-link" href="/portal/claim/procedure/hearing" role="button">{{__('portal.readmore')}} &raquo;</a>
                    </p>
                </div>
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.awards')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.awards_desc')}}
                    </p>
                    <p><a class="navy-link" href="/portal/award/tribunal"
                          role="button">{{__('portal.readmore')}} &raquo;</a></p>
                </div>
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.enforcement')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.enforcement_desc')}}
                    </p>
                    <p><a class="navy-link" href="/portal/award/enforcement"
                          role="button">{{__('portal.readmore')}} &raquo;</a></p>
                </div>
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.penalty')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.penalty_desc')}}
                    </p>
                    <p><a class="navy-link" href="/portal/award/penalty"
                          role="button">{{__('portal.readmore')}} &raquo;</a></p>
                </div>
                <div class="col-sm-4 features-text">
                    <h2>{{__('portal.judicial')}}</h2>
                    <p style="text-align: justify;">
                        {{__('portal.judicial_desc')}}
                    </p>
                    <p><a class="navy-link" href="/portal/award/judicial-review"
                          role="button">{{__('portal.readmore')}} &raquo;</a></p>
                </div>
            </div>
        </div>
    </section>

    <section id="clients-charter" class="container features">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>{{__('portal.pc_s5_b1_title')}}</h1>
                <p class="text-center">{{__('portal.pc_s5_b1_desc')}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-justify wow fadeInLeft">
                <div class="row m-t">
                    <div class="col-md-3">
                        <i class="fa fa-calendar features-icon" style="color: #a2192f"></i>
                        <h2 class="m-l" style="display:inline">{{__('portal.pc_s5_b2_title')}}</h2>
                        <p class="m-t">
                            {{__('portal.pc_s5_b2_desc')}}
                        </p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-heart features-icon" style="color: #a2192f"></i>
                        <h2 class="m-l" style="display:inline">{{__('portal.pc_s5_b3_title')}}</h2>
                        <p class="m-t">
                            {{__('portal.pc_s5_b3_desc')}}
                        </p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-legal features-icon" style="color: #a2192f"></i>
                        <h2 class="m-l" style="display:inline">{{__('portal.pc_s5_b4_title')}}</h2>
                        <p class="m-t">
                            {{__('portal.pc_s5_b4_desc')}}
                        </p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-trophy features-icon" style="color: #a2192f"></i>
                        <h2 class="m-l" style="display:inline">{{__('portal.pc_s5_b5_title')}}</h2>
                        <p class="m-t">
                            {{__('portal.pc_s5_b5_desc')}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('portal.footer_v3')

    <div id="modalDiv"></div>

    <div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ trans('others.announcement_info')}}</h4>
                </div>
                <div class="modal-body" id="modalbodyperanan">
                    <div style="text-align: center;">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
      function openAnnouncement(id) {
        $('#modalDiv').load("{{ route('portal.announcement', ['id' => '']) }}/" + id)
      }
    </script>
@endsection
