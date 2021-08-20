<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\CaseModel\ClaimCase;
use App\SupportModel\Journal;
use App\MasterModel\MasterClaimClassification;
use App\MasterModel\MasterClaimCategory;
use App\SupportModel\Attachment;

use PDF;
use Auth;
use DB;
use App;

class JournalController extends Controller
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
    protected function rules_insert(){

        $rules = [ 
                    'journal_desc'  => 'required',
                    'is_status' => 'required',
                    'claim_classification_id'  => 'required|integer',
                    'claim_category_id'  => 'required|integer'
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'journal_desc'  => 'required',
                    'is_status' => 'required',
                    'claim_classification_id'  => 'required|integer',
                    'claim_category_id'  => 'required|integer'
                ];

        return $rules;
    }

    public function index(Request $request){

        $categories = MasterClaimCategory::where('is_active',1)->orderBy('claim_category_id','desc')->get();
        $classifications = MasterClaimClassification::where('is_active',1)->orderBy('claim_classification_id','asc')->get();

        if ($request->ajax()) {

            $journal = Journal::orderBy('created_at','desc');

            if ( $request->has('claim_category_id') || $request->has('claim_classification_id') || $request->has('status')) {

                if($request->has('claim_classification_id') && !empty($request->claim_classification_id)) 
                    $journal->where('claim_classification_id', $request->claim_classification_id);
                    // $journal = $journal->filter(function ($value) use ($request) {
                    //     return $value->claim_classification_id == $request->claim_classification_id;
                    // });

                if($request->has('claim_category_id') && !empty($request->claim_category_id)) 
                    $journal->whereHas('classification', function ($classification) use ($request) {
                        return $classification->where('category_id', $request->claim_category_id);
                    });
                    // $journal = $journal->filter(function ($value) use ($request) {
                    //     return $value->classification->category_id == $request->claim_category_id;
                    // });

                if($request->has('status') && !empty($request->status)) 
                    $journal->where('is_status', $request->status);
                    // $journal = $journal->filter(function ($value) use ($request) {
                    //     return $value->is_status == $request->status;
                    // });

            }

            $datatables = Datatables::of($journal);

            return $datatables
                ->editColumn('journal_desc', function ($journal) {
                    return $journal->journal_desc;
                })->editColumn('claim_category_id', function ($journal) {
                    $locale = App::getLocale();
                    $category_lang = "category_".$locale;
                    return $journal->classification->category->$category_lang;
                })->editColumn('claim_classification_id', function ($journal) {
                    $locale = App::getLocale();
                    $classification_lang = "classification_".$locale;
                    return $journal->classification->$classification_lang;
                })->editColumn('created_at', function ($journal) {
                    return Carbon::parse($journal->created_at)->format('d/m/Y');
                })->editColumn('status', function ($journal) {
                    if ($journal->is_status == 1)
                        return __('new.publish');
                    else return __('new.unpublish');
                })->editColumn('action', function ($journal) {
                    $button = "";

                    $button .= '<a value="' . route('others.journal.view', $journal->journal_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    $button .= actionButton('green-meadow', __('button.edit'), route('others.journal.edit', ['id'=>$journal->journal_id]), false, 'fa-edit', false);

                    $button .= '<a class="btn btn-xs btn-danger" rel="tooltip" data-original-title="'.__('button.delete').'" onclick="deleteJournal('. $journal->journal_id .')"><i class="fa fa-trash-o"></i></a>';

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"JournalController",null,null,"Datatables load journal");
        return view("others.journal.list", compact('classifications', 'categories'));
    }

    public function export(Request $request, $case_no, $format){
        
        if($format == 'pdf') {
            $this->data['claim'] = $claim = ClaimCase::where('case_no', $case_no)->first();
            //dd($claim);
            // $this->data['form1_filing_date'] = date('d M Y', strtotime($claim->form1->filing_date));

            // if($claim->form1->purchased_date)
            //     $this->data['purchased_date'] = date('d M Y', strtotime($claim->form1->purchased_date));
            // else
            //     $this->data['purchased_date'] = null;

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,17,"JournalController",$claim->case_no,null,"Download journal (PDF)");

            $pdf = PDF::loadView('others/journal/printdocument'.App::getLocale(), $this->data);
            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Journal '.$claim->case_no.'.pdf');
        }

    }

    public function checkcase(Request $request){
        $case = ClaimCase::where('case_no', $request->case_no)->first();

        if($case){
            $journal = Journal::where('journal_desc', $request->case_no)->first();

            if($journal){
                return response()->json([
                    'message' => __("swal.journal_exist"),
                    'result' => false
                ]);
            }
            else {
                return response()->json([
                    'message' => __("swal.success"),
                    'result' => true
                ]);
            }
        }
        else {
            return response()->json([
                'message' => __("swal.claim_not_exist"),
                'result' => false
            ]);
        }
    }

    public function create(){
        $journal = new Journal;
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $classifications = MasterClaimClassification::where('is_active',1)->get();
        $attachments = null;

        return view("others.journal.create", compact('journal', 'classifications', 'categories', 'attachments'));
    }

    public function createclaim(Request $request){
            $categories = MasterClaimCategory::where('is_active',1)->orderBy('claim_category_id','desc')->get();
            $classifications = MasterClaimClassification::where('is_active',1)->orderBy('claim_classification_id','asc')->get();
        if(!$request->case_no){

            return view("others.journal.list", compact('classifications', 'categories'));
        }

        $attachments = null;
        $claim_case = ClaimCase::where('case_no', $request->case_no)->first();


        return view("others.journal.createclaim", compact('claim_case', 'classifications', 'categories', 'attachments'));
    }

    public function edit($id){
        if($id){
            $journal= Journal::find($id);

            $categories = MasterClaimCategory::where('is_active', 1)->get();
            $classifications = MasterClaimClassification::where('is_active',1)->get();
            $attachments = Attachment::where('form_no', 14)->where('form_id', $id)->get();

            return view("others.journal.create", compact('journal', 'classifications', 'categories', 'attachments'));
        }
    }

    public function view($id){
        if($id){
            $journal = Journal::find($id);
            $attachments = Attachment::where('form_no', 14)->where('form_id', $id)->get();

            return view('others.journal.viewModal',compact('journal','attachments'), ['id' => $id])->render();
        }   
    }

    public function delete(Request $request, $id){

        if($id){
            $journal = Journal::find($id)->delete();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"JournalController",null,null,"Delete journal ". $id);
            $attachment = Attachment::where('form_no', 14)->where('form_id', $id)->delete();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){


        $validator = Validator::make($request->all(), $this->rules_insert());

        if($validator->passes()){

            //Auth::id();
            // $request->created_by_user_id = Auth::id();
            // $announcement = Announcement::create($request->all()); 

            if($request->journal_id == NULL){
                $journal_id = DB::table('journal')->insertGetId([
                        'journal_desc' => $request->journal_desc,
                        'claim_classification_id' => $request->claim_classification_id,
                        'is_status' => $request->is_status
                    ]);
            } else {
                $journal_id = $request->journal_id;
                $journal_update = Journal::find($journal_id)->update([
                        'journal_desc' => $request->journal_desc,
                        'claim_classification_id' => $request->claim_classification_id,
                        'is_status' => $request->is_status
                    ]);
            }


            ///////////////////////////// ATTACHMENT part //////////////////////////////
            $form_no = 14;
            $userid = Auth::id();

            //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

            $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $journal_id)->get();

            if($journal_id) {

                if ($request->hasFile('attachment_1')) {
                    if ($request->file('attachment_1')->isValid()) {

                        if($oldAttachments->get(0)) {
                            if($request->file1_info == 2) {
                                // Replace
                                $oldAttachments->get(0)->delete();

                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $journal_id;
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
                                $attachment->form_id = $journal_id;
                                $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_1);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }

                        
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
                                $attachment->form_id = $journal_id;
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
                                $attachment->form_id = $journal_id;
                                $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_2);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }

                        
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
                                $attachment->form_id = $journal_id;
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
                                $attachment->form_id = $journal_id;
                                $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_3);
                                $attachment->created_by_user_id = $userid;
                                $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                $attachment->created_at = Carbon::now();
                                $attachment->updated_at = Carbon::now();
                                $attachment->save();
                            }
                        }

                        
                    }
                }
                else {
                    if($oldAttachments->get(2)) {
                        if($request->file3_info == 2) {
                            $oldAttachments->get(2)->delete();
                        }
                    }
                }

            }










            
            return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
        }else{
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
        
    }

    // public function update(Request $request){

    //     $validator = Validator::make($request->all(), $this->rules_update());

    //     if($request->announcement_id != NULL){

    //         if($validator->passes()){


    //             $announcement = Announcement::find($request->announcement_id)->update([
    //                     'title' => $request->title,
    //                     'description' => $request->description,
    //                     'title_my' => $request->title_my,
    //                     'description_my' => $request->description_my,
    //                     'start_date' => $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString() : NULL,
    //                     'end_date' => $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateTimeString() : NULL
    //                 ]);

    //             $delete = AnnouncementTarget::where('announcement_id', $request->announcement_id)->delete();

    //             foreach($request->target_roles as $role) {

    //                 $announcement_target = new AnnouncementTarget;
    //                 $announcement_target->role_id = $role;
    //                 $announcement_target->announcement_id = $request->announcement_id;
    //                 $announcement_target->save();
    //             }




    //             ///////////////////////////// ATTACHMENT part //////////////////////////////
    //             $form_no = 14;
    //             $userid = Auth::id();

    //             //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

    //             $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $request->announcement_id)->get();

    //             if($request->announcement_id) {

    //                 if ($request->hasFile('attachment_1')) {
    //                     if ($request->file('attachment_1')->isValid()) {

    //                         if($oldAttachments->get(0)) {
    //                             if($request->file1_info == 2) {
    //                                 // Replace
    //                                 $oldAttachments->get(0)->delete();

    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_1);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }
    //                         else {
    //                             if($request->file1_info == 2) {
    //                                 // Add
    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_1);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }

                            
    //                     }
    //                 }
    //                 else {
    //                     if($oldAttachments->get(0)) {
    //                         if($request->file1_info == 2) {
    //                             $oldAttachments->get(0)->delete();
    //                         }
    //                     }
    //                 }

    //                 if ($request->hasFile('attachment_2')) {
    //                     if ($request->file('attachment_2')->isValid()) {

    //                         if($oldAttachments->get(1)) {
    //                             if($request->file2_info == 2) {
    //                                 // Replace
    //                                 $oldAttachments->get(1)->delete();

    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_2);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }
    //                         else {
    //                             if($request->file2_info == 2) {
    //                                 // Add
    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_2);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }

                            
    //                     }
    //                 }
    //                 else {
    //                     if($oldAttachments->get(1)) {
    //                         if($request->file2_info == 2) {
    //                             $oldAttachments->get(1)->delete();
    //                         }
    //                     }
    //                 }
                      

    //                 if ($request->hasFile('attachment_3')) {
    //                     if ($request->file('attachment_3')->isValid()) {

    //                         if($oldAttachments->get(2)) {
    //                             if($request->file3_info == 2) {
    //                                 // Replace
    //                                 $oldAttachments->get(2)->delete();

    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_3);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }
    //                         else {
    //                             if($request->file3_info == 2) {
    //                                 // Add
    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_3);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }

                            
    //                     }
    //                 }
    //                 else {
    //                     if($oldAttachments->get(2)) {
    //                         if($request->file3_info == 2) {
    //                             $oldAttachments->get(2)->delete();
    //                         }
    //                     }
    //                 }

                    
    //                 if ($request->hasFile('attachment_4')) {
    //                     if ($request->file('attachment_4')->isValid()) {

    //                         if($oldAttachments->get(3)) {
    //                             if($request->file4_info == 2) {
    //                                 // Replace
    //                                 $oldAttachments->get(3)->delete();

    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_4);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }
    //                         else {
    //                             if($request->file4_info == 2) {
    //                                 // Add
    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_4);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }

                            
    //                     }
    //                 }
    //                 else {
    //                     if($oldAttachments->get(3)) {
    //                         if($request->file4_info == 2) {
    //                             $oldAttachments->get(3)->delete();
    //                         }
    //                     }
    //                 }


    //                 if ($request->hasFile('attachment_5')) {
    //                     if ($request->file('attachment_5')->isValid()) {

    //                         if($oldAttachments->get(4)) {
    //                             if($request->file5_info == 2) {
    //                                 // Replace
    //                                 $oldAttachments->get(4)->delete();

    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_5);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }
    //                         else {
    //                             if($request->file5_info == 2) {
    //                                 // Add
    //                                 $attachment = new Attachment;
    //                                 $attachment->form_no = $form_no;
    //                                 $attachment->form_id = $request->announcement_id;
    //                                 $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
    //                                 $attachment->file_blob = file_get_contents($request->attachment_5);
    //                                 $attachment->created_by_user_id = $userid;
    //                                 $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
    //                                 $attachment->created_at = Carbon::now();
    //                                 $attachment->updated_at = Carbon::now();
    //                                 $attachment->save();
    //                             }
    //                         }

                            
    //                     }
    //                 }
    //                 else {
    //                     if($oldAttachments->get(4)) {
    //                         if($request->file5_info == 2) {
    //                             $oldAttachments->get(4)->delete();
    //                         }
    //                     }
    //                 }
    //             }






















    //             return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    //         }else{
    //             return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    //         }
    //     }
    // }

}
