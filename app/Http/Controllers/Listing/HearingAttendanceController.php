<?php

namespace App\Http\Controllers\Listing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\CaseModel\Form4;
use App\ViewModel\ViewListHearingAttendance;
use App;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHearingRoom;
use Carbon\Carbon;
use Auth;

class HearingAttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('listing.hearing.attendance', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'asc')->get(); //GET VALUE FROM DB

        if ((Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) && !$request->has('branch')) {
            return redirect()->route('listing.hearing', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if ($request->ajax()) {

            $hearing_attendance = ViewListHearingAttendance::orderBy('filing_date', 'desc');

            if ($request->has('hearing_date') || $request->has('branch') || $request->has('hearing_place') || $request->has('hearing_room')) {

                if ($request->has('hearing_date') && !empty($request->hearing_date))
                    $hearing_attendance->whereHas('form4', function ($form4) use ($request) {
                        return $form4->whereHas('hearing', function ($hearing) use ($request) {
                            return $hearing->where('hearing_date', Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString());
                        });
                    });

                if ($request->has('branch') && !empty($request->branch))
                    $hearing_attendance->whereHas('form4', function ($form4) use ($request) {
                        return $form4->whereHas('hearing', function ($hearing) use ($request) {
                            return $hearing->where('branch_id', $request->branch);
                        });
                    });

                if ($request->has('hearing_place') && !empty($request->hearing_place))
                    $hearing_attendance->whereHas('form4', function ($form4) use ($request) {
                        return $form4->whereHas('hearing', function ($hearing) use ($request) {
                            return $hearing->whereHas('hearing_room', function ($hearing_room) {
                                return $hearing_room->where('hearing_venue_id', $request->hearing_place);
                            });
                        });
                    });

                if ($request->has('hearing_room') && !empty($request->hearing_room))
                    $hearing_attendance->whereHas('form4', function ($form4) use ($request) {
                        return $form4->whereHas('hearing', function ($hearing) use ($request) {
                            return $hearing->where('hearing_room_id', $request->hearing_room);
                        });
                    });

                // if($request->has('hearing_date') && !empty($request->hearing_date))
                // 	$hearing_attendance = $hearing_attendance->filter(function ($value) use ($request) {
                // 		return $value->form4->hearing->hearing_date == Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString();
                // 	}); //CARBON IS SPECIAL FOR DATE AND TIME
                // if($request->has('branch') && !empty($request->branch))
                // 	$hearing_attendance = $hearing_attendance->filter(function ($value) use ($request) {
                // 		return $value->form4->hearing->branch_id == $request->branch;
                // 	});

                // if($request->has('hearing_place') && !empty($request->hearing_place))
                // 	$hearing_attendance = $hearing_attendance->filter(function ($value) use ($request) {
                // 		return $value->form4->hearing->hearing_room->hearing_venue_id == $request->hearing_place;
                // 	});

                // if($request->has('hearing_room') && !empty($request->hearing_room))
                // 	$hearing_attendance = $hearing_attendance->filter(function ($value) use ($request) {
                // 		return $value->form4->hearing->hearing_room_id == $request->hearing_room;
                // 	});
            }

            $datatables = Datatables::of($hearing_attendance);
            return $datatables
                ->editColumn('case_no', function ($hearing_attendance) {
                    return $hearing_attendance->case_no;
                })
                ->editColumn('filing_date_form1_raw', function ($hearing_attendance) {
                    return $hearing_attendance->filing_date;
                })
                ->editColumn('claimant_name', function ($hearing_attendance) {
                    return $hearing_attendance->case->claimant_address ? $hearing_attendance->case->claimant_address->name : '';
                })
                ->editColumn('opponent_name', function ($hearing_attendance) {
                    return $hearing_attendance->case->opponent_address ? $hearing_attendance->case->opponent_address->name : '';
                })
                ->editColumn('form2_status', function ($hearing_attendance) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    if ($hearing_attendance->f2_status)
                        return __('new.filed');
                    else
                        return __('new.not_filed');
                })
                ->editColumn('form3_status', function ($hearing_attendance) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    if ($hearing_attendance->f3_status)
                        return __('new.filed');
                    else
                        return __('new.not_filed');
                })
                ->editColumn('form11_status', function ($hearing_attendance) {
                    if ($hearing_attendance->form11_id)
                        return __('new.filed');
                    else
                        return __('new.not_filed');
                })
                ->editColumn('form12_status', function ($hearing_attendance) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    if ($hearing_attendance->f12_status)
                        return __('new.filed');
                    else
                        return __('new.not_filed');
                })->editColumn('hearing_date', function ($hearing_attendance) {
                    return date('d/m/Y', strtotime($hearing_attendance->form4->hearing->hearing_date));
                })->editColumn('is_claimant_present', function ($hearing_attendance) {
                    if ($hearing_attendance->form4->attendance)
                        if ($hearing_attendance->form4->attendance->is_claimant_present == 1)
                            return __('new.attend');
                        else
                            return __('new.not_attend');
                    else return "-";
                })->editColumn('is_opponent_present', function ($hearing_attendance) {
                    if ($hearing_attendance->form4->attendance)
                        if ($hearing_attendance->form4->case->opponent->public_data->user_public_type_id == 1) {
                            if ($hearing_attendance->form4->attendance->is_opponent_present == 1)
                                return __('new.attend');
                            else
                                return __('new.not_attend');
                        } else {
                            $attend = __('new.not_attend');
                            foreach($hearing_attendance->form4->attendance->representative as $rep) {
                                if($rep->is_present) {
                                    return __('new.attend');
                                }
                            }

                            return $attend;
                        }
                    else return "-";
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "HearingAttendanceController", null, null, "Datatables load hearing attendance");
        return view("hearing_attendance.view", compact('form4', 'hearing_date', 'branch', 'hearingplace', 'hearingRoom', 'branches', 'hearinges'));
    }
}