<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\SupportModel\ClaimSubmission;
use App\MasterModel\MasterSubmissionCategory;
use App\MasterModel\MasterSubmissionType;
use App\MasterModel\MasterBranch;
use App\SupportModel\Attachment;
use App\CaseModel\Form4;

use Auth;
use DB;
use App;

class ClaimSubmissionRecordController extends Controller
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
    
    //
    protected function rules_insert(Request $request){

        $rules = [ 
                    'submission_date' => 'required',
                    'is_claimant_submit' => 'required'
                ];
        if ( $request->is_claimant_submit == 1){
            $rules['submission_category_id']  = 'required|integer';
            $rules['submission_type_id']  = 'required|integer';

            if( $request->submission_category_id == 2 )
            $rules['pos_reference_no'] = 'required';
        }
        else {
            $rules['is_letter'] = 'required';
        }

        return $rules;
    }

    protected function rules_update(Request $request){

        $rules = [ 
                    'submission_date' => 'required',
                    'is_claimant_submit' => 'required'
                ];

        if ( $request->is_claimant_submit == 1){
            $rules['submission_category_id']  = 'required|integer';
            $rules['submission_type_id']  = 'required|integer';

            if( $request->submission_category_id == 2 )
            $rules['pos_reference_no'] = 'required';
        }
        else {
            $rules['is_letter'] = 'required';
        }

        return $rules;
    }

    public function index(Request $request){

        if( !Auth::user()->hasRole('user') && !$request->has('branch') ) {
            return redirect()->route('others.claimsubmission', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        $branches = MasterBranch::where('is_active', 1)->get();

        if ($request->ajax()) {

            $claim_submission = ClaimSubmission::with(['form4.case','form4.hearing.branch'])->orderBy('created_at','desc');

            if($request->has('branch') && !empty($request->branch))  
                $claim_submission->whereHas('form4', function ($form4) use ($request) {
                    return $form4->whereHas('hearing', function ($hearing) use ($request) {
                        return $hearing->where('branch_id', $request->branch);
                    });
                });
                // $claim_submission = $claim_submission->filter(function ($value) use ($request) {
                //     return $value->form4->hearing->branch_id == $request->branch;
                // });


            $datatables = Datatables::of($claim_submission);

            return $datatables
                ->editColumn('claim_no', function ($claim_submission) {
                    return $claim_submission->form4->case->case_no;
                })->editColumn('branch', function ($claim_submission) {
                    return $claim_submission->form4->hearing->branch->branch_name;
                })->editColumn('party', function ($claim_submission) {
                    if ($claim_submission->is_claimant_submit == 0)
                        return __('new.opponent');
                    else return __('new.claimant');
                })->editColumn('submission_date', function ($claim_submission) {
                    return Carbon::parse($claim_submission->submission_date)->format('d/m/Y');
                })->editColumn('hearing_date', function ($claim_submission) {
                    return Carbon::parse($claim_submission->form4->hearing->hearing_date)->format('d/m/Y');
                })->editColumn('action', function ($claim_submission) {

                    $button = "";

                    $button .= '<a value="' . route('others.claimsubmission.view', $claim_submission->claim_submission_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    if( $claim_submission->is_claimant_submit == 1)
                    $button .= actionButton('green-meadow', __('button.edit'), route('others.claimsubmission.edit.pym', ['claim_submission_id' => $claim_submission->claim_submission_id]), false, 'fa-edit', false);
                    else
                    $button .= actionButton('green-meadow', __('button.edit'), route('others.claimsubmission.edit.p', ['claim_submission_id' => $claim_submission->claim_submission_id]), false, 'fa-edit', false);   

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"ClaimSubmissionRecordController",null,null,"Datatables load claim submission record");
        return view("others.claim_submission.list", compact('branches','claim_submission'));
    }

    public function create_pym(Request $request){

        $claim_submission = ClaimSubmission::where('form4_id' ,$request->form4_id)->where('is_claimant_submit', 1)->get();

        if($claim_submission->count() > 0) {

            $claim_submission = $claim_submission->first();
            $submission_date =  date('d/m/Y', strtotime($claim_submission->submission_date));
            $attachments = Attachment::where('form_no', 18)->where('form_id', $claim_submission->claim_submission_id)->get();
        }
        else {

            $claim_submission = new ClaimSubmission;
            $submission_date = date('d/m/Y');
            $attachments = null;
        }

        $types = MasterSubmissionType::where('is_active', 1)->get();
        $categories = MasterSubmissionCategory::all();
        $form4 = Form4::find($request->form4_id);
        
        

        return view("others.claim_submission.create_pym", compact('claim_submission', 'submission_date', 'form4', 'types', 'categories', 'attachments'));
    }

    public function create_p(Request $request){

        $claim_submission = ClaimSubmission::where('form4_id' ,$request->form4_id)->where('is_claimant_submit', 0)->get();

        if($claim_submission->count() > 0) {

            $claim_submission = $claim_submission->first();
            $submission_date =  date('d/m/Y', strtotime($claim_submission->submission_date));
            $attachments = Attachment::where('form_no', 18)->where('form_id', $claim_submission->claim_submission_id)->get();
        }
        else {

            $claim_submission = new ClaimSubmission;
            $submission_date = date('d/m/Y');
            $attachments = null;
        }

        $form4 = Form4::find($request->form4_id);

        return view("others.claim_submission.create_p", compact('claim_submission', 'submission_date', 'form4', 'attachments'));
    }

    public function edit_pym(Request $request, $id){

        if($id){
            $claim_submission = ClaimSubmission::find($id);
            $form4 = Form4::find($claim_submission->form4_id);
            $submission_date =  date('d/m/Y', strtotime($claim_submission->submission_date));
            $types = MasterSubmissionType::where('is_active', 1)->get();
            $categories = MasterSubmissionCategory::all();
            $attachments = Attachment::where('form_no', 18)->where('form_id', $id)->get();

            return view("others.claim_submission.create_pym", compact('claim_submission', 'form4', 'submission_date', 'classifications', 'types', 'categories', 'attachments'));
        }
    }

    public function edit_p(Request $request, $id){

        if($id){
            $claim_submission = ClaimSubmission::find($id);
            $form4 = Form4::find($claim_submission->form4_id);
            $submission_date =  date('d/m/Y', strtotime($claim_submission->submission_date));
            $types = MasterSubmissionType::where('is_active', 1)->get();
            $categories = MasterSubmissionCategory::all();
            $attachments = Attachment::where('form_no', 18)->where('form_id', $id)->get();

            return view("others.claim_submission.create_p", compact('claim_submission', 'form4', 'submission_date', 'classifications', 'types', 'categories', 'attachments'));
        }
    }

    public function view(Request $request, $id){
        if($id){
            $claim_submission = ClaimSubmission::find($id);
            $attachments = Attachment::where('form_no', 18)->where('form_id', $id)->get();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"ClaimSubmissionRecordController",null,null,"View claim submission record ". $id);
            return view('others.claim_submission.viewModal',compact('claim_submission','attachments'), ['id' => $id])->render();
        }   
    }

    public function delete(Request $request, $id){

        if($id){
            $claim_submission = ClaimSubmission::find($id)->delete();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"ClaimSubmissionRecordController",null,null,"Delete claim submission record ". $id);
            $attachment = Attachment::where('form_no', 14)->where('form_id', $id)->delete();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){


        $validator = Validator::make($request->all(), $this->rules_insert($request));

        if($validator->passes()){

            //Auth::id();
            // $request->created_by_user_id = Auth::id();
            // $announcement = Announcement::create($request->all()); 


                if($request->claim_submission_id == NULL){

                    $claim_submission_id = DB::table('claim_submission')->insertGetId([
                            'form4_id' => $request->form4_id,
                            'claim_case_id' => $request->claim_case_id,
                            'is_claimant_submit' => $request->is_claimant_submit,
                            'is_representative_letter' => $request->is_letter ? $request->is_letter : null,
                            'submission_category_id' => $request->submission_category_id ? $request->submission_category_id : null,
                            'submission_type_id' => $request->submission_type_id ? $request->submission_type_id : null,
                            'submission_date' => $request->submission_date ? Carbon::createFromFormat('d/m/Y', $request->submission_date)->toDateTimeString() : Carbon::now(),
                            'created_by_user_id' => Auth::id(),
                            'pos_reference_no' => $request->submission_category_id == 2 ? $request->pos_reference_no : null
                        ]);
                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$claim_submission_id." - Create claim submission record");
                } 

                else{

                    $claim_submission_id = $request->claim_submission_id;
                    $claim_submission = ClaimSubmission::find($request->claim_submission_id)->update([

                        'form4_id' => $request->form4_id,
                        'claim_case_id' => $request->claim_case_id,
                        'is_claimant_submit' => $request->is_claimant_submit,
                        'is_representative_letter' => $request->is_letter ? $request->is_letter : null,
                        'submission_category_id' => $request->submission_category_id ? $request->submission_category_id : null,
                        'submission_type_id' => $request->submission_type_id ? $request->submission_type_id : null,
                        'submission_date' => $request->submission_date ? Carbon::createFromFormat('d/m/Y', $request->submission_date)->toDateTimeString() : Carbon::now(),
                        'pos_reference_no' => $request->submission_category_id == 2 ? $request->pos_reference_no : null

                    ]);

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request,5,"ClaimSubmissionRecordController",null,null,"Edit Claim Submission Record ".$claim_submission_id);
                }
           


            ///////////////////////////// ATTACHMENT part //////////////////////////////
            $form_no = 18;
            $userid = Auth::id();

            //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

            $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $claim_submission_id)->get();

            if($claim_submission_id) {

                if ($request->hasFile('attachment_1')) {
                    if ($request->file('attachment_1')->isValid()) {

                        if($oldAttachments->get(0)) {
                            if($request->file1_info == 2) {
                                // Replace
                                $oldAttachments->get(0)->delete();

                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_1);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }
                        else {
                            if($request->file1_info == 2) {
                                // Add
                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_1);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }

                        $audit = new \App\Http\Controllers\Admin\AuditController;
                        $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_1')->getClientOriginalName()." - Upload attachement");
                    }
                }
                else {
                    if($oldAttachments->get(0)) {
                        if($request->file1_info == 2) {
                            $oldAttachments->get(0)->delete();
                        }
                    }
                }

                if ($request->hasFile('attachment_2')) {
                    if ($request->file('attachment_2')->isValid()) {

                        if($oldAttachments->get(1)) {
                            if($request->file2_info == 2) {
                                // Replace
                                $oldAttachments->get(1)->delete();

                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_2);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }
                        else {
                            if($request->file2_info == 2) {
                                // Add
                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_2);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }

                        $audit = new \App\Http\Controllers\Admin\AuditController;
                        $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_2')->getClientOriginalName()." - Upload attachement");
                    }
                }
                else {
                    if($oldAttachments->get(1)) {
                        if($request->file2_info == 2) {
                            $oldAttachments->get(1)->delete();
                        }
                    }
                }
                  

                if ($request->hasFile('attachment_3')) {
                    if ($request->file('attachment_3')->isValid()) {

                        if($oldAttachments->get(2)) {
                            if($request->file3_info == 2) {
                                // Replace
                                $oldAttachments->get(2)->delete();

                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_3);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }
                        else {
                            if($request->file3_info == 2) {
                                // Add
                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_3);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }

                        $audit = new \App\Http\Controllers\Admin\AuditController;
                        $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_3')->getClientOriginalName()." - Upload attachement");
                    }
                }
                else {
                    if($oldAttachments->get(2)) {
                        if($request->file3_info == 2) {
                            $oldAttachments->get(2)->delete();
                        }
                    }
                }

                
                if ($request->hasFile('attachment_4')) {
                    if ($request->file('attachment_4')->isValid()) {

                        if($oldAttachments->get(3)) {
                            if($request->file4_info == 2) {
                                // Replace
                                $oldAttachments->get(3)->delete();

                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_4);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }
                        else {
                            if($request->file4_info == 2) {
                                // Add
                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_4);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }

                        $audit = new \App\Http\Controllers\Admin\AuditController;
                        $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_4')->getClientOriginalName()." - Upload attachement");
                    }
                }
                else {
                    if($oldAttachments->get(3)) {
                        if($request->file4_info == 2) {
                            $oldAttachments->get(3)->delete();
                        }
                    }
                }


                if ($request->hasFile('attachment_5')) {
                    if ($request->file('attachment_5')->isValid()) {

                        if($oldAttachments->get(4)) {
                            if($request->file5_info == 2) {
                                // Replace
                                $oldAttachments->get(4)->delete();

                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_5);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }
                        else {
                            if($request->file5_info == 2) {
                                // Add
                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $claim_submission_id;
                                $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_5);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }

                        $audit = new \App\Http\Controllers\Admin\AuditController;
                        $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_5')->getClientOriginalName()." - Upload attachement");
                    }
                }
                else {
                    if($oldAttachments->get(4)) {
                        if($request->file5_info == 2) {
                            $oldAttachments->get(4)->delete();
                        }
                    }
                }
            }
            
            return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
        }else{
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
        
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), $this->rules_update($request));

        if($request->claim_submission_id != NULL){

            if($validator->passes()){


                $claim_submission = ClaimSubmission::find($request->claim_submission_id)->update([

                        'form4_id' => $request->form4_id,
                        'claim_case_id' => $request->claim_case_id,
                        'is_claimant_submit' => $request->is_claimant_submit,
                        'is_representative_letter' => $request->is_letter ? $request->is_letter : null,
                        'submission_category_id' => $request->submission_category_id ? $request->submission_category_id : null,
                        'submission_type_id' => $request->submission_type_id ? $request->submission_type_id : null,
                        'submission_date' => $request->submission_date ? Carbon::createFromFormat('d/m/Y', $request->submission_date)->toDateTimeString() : Carbon::now(),
                        'created_by_user_id' => Auth::id(),
                        'pos_reference_no' => $request->submission_category_id == 2 ? $request->pos_reference_no : null

                    ]);


                ///////////////////////////// ATTACHMENT part //////////////////////////////
                $form_no = 18;
                $userid = Auth::id();

                //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

                $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $request->claim_submission_id)->get();

                if($request->claim_submission_id) {

                    if ($request->hasFile('attachment_1')) {
                        if ($request->file('attachment_1')->isValid()) {

                            if($oldAttachments->get(0)) {
                                if($request->file1_info == 2) {
                                    // Replace
                                    $oldAttachments->get(0)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_1);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }
                            else {
                                if($request->file1_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_1);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new \App\Http\Controllers\Admin\AuditController;
                            $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_1')->getClientOriginalName()." - Upload attachement");
                        }
                    }
                    else {
                        if($oldAttachments->get(0)) {
                            if($request->file1_info == 2) {
                                $oldAttachments->get(0)->delete();
                            }
                        }
                    }

                    if ($request->hasFile('attachment_2')) {
                        if ($request->file('attachment_2')->isValid()) {

                            if($oldAttachments->get(1)) {
                                if($request->file2_info == 2) {
                                    // Replace
                                    $oldAttachments->get(1)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_2);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }
                            else {
                                if($request->file2_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_2);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new \App\Http\Controllers\Admin\AuditController;
                            $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_2')->getClientOriginalName()." - Upload attachement");
                        }
                    }
                    else {
                        if($oldAttachments->get(1)) {
                            if($request->file2_info == 2) {
                                $oldAttachments->get(1)->delete();
                            }
                        }
                    }
                      

                    if ($request->hasFile('attachment_3')) {
                        if ($request->file('attachment_3')->isValid()) {

                            if($oldAttachments->get(2)) {
                                if($request->file3_info == 2) {
                                    // Replace
                                    $oldAttachments->get(2)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_3);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }
                            else {
                                if($request->file3_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_3);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new \App\Http\Controllers\Admin\AuditController;
                            $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_3')->getClientOriginalName()." - Upload attachement");
                        }
                    }
                    else {
                        if($oldAttachments->get(2)) {
                            if($request->file3_info == 2) {
                                $oldAttachments->get(2)->delete();
                            }
                        }
                    }

                    
                    if ($request->hasFile('attachment_4')) {
                        if ($request->file('attachment_4')->isValid()) {

                            if($oldAttachments->get(3)) {
                                if($request->file4_info == 2) {
                                    // Replace
                                    $oldAttachments->get(3)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_4);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }
                            else {
                                if($request->file4_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_4);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new \App\Http\Controllers\Admin\AuditController;
                            $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_4')->getClientOriginalName()." - Upload attachement");
                        }
                    }
                    else {
                        if($oldAttachments->get(3)) {
                            if($request->file4_info == 2) {
                                $oldAttachments->get(3)->delete();
                            }
                        }
                    }


                    if ($request->hasFile('attachment_5')) {
                        if ($request->file('attachment_5')->isValid()) {

                            if($oldAttachments->get(4)) {
                                if($request->file5_info == 2) {
                                    // Replace
                                    $oldAttachments->get(4)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_5);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }
                            else {
                                if($request->file5_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->claim_submission_id;
                                    $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_5);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new \App\Http\Controllers\Admin\AuditController;
                            $audit->add($request,4,"ClaimSubmissionRecordController",json_encode($request->input()),null,"Claim Submission Record ".$request->file('attachment_5')->getClientOriginalName()." - Upload attachement");
                        }
                    }
                    else {
                        if($oldAttachments->get(4)) {
                            if($request->file5_info == 2) {
                                $oldAttachments->get(4)->delete();
                            }
                        }
                    }
                }
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"ClaimSubmissionRecordController",null,null,"Edit Claim Submission Record ".$request->claim_submission_id);
                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            }else{
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

}
