<?php

namespace App\Http\Controllers;

use App;
use App\CaseModel\ClaimCaseOpponent;
use App\Repositories\LogAuditRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use DB;
use Exception;
use App\CaseModel\ClaimCase;
use App\PaymentModel\Payment;
use App\MasterModel\MasterBranch;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class PaymentController extends Controller
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

    public function modal(Request $request, $claim_case_id, $form_no)
    {
        switch ($form_no) {
            case 1: // b1 - get cc
                $branch = ClaimCase::find($claim_case_id)->branch;
                break;
            case 2: // b2 - get cco
                $cco = ClaimCaseOpponent::find($claim_case_id);
                $claim_case_id = $cco->id; // pass cco id to be use for b2 payment.
                $branch = $cco->claimCase->branch;
                break;
        }

        LogAuditRepository::store($request, 3, "PaymentController", null, null, "View payment details");

        return view('payment.modalPaymentMethod', compact('claim_case_id', 'form_no', 'branch'));
    }

    public function review(Request $request)
    {
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();

        $payments = Payment::with('case.claimant_address')->whereNotNull('receipt_no')->orderBy('paid_at', 'desc');

        if ($request->has('branch') || $request->has('method') || ($request->has('start_date') && $request->has('end_date'))) {

            if ($request->has('start_date') && !empty($request->start_date) && $request->has('end_date') && !empty($request->end_date))
                $payments->whereNotNull('receipt_no')
                    ->whereDate('paid_at', '>=', Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString())
                    ->whereDate('paid_at', '<=', Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateString())
                    ->get();

            if ($request->has('branch') && !empty($request->branch)) {
                $payments->whereHas('case', function ($case) use ($request) {
                    return $case->where('branch_id', $request->branch);
                });
            }

            if ($request->has('method') && !empty($request->method)) {
                $payments->where(function ($payments) use ($request) {
                    if ($request->method == 1)
                        return $payments->whereNotNull('payment_fpx_id');
                    else if ($request->method == 2)
                        return $payments->whereNotNull('payment_postalorder_id');
                    else if ($request->method == 3)
                        return $payments->where('is_payment_counter', 1);
                });
            }
        }

        $datatables = Datatables::of($payments);

        if ($request->ajax()) {

            return $datatables
                ->editColumn('case_no', function ($payments) {
                    if ($payments->case)
                        return "<a class='' href='" . route('claimcase-view', [$payments->claim_case_id]) . "'> " . $payments->case->case_no . "</a>";
                    else return "-";
                })
                ->editColumn('payment_method', function ($payments) {
                    if ($payments->payment_fpx_id)
                        return __('form1.online_payment');
                    elseif ($payments->payment_postalorder_id)
                        return __('form1.postal_order');
                    else
                        return __('form1.pay_counter');
                })
                ->editColumn('form_no', function ($payments) {
                    if (!empty($payments->form_no))
                        return $payments->form_no;
                    else return "-";
                })
                ->editColumn('paid_at', function ($payments) {
                    return Carbon::parse($payments->paid_at)->format('d/m/Y');
                })
                ->editColumn('receipt_no', function ($payments) {
                    return $payments->receipt_no;
                })
                ->editColumn('payment_status_id', function ($payments) {
                    $locale = App::getLocale();
                    return $payments->status['status_' . $locale];
                })
                ->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "PaymentController", null, null, "Datatables load review payment");
        return view('payment.review', compact('branches'));
    }
}
