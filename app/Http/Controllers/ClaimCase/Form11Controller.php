<?php

namespace App\Http\Controllers\ClaimCase;

use App;
use App\CaseModel\Form4;
use App\CaseModel\Form11;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\MasterModel\MasterCountry;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterMonth;
use App\User;
use App\RoleUser;
use App\Repositories\LogAuditRepository;
use App\UserWitness;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PDF;
use Redirect;
use Yajra\Datatables\Datatables;

class Form11Controller extends Controller
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

    public function list(Request $request)
    {
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $input = $request->all();

        $input['year'] = (!isset($input['year']) || trim($input['year']) === '') ? date('Y') : $input['year'];

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('onlineprocess.form11', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if ($request->ajax()) {

            $userid = Auth::id();
            $user = User::find($userid);

            $form11 = Form11::select(['form11.*'])
            ->with(['form4.case', 'form4.hearing', 'userWitness', 'form4.claimCaseOpponent.opponent_address', 'form4.claimCase.form1'])
                ->orderBy('form11.created_at', 'desc');

            //Check for filteration
            if ($request->has('branch') || $request->has('month') || $request->has('year')) {
                if ($request->has('branch') && !empty($request->branch)) {
                    $form11->whereHas('form4', function ($form4) use ($request) {
                        return $form4->whereHas('case', function ($case) use ($request) {
                            return $case->where('branch_id', $request->branch);
                        });
                    });
                }

                if ($input['year'] > 0) {
                    $form11->whereYear('created_at', $input['year']);
                }

                if ($request->has('month') && !empty($request->month)) {
                    $form11->whereMonth('created_at', $request->month);
                }
            }

            $datatables = Datatables::of($form11);

            return $datatables
                ->addIndexColumn()
                ->editColumn('case_no', function ($form11) {
                    return "<a class='' href='" . route('claimcase-view', [$form11->form4->case->claim_case_id]) . "'> " . $form11->form4->case->case_no . "</a>";
                })
                ->editColumn('created_at_form11', function ($form11) {
                    return date('d/m/Y', strtotime($form11->created_at));
                })
                ->editColumn('processed_at_form1', function ($form11) {
                    if ($form11->form4->claimCase->form1->processed_at) {
                        return date('d/m/Y', strtotime($form11->form4->claimCase->form1->processed_at));
                    }

                    return '-';
                })
                ->editColumn('hearing_date', function ($form11) {
                    return date('d/m/Y', strtotime($form11->form4->hearing->hearing_date));
                })
                ->editColumn('opponent_name', function ($form11) {
                    return $form11->form4->claimCaseOpponent->opponent_address->name;
                })
                ->editColumn('witness_name', function ($form11) {
                    return $form11->userWitness->name;
                })
                ->editColumn('action', function ($form11) {
                    $userid = Auth::id();
                    $user = User::find($userid);

                    $button = "";

                    $button .= actionButton('blue', __('new.view_witness'), route('form11-view', ['form11_id' => $form11->form11_id]), false, 'fa-search', false);

                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form11Controller", null, null, "Datatables load form 11");

        return view("claimcase/form11/list", compact('branches', 'years', 'months', 'input'));

    }

    public function view(Request $request, $form11_id)
    {
        $form11 = Form11::find($form11_id);
        $form4 = Form4::find($form11->form4->form4_id);

        if ($form11_id) {

            if ($request->ajax()) {

                $user_witness = UserWitness::where('form11_id', $form11_id)->orderBy('created_at', 'desc')->get();

                $datatables = Datatables::of($user_witness);

                return $datatables
                    ->editColumn('witness_on_behalf', function ($user_witness) {
                        if ($user_witness->witness_on_behalf == 1)
                            return __('new.ttpm_parties');
                        elseif ($user_witness->witness_on_behalf == 2)
                            return $user_witness->form11->form4->case->claimant->name;
                        else
                            return $user_witness->form11->form4->claimCaseOpponent->opponent->name;
                    })->editColumn('witness_name', function ($user_witness) {
                        return $user_witness->name;
                    })->editColumn('action', function ($user_witness) {

                        $userid = Auth::id();
                        $user = User::find($userid);

                        $button = "";

                        $button .= actionButton('green-meadow', __('button.update'), route('form11-edit', ['user_witness_id' => $user_witness->user_witness_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark btn-outline" rel="tooltip" data-original-title="' . __('new.print_f11') . '" onclick="exportPDF(' . $user_witness->user_witness_id . ')"><i class="fa fa-file-pdf-o"></i> PDF</a>';

                        $button .= '<a class="btn btn-xs dark btn-outline" rel="tooltip" data-original-title="' . __('new.print_f11') . '" onclick="exportDOCX(' . $user_witness->user_witness_id . ')"><i class="fa fa-file-o"></i> DOCX</a>';

                        $button .= '<a class="btn btn-xs btn-danger" rel="tooltip" data-original-title="' . __('button.delete') . '" onclick="deleteWitness(' . $user_witness->user_witness_id . ')"><i class="fa fa-trash-o"></i></a>';

                        return $button;

                    })->make(true);
            }
            $audit = new AuditController;
            $audit->add($request, 12, "Form11Controller", null, null, "Datatables load list of witness for " . $form4->case->case_no);
            return view('claimcase/form11/view', compact('user_witness', 'form11', 'form11_id', 'form4'));
        }

    }

    public function find(Request $request)
    {
        if ($request->ajax()) {

            $userid = Auth::id();
            $user = User::find($userid);

            $form4 = Form4::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'form4.claim_case_id')
                ->orderBy('case_year', 'desc')->orderBy('case_sequence', 'desc')
                ->with(['form11', 'case'])
                ->whereNotIn('hearing_status_id', [1]) // only hearing that are not finished. its include hearing that are not heared yet
                ->orderBy('created_at', 'desc')
                ->whereHas('case', function ($case) use ($request) {
                    return $case->where('branch_id', Auth::user()->ttpm_data->branch_id);
                })
                ->get();
            // ->where(function ($form4) use ($request){
            //                 return $form4->whereHas('form4_next', function ($form4_net) use ($request) {
            //                     return $form4_net->whereNull('hearing_status_id');
            //                 })->orDoesntHave('form4_next');
            //             });

            // $form4 = $form4->filter(function ($value) {
            //     return (!($value->form11)) && ($value->case->branch_id == Auth::user()->ttpm_data->branch_id);
            // });

            $form4 = $form4->filter(function ($value) {
                if ($value->form4_next) {
                    return !$value->form4_next->hearing_status_id;

                    // if($value->form4_next->hearing_status_id)
                    //     return false;

                    // // $hearing_date = Carbon::createFromFormat('Y-m-d', $value->form4_next->hearing->hearing_date);
                    // // return Carbon::now()->diffInHours($hearing_date, false) > -1;
                    // else
                    //     return true;
                } else
                    return true;
            });

            $datatables = Datatables::of($form4);

            return $datatables
                ->editColumn('case_no', function ($form4) {
                    return $form4->case->case_no;
                })->editColumn('hearing_date', function ($form4) {
                    return date('d/m/Y', strtotime($form4->hearing->hearing_date));
                    // tambah nama penenetang
                })->editColumn('hearing_position', function ($form4) {
                    $locale = App::getLocale();
                    $hearing_position_lang = "hearing_position_" . $locale;
                    return $form4->hearing_position ? $form4->hearing_position->$hearing_position_lang : '-';
                })->editColumn('action', function ($form4) {

                    $button = "";

                    $button .= actionButton('green-meadow', __('form11.reg_witness'), route('form11-create', ['form4_id' => $form4->form4_id]), false, 'fa-edit', false);

                    return $button;
                })->make(true);
        }
        $audit = new AuditController;
        $audit->add($request, 12, "Form11Controller", null, null, "Datatables load cases that can file form 11");
        return view("claimcase/form11/list2", compact('form4'));

    }

    public function delete(Request $request, $id)
    {

        if ($id) {

            $user_witness = UserWitness::find($id);
            $form11_id = $user_witness->form11_id;
            $audit = new AuditController;
            $audit->add($request, 6, "Form11Controller", null, null, "Delete witness " . $user_witness->form11->form4->case->case_no);
            $user_witness->delete();

            $user_witness = UserWitness::where('form11_id', $form11_id)->get();

            //

            if (count($user_witness) == 0) {
                $form11 = Form11::find($form11_id)->delete();
                $audit = new AuditController;
                $audit->add($request, 6, "Form11Controller", null, null, "Delete form 11 " . $user_witness->form11->form4->case->case_no);
                return Response::json(['status' => 'ok', 'return' => 1]);
            }

            return Response::json(['status' => 'ok', 'return' => 0]);
        }
        return Response::json(['status' => 'fail']);

    }

    /**
     * To export form 11 into several formats.
     * Supported format PDF, DOCX.
     *
     * @param \Illuminate\Http\Request $request
     * @param $user_witness_id
     * @param $file_format
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, $user_witness_id, $file_format)
    {
        $user_witness = UserWitness::find($user_witness_id);

        switch ($file_format) {
            case 'docx':
                return self::exportDoc($request, $user_witness);
                break;
            case 'pdf':
            default;
                return self::exportPdf($request, $user_witness);
                break;
        }
    }

    /**
     * Form 11 export to pdf format
     *
     * @param $request
     * @param $user_witness
     * @return mixed
     */
    protected function exportPdf($request, $user_witness)
    {
        $this->data['user_witness'] = $user_witness;

        LogAuditRepository::store($request, 17, "Form11Controller", $user_witness->form11->form4->case->case_no, null, "Download Form 11 (PDF)");

        $pdf = PDF::loadView('claimcase/form11/printform11' . App::getLocale(), $this->data);
        $pdf->setOption('enable-javascript', true);

        return $pdf->download('B11' . $user_witness->form11->form4->case->case_no . '.pdf');
    }

    /**
     * Form 11 export to doc format
     *
     * @param $request
     * @param $user_witness
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    protected function exportDoc($request, $user_witness)
    {
        $gen = new GeneralController;

        $file = $gen->integrateDocTemplate('form11_' . App::getLocale(), [
            "hearing_venue" => $user_witness->form11->form4->case->venue ? strtotime($user_witness->form11->form4->case->venue->hearing_venue) : '-',
            "state_name" => strtoupper($user_witness->form11->form4->case->branch->state->state),
            "case_no" => strtoupper($user_witness->form11->form4->case->case_no),
            "claimant_name" => strtoupper($user_witness->form11->form4->case->claimant_address->name),
            "claimant_identification_type" => strtoupper($user_witness->form11->form4->case->claimant_address->is_company == 0 ? ($user_witness->form11->form4->case->claimant_address->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': ') : ''),
            "claimant_identification_no" => $user_witness->form11->form4->case->claimant_address->is_company == 0 ? $user_witness->form11->form4->case->claimant_address->identification_no : '(' . $user_witness->form11->form4->case->claimant_address->identification_no . ')',
            "opponent_name" => $user_witness->form11->form4->claimCaseOpponent->opponent_address ? strtoupper($user_witness->form11->form4->claimCaseOpponent->opponent_address->name) : '',
            "opponent_identification_type" => $user_witness->form11->form4->claimCaseOpponent->opponent_address ? strtoupper($user_witness->form11->form4->claimCaseOpponent->opponent_address->is_company == 0 ? ($user_witness->form11->form4->claimCaseOpponent->opponent_address->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': ') : '') : '',
            "opponent_identification_no" => $user_witness->form11->form4->claimCaseOpponent->opponent_address ? $user_witness->form11->form4->claimCaseOpponent->opponent_address->is_company == 0 ? $user_witness->form11->form4->claimCaseOpponent->opponent_address->identification_no : '(' . $user_witness->form11->form4->claimCaseOpponent->opponent_address->identification_no . ')' : '',
            "witness_name" => strtoupper($user_witness->name),
            "witness_identification_type" => strtoupper($user_witness->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': '),
            "witness_identification_no" => $user_witness->identification_no,
            "witness_address" => $user_witness->address,
            "hearing_room" => $user_witness->form11->form4->hearing->hearing_room ? $user_witness->form11->form4->hearing->hearing_room->hearing_room : '',
            "hearing_address" => '', //str_replace(',', ', ', $form4->hearing->hearing_room->address),
            "psu_name" => strtoupper($user_witness->psu->name),
            "psu_role_en" => strtoupper($user_witness->psu->roleuser->first()->role->display_name_en),
            "psu_role_my" => strtoupper($user_witness->psu->roleuser->first()->role->display_name_my),
            "hearing_date" => date('j', strtotime($user_witness->form11->form4->hearing->hearing_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($user_witness->form11->form4->hearing->hearing_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($user_witness->form11->form4->hearing->hearing_date . ' 00:00:00')),
            "hearing_day" => localeDay(date('l', strtotime($user_witness->form11->form4->hearing->hearing_date . ' 00:00:00'))),
            "hearing_time" => date('g.i', strtotime($user_witness->form11->form4->hearing->hearing_date . ' ' . $user_witness->form11->form4->hearing->hearing_time)) . ' ' . localeDaylight(date('a', strtotime($user_witness->form11->form4->hearing->hearing_date . ' ' . $user_witness->form11->form4->hearing->hearing_time))),
            "witness_document" => strtoupper($user_witness->document_desc),
            "today_day" => date('h'),
            "today_month" => localeMonth(date('F')),
            "today_year" => date('Y'),
            "today_date" => date('h') . ' ' . localeMonth(date('F')) . ' ' . date('Y'),
            "extra_name" => $user_witness->form11->form4->case->extra_claimant ? '/n /n' . $user_witness->form11->form4->case->extra_claimant->name : '',
            "extra_claimant_ic" => $user_witness->form11->form4->case->extra_claimant ? ($user_witness->form11->form4->case->extra_claimant->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': ') : '',
        ]);

        LogAuditRepository::store($request, 17, "Form11Controller", $user_witness->form11->form4->case->case_no, null, "Download Form 11 (DOCX)");

        return response()->download($file, 'B11' . $user_witness->form11->form4->case->case_no . '.docx')->deleteFileAfterSend(true);
    }

    public function create(Request $request)
    {

        $userid = Auth::id();
        $user = User::find($userid);
        $user_witness = new UserWitness;
        $form4 = Form4::find($request->form4_id);

        $countries = MasterCountry::all();

        // $psus = RoleUser::with(['user.ttpm_data'])->whereIn('role_id', [18,17,10,20])->get()->where('user.ttpm_data.branch_id', $form4->hearing->branch_id)->where('user.user_status_id', 1); 
        $psus = RoleUser::with(['user.ttpm_data'])->whereIn('role_id', [18, 17, 10, 20])
            ->whereHas('user', function ($user) use ($form4) {
                return $user->where('user_status_id', 1)->whereHas('ttpm_data', function ($user_ttpm) use ($form4) {
                    return $user_ttpm->where('branch_id', $form4->hearing->branch_id);
                });
            })
            ->get();


        $audit = new AuditController;
        $audit->add($request, 9, "Form11Controller", null, null, "View witness summons form  " . $form4->case->case_no);
        return view("claimcase/form11/create", compact('form4', 'psus', 'countries', 'user_witness'));

    }

    public function add(Request $request)
    {

        $userid = Auth::id();
        $user = User::find($userid);
        $user_witness = new UserWitness;
        $form4 = Form4::find($request->form4_id);

        $countries = MasterCountry::all();
        // $psus = RoleUser::with(['user.ttpm_data'])->whereIn('role_id', [18,17,10,20,20])->get()->where('user.ttpm_data.branch_id', $form4->hearing->branch_id)->where('user.user_status_id', 1); 
        $psus = RoleUser::with(['user.ttpm_data'])->whereIn('role_id', [18, 17, 10, 20])
            ->whereHas('user', function ($user) use ($form4) {
                return $user->where('user_status_id', 1)->whereHas('ttpm_data', function ($user_ttpm) use ($form4) {
                    return $user_ttpm->where('branch_id', $form4->hearing->branch_id);
                });
            })
            ->get();

        $audit = new AuditController;
        $audit->add($request, 9, "Form11Controller", null, null, "View witness summons form  " . $form4->case->case_no);
        return view("claimcase/form11/create", compact('form4', 'psus', 'countries', 'user_witness'));

    }

    public function edit($id)
    {

        if ($id) {

            $userid = Auth::id();
            $user = User::find($userid);

            $user_witness = UserWitness::find($id);
            $countries = MasterCountry::all();
            //yang active jeeee
            // $psus = RoleUser::with(['user.ttpm_data'])->whereIn('role_id', [18,17,10,20])->get()->where('user.ttpm_data.branch_id', $user_witness->form11->form4->hearing->branch_id)->where('user.user_status_id', 1); 
            $psus = RoleUser::with(['user.ttpm_data'])->whereIn('role_id', [18, 17, 10, 20])
                ->whereHas('user', function ($user) use ($user_witness) {
                    return $user->where('user_status_id', 1)->whereHas('ttpm_data', function ($user_ttpm) use ($user_witness) {
                        return $user_ttpm->where('branch_id', $user_witness->form11->form4->hearing->branch_id);
                    });
                })
                ->get();

            $form4 = Form4::find($user_witness->form11->form4->form4_id);

            return view("claimcase/form11/create", compact('user_witness', 'psus', 'countries', 'form4'));

        }

    }

    protected function rules_insert($request)
    {

        $rules = [
            'form4_id' => 'required|integer',
            'name' => 'required',
            'identification_no' => 'required',
            'witness_identity_type' => 'required|integer',
            'witness_on_behalf' => 'required',
            'document_desc' => 'required',
            'psu_user_id' => 'required|integer'
        ];

        if ($request->witness_identity_type == 2)
            $rules['nationality_country_id'] = 'required|integer';

        return $rules;
    }

    protected function rules_update($request)
    {

        $rules = [
            'name' => 'required',
            'identification_no' => 'required',
            'witness_identity_type' => 'required|integer',
            'witness_on_behalf' => 'required',
            'document_desc' => 'required',
            'psu_user_id' => 'required|integer'
        ];

        if ($request->witness_identity_type == 2)
            $rules['nationality_country_id'] = 'required|integer';

        return $rules;
    }

    protected function rules_add($request)
    {

        $rules = [
            'name' => 'required',
            'identification_no' => 'required',
            'witness_identity_type' => 'required|integer',
            'witness_on_behalf' => 'required',
            'document_desc' => 'required',
            'psu_user_id' => 'required|integer'
        ];

        if ($request->witness_identity_type == 2)
            $rules['nationality_country_id'] = 'required|integer';

        return $rules;
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_insert($request));

        if ($request->form11_id == NULL) {

            if ($validator->passes()) {

                $form11_id = DB::table('form11')->insertGetId([
                    'form4_id' => $request->form4_id
                ]);

                $user_witness = new UserWitness;
                $user_witness->form11_id = $form11_id;
                $user_witness->name = $request->name;
                $user_witness->identification_no = $request->identification_no;
                $user_witness->document_desc = $request->document_desc;
                $user_witness->witness_on_behalf = $request->witness_on_behalf;
                $user_witness->nationality_country_id = $request->witness_identity_type == 2 ? $request->nationality_country_id : 129;
                $user_witness->address = $request->address;
                $user_witness->psu_user_id = $request->psu_user_id;

                if ($request->witness_identity_type != 3)
                    $user_witness->user_public_type_id = 1;
                else
                    $user_witness->user_public_type_id = 2;


                $user_witness->save();

                $audit = new AuditController;
                $audit->add($request, 4, "Form11Controller", json_encode($request->input()), null, "Form 11 " . $form11_id . " - Create form 11");
                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);

            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function new(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_add($request));

        if ($request->user_witness_id == NULL) {

            if ($validator->passes()) {

                $form11 = Form11::where('form4_id', $request->form4_id)->first();

                if ($request->witness_identity_type != 3)
                    $user_public_type_id = 1;
                else
                    $user_public_type_id = 2;

                $user_witness = DB::table('user_witness')->insertGetId([
                    'form11_id' => $form11->form11_id,
                    'name' => $request->name,
                    'identification_no' => $request->identification_no,
                    'document_desc' => $request->document_desc,
                    'witness_on_behalf' => $request->witness_on_behalf,
                    'nationality_country_id' => $request->nationality_country_id = $request->witness_identity_type == 2 ? $request->nationality_country_id : 129,
                    'user_public_type_id' => $user_public_type_id,
                    'address' => $request->address,
                    'psu_user_id' => $request->psu_user_id
                ]);

                $audit = new AuditController;
                $audit->add($request, 4, "Form11Controller", json_encode($request->input()), null, "Form 11 " . $form11->form4->case->case_no . " - Create new witness");
                return Response::json(['status' => 'ok', 'form11' => $form11->form11_id, 'message' => __('new.create_success')]);

            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_update($request));

        if ($request->user_witness_id != NULL) {

            if ($validator->passes()) {

                if ($request->witness_identity_type != 3)
                    $user_public_type_id = 1;
                else
                    $user_public_type_id = 2;

                $user_witness_data = UserWitness::find($request->user_witness_id);

                $user_witness_data->update([

                    'name' => $request->name,
                    'identification_no' => $request->identification_no,
                    'nationality_country_id' => $request->nationality_country_id = $request->witness_identity_type == 2 ? $request->nationality_country_id : 129,
                    'address' => $request->address,
                    'witness_on_behalf' => $request->witness_on_behalf,
                    'document_desc' => $request->document_desc,
                    'user_public_type_id' => $user_public_type_id,
                    'psu_user_id' => $request->psu_user_id

                ]);
                $audit = new AuditController;
                $audit->add($request, 5, "Form11Controller", null, null, "Update witness form 11 " . $request->identification_no);
                return Response::json(['status' => 'ok', 'form11' => $user_witness_data->form11_id, 'message' => __('new.create_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }


}