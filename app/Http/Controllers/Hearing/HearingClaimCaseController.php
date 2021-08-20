<?php

namespace App\Http\Controllers\Hearing;

use App;
use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form4;
use App\HearingModel\Hearing;
use App\HearingModel\PresidentSchedule;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;
use App\Repositories\LogAuditRepository;
use App\SupportModel\Form4Reset;
use App\UserImage;
use App\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Response;
use Yajra\Datatables\Datatables;

class HearingClaimCaseController extends Controller
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

    /**
     * Datatable ajax request for listhearingcc
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @throws \Exception
     */
    public function tablehearingcc(Request $request)
    {
        $branch_id = auth()->user()->ttpm_data->branch_id;

        if ($request->ajax()) {
            $branch_id = $request->has('branch') ? $request->branch : $branch_id;

            if ($request->has('hearing_date')) {
                $hearing = Hearing::find($request->hearing_date);
                $hearing_date = Carbon::createFromFormat('Y-m-d', $hearing->hearing_date);
            } else {
                $hearing_date = Carbon::parse();
            }

            $datatables = Datatables::of(self::hearingWithoutDateQuery($branch_id));

            return self::hearingWithoutDateDt($datatables, $request, $hearing_date);
        }
    }

    /**
     * Show list of form4 that not have hearing id yet.
     * form4 must have been created. just not have form4 yet.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function listhearingcc(Request $request)
    {
        $branch_id = auth()->user()->ttpm_data->branch_id;

//        dd(self::hearingWithoutDateQuery($branch_id)->get());

        if ($request->ajax()) {
            $branch_id = $request->has('branch') ? $request->branch : $branch_id;

            if ($request->has('hearing_date')) {
                $hearing = Hearing::find($request->hearing_date);
                $hearing_date = Carbon::createFromFormat('Y-m-d', $hearing->hearing_date);
            } else {
                $hearing_date = Carbon::parse();
            }

            $datatables = Datatables::of(self::hearingWithoutDateQuery($branch_id));

            return self::hearingWithoutDateDt($datatables, $request, $hearing_date);
        }
        $schedule = PresidentSchedule::all();

        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('psu-hq')) {
            $branch = MasterBranch::where('is_active', 1)
                ->where('branch_id', Auth::user()->ttpm_data->branch_id)
                ->orderBy('branch_id', 'desc')
                ->get();
        } else {
            $branch = MasterBranch::where('is_active', 1)
                ->orderBy('branch_id', 'desc')
                ->get();
        }

        LogAuditRepository::store($request, 12, "HearingClaimCaseController", null, null, "Datatables claim without hearing date");

        return view('hearing_claim_case.index', compact('schedule', 'branch'));
    }

    public function namelist(Request $request)
    {
        $idcase = $request->sentlist;
        $listcase = ClaimCaseOpponent::with('claimCase')
            ->wherein('id', $idcase)
            ->get();

        $list = $listcase->mapWithKeys(function ($q) {
            return [$q->id => $q->claimCase->case_no . ' (Penentang - ' . $q->opponent_address->name . ')'];
        });

        return Response::json(['listcase' => $list->toArray(), 'idcase' => $idcase]);
    }

    /**
     * Sent Choosen Case
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function sentchoosencase(Request $request)
    {
        $listcase = $request->sentlist;
        $fielddata = $request->fields;
        foreach ($listcase as $key => $claim_case_id) {
            $claim_case_opponent = ClaimCaseOpponent::with('claimCase')
                ->find($claim_case_id);

            if ($claim_case_opponent->claimCase->form4_latest && $claim_case_opponent->claimCase->form4_latest->form4) {
                $form12_id = $claim_case_opponent->claimCase->form4_latest->form4->form12 ? $claim_case_opponent->claimCase->form4_latest->form4->form12->form12_id : null;
            } else {
                // if not have please check with claim_case_id
                // if exists, then link to latest f4 data
                $form12_id = null;
            }

            $form4_id = Form4::create(
                [
                    'opponent_user_id' => $claim_case_opponent->opponent_user_id,
                    'claim_case_opponent_id' => $claim_case_opponent->id,
                    'claim_case_id' => $claim_case_opponent->claim_case_id,
                    'hearing_id' => $fielddata,
                    'form12_id' => $form12_id,
                    'created_by_user_id' => Auth::id(),
                    'psu_user_id' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );

            $claim_case_opponent->update([
                "case_status_id" => 7,
            ]);
        }
        return Response::json(['status' => 'ok']);
    }

    /**
     * Hearing Single Verify
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function hearingsingleverify(Request $request)
    {
        $listcase = $request->sentlist;
        $fielddata = $request->fields;

        $claim_case_opponent = ClaimCaseOpponent::with('claimCase')
            ->find($listcase[0]);

        if ($claim_case_opponent->claimCase->form4_latest) {
            $form12_id = $claim_case_opponent->claimCase->form4_latest->form4->form12 ? $claim_case_opponent->claimCase->form4_latest->form4->form12->form12_id : null;
        } else {
            $form12_id = null;
        }

        $form4_id = Form4::create(
            [
                'opponent_user_id' => $claim_case_opponent->opponent_user_id,
                'claim_case_opponent_id' => $claim_case_opponent->id,
                'claim_case_id' => $claim_case_opponent->claim_case_id,
                'hearing_id' => $fielddata,
                'form12_id' => $form12_id,
                'created_by_user_id' => Auth::id(),
                'psu_user_id' => Auth::id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        $claim_case_opponent->update([
            "case_status_id" => 7,
        ]);
        return Response::json(['status' => 'ok']);
    }

    /**
     * update hearing date of claim case
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function listUpdate(Request $request)
    {
        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('hearing-update-list', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        $states = MasterState::get();

        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('psu-hq')) {
            $branches = MasterBranch::where('is_active', 1)
                ->where('branch_id', Auth::user()->ttpm_data->branch_id)->orderBy('branch_id', 'desc')
                ->get();
        } else {
            $branches = MasterBranch::where('is_active', 1)
                ->orderBy('branch_id', 'desc')
                ->get();
        }

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $hearing_date = date('d/m/Y');

        if ($request->ajax()) {
            $form4 = Form4::doesntHave('reset')
                ->with(['case.claimant','hearing.president', 'hearing.hearing_room.venue', 'president'])
                ->whereNull('hearing_status_id')
                ->orderBy('form4.created_at', 'desc');

            if ($request->has('branch') || $request->has('year') || $request->has('month') || $request->has('hearing_date')) {
                if ($request->has('hearing_date') && !empty($request->hearing_date)) {
                    $form4->whereHas('hearing', function ($hearing) use ($request) {
                        return $hearing->whereDate('hearing_date', Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString());
                    });
                }

                if ($request->has('branch') && !empty($request->branch)) {
                    $form4->where(function ($q) use ($request) {
                        $q->whereHas('case', function ($case) use ($request) {
                            return $case->where('branch_id', $request->branch)
                                ->orWhere('transfer_branch_id', $request->branch);
                        });
                    });
                }

                if ($request->has('year') && !empty($request->year)) {
                    $form4->whereHas('hearing', function ($hearing) use ($request) {
                        return $hearing->whereYear('hearing_date', $request->year);
                    });
                }

                if ($request->has('month') && !empty($request->month)) {
                    $form4->whereHas('hearing', function ($hearing) use ($request) {
                        return $hearing->whereMonth('hearing_date', $request->month);
                    });
                }
            }

            $datatables = Datatables::of($form4);

            return $datatables
                ->addColumn('checkbox', function ($form4) {
                    return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
				                <input onchange="updateSelection(this)" name="selectedF4" type="checkbox" class="checkboxes" value="' . $form4->form4_id . '" />
				                <span></span>
				            </label>';
                })
                ->addColumn('case_no', function ($form4) {
                    return $form4->case->case_no;
                })
                ->addColumn('claimant_name', function ($form4) {
                    return $form4->case->claimant->name;
                })
                ->addColumn('hearing_date', function ($form4) {
                    // return Carbon::parse( )->format('d/m/Y');
                    return date('d/m/Y', strtotime($form4->hearing->hearing_date));
                })
                ->addColumn('hearing_venue', function ($form4) {
                    if ($form4->hearing->hearing_room_id) {
                        if ($form4->hearing->hearing_room->venue) {
                            return $form4->hearing->hearing_room->venue->hearing_venue;
                        } else {
                            return '-';
                        }
                    } else {
                        return '-';
                    }
                })
                ->addColumn('hearing_room', function ($form4) {
                    if ($form4->hearing->hearing_room_id) {
                        return $form4->hearing->hearing_room->hearing_room;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('president_name', function ($form4) {
                    return $form4->president ? $form4->president->name : ($form4->hearing->president ? $form4->hearing->president->name : '-');
                })
                ->make(true);
        }

        return view('hearing/date/listUpdate', compact('form4', 'branches', 'years', 'months', 'hearing_date', 'states'));
    }

    public function submitUpdate(Request $request)
    {
        $rules = [
            'hearing_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        $f4_list = explode(",", $request->selectedF4);

        foreach ($f4_list as $f4) {
            Form4::find($f4)->update(['hearing_id' => $request->hearing_id, 'form_status_id' => 35, 'psu_user_id' => Auth::id()]);
            $form4 = Form4::findOrFail($f4);
            $case = ClaimCase::find($form4->claim_case_id);
            $case->update([
                'hearing_venue_id' => $request->hearing_venue_id,
                'transfer_branch_id' => $request->transfer_branch_id
            ]);
        }

        return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    }

    public function submitReset(Request $request)
    {
        $rules = [
            'hearing_id' => 'required|integer',
            'reason' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        $f4_list = explode(",", $request->selectedF4);

        foreach ($f4_list as $f4) {
            $reset = new Form4Reset;
            $reset->form4_id = $f4;
            $reset->reset_reason = $request->reason;
            $reset->save();

            $old = Form4::find($f4);
            $new = $old->replicate();
            $new->hearing_id = $request->hearing_id;
            $new->psu_user_id = Auth::id();
            $new->save();
        }

        return Response::json(['status' => 'ok', 'message' => __('new.reset_success')]);
    }

    public static function hearingWithoutDateQuery($branch_id)
    {
        return ClaimCaseOpponent::with([
            'claimCase', 'claimCase.form1'
        ])
            ->select([DB::raw('claim_case_opponents.*'), 'claim_case.form1_id'])
            ->join('claim_case', 'claim_case_opponents.claim_case_id', '=', 'claim_case.claim_case_id')
            ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->whereHas('claimCase', function ($q) use ($branch_id) {
                $q->where('case_status_id', '>=', 2)
                    ->whereHas('form1', function ($r) {
                        $r->where('form_status_id', 17);
                    })
                    ->where(function ($q) use ($branch_id) {
                        $q->where('branch_id', $branch_id)
                            ->orWhere('transfer_branch_id', $branch_id);
                    })
                    ->whereBetween('created_at', ['2015-01-01 00:00:00', date('Y-m-d H:i:s')]);
            })
            ->where(function ($r) {
                $r->doesntHave('form4')
                    ->orWhereHas('form4Latest.form4', function ($r) {
                        $r->whereIn('hearing_status_id', [3, 2])
                            ->orWhere(function ($s) {
                                $s->whereIn('hearing_status_id', [1])
                                    ->has('form12');
                            });
                    });
            })
            ->orderBy('form1.processed_at', 'desc');
    }

    public function hearingWithoutDateDt($datatables, $request, $hearing_date)
    {
        return $datatables
//                ->editColumn('id', function ($case) {
//                    return $case->case_no;
//                })
            ->editColumn('checkbox', function ($case) {
                $show = '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes checkterima" value="' . $case->id . '" name="check[' . $case->id . ']">
                    <span></span>
                    </label>';
                return $show;
            })
            ->addColumn('case_no', function ($case) {
                return $case->claimCase->case_no;
            })
            ->addColumn('matured_date', function ($case) use ($request, $hearing_date) {
                $matured_date = Carbon::createFromFormat('Y-m-d', $case->claimCase->form1->matured_date);
                return "<span style='" . ($matured_date->diffInDays($hearing_date, false) < 1 ? 'color:#9E1E34' : '') . "'>" . $matured_date->format('d/m/Y') ?? '-' . "</span>";
            })
            ->addColumn('claimant', function ($case) {
                return $case->claimCase->claimant_address ? $case->claimCase->claimant_address->name : '';
            })
            ->addColumn('opponent', function ($case) {
                return $case->opponent_address ? $case->opponent_address->name : '-';
            })
            ->addColumn('type', function ($case) {
                if ($case->claimCase->case_status_id <= 6)
                    return __('new.new');
                else if (!$case->last_form4)
                    return __('new.new');
                else if ($case->last_form4->hearing_status_id == 3 || $case->last_form4->hearing_status_id == 2)
                    return __('new.postponed');
                else if ($case->last_form4->hearing_status_id == 1 && $case->last_form4->form12)
                    return __('new.form12');
                else return '-';
            })
            ->rawColumns(['checkbox', 'name', 'description', 'tindakan'])
            ->make(true);
    }

}
