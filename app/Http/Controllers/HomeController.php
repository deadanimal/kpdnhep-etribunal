<?php

namespace App\Http\Controllers;

use App;
use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form4;
use App\CaseModel\Inquiry;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterMonth;
use App\Repositories\UserPublicCompanyRepository;
use App\Repositories\UserPublicIndividualRepository;
use App\Repositories\UserTtpmRepository;
use App\SupportModel\Announcement;
use App\SupportModel\Suggestion;
use App\User;
use App\ViewModel\ViewReportDashboard;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     */
    public function index(Request $request)
    {
        $userid = Auth::id();
        $user = User::find($userid);
        $user_type = $user->user_type_id;

        $user_language = $user->language_id;

        if ($user_language == 1) { // English
            $request->session()->put('locale', 'en');
            App::setLocale('en');
        } else { // Malay
            $request->session()->put('locale', 'my');
            App::setLocale('my');
        }

        $announcements = Announcement::whereDate('start_date', '<=', Carbon::today())
            ->whereDate('end_date', '>=', Carbon::today()->subDay())
            ->whereHas('targets', function ($targets) {
                $targets->where('role_id', Auth::user()->roles->first()->id ?? 3); // default as public user.
            })
            ->get();

        switch ($user_type) {
            case 1: // admin
                return self::homeAdmin($announcements);
                break;
            case 2:
                return self::homeStaff($announcements);
                break;
            default:
                return self::homeUser($announcements, $userid);
                break;
        }
    }

    public function homeAdmin($announcements)
    {
        //header first
        $ttpm = UserTtpmRepository::getCounter();
        $user_publics = UserPublicIndividualRepository::getCounter();
        $citizen = $user_publics->citizen;
        $noncitizen = $user_publics->non_citizen;
        $company = UserPublicCompanyRepository::getCounter();

        //header second
        $suggestion = Suggestion::select([DB::raw('count(*) total')])
            ->first()
            ->total;

        $inquiry = Inquiry::select([DB::raw('count(*) total')])
            ->where('inquiry_form_status_id', 10)
            ->first()
            ->total;

        $form1 = ClaimCase::select([DB::raw('count(*) total')])
            ->join('form1', 'form1.form1_id', '=', 'claim_case.form1_id')
            ->where('form1.form_status_id', 14)
            ->first()
            ->total;

        $form2 = DB::select("
                SELECT count(*) AS count 
                FROM claim_case 
                INNER JOIN form1 ON form1.form1_id = claim_case.form1_id
                INNER JOIN form2 ON form2.form2_id = form1.form2_id
                WHERE form2.form_status_id = 19
                AND form1.form2_id != ''
            ");
        $form2 = $form2[0]->count;

        $form3 = DB::select("
                SELECT count(*) AS count 
                FROM claim_case 
                INNER JOIN form1 ON form1.form1_id = claim_case.form1_id
                INNER JOIN form2 ON form2.form2_id = form1.form2_id
                INNER JOIN form3 ON form3.form3_id = form2.form3_id
                WHERE form3.form_status_id = 31
            ");
        $form3 = $form3[0]->count;

        $form4 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                WHERE year(hearing.hearing_date) = " . date('Y') . "
                AND form4.counter = 1
            ");
        $form4 = $form4[0]->count;

        $form5 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE award.award_type = 5 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form5 = $form5[0]->count;

        $form6 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE award.award_type = 6 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form6 = $form6[0]->count;

        $form7 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE award.award_type = 7 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form7 = $form7[0]->count;

        $form8 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE award.award_type = 8 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form8 = $form8[0]->count;

        $form9 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE award.award_type = 9 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form9 = $form9[0]->count;

        $form10 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE award.award_type = 10 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form10 = $form10[0]->count;

        $form11 = DB::select("
                SELECT count(*) AS count 
                FROM form11 
                INNER JOIN form4 ON form11.form4_id = form4.form4_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                WHERE year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form11 = $form11[0]->count;

        $form12 = DB::select("
                SELECT count(*) AS count 
                FROM form12 
                INNER JOIN form4 ON form12.form4_id = form4.form4_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                WHERE form12.form_status_id = 24 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form12 = $form12[0]->count;

        $transfer = DB::select("
                SELECT count(*) AS count 
                FROM claim_case
                WHERE transfer_branch_id IS NOT NULL
            ");
        $transfer = $transfer[0]->count;

        return view('home_admin', compact('ttpm', 'citizen', 'noncitizen', 'company', 'inquiry',
            'form1', 'form2', 'form3', 'form4', 'form5', 'form6', 'form7', 'form8', 'form9', 'form10', 'form11',
            'form12', 'announcements', 'suggestion', 'transfer'));

    }

    public function homeStaff($announcements)
    {
        $branch_id = Auth::user()->ttpm_data->branch_id;

        $form_status = MasterFormStatus::whereIn('form_status_id', [13, 14, 15, 16, 17])->get();

        if (Auth::user()->hasRole('setiausaha')) {
            $inquiry_30 = DB::select("
                    SELECT count(*) AS count 
                    FROM inquiry 
                    WHERE inquiry_form_status_id = 10 AND datediff(CURDATE(), created_at) > 30
                ");
            $inquiry_30 = $inquiry_30[0]->count;

            $inquiry = DB::select("
                    SELECT count(*) AS count 
                    FROM inquiry 
                    WHERE inquiry_form_status_id = 10
                ");
            $inquiry = $inquiry[0]->count;

            $sms_unanswered = DB::select("
                    SELECT count(*) AS count 
                    FROM inquiry 
                    WHERE inquiry_form_status_id = 10 AND inquiry_method_id = 7
                ");
            $sms_unanswered = $sms_unanswered[0]->count;
        } else {
            $inquiry_30 = DB::select("
                    SELECT count(*) AS count 
                    FROM inquiry a
                    -- JOIN master_branch b ON a.transaction_state = b.branch_state_id
                    WHERE a.branch_id = {$branch_id} 
                    AND a.inquiry_form_status_id = 9 
                    AND datediff(CURDATE(), a.created_at) > 3 
                    -- AND a.inquiry_form_status_id = 9
                    -- OR b.branch_id = {$branch_id}
                ");
            $inquiry_30 = $inquiry_30[0]->count;

            $inquiry = DB::select("
                    SELECT count(*) AS count 
                    FROM inquiry a
                    -- JOIN master_branch b ON a.transaction_state = b.branch_state_id
                    WHERE a.branch_id = {$branch_id} 
                    AND a.inquiry_form_status_id = 9
                    -- OR b.branch_id = {$branch_id}
                ");
            $inquiry = $inquiry[0]->count;

            $sms_unanswered = DB::select("
                    SELECT count(*) AS count 
                    FROM inquiry a
                    JOIN master_branch b ON a.transaction_state = b.branch_state_id
                    WHERE a.branch_id = {$branch_id} 
                    AND a.inquiry_form_status_id = 9 
                    AND a.inquiry_method_id = 7
                    OR b.branch_id = {$branch_id}
                ");
            $sms_unanswered = $sms_unanswered[0]->count;
        }

        $form1 = DB::select("
                SELECT count(*) AS count 
                FROM claim_case 
                INNER JOIN form1 ON form1.form1_id = claim_case.form1_id
                WHERE claim_case.branch_id = {$branch_id} AND form1.form_status_id = 14
            ");
        $form1 = $form1[0]->count;

        $form1_unpaid = DB::select("
                SELECT count(*) AS count 
                FROM claim_case 
                INNER JOIN form1 ON form1.form1_id = claim_case.form1_id
                WHERE claim_case.branch_id = {$branch_id} AND form1.form_status_id = 15
            ");
        $form1_unpaid = $form1_unpaid[0]->count;

        $form1_incomplete = DB::select("
                SELECT count(*) AS count 
                FROM claim_case 
                INNER JOIN form1 ON form1.form1_id = claim_case.form1_id
                WHERE claim_case.branch_id = {$branch_id} AND form1.form_status_id = 16
            ");
        $form1_incomplete = $form1_incomplete[0]->count;

        $form2 = ClaimCaseOpponent::select([DB::raw('count(1) total')])
            ->whereHas('claimCase', function ($cc) use ($branch_id) {
                $cc->where('branch_id', $branch_id);
            })
            ->whereHas('form2', function ($f2) {
                $f2->where('form_status_id', 19);
            })
            ->groupBy('id')
            ->first();

        $form2 = $form2->total ?? 0;

        $form2_unpaid = ClaimCaseOpponent::select([DB::raw('count(1) total')])
            ->whereHas('claimCase', function ($cc) use ($branch_id) {
                $cc->where('branch_id', $branch_id);
            })
            ->whereHas('form2', function ($f2) {
                $f2->where('form_status_id', 20);
            })
            ->groupBy('id')
            ->first();

        $form2_unpaid = $form2_unpaid->total ?? 0;

        $form3 = DB::select("
                SELECT count(*) AS count 
                FROM claim_case 
                INNER JOIN form1 ON form1.form1_id = claim_case.form1_id
                INNER JOIN form2 ON form2.form2_id = form1.form2_id
                INNER JOIN form3 ON form3.form3_id = form2.form3_id
                WHERE claim_case.branch_id = {$branch_id} AND form3.form_status_id = 31
            ");
        $form3 = $form3[0]->count;

        $form4 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN form1 on claim_case.form1_id = form1.form1_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                WHERE claim_case.branch_id = {$branch_id} 
                AND year(form1.filing_date) = " . date('Y') . "
                AND form4.counter = 1
                and form4.deleted_at is null
            ");
        $form4 = $form4[0]->count;

        $f4_not_print = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN form1 on claim_case.form1_id = form1.form1_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                WHERE claim_case.branch_id = {$branch_id} 
                AND form4.form_status_id = 35 
                AND year(form1.filing_date) = " . date('Y') . "
                and form4.deleted_at is null
            ");
        $f4_not_print = $f4_not_print[0]->count;

        $form5 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE claim_case.branch_id = {$branch_id} AND award.award_type = 5 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form5 = $form5[0]->count;

        $form6 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE claim_case.branch_id = {$branch_id} AND award.award_type = 6 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form6 = $form6[0]->count;

        $form7 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE claim_case.branch_id = {$branch_id} AND award.award_type = 7 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form7 = $form7[0]->count;

        $form8 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE claim_case.branch_id = {$branch_id} AND award.award_type = 8 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form8 = $form8[0]->count;

        $form9 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE claim_case.branch_id = {$branch_id} AND award.award_type = 9 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form9 = $form9[0]->count;

        $form10 = DB::select("
                SELECT count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN award ON form4.award_id = award.award_id
                WHERE claim_case.branch_id = {$branch_id} AND award.award_type = 10 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form10 = $form10[0]->count;

        $form11 = DB::select("
                SELECT count(*) AS count 
                FROM form11 
                INNER JOIN form4 ON form11.form4_id = form4.form4_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                WHERE claim_case.branch_id = {$branch_id} AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form11 = $form11[0]->count;

        $form12 = DB::select("
                SELECT count(*) AS count 
                FROM form12 
                INNER JOIN form4 ON form12.form4_id = form4.form4_id
                INNER JOIN hearing ON hearing.hearing_id = form4.hearing_id
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                WHERE claim_case.branch_id = {$branch_id} AND form12.form_status_id = 24 AND year(hearing.hearing_date) = " . date('Y') . "
            ");
        $form12 = $form12[0]->count;

        $stop_notice_unprocessed = DB::select("
                SELECT count(*) AS count 
                FROM stop_notice 
                INNER JOIN claim_case ON stop_notice.claim_case_id = claim_case.claim_case_id
                WHERE claim_case.branch_id = {$branch_id} AND stop_notice.form_status_id = 26
            ");
        $stop_notice_unprocessed = $stop_notice_unprocessed[0]->count;

        $award_disobey_unprocessed = DB::select("
                SELECT count(*) AS count 
                FROM award_disobey 
                INNER JOIN form4 ON award_disobey.form4_id = form4.form4_id
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                WHERE claim_case.branch_id = {$branch_id} AND award_disobey.form_status_id = 28
            ");
        $award_disobey_unprocessed = $award_disobey_unprocessed[0]->count;

        $suggestion = DB::select("
                SELECT count(*) AS count 
                FROM suggestion
            ");
        $suggestion = $suggestion[0]->count;
        if (Auth::user()->hasRole('presiden')) {
            $hearings = Form4::select('hearing.hearing_date', 'hearing.hearing_time',
                DB::raw('count(*) AS count'))
                ->join('claim_case', 'form4.claim_case_id', '=', 'claim_case.claim_case_id')
                ->join('hearing', 'form4.hearing_id', '=', 'hearing.hearing_id')
                ->whereNull('form4.hearing_status_id')
                ->where('hearing.president_user_id', auth()->user()->user_id)
                ->groupBy('hearing.hearing_id')
                ->get();
        } else {
            $hearings = DB::select("
                SELECT 
                    hearing.hearing_date,
                    hearing.hearing_time,
                    count(*) AS count 
                FROM form4 
                INNER JOIN claim_case ON form4.claim_case_id = claim_case.claim_case_id
                INNER JOIN hearing ON form4.hearing_id = hearing.hearing_id
                WHERE claim_case.branch_id = {$branch_id} AND form4.hearing_status_id IS NULL
                GROUP BY hearing.hearing_id
            ");
        }

        $transfer = DB::select("
                SELECT count(*) AS count 
                FROM claim_case a
                JOIN master_hearing_venue b ON a.hearing_venue_id = b.hearing_venue_id
                WHERE a.transfer_branch_id IS NOT NULL
                AND a.transfer_branch_id = {$branch_id}
                AND b.branch_id = {$branch_id}
            ");
        $transfer = $transfer[0]->count;

        $claim_no_hearing_date = ClaimCaseOpponent::select(DB::raw('count(1) as total'))
            ->join('claim_case', 'claim_case_opponents.claim_case_id', '=', 'claim_case.claim_case_id')
            ->join('form1', 'form1.form1_id', '=', 'claim_case.form1_id')
            ->where('claim_case.case_status_id', '>=', 2)
            ->where('form1.form_status_id', 17)
            ->where(function ($q) use ($branch_id) {
                $q->where('claim_case.branch_id', $branch_id)
                    ->orWhere('claim_case.transfer_branch_id', $branch_id);
            })
            ->whereBetween('claim_case.created_at', ['2015-01-01 00:00:00', date('Y-m-d H:i:s')])
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
            ->first()
            ->total;

        $months = MasterMonth::all();
        $report_dashboard = ViewReportDashboard::where('branch_id', Auth::user()->ttpm_data->branch_id)
            ->where('year', date('Y'))
            ->orderBy('month');

        $branch_staff = $branch_id;
        $user = Auth::user();

        return view('home_staff', compact('inquiry', 'inquiry_30', 'form1', 'form2', 'announcements',
            'suggestion', 'form8', 'form10', 'form12', 'form_status', 'sms_unanswered', 'form1_unpaid',
            'form1_incomplete', 'form2_unpaid', 'claim_no_hearing_date', 'f4_not_print', 'stop_notice_unprocessed',
            'award_disobey_unprocessed', 'form11', 'form4', 'form5', 'form6', 'form7', 'form9', 'form11',
            'form3', 'report_dashboard', 'months', 'hearings', 'branch_staff', 'user', 'transfer'));
    }

    /**
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function homeUser($announcements, $user_id)
    {
        $claim = ClaimCase::where('claimant_user_id', $user_id)
            ->join('form1', 'form1.form1_id','=','claim_case.form1_id')
            ->where('case_status_id', '>', 0)
            ->orderBy('form1.filing_date', 'desc')
            ->get();

        // Get claim_case where opponent_id same as user_id
        $opposed = ClaimCaseOpponent::with('claimCase')
            ->join('claim_case', 'claim_case.claim_case_id','=','claim_case_opponents.claim_case_id')
            ->join('form1', 'form1.form1_id','=','claim_case.form1_id')
            ->where('claim_case_opponents.opponent_user_id', $user_id)
            ->where('claim_case.case_status_id', '>', 1)
            ->orderBy('form1.filing_date', 'desc')
            ->get();

        return view('home_user', compact('claim', 'opposed', 'announcements'));
    }
}
