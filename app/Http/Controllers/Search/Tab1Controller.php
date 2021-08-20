<?php

namespace App\Http\Controllers\Search;

use App;
use App\Http\Controllers\Controller;
use App\Repositories\LogAuditRepository;
use App\SupportModel\Suggestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class Tab1Controller extends Controller
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
        LogAuditRepository::store($request, 7, "SearchController", json_encode($request->input()), null, "Suggestion search");

        if ($request->ajax()) {
            $suggestion_search = Suggestion::with(['created_by'])->where("subject", "LIKE", "%{$request->suggestion}%")->where("suggestion", "LIKE", "%{$request->suggestion}%");

            if ($request->has('name') && !empty($request->name)) {
                $suggestion_search->whereHas('created_by', function ($created_by) use ($request) {
                    return $created_by->where('name', 'LIKE', "%{$request->name}%");
                });
            }

            if ($request->has('username') && !empty($request->username)) {
                $suggestion_search->whereHas('created_by', function ($created_by) use ($request) {
                    return $created_by->where('username', 'LIKE', "%{$request->username}%");
                });
            }

            $datatables = Datatables::of($suggestion_search);

            return $datatables
                ->editColumn('name', function ($suggestion_search) {
                    return $suggestion_search->created_by->name;
                })
                ->editColumn('username', function ($suggestion_search) {
                    return $suggestion_search->created_by->username;
                })
                ->editColumn('status', function ($suggestions) {
                    if ($suggestions->response)
                        return __("new.responded");
                    else
                        return __("new.no_respond");
                })
                ->editColumn('created_at', function ($suggestions) {
                    return Carbon::parse($suggestions->created_at)->format('d/m/Y');
                })
                ->editColumn('suggestion', function ($suggestion_search) {
                    return "<strong>" . $suggestion_search->subject . "</strong><br>" . $suggestion_search->suggestion;

                })
                ->make(true);
        }

        return view('search.tab1-result');
    }
}
