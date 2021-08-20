<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use App\Mail\SuggestionAutoReplyMail;
use App\Mail\SuggestionReplyMail;

use App\SupportModel\Suggestion;
use App\MasterModel\MasterClaimClassification;
use App\MasterModel\MasterClaimCategory;
use App\SupportModel\Attachment;

use App\Role;

use App;
use Auth;
use DB;

use Exception;

class SuggestionController extends Controller
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

    public function modal(){
        $attachments = null;
        return view("others.suggestion.modalCreate", compact('attachments'));
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'subject'  => 'required',
                    'suggestion' => 'required'                  
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'response'  => 'required',
                    //'suggestion' => 'required'
                    //'is_general_inquiry'  => 'required|integer'
                    
                ];

        return $rules;
    }

    public function index(Request $request){

        $categories = MasterClaimCategory::where('is_active',1)->orderBy('claim_category_id','desc')->get();
        $classifications = MasterClaimClassification::where('is_active',1)->orderBy('claim_classification_id','asc')->get();

        if ($request->ajax()) {

            $suggestions = Suggestion::with(['created_by', 'responded_by'])->orderBy('created_at','desc');

            if ($request->has('claim_classification_id')) {

                if($request->has('claim_classification_id') && !empty($request->claim_classification_id)) 
                    $suggestions->where('is_general_inquiry', $request->claim_classification_id);
                    // $suggestions = $suggestions->filter(function ($value) use ($request) {
                    //     return $value->is_general_inquiry == $request->claim_classification_id;
                    // });

            }

            $datatables = Datatables::of($suggestions);

            return $datatables
                ->editColumn('subject', function ($suggestions) {
                    return "<strong>".$suggestions->subject."</strong><br>".$suggestions->suggestion;
                })->editColumn('status', function ($suggestions) {
                    if($suggestions->response)
                        return '<span class="label bg-yellow-soft">'.__("new.responded").'</span>';
                    else
                        return '<span class="label label-default">'.__("new.no_respond").'</span>';
                })->editColumn('created_by_user_id', function ($suggestions) {
                    return $suggestions->created_by->name;
                })->editColumn('responded_by_user_id', function ($suggestions) {
                    if($suggestions->responded_by)
                        return $suggestions->responded_by->name;
                    else return "-";
                })->editColumn('created_at', function ($suggestions) {
                    return Carbon::parse($suggestions->created_at)->format('d/m/Y');
                })->editColumn('action', function ($suggestions) {
                    $button = "";

                    $button .= '<a value="' . route('others.suggestion.view', $suggestions->suggestion_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                     if( Auth::user()->hasRole('setiausaha') || Auth::user()->hasRole('admin')) {

                    if(!$suggestions->response)
                        $button .= '<a href="' . route('others.suggestion.edit', $suggestions->suggestion_id) . '" rel="tooltip" data-original-title="'.__('button.respond').'" class="btn btn-xs green-meadow" ><i class="fa fa-edit"></i> '.__('button.respond').'</a>';

                    }

                    // $button .= '<a class="btn btn-xs btn-danger" rel="tooltip" data-original-title="'.__('button.delete').'" onclick="deleteSuggestion('. $suggestions->suggestion_id .')"><i class="fa fa-trash-o"></i></a>';

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"SuggestionController",null,null,"Datatables load suggestion");
        return view("others.suggestion.list", compact('classifications', 'categories'));
    }

    public function create(){
        $suggestions = new Suggestion;
       /* $categories = MasterClaimCategory::where('is_active', 1)->orderBy('claim_category_id','desc')->get();
        $classifications = MasterClaimClassification::where('is_active',1)->orderBy('claim_classification_id','desc')->get();*/
        $attachments = null;

        return view("others.suggestion.create", compact('suggestions', 'subject', 'categories', 'attachments'));
    }

    public function edit($id){
        /*if($id){*/
            $suggestions= Suggestion::find($id);

            $start_date = date('d/m/Y', strtotime($suggestions->start_date));
            $end_date = date('d/m/Y', strtotime($suggestions->end_date));
            $roles = Role::all();
            $attachments = Attachment::where('form_no', 15)->where('form_id', $id)->get();

            return view("others.suggestion.respond", compact('suggestions', 'categories', 'attachments'));
        /*}*/
    }

    public function view(Request $request, $id){
        if($id){
            $suggestions = Suggestion::find($id);
            $attachments = Attachment::where('form_no', 15)->where('form_id', $id)->get();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"SuggestionController",null,null,"View suggestion ". $id);

            return view('others.suggestion.viewModal',compact('suggestions','attachments'), ['id' => $id])->render();
        }   
    }

    public function delete(Request $request, $id){

        if($id){
            $suggestions = Suggestion::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"SuggestionController",null,null,"Delete suggestion ". $id);
            $attachment = Attachment::where('form_no', 15)->where('form_id', $id)->delete();
            $suggestions->delete();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

        //$userid = Auth::id();

        $validator = Validator::make($request->all(), $this->rules_insert());

        if($request->suggestion_id == NULL){

            if($validator->passes()){

                //Auth::id();
                // $request->created_by_user_id = Auth::id();
                // $announcement = Announcement::create($request->all()); 
                $suggestion_id = DB::table('suggestion')->insertGetId([
                        'created_by_user_id' => Auth::id(),
                        'subject' => $request->subject,
                        'suggestion' => $request->suggestion
                    ]);

                
                ///////////////////////////// ATTACHMENT part //////////////////////////////
                $form_no = 15;
                $userid = Auth::id();


                //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

                $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $suggestion_id)->get();

                if($suggestion_id) {

                    if ($request->hasFile('attachment_1')) {
                        if ($request->file('attachment_1')->isValid()) {

                            if($oldAttachments->get(0)) {
                                if($request->file1_info == 2) {
                                    // Replace
                                    $oldAttachments->get(0)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $suggestion_id;
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
                                    $attachment->form_id = $suggestion_id;
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
                            $audit->add($request,4,"SuggestionController",json_encode($request->input()),null,"Suggestion ".$request->file('attachment_1')->getClientOriginalName()." - Upload attachement");
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
                                    $attachment->form_id = $suggestion_id;
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
                                    $attachment->form_id = $suggestion_id;
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
                            $audit->add($request,4,"SuggestionController",json_encode($request->input()),null,"Suggestion ".$request->file('attachment_2')->getClientOriginalName()." - Upload attachement");
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
                                    $attachment->form_id = $suggestion_id;
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
                                    $attachment->form_id = $suggestion_id;
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
                            $audit->add($request,4,"SuggestionController",json_encode($request->input()),null,"Suggestion ".$request->file('attachment_3')->getClientOriginalName()." - Upload attachement");
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
                                    $attachment->form_id = $suggestion_id;
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
                                    $attachment->form_id = $suggestion_id;
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
                            $audit->add($request,4,"SuggestionController",json_encode($request->input()),null,"Suggestion ".$request->file('attachment_4')->getClientOriginalName()." - Upload attachement");
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
                                    $attachment->form_id = $suggestion_id;
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
                                    $attachment->form_id = $suggestion_id;
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
                            $audit->add($request,4,"SuggestionController",json_encode($request->input()),null,"Suggestion ".$request->file('attachment_5')->getClientOriginalName()." - Upload attachement");
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

                try {
                    Mail::to(Auth::user()->email)->send(new SuggestionAutoReplyMail(Auth::user()->language_id));
                } catch(Exception $e) {
                    die(Auth::user()->email);
                }
                
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"SuggestionController",json_encode($request->input()),null,"Suggestion ".$suggestion_id." - Create suggestion");

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            }else{
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), $this->rules_update());

        if($request->suggestion_id != NULL){

            if($validator->passes()){

                $suggestions = Suggestion::find($request->suggestion_id);

                $suggestions->response = $request->response;
                $suggestions->responded_by_user_id = Auth::id();
                $suggestions->save();
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"SuggestionController",null,null,"Edit suggestion ". $request->suggestion_id);
                Mail::to($suggestions->created_by->email)->send(new SuggestionReplyMail($suggestions, $suggestions->created_by->language_id));

                return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
            }else{
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

}
