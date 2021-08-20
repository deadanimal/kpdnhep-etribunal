<li class="heading">
    <h3 class="uppercase">{{ trans('menu.main_menu') }}</h3>
</li>
<li class="nav-item start {{ Request::is('home*') ? 'active' : '' }}">
    <a href="{{ route('home') }}" class="nav-link">
        <i class="icon-home"></i>
        <span class="title">{{ trans('menu.dashboard') }}</span>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('portal') }}" target="_blank" class="nav-link">
        <i class="icon-screen-desktop "></i>
        <span class="title">{{ trans('menu.portal') }}</span>
    </a>
</li>
<li class="heading">
    <h3 class="uppercase">{{ trans('menu.user_menu') }}</h3>
</li>
@permission(['claimcase'])
<li class="nav-item {{ Request::is('claimcase/list*') ? 'active' : '' }}">
    <a href="{{ route('claimcase-list') }}" class="nav-link">
        <i class="fa fa-th-list"></i>
        <span class="title">{{ trans('menu.all_claim_status') }}</span>
    </a>
</li>
@endpermission
@permission(['listing'])
<li class="nav-item {{ Request::is('listing/*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-list"></i>
        <span class="title">{{ trans('menu.list') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
        @permission(['listing-visitor'])
        <li class="nav-item {{ Request::is('listing/visitor*') ? 'active' : '' }}">
            <a href="{{ route('listing.visitor') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.visitor') }}</span>
                {!! Request::is('listing/visitor*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['listing-attendance'])
        <li class="nav-item {{ Request::is('listing/attendance*') ? 'active' : '' }}">
            <a href="{{ route('listing.attendance') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.attendance') }}</span>
                {!! Request::is('listing/attendance*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['listing-hearing'])
        <li class="nav-item {{ Request::is('listing/hearing*') && !Request::is('listing/hearing_attendance*') ? 'active' : '' }}">
            <a href="{{ route('listing.hearing') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.hearing') }}</span>
                {!! Request::is('listing/hearing/*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission
        @permission(['listing-hearing-attendance'])
        <li class="nav-item {{ Request::is('listing/hearing_attendance*') ? 'active' : '' }}">
            <a href="{{ route('listing.hearing.attendance') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.attendance_hearing') }}</span>
                {!! Request::is('listing/hearing_attendance*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

    </ul>
</li>
@endpermission

@permission(['onlineprocess'])
<li class="nav-item {{ Request::is('onlineprocess*') || Request::is('form*') || Request::is('inquiry*') || Request::is('stop_notice*') || Request::is('award_disobey*') || Request::is('judicial_review*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-file"></i>
        <span class="title">{{ trans('menu.online_process') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
        @permission(['onlineprocess-inquiry'])
        <li class="{{ Request::is('onlineprocess/inquiry*') || Request::is('inquiry*') ? 'active' : '' }}">
            <a href="{{ route('onlineprocess.inquiry') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.inquiry') }}</span>
                {!! Request::is('onlineprocess/inquiry*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission


        @permission(['onlineprocess-form1'])
        @if(!(Auth::user()->user_type_id == 3 && Auth::user()->public_data->user_public_type_id == 2))
            <li class="{{ Request::is('onlineprocess/form1') || Request::is('form1') || Request::is('form1/*') ? 'active' : '' }}">
                <a href="{{ route('onlineprocess.form1') }}" class="nav-link">
                    <i class="fa fa-circle"></i>
                    <span class="title">{{ trans('menu.form1') }}</span>
                    {!! Request::is('onlineprocess/form1*') ? '<span class="selected"></span>' : '' !!}
                </a>
            </li>
        @endif
        @endpermission

        @permission(['onlineprocess-form2'])
        <li class="{{ Request::is('onlineprocess/form2*') || Request::is('form2*') ? 'active' : '' }}">
            <a href="{{ route('onlineprocess.form2') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.form2') }}</span>
                {!! Request::is('onlineprocess/form2*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['onlineprocess-form3'])
        @if(!(Auth::user()->user_type_id == 3 && Auth::user()->public_data->user_public_type_id == 2))
            <li class="{{ Request::is('onlineprocess/form3*') || Request::is('form3*') ? 'active' : '' }}">
                <a href="{{ route('onlineprocess.form3') }}" class="nav-link">
                    <i class="fa fa-circle"></i>
                    <span class="title">{{ trans('menu.form3') }}</span>
                    {!! Request::is('onlineprocess/form3*') ? '<span class="selected"></span>' : '' !!}
                </a>
            </li>
        @endif
        @endpermission

        @permission(['onlineprocess-form4'])
        <li class="{{ Request::is('onlineprocess/form4*') || Request::is('form4*') ? 'active' : '' }}">
            <a href="{{ route('onlineprocess.form4') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.form4') }}</span>
                {!! Request::is('onlineprocess/form4*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @if(Auth::user()->user_type_id != 3)
            @permission(['onlineprocess-form11'])
            <li class="{{ Request::is('onlineprocess/form11*') || Request::is('form11*') ? 'active' : '' }}">
                <a href="{{ route('onlineprocess.form11') }}" class="nav-link">
                    <i class="fa fa-circle"></i>
                    <span class="title">{{ trans('menu.form11') }}</span>
                    {!! Request::is('onlineprocess/form11*') ? '<span class="selected"></span>' : '' !!}
                </a>
            </li>
            @endpermission
            @permission(['onlineprocess-form12'])
            <li class="{{ Request::is('onlineprocess/form12*') || Request::is('form12*') ? 'active' : '' }}">
                <a href="{{ route('onlineprocess.form12') }}" class="nav-link">
                    <i class="fa fa-circle"></i>
                    <span class="title">{{ trans('menu.form12') }}</span>
                    {!! Request::is('onlineprocess/form12*') ? '<span class="selected"></span>' : '' !!}
                </a>
            </li>
            @endpermission
        @endif

        @permission(['onlineprocess-stopnotice'])
        @if(Auth::user()->user_type_id != 3 || Auth::user()->public_data->user_public_type_id == 1)
            <li class="{{ Request::is('onlineprocess/stop_notice*') || Request::is('stop_notice*') ? 'active' : '' }}">
                <a href="{{ route('onlineprocess.stop_notice') }}" class="nav-link">
                    <i class="fa fa-circle"></i>
                    <span class="title">{{ trans('menu.stop_notice') }}</span>
                    {!! Request::is('onlineprocess/stop_notice*') ? '<span class="selected"></span>' : '' !!}
                </a>
            </li>
        @endif
        @endpermission

        @if(Auth::user()->user_type_id != 3)
            @permission(['onlineprocess-awarddisobey'])
            <li class="{{ Request::is('onlineprocess/award_disobey*') || Request::is('award_disobey*') ? 'active' : '' }}">
                <a href="{{ route('onlineprocess.award_disobey') }}" class="nav-link">
                    <i class="fa fa-circle"></i>
                    <span class="title">{{ trans('menu.award_disobey') }}</span>
                    {!! Request::is('onlineprocess/award_disobey*') ? '<span class="selected"></span>' : '' !!}
                </a>
            </li>
            @endpermission

            @permission(['onlineprocess-judicialreview'])
            <li class="{{ Request::is('onlineprocess/judicial_review*') || Request::is('judicial_review*') ? 'active' : '' }}">
                <a href="{{ route('onlineprocess.judicial_review') }}" class="nav-link">
                    <i class="fa fa-circle"></i>
                    <span class="title">{{ trans('menu.judicial_review') }}</span>
                    {!! Request::is('onlineprocess/judicial_review*') ? '<span class="selected"></span>' : '' !!}
                </a>
            </li>
            @endpermission
        @endif

    </ul>
</li>
@endpermission


@permission(['hearing'])
<li class="nav-item {{ Request::is('hearing/*') && !Request::is('hearing/status*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-legal"></i>
        <span class="title">{{ trans('menu.hearing') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">

        @permission(['hearing-set'])
        <li class="nav-item {{ Request::is('hearing/set_hearing_date*') ? 'active' : '' }}">
            <a href="{{ route('hearing.listhearing') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.set_hearing_date') }}</span>
                {!! Request::is('hearing/set_hearing_date*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['hearing-list'])
        <li class="nav-item {{ Request::is('hearing/without_hearing_date*') ? 'active' : '' }}">
            <a href="{{ route('hearing_claim_case.listhearingcc') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.claim_no_hearing_date') }}</span>
                {!! Request::is('hearing/without_hearing_date*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['hearing-update'])
        <li class="nav-item {{ Request::is('hearing/date/update*') ? 'active' : '' }}">
            <a href="{{ route('hearing-update-list') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.update_hearing_date') }}</span>
                {!! Request::is('hearing/update_hearing_date*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['hearing-reset'])
        <li class="nav-item {{ Request::is('hearing/date/reset*') ? 'active' : '' }}">
            <a href="{{ route('hearing-reset-list') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.reset_hearing_date') }}</span>
                {!! Request::is('hearing/reset_hearing_date*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['hearing-postpone'])
        <li class="nav-item {{ Request::is('hearing/claim_postponed*') ? 'active' : '' }}">
            <a href="{{ route('hearing.claim_postponed') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.postponed_hearing') }}</span>
                {!! Request::is('hearing/claim_postponed*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

    </ul>
</li>
@endpermission

@permission(['hearingstatus'])
<li class="nav-item {{ Request::is('hearing/status*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-legal"></i>
        <span class="title">{{ trans('menu.hearing_status') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">

        @permission(['hearingstatus-set'])
        <li class="nav-item {{ Request::is('hearing/status*') && !Request::is('hearing/status/update*') ? 'active' : '' }}">
            <a href="{{ route('form4-status-list') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.entry_hearing_status') }}</span>
                {!! Request::is('hearing/status*') && !Request::is('hearing/status/update*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['hearingstatus-update'])
        <li class="nav-item {{ Request::is('hearing/status/update*') ? 'active' : '' }}">
            <a href="{{ route('form4-status-update-list') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.update_hearing_status') }}</span>
                {!! Request::is('hearing/status/update*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

    </ul>
</li>
@endpermission

@permission(['presidentschedule'])
<li class="nav-item {{ Request::is('president_schedule*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-calendar"></i>
        <span class="title">{{ trans('menu.president_schedule') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">

        @permission(['presidentschedule-list'])
        <li class="nav-item {{ Request::is('president_schedule/listschedule*')  || Request::is('president_schedule/calendarschedule*') ? 'active' : '' }}">

            @if(Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks') || Auth::user()->hasRole('psu-hq') || Auth::user()->hasRole('ks-hq'))
                <a href="{{ route('president_schedule.listschedule') }}" class="nav-link">
                    @elseif(Auth::user()->hasRole('presiden'))
                        <a href="{{ route('president_schedule.calendarschedule') }}" class="nav-link">
                            @else
                                <a href="{{ route('president_schedule.listschedule') }}" class="nav-link">
                                    @endif
                                    <i class="fa fa-circle"></i>
                                    <span class="title">{{ trans('menu.president_schedule_suggest') }}</span>
                                    {!! Request::is('president_schedule/listschedule*') || Request::is('president_schedule/calendarschedule*') ? '<span class="selected"></span>' : '' !!}
                                </a>
        </li>
        @endpermission

        @permission(['presidentschedule-view'])
        <li class="nav-item {{ Request::is('president_schedule_view/listscheduleview*') ? 'active' : '' }}">
            <a href="{{ route('president_schedule_view.listscheduleview') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.president_schedule_view') }}</span>
                {!! Request::is('president_schedule_view/listscheduleview*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['presidentschedule-movement'])
        <li class="nav-item {{ Request::is('president_schedule/president_movement*') ? 'active' : '' }}">
            <a href="{{ route('president_schedule.president_movement') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.president_movement') }}</span>
                {!! Request::is('president_schedule/president_movement*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

    </ul>
</li>
@endpermission


@permission(['others'])
<li class="nav-item {{ Request::is('others*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-cog"></i>
        <span class="title">{{ trans('menu.others') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">

        @permission(['others-announcement'])
        <li class="{{ Request::is('others/announcement*') ? 'active' : '' }}">
            <a href="{{ route('others.announcement') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.announcement') }}</span>
                {!! Request::is('others/announcement*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['others-claimsubmission'])
        <li class="{{ Request::is('others/claimsubmission*') ? 'active' : '' }}">
            <a href="{{ route('others.claimsubmission') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.claimsubmission') }}</span>
                {!! Request::is('others/claimsubmission*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['others-journal'])
        <li class="{{ Request::is('others/journal*') ? 'active' : '' }}">
            <a href="{{ route('others.journal') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.journal') }}</span>
                {!! Request::is('others/journal*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['others-suggestion'])
        <li class="{{ Request::is('others/suggestion*') ? 'active' : '' }}">
            <a href="{{ route('others.suggestion') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.suggestion') }}</span>
                {!! Request::is('others/suggestion*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission
    </ul>
</li>
@endpermission

@permission(['suggestion'])
<li class="nav-item">
    <a href="javascript:;" onclick='openSuggestion()' class="nav-link">
        <i class="fa fa-lightbulb-o"></i>
        <span class="title">{{ trans('menu.suggestion') }}</span>
    </a>
</li>
@endpermission

@permission(['payment'])
<li class="nav-item {{ Request::is('payment*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-money"></i>
        <span class="title">{{ trans('menu.payment') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">

        @permission(['payment-review'])
        <li class="{{ Request::is('payment/review*') ? 'active' : '' }}">
            <a href="{{ route('payment-review') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.payment_review') }}</span>
                {!! Request::is('payment/review*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['payment-report'])
        <li class="{{ Request::is('report/report24*') ? 'active' : '' }}">
            <a href="{{ route('report24-view') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.payment_report') }}</span>
                {!! Request::is('report/report24*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission
    </ul>
</li>
@endpermission


@permission(['holiday'])
<li class="nav-item {{ Request::is('admin/master/holiday') ? 'active' : '' }}">
    <a href="{{ route('master.holiday') }}" class="nav-link">
        <i class="fa fa-circle"></i>
        <span class="title">{{ trans('menu.holiday') }}</span>
        {!! Request::is('admin/master/holiday') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission

@permission(['reports'])
<li class="nav-item {{ Request::is('report*') ? 'active' : '' }}">
    <a href="{{ route('report.list') }}" class="nav-link">
        <i class="fa fa-paperclip"></i>
        <span class="title">{{ trans('menu.reports') }}</span>
    </a>
</li>
@endpermission

@permission(['search'])
<li class="nav-item {{ Request::is('search*') ? 'active' : '' }}">
    <a href="{{ route('search') }}" class="nav-link">
        <i class="fa fa-search"></i>
        <span class="title">{{ trans('menu.search') }}</span>
    </a>
</li>
@endpermission

@permission(['manual'])
<li class="nav-item">
    <a href="{{ route('manual') }}" class="nav-link">
        <i class="fa fa-download"></i>
        <span class="title">Manual</span>
    </a>
</li>
@endpermission

@permission(['admin'])
<li class="heading">
    <h3 class="uppercase">{{ trans('menu.administrator_menu') }}</h3>
</li>

@permission(['admin-users'])
<li class="nav-item {{ Request::is('admin/user/*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-users"></i>
        <span class="title">{{ trans('menu.user_management') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
        @permission(['admin-users-ttpm'])
        <li class="{{ Request::is('admin/user/ttpm*') ? 'active' : '' }}">
            <a href="{{ route('ttpm') }}" class="nav-link">
                <i class="fa fa-user"></i>
                <span class="title">{{ trans('menu.ttpm_user') }}</span>
                {!! Request::is('admins/ttpmuser*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission

        @permission(['admin-users-public'])
        <li class="{{ Request::is('admin/user/public*') ? 'active' : '' }}">
            <a href="{{ route('public') }}" class="nav-link">
                <i class="fa fa-user"></i>
                <span class="title">{{ trans('menu.reg_user') }}</span>
                {!! Request::is('admins/listroles*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        @endpermission
    </ul>
</li>
@endpermission
@permission(['admin-roles'])
<li class="nav-item {{ Request::is('admin/listroles*') ? 'active' : '' }}">
    <a href="{{ route('admins.listroles') }}" class="nav-link">
        <i class="fa fa-user-secret"></i>
        <span class="title">{{ trans('menu.role_management') }}</span>
        {!! Request::is('admins/listroles*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission
@permission(['admin-permissions'])
<li class="nav-item {{ Request::is('admin/listpermissions*') ? 'active' : '' }}">
    <a href="{{ route('admins.listpermissions') }}" class="nav-link">
        <i class="fa fa-tasks"></i>
        <span class="title">{{ trans('menu.permission') }}</span>
        {!! Request::is('admins/listpermissions*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission
@permission(['admin-settings'])
<li class="{{ Request::is('settings*') ? 'active' : '' }}">
    <a href="{{ route('settings') }}" class="nav-link">
        <i class="fa fa-cog"></i>
        <span class="title">{{ trans('menu.settings') }}</span>
        {!! Request::is('settings*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission
@permission(['admin-backup'])
<li class="{{ Request::is('admin/backup*') ? 'active' : '' }}">
    <a href="{{ route('backup') }}" class="nav-link">
        <i class="fa fa-cog"></i>
        <span class="title">{{ trans('menu.backup_manager') }}</span>
        {!! Request::is('admin/backup*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission
@permission(['admin-translations'])
<li class="nav-item {{ Request::is('translations*') ? 'active' : '' }}">
    <a href="{{ url('translations') }}" class="nav-link">
        <i class="fa fa-cogs"></i>
        <span class="title">{{ trans('menu.translation_manager') }}</span>
        {!! Request::is('translations*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission
@permission(['admin-audit'])
<li class="nav-item {{ Request::is('log/audittrail*') ? 'active' : '' }}">
    <a href="{{ route('audit-trail') }}" class="nav-link">
        <i class="fa fa-cogs"></i>
        <span class="title">{{ trans('menu.audit_trail') }}</span>
        {!! Request::is('log/audittrail*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission
@permission(['admin-myidentity-log'])
<li class="nav-item {{ Request::is('log/myidentity*') ? 'active' : '' }}">
    <a href="{{ route('log-myidentity') }}" class="nav-link">
        <i class="fa fa-user-secret"></i>
        <span class="title">{{ trans('menu.log_myidentity') }}</span>
        {!! Request::is('log/myidentity*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission
@permission(['admin-ks'])
<li class="nav-item {{ Request::is('admin/master*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-cog"></i>
        <span class="title">{{ trans('menu.masterdata') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
        <li class="{{ Request::is('admin/master/branch*') ? 'active' : '' }}">
            <a href="{{ route('master.branch') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.master_branch') }}</span>
                {!! Request::is('admins/master/branch*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/subdistricts/*') ? 'active' : '' }}">
            <a href="{{ route('master.subdistricts.index') }}" class="nav-link">
                <i class="fa fa-gears"></i>
                <span class="title">{{ __('menu.master_subdistrict') }}</span>
                {!! Request::is('admins/master/subdistricts*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/classification*') ? 'active' : '' }}">
            <a href="{{ route('master.classification') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.master_classification') }}</span>
                {!! Request::is('admins/master/classification*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/hearing_room*') ? 'active' : '' }}">
            <a href="{{ route('master.hearing_room') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.hearing_room') }}</span>
                {!! Request::is('admin/master/hearing_room') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/organization*') ? 'active' : '' }}">
            <a href="{{ route('master.organization') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.organization') }}</span>
                {!! Request::is('admin/master/organization') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
    </ul>
</li>
@endpermission
@permission(['admin-masters'])
<li class="nav-item {{ Request::is('admin/master*') ? 'active open' : '' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-cog"></i>
        <span class="title">{{ trans('menu.masterdata') }}</span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
        <li class="{{ Request::is('admin/master/branch*') ? 'active' : '' }}">
            <a href="{{ route('master.branch') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.master_branch') }}</span>
                {!! Request::is('admins/master/branch*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/subdistricts/*') ? 'active' : '' }}">
            <a href="{{ route('master.subdistricts.index') }}" class="nav-link">
                <i class="fa fa-gears"></i>
                <span class="title">{{ __('menu.master_subdistrict') }}</span>
                {!! Request::is('admins/master/subdistricts*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/classification*') ? 'active' : '' }}">
            <a href="{{ route('master.classification') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.master_classification') }}</span>
                {!! Request::is('admins/master/classification*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/category*') ? 'active' : '' }}">
            <a href="{{ route('master.category') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.master_category') }}</span>
                {!! Request::is('admins/master/category*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/submission_type*') ? 'active' : '' }}">
            <a href="{{ route('master.submission_type') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.master_submission_type') }}</span>
                {!! Request::is('admins/master/submission_type*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/holiday') ? 'active' : '' }}">
            <a href="{{ route('master.holiday') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.holiday') }}</span>
                {!! Request::is('admin/master/holiday') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/holiday_event*') ? 'active' : '' }}">
            <a href="{{ route('master.holiday_event') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.holiday_event') }}</span>
                {!! Request::is('admin/master/holiday_event*') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/hearing_room*') ? 'active' : '' }}">
            <a href="{{ route('master.hearing_room') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.hearing_room') }}</span>
                {!! Request::is('admin/master/hearing_room') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/hearing_venue*') ? 'active' : '' }}">
            <a href="{{ route('master.hearing_venue') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.hearing_venue') }}</span>
                {!! Request::is('admin/master/hearing_venue') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/occupation*') ? 'active' : '' }}">
            <a href="{{ route('master.occupation') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.occupation') }}</span>
                {!! Request::is('admin/master/occupation') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/offence_type*') ? 'active' : '' }}">
            <a href="{{ route('master.offence_type') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.offence_type') }}</span>
                {!! Request::is('admin/master/offence_type') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/organization*') ? 'active' : '' }}">
            <a href="{{ route('master.organization') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.organization') }}</span>
                {!! Request::is('admin/master/organization') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/stop_reason*') ? 'active' : '' }}">
            <a href="{{ route('master.stop_reason') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.stop_reason') }}</span>
                {!! Request::is('admin/master/stop_reason') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/stop_method*') ? 'active' : '' }}">
            <a href="{{ route('master.stop_method') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.stop_method') }}</span>
                {!! Request::is('admin/master/stop_method') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/application_method*') ? 'active' : '' }}">
            <a href="{{ route('master.application_method') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.application_method') }}</span>
                {!! Request::is('admin/master/application_method') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/inquiry_method*') ? 'active' : '' }}">
            <a href="{{ route('master.inquiry_method') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.inquiry_method') }}</span>
                {!! Request::is('admin/master/inquiry_method') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/salutation*') ? 'active' : '' }}">
            <a href="{{ route('master.salutation') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.salutation') }}</span>
                {!! Request::is('admin/master/salutation') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/reason*') ? 'active' : '' }}">
            <a href="{{ route('master.reason') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.visitor_reason') }}</span>
                {!! Request::is('admin/master/reason') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/term*') ? 'active' : '' }}">
            <a href="{{ route('master.term') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.term') }}</span>
                {!! Request::is('admin/master/term') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/court*') ? 'active' : '' }}">
            <a href="{{ route('master.court') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.court') }}</span>
                {!! Request::is('admin/master/court') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
        <li class="{{ Request::is('admin/master/designation*') ? 'active' : '' }}">
            <a href="{{ route('master.designation') }}" class="nav-link">
                <i class="fa fa-circle"></i>
                <span class="title">{{ trans('menu.designation') }}</span>
                {!! Request::is('admin/master/designation') ? '<span class="selected"></span>' : '' !!}
            </a>
        </li>
    </ul>
</li>
@endpermission
@permission(['portal'])
<li class="heading">
    <h3 class="uppercase">{{ trans('menu.cms_portal') }}</h3>
</li>

<li class="nav-item {{ Request::is('cms/menu*') ? 'active' : '' }}">
    <a href="{{ route('cms.menu') }}" class="nav-link">
        <i class="fa fa-tasks"></i>
        <span class="title">{{ trans('menu.menu') }}</span>
        {!! Request::is('cms/menu*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
<li class="nav-item {{ Request::is('cms/page*') ? 'active' : '' }}">
    <a href="{{ route('cms.page') }}" class="nav-link">
        <i class="fa fa-files-o"></i>
        <span class="title">{{ trans('menu.pages') }}</span>
        {!! Request::is('cms/page*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
<li class="nav-item {{ Request::is('cms/announcement*') ? 'active' : '' }}">
    <a href="{{ route('cms.announcement') }}" class="nav-link">
        <i class="fa fa-bullhorn"></i>
        <span class="title">{{ trans('menu.announcement') }}</span>
        {!! Request::is('cms/announcement*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
<li class="nav-item {{ Request::is('admin/master/directory/hq*') ? 'active' : '' }}">
    <a href="{{ route('master.directory.hq') }}" class="nav-link">
        <i class="fa fa-cog"></i>
        <span class="title">{{ trans('menu.directory_hq') }}</span>
        {!! Request::is('admin/master/directory/hq*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
<li class="nav-item {{ Request::is('admin/master/directory/branch*') ? 'active' : '' }}">
    <a href="{{ route('master.directory.branch') }}" class="nav-link">
        <i class="fa fa-cog"></i>
        <span class="title">{{ trans('menu.directory_branch') }}</span>
        {!! Request::is('admin/master/directory/branch*') ? '<span class="selected"></span>' : '' !!}
    </a>
</li>
@endpermission
@endpermission
