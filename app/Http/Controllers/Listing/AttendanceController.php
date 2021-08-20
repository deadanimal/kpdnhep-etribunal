<?php

namespace App\Http\Controllers\Listing;

use App\Repositories\LogAuditRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHearingVenue;

use App\MasterModel\MasterDesignation;
use App\MasterModel\MasterRelationship;


use App\SupportModel\AttendanceMinutes;
use App\SupportModel\Attendance;
use App\SupportModel\AttendanceRepresentative;
use App;
use Auth;
use PDF;
use DB;
use App\User;
use App\RoleUser;
use App\CaseModel\Form4;


class AttendanceController extends Controller
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
     * List of attendance
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('listing.attendance', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        $branches = MasterBranch::where('is_active', 1)
            ->orderBy('branch_id', 'desc')
            ->get();

        if ($request->ajax()) {
            $userid = Auth::id();
            $user = User::find($userid);

            $form4 = Form4::orderBy('created_at', 'desc');

            if ($request->search['value']) {
                $form4->whereHas('case', function ($case) use ($request) {
                    return $case
                        ->where('case_no', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhereHas('claimant_address', function ($claimant_address) use ($request) {
                            return $claimant_address->where('identification_no', 'LIKE', '%' . $request->search['value'] . '%');
                        })
                        ->orWhereHas('opponent_address', function ($opponent_address) use ($request) {
                            return $opponent_address->where('identification_no', 'LIKE', '%' . $request->search['value'] . '%');
                        });
                });
            }

            if ($request->has('hearing_date') && !empty($request->hearing_date)) {
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    return $hearing->where('hearing_date', Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString());
                });
            }

            if ($request->has('branch') && !empty($request->branch)) {
                $form4->whereHas('case', function ($case) use ($request) {
                    {
                        return $case->where(function ($q) use ($request) {
                            $q->where('branch_id', $request->branch)
                                ->orWhere('transfer_branch_id', $request->branch);
                        });
                    }
                });
            }

            if ($request->has('hearing_place') && !empty($request->hearing_place)) {
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    return $hearing->whereHas('hearing_room', function ($hearing_room) use ($request) {
                        return $hearing_room->where('hearing_venue_id', $request->hearing_place);
                    });
                });
            }

            if ($request->has('hearing_room') && !empty($request->hearing_room)) {
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    return $hearing->where('hearing_room_id', $request->hearing_room);
                });
            }

            if ($request->has('claim_case_opponent_id') && !empty($request->claim_case_opponent_id)) {
                $form4->where('claim_case_opponent_id', $request->claim_case_opponent_id);
            }

            if ($request->has('hearing_id') && !empty($request->hearing_id)) {
                $form4->where('hearing_id', $request->hearing_id);
            }

            $datatables = Datatables::of($form4);

            return $datatables
                ->editColumn('claim_details', function ($form4) {
                    $relationships = MasterRelationship::where('relationship_id', '!=', 3)->get();
                    $designations = MasterDesignation::where('is_active', 1)->get();
                    $locale = App::getLocale();
                    $relationship_lang = "relationship_" . $locale;
                    $designation_lang = "designation_" . $locale;
                    $attendance = Attendance::where('form4_id', $form4->form4_id)->get();

                    if ($attendance->count() > 0) {
                        $attendance = $attendance->first();
                        $attendance_rep_claimant = AttendanceRepresentative::where('attendance_id', $attendance->attendance_id)
                            ->where('is_representing_claimant', 1)
                            ->get();
                        $attendance_rep_opponent = AttendanceRepresentative::where('attendance_id', $attendance->attendance_id)
                            ->where('is_representing_claimant', 0)
                            ->get();
                    } else {
                        $attendance = null;
                        $attendance_rep_claimant = null;
                        $attendance_rep_opponent = null;
                    }

                    $result = '
                        <form method="post" action="' . route('listing.attendance.save', [$form4->form4_id]) . '">
                            <table class="data" style="width: 100%; border-color: #9d9a9a">
                                <tr style="text-align: center; font-weight: bold">
                                    <td colspan="3">' . __('new.claim_name') . '</td>
                                    <td colspan="5">' . __('new.representative') . '</td>
                                </tr>
                                <tr style="text-align: center;">
                                
                                    <td colspan="3">
                                        <input id="' . $form4->form4_id . '_form4_id" name="form4_id" type="hidden" value="' . $form4->form4_id . '"/>
                                        <a class="btn btn-xs dark" href="' . route('claimcase-view-cc', [$form4->claim_case_opponent_id, 'cc']) . '"><i class="fa fa-search"></i> ' . $form4->case->case_no . '</a> | ' . date('d/m/Y', strtotime($form4->case->created_at))
                        . ' </td>
                                    <td colspan="5"><a class="btn btn-xs dark btn-outline" onclick="processAttendance(' . $form4->form4_id . ')"><i class="fa fa-print"></i> ' . __('new.print_minutes') . '</a></td>
                                </tr>';


                    for ($i = 1; $i < 4; $i++) {

                        $rep_data = null;
                        if ($attendance_rep_claimant)
                            if ($attendance_rep_claimant->count() >= $i)
                                $rep_data = $attendance_rep_claimant->get($i - 1);

                        if ($i == 1) {
                            $result .= '
                                <tr>
                                    <td rowspan="3" style="text-align: center">PYM</td>
                                    <td rowspan="3" style="text-align: center; width: 6%">
                                        <div class="md-checkbox-inline md-checkbox">
                                            <input id="' . $form4->form4_id . '_is_attendance_claimant" name="is_attendance_claimant" type="checkbox" value="1" ';

                            if ($attendance)
                                if ($attendance->is_claimant_present == 1)
                                    $result .= ' checked ';

                            $result .= '
                                    />
                                            <label for="' . $form4->form4_id . '_is_attendance_claimant">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td rowspan="3" style="width:200px">
                                        <a class="btn btn-xs blue btn-outline" href="' . route('others.claimsubmission.create.pym', ['id' => $form4->form4_id]) . '"><i class="fa fa-search"></i> ' . $form4->case->claimant_address->name . '</a>
                                    </td>';
                        } else
                            $result .= '<tr>';

                        $result .= '    <td style="text-align: center; width: 6%">
                                        <div class="md-checkbox-inline md-checkbox">
                                            <input id="' . $form4->form4_id . '_is_attendance_rep_claimant' . $i . '" name="is_attendance_rep_claimant' . $i . '" type="checkbox" value="1" ';

                        if ($rep_data)
                            if ($rep_data->is_present == 1)
                                $result .= 'checked';


                        $result .= ' />
                                            <label for="' . $form4->form4_id . '_is_attendance_rep_claimant' . $i . '">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control" name="name_rep_claimant' . $i . '" placeholder="' . __('new.name') . '" value="';

                        if ($rep_data)
                            $result .= $rep_data->name;


                        $result .= '"></td>
                                    <td><div class="input-icon right"><i class="clickme fa fa-question font-green" onclick="checkMyIdentity(this)"></i><input type="text" class="form-control numeric" maxlength="12" name="ic_rep_claimant' . $i . '" placeholder="' . __('new.ic_short') . '" value="';

                        if ($rep_data)
                            $result .= $rep_data->identification_no;

                        $result .= '"></div></td>
                                    <td>
                                        <select class="form-control" name="relationship_rep_claimant' . $i . '" data-placeholder="' . __('hearing.please_choose') . '">
                                        <option value="" selected disabled hidden>' . __('hearing.please_choose') . '</option>';

                        foreach ($relationships as $rel) {
                            $result .= '<option ';

                            if ($rep_data)
                                if ($rep_data->relationship_id == $rel->relationship_id)
                                    $result .= 'selected';

                            $result .= ' value="' . $rel->relationship_id . '">' . $rel->$relationship_lang . '</option>';
                        }


                        $result .= '
                                    </td>
                                    <td>
                                        <a class="btn btn-xs red" onclick="clearRow(this)"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>';
                    }


                    if ($form4->claimCaseOpponent && $form4->claimCaseOpponent->opponent && $form4->claimCaseOpponent->opponent->public_data && $form4->claimCaseOpponent->opponent->public_data->user_public_type_id == 2) {
                        for ($i = 1; $i < 4; $i++) {

                            $rep_data = null;
                            if ($attendance_rep_opponent)
                                if ($attendance_rep_opponent->count() >= $i)
                                    $rep_data = $attendance_rep_opponent->get($i - 1);

                            if ($i == 1) {
                                $result .= '
                                <tr>
                                    <td rowspan="3" style="text-align: center">P</td>
                                    <td rowspan="3" colspan="2" style="width:200px">
                                        <a class="btn btn-xs blue btn-outline" href="' . route('others.claimsubmission.create.p', ['id' => $form4->form4_id]) . '"><i class="fa fa-search"></i> ' . ($form4->claimCaseOpponent ? $form4->claimCaseOpponent->opponent_address->name : 'N/A') . '</a>
                                    </td>';
                            } else
                                $result .= '<tr>';

                            $result .= '    <td style="text-align: center; width: 6%">
                                        <div class="md-checkbox-inline md-checkbox">
                                            <input id="' . $form4->form4_id . '_is_attendance_rep_opponent' . $i . '" name="is_attendance_rep_opponent' . $i . '" type="checkbox" value="1" ';

                            if ($rep_data)
                                if ($rep_data->is_present == 1)
                                    $result .= 'checked';


                            $result .= ' />
                                            <label for="' . $form4->form4_id . '_is_attendance_rep_opponent' . $i . '">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control" name="name_rep_opponent' . $i . '" placeholder="' . __('new.name') . '" value="';

                            if ($rep_data)
                                $result .= $rep_data->name;


                            $result .= '"></td>
                                    <td><div class="input-icon right"><i class="clickme fa fa-question font-green" onclick="checkMyIdentity(this)"></i><input type="text" class="form-control numeric" maxlength="12" name="ic_rep_opponent' . $i . '" placeholder="' . __('new.ic_short') . '" value="';

                            if ($rep_data)
                                $result .= $rep_data->identification_no;


                            $result .= '"></div></td>
                                    <td>
                                        <select id="' . $form4->form4_id . '_designation" class="form-control" name="designation_rep_opponent' . $i . '" data-placeholder="' . __('hearing.please_choose') . '">
                                        <option value="" selected disabled hidden>' . __('hearing.please_choose') . '</option>';

                            foreach ($designations as $desg) {
                                $result .= '<option ';

                                if ($rep_data)
                                    if ($rep_data->designation_id == $desg->designation_id)
                                        $result .= 'selected';

                                $result .= ' value="' . $desg->designation_id . '">' . $desg->$designation_lang . '</option>';
                            }


                            $result .= '
                                    </td>
                                    <td>
                                        <a class="btn btn-xs red" onclick="clearRow(this)"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>';

                        }


                    } else {

                        for ($i = 1; $i < 4; $i++) {

                            $rep_data = null;
                            if ($attendance_rep_opponent)
                                if ($attendance_rep_opponent->count() >= $i)
                                    $rep_data = $attendance_rep_opponent->get($i - 1);

                            if ($i == 1) {

                                $result .= '
                                
                                <tr>
                                    <td rowspan="3" style="text-align: center">P</td>
                                    <td rowspan="3" style="text-align: center; width: 6%">
                                        <div class="md-checkbox-inline md-checkbox">
                                            <input id="' . $form4->form4_id . '_is_attendance_opponent" name="is_attendance_opponent" type="checkbox" value="1" ';

                                if ($attendance)
                                    if ($attendance->is_opponent_present == 1)
                                        $result .= ' checked ';


                                $result .= '            />
                                            <label for="' . $form4->form4_id . '_is_attendance_opponent">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td rowspan="3" style="width:200px">
                                        <a class="btn btn-xs blue btn-outline" href="' . route('others.claimsubmission.create.p', ['id' => $form4->form4_id]) . '"><i class="fa fa-search"></i> ' . ($form4->claimCaseOpponent ? $form4->claimCaseOpponent->opponent_address->name : 'N/A') . '</a>
                                    </td>';
                            } else
                                $result .= '<tr>';

                            $result .= '<td style="text-align: center; width: 6%">
                                        <div class="md-checkbox-inline md-checkbox">
                                            <input id="' . $form4->form4_id . '_is_attendance_rep_opponent' . $i . '" name="is_attendance_rep_opponent' . $i . '" type="checkbox" value="1" ';

                            if ($rep_data)
                                if ($rep_data->is_present == 1)
                                    $result .= 'checked';


                            $result .= ' />
                                            <label for="' . $form4->form4_id . '_is_attendance_rep_opponent' . $i . '">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control" name="name_rep_opponent' . $i . '" placeholder="' . __('new.name') . '" value="';

                            if ($rep_data)
                                $result .= $rep_data->name;


                            $result .= '"></td>
                                    <td><div class="input-icon right"><i class="clickme fa fa-question font-green" onclick="checkMyIdentity(this)"></i><input type="text" class="form-control numeric" maxlength="12" name="ic_rep_opponent' . $i . '" placeholder="' . __('new.ic_short') . '" value="';

                            if ($rep_data)
                                $result .= $rep_data->identification_no;


                            $result .= '"></div></td>
                                    <td>
                                        <select id="' . $form4->form4_id . '_designation" class="form-control" name="relationship_rep_opponent' . $i . '" data-placeholder="' . __('hearing.please_choose') . '">
                                        <option value="" selected disabled hidden>' . __('hearing.please_choose') . '</option>';

                            foreach ($relationships as $rel) {
                                $result .= '<option ';

                                if ($rep_data)
                                    if ($rep_data->relationship_id == $rel->relationship_id)
                                        $result .= 'selected';

                                $result .= ' value="' . $rel->relationship_id . '">' . $rel->$relationship_lang . '</option>';
                            }


                            $result .= '
                                    </td>
                                    <td>
                                        <a class="btn btn-xs red" onclick="clearRow(this)"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>';


                        }

                    }// End if

                    $result .= '
                                <tr>
                                    <td colspan="8" style="text-align: center">
                                        <button type="button" class="btn btn-xs green" onclick="submitForm(this)"><i class="fa fa-paper-plane mr10"></i> ' . __('button.save') . '</button>
                                    </td>
                                </tr>
                            </table>
                        </form>';


                    return $result;

                })->make(true);
        }

        LogAuditRepository::store($request, 12, "AttendanceController", null, null, "Datatables load attendance");

        return view("list/attendance/list", compact('branches'));
    }

    protected function rules_insert($request)
    {
        $rules = [];

        $rules['form4_id'] = 'required|integer';

        return $rules;
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules_insert($request));

        if (!$validator->passes()) {
            return Response::json(['result' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }


        // Reset everything
        $attendance = Attendance::where('form4_id', $request->form4_id);

        if ($attendance->count() > 0)
            $backup_id = $attendance->first()->attendance_id;
        else
            $backup_id = 0;


        $attendance->delete();

        $attendance_id = DB::table('attendance')->insertGetId([
            'form4_id' => $request->form4_id,
            'is_claimant_present' => $request->is_attendance_claimant ? 1 : 0,
            'is_opponent_present' => $request->is_attendance_opponent ? 1 : 0,
            'created_by_user_id' => Auth::id()
        ]);

        AttendanceMinutes::where('attendance_id', $backup_id)->update([
            "attendance_id" => $attendance_id
        ]);

        //dd($request->input());


        if ($request->has('name_rep_claimant1') && $request->has('ic_rep_claimant1') && $request->has('relationship_rep_claimant1')) {

            $attendance_rep = DB::table('attendance_representative')->insertGetId([
                'attendance_id' => $attendance_id,
                'is_present' => $request->is_attendance_rep_claimant1,
                'is_representing_claimant' => 1,
                'identification_no' => $request->ic_rep_claimant1,
                'name' => $request->name_rep_claimant1,
                'relationship_id' => $request->relationship_rep_claimant1

            ]);
        }

        if ($request->has('name_rep_claimant2') && $request->has('ic_rep_claimant2') && $request->has('relationship_rep_claimant2')) {

            $attendance_rep = DB::table('attendance_representative')->insertGetId([
                'attendance_id' => $attendance_id,
                'is_present' => $request->is_attendance_rep_claimant2,
                'is_representing_claimant' => 1,
                'identification_no' => $request->ic_rep_claimant2,
                'name' => $request->name_rep_claimant2,
                'relationship_id' => $request->relationship_rep_claimant2

            ]);
        }

        if ($request->has('name_rep_claimant3') && $request->has('ic_rep_claimant3') && $request->has('relationship_rep_claimant3')) {

            $attendance_rep = DB::table('attendance_representative')->insertGetId([
                'attendance_id' => $attendance_id,
                'is_present' => $request->is_attendance_rep_claimant3,
                'is_representing_claimant' => 1,
                'identification_no' => $request->ic_rep_claimant3,
                'name' => $request->name_rep_claimant3,
                'relationship_id' => $request->relationship_rep_claimant3

            ]);
        }

        if ($request->has('name_rep_opponent1') && $request->has('ic_rep_opponent1') && ($request->has('designation_rep_opponent1') || $request->has('relationship_rep_opponent1'))) {

            $attendance_rep = DB::table('attendance_representative')->insertGetId([
                'attendance_id' => $attendance_id,
                'is_present' => $request->is_attendance_rep_opponent1,
                'is_representing_claimant' => 0,
                'identification_no' => $request->ic_rep_opponent1,
                'name' => $request->name_rep_opponent1,
                $request->has('designation_rep_opponent1') ? 'designation_id' : 'relationship_id' => $request->has('designation_rep_opponent1') ? $request->designation_rep_opponent1 : $request->relationship_rep_opponent1

            ]);

        }

        if ($request->has('name_rep_opponent2') && $request->has('ic_rep_opponent2') && ($request->has('designation_rep_opponent2') || $request->has('relationship_rep_opponent2'))) {

            $attendance_rep = DB::table('attendance_representative')->insertGetId([
                'attendance_id' => $attendance_id,
                'is_present' => $request->is_attendance_rep_opponent2,
                'is_representing_claimant' => 0,
                'identification_no' => $request->ic_rep_opponent2,
                'name' => $request->name_rep_opponent2,
                $request->has('designation_rep_opponent2') ? 'designation_id' : 'relationship_id' => $request->has('designation_rep_opponent2') ? $request->designation_rep_opponent2 : $request->relationship_rep_opponent1

            ]);
        }

        if ($request->has('name_rep_opponent3') && $request->has('ic_rep_opponent3') && ($request->has('designation_rep_opponent3') || $request->has('relationship_rep_opponent3'))) {

            $attendance_rep = DB::table('attendance_representative')->insertGetId([
                'attendance_id' => $attendance_id,
                'is_present' => $request->is_attendance_rep_opponent3,
                'is_representing_claimant' => 0,
                'identification_no' => $request->ic_rep_opponent3,
                'name' => $request->name_rep_opponent3,
                $request->has('designation_rep_opponent3') ? 'designation_id' : 'relationship_id' => $request->has('designation_rep_opponent3') ? $request->designation_rep_opponent3 : $request->relationship_rep_opponent1

            ]);
        }


        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 4, "AttendanceController", json_encode($request->input()), null, "Attendance " . $attendance_id . " - Create attendance");

        return response()->json(['result' => 'Success']);
    }


    public function set($id)
    {
        $form4 = Form4::find($id);
        $designation = MasterDesignation::where('is_active', 1)->get();
        $relationship = MasterRelationship::whereIn('relationship_id', [1, 2])->get();

        return view('list/attendance/modalSet', compact('form4', 'designation', 'relationship'));
    }

    public function process($id)
    {

        $userid = Auth::id();
        $user = User::find($userid);

        if ($user->user_type_id != 3) {
            $is_staff = true;
        } else {
            $is_staff = false;
        }

        $form4 = Form4::find($id);
        if ($form4->attendance)
            $attendance = Attendance::find($form4->attendance->attendance_id);
        else
            $attendance = null;
        // $psus = RoleUser::where('role_id', 18)->orWhere('role_id', 17)->get()->filter(function($query){
        //     return $query->user->user_status_id == 1;
        // });
        $psus = RoleUser::whereIn('role_id', [18, 17, 10])
            ->whereHas('user', function ($user) {
                return $user->where('user_status_id', 1);
            })
            ->get();


        return view('list/attendance/modalProcess', compact('form4', 'is_staff', 'psus', 'attendance'));

    }

    public function print(Request $request)
    {

        if ($request->form4_id != NULL) {

            $this->data['form4'] = $form4 = Form4::find($request->form4_id);

            $form4 = Form4::find($request->form4_id);
            $attendance_id = $form4->attendance ? $form4->attendance->attendance_id : null;

            if ($form4->attendance)
                if ($form4->attendance->minutes)
                    $delete = AttendanceMinutes::where('attendance_id', $form4->attendance->attendance_id)->delete();

            if (count($request->psus) > 0) {
                foreach ($request->psus as $psu) {

                    $attendance_psus = new AttendanceMinutes;
                    $attendance_psus->attendance_id = $attendance_id;
                    $attendance_psus->form4_id = $request->form4_id;
                    $attendance_psus->psu_user_id = $psu;
                    $attendance_psus->save();
                }
            }


            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 17, "AttendanceController", $request->form4_id, null, "Download Minute Paper");
            $pdf = PDF::loadView('list/attendance/printminutes' . App::getLocale(), $this->data);

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Kertas Minit ' . $form4->case->case_no . '.pdf');
            //return $pdf->download('Kertas Minit '.$form4->case->case_no.'.pdf');
            return redirect()->route('listing.attendance');
        } else redirect()->route('listing.attendance');
    }


}
