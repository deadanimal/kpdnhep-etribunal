<?php

namespace App\Http\Controllers\Search;

use App\CaseModel\Inquiry;
use App;
use App\Http\Controllers\Controller;
use App\Repositories\LogAuditRepository;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class Tab2Controller extends Controller
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

    public function __invoke(Request $request)
    {
        LogAuditRepository::store($request, 7, "SearchController", json_encode($request->input()), null, "Inquiry search");

        if ($request->ajax()) {

            if ($request->question_detail) {
                $search_question = Inquiry::with(['inquired_by', 'opponent'])->where("inquiry_no", "LIKE", "%{$request->question_no}%")->where("inquiry_msg", "LIKE", "%{$request->question_detail}%");
            } else {
                $search_question = Inquiry::with(['inquired_by', 'opponent'])->where("inquiry_no", "LIKE", "%{$request->question_no}%");
            }

            if ($request->has('claim_name') && !empty($request->claim_name)) {
                $search_question->whereHas('inquired_by', function ($inquired_by) use ($request) {
                    return $inquired_by->where('name', 'LIKE', "%{$request->claim_name}%");
                });
            }

            if ($request->has('claim_identity') && !empty($request->claim_identity)) {
                $search_question->whereHas('inquired_by', function ($inquired_by) use ($request) {
                    return $inquired_by->where('username', 'LIKE', "%{$request->claim_identity}%");
                });
            }

            if ($request->has('responder_name') && !empty($request->responder_name)) {
                $search_question->whereHas('opponent', function ($opponent) use ($request) {
                    return $opponent->where('name', 'LIKE', "%{$request->responder_name}%");
                });
            }

            if ($request->has('responder_company') && !empty($request->responder_company)) {
                $search_question->whereHas('opponent', function ($opponent) use ($request) {
                    return $opponent->where('identification_no', 'LIKE', "%{$request->responder_company}%");
                });
            }

            $datatables = Datatables::of($search_question);

            return $datatables
                ->editColumn('inquiry_no', function ($search_question) {
                    return $search_question->inquiry_no;
                })
                ->editColumn('name', function ($search_question) {
                    return $search_question->inquired_by->name;
                })
                ->editColumn('identification_no', function ($search_question) {
                    return $search_question->inquired_by->username;
                })
                ->editColumn('opponent_name', function ($search_question) {
                    if (!empty($search_question->opponent)) {
                        return $search_question->opponent->name;
                    } else {
                        return '-';
                    }
                })
                ->editColumn('opponent_identification_no', function ($search_question) {
                    if (!empty($search_question->opponent)) {
                        return $search_question->opponent->identification_no;
                    } else {
                        return '-';
                    }

                })
                ->editColumn('inquiry_msg', function ($search_question) {
                    if (!empty($search_question->inquiry_msg)) {
                        return $search_question->inquiry_msg;
                    } else {
                        return '-';
                    }
                })
                ->make(true);
        }

        return view('search.tab2-result');
    }
}
