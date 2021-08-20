<?php

namespace App\Http\Controllers\Search;

use App;
use App\CaseModel\ClaimCaseOpponent;
use App\Http\Controllers\Controller;
use App\Repositories\LogAuditRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class Tab3Controller extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        LogAuditRepository::store($request, 7, "SearchController", json_encode($request->input()), null, "Claim filings search");

        $input = $request->all();

        $input['filing_start_date'] = isset($input['filing_start_date']) && $input['filing_start_date'] != ''
            ? Carbon::createFromFormat('d/m/Y', $input['filing_start_date'])->startOfDay()->toDateTimeString()
            : Carbon::parse()->startOfYear()->toDateTimeString();
        $input['filing_end_date'] = isset($input['filing_end_date']) && $input['filing_end_date'] != ''
            ? Carbon::createFromFormat('d/m/Y', $input['filing_end_date'])->endOfDay()->toDateTimeString()
            : Carbon::parse()->endOfYear()->toDateTimeString();

        if ($request->ajax()) {
            if ($request->has('branch_code') && $request->has('category_code') && $request->has('serial_no') && $request->has('year')) {
                $case_no = "TTPM-" . $request->branch_code . "-(" . $request->category_code . ")-" . $request->serial_no . "-" . $request->year;
            } else {
                $case_no = "";
            }

            $claim_case_opponents = self::query($request, $input, $case_no);

            return self::dt($claim_case_opponents);
        }

        return view('search.tab3-result');
    }

    /**
     * Run query
     * @param $request
     * @param $input
     * @param $case_no
     * @return \App\CaseModel\ClaimCaseOpponent|\Illuminate\Database\Eloquent\Builder
     */
    public function query($request, $input, $case_no)
    {
        $claim_case_opponents = ClaimCaseOpponent::with([
            'claimCase', 'claimCase.claimant_address', 'opponent_address',
            'claimCase.form1.offenceType', 'claimCase.status', 'claimCase.branch'
        ])
            ->select('claim_case_opponents.id', 'claim_case_opponents.claim_case_id', 'claim_case_opponents.opponent_address_id')
            ->join('claim_case', 'claim_case_opponents.claim_case_id', '=', 'claim_case.claim_case_id')
            ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->orderBy('case_year', 'asc')
            ->orderBy('case_sequence', 'asc')
            ->whereHas('claimCase', function ($q) use ($request, $input, $case_no) {

                if ($case_no != '') {
                    $q->where("case_no", "LIKE", "%{$case_no}%");
                }

                $q->where("branch_id", "LIKE", $request->branch_id)
                    ->where("case_status_id", ">", 1)
                    ->whereNotNull('form1_id')
                    ->whereHas('form1', function ($r) use ($input) {
                        $r->whereBetween('processed_at', [$input['filing_start_date'], $input['filing_end_date']]);
                    })
                    ->orderBy('case_no');
            });

        if ($request->has('category') && ($request->category != 0)) {
            $claim_case_opponents->whereHas('claimCase.form1', function ($q) use ($request) {
                $q->whereHas('classification', function ($r) use ($request) {
                    $r->where('category_id', $request->category);
                });
            });
        }

        if ($request->has('claim_details') && !empty($request->claim_details)) {
            $claim_case_opponents->whereHas('claimCase.form1', function ($q) use ($request) {
                $q->where('claim_details', 'LIKE', "%{$request->claim_details}%");
            });
        }

        if ($request->has('claimant_name') && !empty($request->claimant_name)) {
            $claim_case_opponents->whereHas('claimCase.claimant', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->claimant_name}%");
            });
        }

        if ($request->has('claimant_no') && !empty($request->claimant_no)) {
            $claim_case_opponents->whereHas('claimCase.claimant_address', function ($q) use ($request) {
                $q->where('identification_no', 'LIKE', "%{$request->claimant_no}%");
            });
        }

        if ($request->has('classification') && ($request->classification != 0)) {
            $claim_case_opponents->whereHas('claimCase.form1', function ($q) use ($request) {
                $q->where('claim_classification_id', $request->classification);
            });
        }

        if ($request->has('hearing_start_date') && !empty($request->hearing_start_date) && $request->has('hearing_end_date') && !empty($request->hearing_end_date)) {
            $claim_case_opponents->whereHas('form4Latest', function ($q) use ($request) {
                $q->whereHas('form4.hearing', function ($r) use ($request) {
                    $r->whereBetween('hearing_date', [
                        Carbon::createFromFormat('d/m/Y', $request->hearing_start_date)->toDateString(),
                        Carbon::createFromFormat('d/m/Y', $request->hearing_end_date)->toDateString()
                    ]);
                });
            });
        }

        if ($request->has('opponent_name') && !empty($request->opponent_name)) {
            $claim_case_opponents->whereHas('opponent', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->opponent_name}%");
            });
        }

        if ($request->has('opponent_no') && !empty($request->opponent_no)) {
            $claim_case_opponents->whereHas('opponent', function ($q) use ($request) {
                $q->where('username', 'LIKE', "%{$request->opponent_no}%");
            });
        }

        if ($request->has('is_online')) {
            $claim_case_opponents->whereHas('claimCase.form1', function ($q) use ($request) {
                $q->where('is_online_purchased', $request->is_online);
            });
        }

        if ($request->has('is_claimant_citizen')) {
            $claim_case_opponents->whereHas('claimCase.claimant_address', function ($q) use ($request) {
                if ($request->is_opponent_citizen == 1) {
                    $q->where('is_company', 0)
                        ->where('nationality_country_id', 129);
                } else {
                    return $q->where('is_company', 0)
                        ->where('nationality_country_id', '!=', 129);
                }
            });
        }

        if ($request->has('is_opponent_citizen')) {
            $claim_case_opponents->whereHas('opponent_address', function ($q) use ($request) {
                if ($request->is_opponent_citizen == 1) {
                    $q->where('nationality_country_id', 129);
                } else {
                    $q->where('nationality_country_id', '!=', 129);
                }
            });
        }


        return $claim_case_opponents;
    }

    /**
     * Datatable function
     * @param $claim_case_opponents
     * @return mixed
     * @throws \Exception
     */
    public function dt($claim_case_opponents)
    {
        $datatables = Datatables::of($claim_case_opponents);

        return $datatables
            ->addIndexColumn()
            ->editColumn('claim_case.case_no', function ($claim_case_opponents) {
                return "<a class='s' href='" . route('claimcase-view-cc', [$claim_case_opponents->id, 'cc']) . "'>"
                    . $claim_case_opponents->claimCase->case_no
                    . "</a>";
            })
            ->editColumn('claim_case.form1.filing_date', function ($claim_case_opponents) {
                return date('d/m/Y', strtotime($claim_case_opponents->claimCase->form1->filing_date));
            })
            ->editColumn('claim_case.form1.matured_date', function ($claim_case_opponents) {
                return date('d/m/Y', strtotime($claim_case_opponents->claimCase->form1->matured_date));
            })
            ->editColumn('claim_case.last_form4.award.award_cost_value', function ($claim_case_opponents) {
                if ($claim_case_opponents->form4Latest && $claim_case_opponents->form4Latest->form4 && $claim_case_opponents->form4Latest->form4->award) {
                    return number_format($claim_case_opponents->form4Latest->form4->award->award_value, 2, '.', ',');
                } else {
                    return '-';
                }
            })
            ->editColumn('hearing_position', function ($claim_case_opponents) {
                if (!empty($claim_case_opponents->form4)) {
                    if (count($claim_case_opponents->form4) > 0) {
                        $position = '';
                        foreach ($claim_case_opponents->form4 as $index => $form4_position) {
                            if (!empty($form4_position->hearing_position_id)) {
                                $locale = App::getLocale();
                                $hearingposition = "hearing_position_" . $locale;
                                $position .= __('new.hearing_alphabet') . "[" . ($index + 1) . "] " . $form4_position->hearing_position->$hearingposition . "<br>";
                            } else {
                                $position .= '-';
                            }
                        }
                        return $position;
                    } else {
                        return '-';
                    }
                } else {
                    return '-';
                }
            })
            ->editColumn('updated_at', function ($claim_case_opponents) {
                $date_hearing = '';
                if ($claim_case_opponents->stop_notice) {
                    if ($claim_case_opponents->stop_notice->form_status_id != 57) {
                        return date('d/m/Y', strtotime($claim_case_opponents->stop_notice->stop_notice_date));
                    }
                }

                foreach ($claim_case_opponents->form4 as $index => $form4_date) {
                    if (!empty($form4_date->hearing_status_id))
                        $date_hearing .= __('new.hearing_alphabet') . "[" . ($index + 1) . "] " . date('d/m/Y', strtotime($form4_date->hearing->hearing_date)) . "<br>";
                    // $date_hearing = date('d/m/Y', strtotime($form4_date->hearing->hearing_date));
                }

                return $date_hearing == '' ? '-' : $date_hearing;
            })
//            ->editColumn('claim_case.branch.branch_name', function($q) {
//                return $q->claimCase->branch->branch_name;
//            })
            ->editColumn('claim_case.form1.offence_type_id', function($q) {
                return $q->claimCase->form1->offenceType['offence_description_'.App::getLocale()];
            })
            ->editColumn('created_at', function ($claim_case_opponents) {
                $date_hearing1 = '';
                foreach ($claim_case_opponents->form4 as $index => $form4_date) {
                    if (!empty($form4_date->hearing_status_id))
                        $date_hearing1 = date('d/m/Y', strtotime($form4_date->hearing->hearing_date));
                }
                return $date_hearing1 == '' ? '-' : $date_hearing1;
            })
            ->make(true);
    }
}
