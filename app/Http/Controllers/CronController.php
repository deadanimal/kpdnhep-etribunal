<?php

namespace App\Http\Controllers;

use App;
use App\CaseModel\Inquiry;
use App\CaseModel\Form1;
use App\CaseModel\Form2;
use App\Mail\InquirySecretaryAlertMail;
use App\RoleUser;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
    public function checkMaturity()
    {
        // Check for form1
        $form1 = Form1::where('form_status_id', 14)->orWhere('form_status_id', 15)->get();

        foreach ($form1 as $form) {
            if ($form->created_at->diff(Carbon::now())->days > 14) {
                if (!$form->payment_id) {
                    $form = Form1::find($form->form1_id)->update(['form_status_id' => 13]);
                } else if ($form->payment->payment_status_id != 4) {
                    $form = Form1::find($form->form1_id)->update(['form_status_id' => 13]);
                }
            }
        }

        echo $form1->count() . "<br>";

        // Check for form1
        $form2 = Form2::where('form_status_id', 19)->orWhere('form_status_id', 20)->get();

        foreach ($form2 as $form) {
            if ($form->created_at->diff(Carbon::now())->days > 14) {
                if (!$form->payment_id) {
                    $form = Form2::find($form->form2_id)->update(['form_status_id' => 18]);
                } else if ($form->payment->payment_status_id != 4) {
                    $form = Form2::find($form->form2_id)->update(['form_status_id' => 18]);
                }
            }
        }

        echo $form2->count() . "<br>";

        // 0 * * * * wget -q -O - "https://etribunalv2.kpdnkk.gov.my/cron/checkmaturity" > /dev/null
    }

    /**
     * Check all inquries that more than 3 days and still in new status
     * change it into perlu dijawab SU's status
     * and send notification email.
     */
    public function checkInquiry()
    {
        $inquiries = Inquiry::whereNull('processed_at')
            ->where('created_at', '<=', Carbon::now()->subDays(6)->toDateTimeString()) // more that 3 days
            ->where('inquiry_form_status_id', 9) // new
            ->get();

        foreach ($inquiries as $inquiry) {
            $inquiry->inquiry_form_status_id = 10; // perlu dijawab SU
            $inquiry->save();

            $secretaries = RoleUser::where('role_id', 6)->get()->filter(function ($query) {
                return $query->user->user_status_id == 1;
            });

            foreach ($secretaries as $secretary) {
                if ($secretary->user->user_status_id == 1) { // Active
                    Mail::to($secretary->user->email)->send(new InquirySecretaryAlertMail($inquiry, App::getLocale() == "en" ? 1 : 2));
                }
            }
        }

        echo $inquiries->count();

        // */30 * * * * wget -q -O - "https://etribunalv2.kpdnkk.gov.my/cron/checkinquiry" > /dev/null
    }
}
