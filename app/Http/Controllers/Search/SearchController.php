<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Repositories\LogAuditRepository;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\SupportModel\Suggestion;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterClaimCategory;
use App\MasterModel\MasterClaimClassification;
use App;

class SearchController extends Controller
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
     * Show the application dashboard.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        $branches = MasterBranch::where('is_active', 1)->get();
        $claimcategory = MasterClaimCategory::where('is_active', 1)->get();
        $classifications = MasterClaimClassification::where('is_active', 1)->get();
        $district = MasterDistrict::all();

        if ($request->ajax()) {

            $search_suggestion = Suggestion::all();
            $datatables = Datatables::of($search_suggestion);

            return $datatables
                ->editColumn('suggestion_id', function ($search_suggestion) {
                    return $search_suggestion->suggestion_id;
                })->editColumn('subject', function ($search_suggestion) {
                    return $search_suggestion->subject;
                })->make(true);
        }

        LogAuditRepository::store($request, 12, "SearchController", null, null, "Datatables load search");

        return view('search.search', compact('search_suggestion', 'branches', 'district',
            'claimcategory', 'classifications'));
    }
}
