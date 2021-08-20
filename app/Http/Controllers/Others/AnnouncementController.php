<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\SupportModel\Announcement;
use App\SupportModel\AnnouncementTarget;
use App\SupportModel\Attachment;
use App\MasterModel\MasterAnnouncementType;
use App\MasterModel\MasterMonth;
use App\Role;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;

use Auth;
use DB;
use App;

class AnnouncementController extends Controller
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
    protected function rules_insert($request){

        $rules = [ 
                    'title_en'  => 'required',
                    'title_my'  => 'required',
                    'description_en'  => 'required',
                    'description_my'  => 'required',
                    'announcement_type_id' => 'required|integer',
                    'start_date' => 'required' ,
                    'end_date' => 'required',
                    'select_mode' => 'required|integer'
                ];

        if($request->select_mode == 3)
            $rules['target_roles'] = 'required';

        return $rules;
    }

    protected function rules_update($request){

        $rules = [ 
                    'title_en'  => 'required',
                    'title_my'  => 'required',
                    'description_en'  => 'required',
                    'description_my'  => 'required',
                    'announcement_type_id' => 'required|integer',
                    'start_date' => 'required' ,
                    'end_date' => 'required',
                    'select_mode' => 'required|integer'
                ];

        if($request->select_mode == 3)
            $rules['target_roles'] = 'required';

        return $rules;
    }

    public function index(Request $request){

        $status = [
            '1' => __('new.active'),
            '2' => __('new.inactive')
        ];
        $types = MasterAnnouncementType::where('is_active', 1)->get();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();


        if ($request->ajax()) {

            $announcements = Announcement::with(['created_by','type'])->orderBy('created_at', 'desc');

            // Check for filteration
            if($request->has('status') && !empty($request->status)) {
                    
                if($request->status == 1) { //Active
                    $announcements = $announcements->whereDate('start_date', '<=', Carbon::today())->whereDate('end_date', '>=', Carbon::today()->subDay());
                } else {
                    $announcements = $announcements->whereDate('start_date', '>', Carbon::today())->orWhereDate('end_date', '<', Carbon::today()->subDay());
                }
            }
            
            // $announcements = $announcements->get();

            if($request->has('type') && !empty($request->type)) 
                $announcements->where('announcement_type_id', $request->type);
                // $announcements = $announcements->filter(function ($value) use ($request) {
                //     return $value->announcement_type_id == $request->type;
                // });

            if($request->has('year') && !empty($request->year)) 
                $announcements->whereYear('created_at', $request->year);
                // $announcements = $announcements->filter(function ($value) use ($request) {
                //     return date('Y', strtotime($value->created_at)) == $request->year;
                // });

            if($request->has('month') && !empty($request->month)) 
                $announcements->whereMonth('created_at', $request->month);
                // $announcements = $announcements->filter(function ($value) use ($request) {
                //     return date('m', strtotime($value->created_at)) == $request->month;
                // });

            $datatables = Datatables::of($announcements);

            return $datatables
                ->editColumn('announcement_id', function ($announcement){
                    return $announcement->announcement_id;
                })->editColumn('title', function ($announcement) {
                    $locale = App::getLocale();
                    $title_lang = "title_".$locale;
                    return $announcement->$title_lang;
                })->editColumn('type', function ($announcement) {
                    $locale = App::getLocale();
                    $type_lang = "announcement_type_".$locale;
                    return $announcement->type->$type_lang;
                })->editColumn('created_by', function ($announcement) {
                    return $announcement->created_by->name;
                })->editColumn('created_at', function ($announcement) {
                    return Carbon::parse($announcement->created_at)->format('d/m/Y');
                })->editColumn('start_date', function ($announcement) {
                    return Carbon::parse($announcement->start_date)->format('d/m/Y');
                })->editColumn('end_date', function ($announcement) {
                    return Carbon::parse($announcement->end_date)->format('d/m/Y');
                })->editColumn('action', function ($announcement) {
                    $button = "";

                    $button .= '<a value="' . route('others.announcement.view', $announcement->announcement_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    if( Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks') || Auth::user()->hasRole('admin') || $announcement->created_by_user_id == Auth::id() ) {

                        $button .= actionButton('green-meadow', __('button.edit'), route('others.announcement.edit', ['id'=>$announcement->announcement_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs btn-danger" rel="tooltip" data-original-title="'.__('button.delete').'" onclick="deleteAnnouncement('. $announcement->announcement_id .')"><i class="fa fa-trash-o"></i></a>';
                    }

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"AnnouncementController",null,null,"Datatables load announcement");

        return view("others.announcement.list", compact('announcements','status','years','months','types'));
    }

    public function create(){

        $userid = Auth::id();
        $user = User::find($userid);
        $announcement = new Announcement;
        $start_date = date('d/m/Y');
        $end_date = date('d/m/Y'); //Carbon::now()->addDays(1)->format('d/m/Y');

        if( Auth::user()->hasRole('pengerusi') )
            $types = MasterAnnouncementType::all();
        else
            $types = MasterAnnouncementType::where('announcement_type_id', '!=', '3')->get();

        $roles = Role::all();
        $attachments = null;

        return view("others.announcement.create", compact('announcement', 'start_date',  'end_date', 'roles', 'types','attachments'));
    }

    public function edit($id){
        if($id){
            $announcement= Announcement::find($id);

            $start_date = date('d/m/Y', strtotime($announcement->start_date));
            $end_date = date('d/m/Y', strtotime($announcement->end_date));

            if( Auth::user()->hasRole('pengerusi') )
                $types = MasterAnnouncementType::all();
            else
                $types = MasterAnnouncementType::where('announcement_type_id', '!=', '3')->get();

            


            $roles = Role::all();
            $attachments = Attachment::where('form_no', 13)->where('form_id', $id)->get();

            return view("others.announcement.create", compact('announcement', 'start_date', 'end_date', 'roles', 'types', 'attachments'));
        }
    }

    public function view(Request $request, $id){
        if($id){
            $announcement = Announcement::find($id);
            $attachments = Attachment::where('form_no', 13)->where('form_id', $id)->get();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"AnnouncementController",null,null,"View Announcement ".$id);
            return view('others.announcement.viewModal',compact('announcement','attachments'), ['id' => $id])->render();
        }   
    }

    public function viewDashboard(Announcement $announcement){
        if($announcement){
            $attachments = Attachment::where('form_no', 13)
                ->where('form_id', $announcement->announcement_id)
                ->get();

            return view('others.announcement.viewModalDashboard',compact('announcement','attachments'), ['id' => $announcement->announcement_id])->render();
        }   
    }

    public function delete(Request $request, $id){

        if($id){
            $announcement = Announcement::find($id)->delete();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"AnnouncementController",null,null,"Delete announcement ". $id);
            $attachment = Attachment::where('form_no', 13)->where('form_id', $id)->delete();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){


        $validator = Validator::make($request->all(), $this->rules_insert($request));

        if($request->announcement_id == NULL){

            if($validator->passes()){

                //Auth::id();
                // $request->created_by_user_id = Auth::id();
                // $announcement = Announcement::create($request->all()); 
                $announcement_id = DB::table('announcement')->insertGetId([
                        'title_en' => $request->title_en,
                        'description_en' => $request->description_en,
                        'title_my' => $request->title_my,
                        'description_my' => $request->description_my,
                        'announcement_type_id' => $request->announcement_type_id,
                        'start_date' => $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString() : NULL,
                        'end_date' => $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateTimeString() : NULL,
                        'created_by_user_id' => Auth::id()
                    ]);

                if($request->select_mode == 1) {
                    $roles = Role::all();
                    foreach($roles as $role) {

                        $announcement_target = new AnnouncementTarget;
                        $announcement_target->role_id = $role->id;
                        $announcement_target->announcement_id = $announcement_id;
                        $announcement_target->save();
                    }
                }
                else if($request->select_mode == 2) {
                    $roles = Role::where('type','!=',3)->get();
                    foreach($roles as $role) {

                        $announcement_target = new AnnouncementTarget;
                        $announcement_target->role_id = $role->id;
                        $announcement_target->announcement_id = $announcement_id;
                        $announcement_target->save();
                    }
                }
                else {
                    foreach($request->target_roles as $role) {

                        $announcement_target = new AnnouncementTarget;
                        $announcement_target->role_id = $role;
                        $announcement_target->announcement_id = $announcement_id;
                        $announcement_target->save();
                    }
                }


                ///////////////////////////// ATTACHMENT part //////////////////////////////
                $form_no = 13;
                $userid = Auth::id();

                //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

                $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $announcement_id)->get();

                if($announcement_id) {

                    if ($request->hasFile('attachment_1')) {
                        if ($request->file('attachment_1')->isValid()) {

                            if($oldAttachments->get(0)) {
                                if($request->file1_info == 2) {
                                    // Replace
                                    $oldAttachments->get(0)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $announcement_id;
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
                                    $attachment->form_id = $announcement_id;
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
                            $audit->add($request,4,"AnnouncementController",json_encode($request->input()),null,"Announcement ".$request->file('attachment_1')->getClientOriginalName()." - Upload attachement");
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
                                    $attachment->form_id = $announcement_id;
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
                                    $attachment->form_id = $announcement_id;
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
                            $audit->add($request,4,"AnnouncementController",json_encode($request->input()),null,"Announcement ".$request->file('attachment_2')->getClientOriginalName()." - Upload attachement");
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
                                    $attachment->form_id = $announcement_id;
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
                                    $attachment->form_id = $announcement_id;
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
                            $audit->add($request,4,"AnnouncementController",json_encode($request->input()),null,"Announcement ".$request->file('attachment_3')->getClientOriginalName()." - Upload attachement");
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
                                    $attachment->form_id = $announcement_id;
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
                                    $attachment->form_id = $announcement_id;
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
                            $audit->add($request,4,"AnnouncementController",json_encode($request->input()),null,"Announcement ".$request->file('attachment_4')->getClientOriginalName()." - Upload attachement");
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
                                    $attachment->form_id = $announcement_id;
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
                                    $attachment->form_id = $announcement_id;
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
                            $audit->add($request,4,"AnnouncementController",json_encode($request->input()),null,"Announcement ".$request->file('attachment_5')->getClientOriginalName()." - Upload attachement");
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
                $audit->add($request,4,"AnnouncementController",json_encode($request->input()),null,"Announcement ".$announcement_id." - Create announcement");

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            }else{
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), $this->rules_update($request));

        if($request->announcement_id != NULL){

            if($validator->passes()){

                $announcement_id = $request->announcement_id;

                $announcement = Announcement::find($request->announcement_id)->update([
                        'title_en' => $request->title_en,
                        'description_en' => $request->description_en,
                        'title_my' => $request->title_my,
                        'description_my' => $request->description_my,
                        'announcement_type_id' => $request->announcement_type_id,
                        'start_date' => $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString() : NULL,
                        'end_date' => $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateTimeString() : NULL
                    ]);

                $delete = AnnouncementTarget::where('announcement_id', $request->announcement_id)->delete();

                if($request->select_mode == 1) {
                    $roles = Role::all();
                    foreach($roles as $role) {

                        $announcement_target = new AnnouncementTarget;
                        $announcement_target->role_id = $role->id;
                        $announcement_target->announcement_id = $announcement_id;
                        $announcement_target->save();
                    }
                }
                else if($request->select_mode == 2) {
                    $roles = Role::where('type','!=',3)->get();
                    foreach($roles as $role) {

                        $announcement_target = new AnnouncementTarget;
                        $announcement_target->role_id = $role->id;
                        $announcement_target->announcement_id = $announcement_id;
                        $announcement_target->save();
                    }
                }
                else {
                    foreach($request->target_roles as $role) {

                        $announcement_target = new AnnouncementTarget;
                        $announcement_target->role_id = $role;
                        $announcement_target->announcement_id = $announcement_id;
                        $announcement_target->save();
                    }
                }




                ///////////////////////////// ATTACHMENT part //////////////////////////////
                $form_no = 13;
                $userid = Auth::id();

                //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

                $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $request->announcement_id)->get();

                if($request->announcement_id) {

                    if ($request->hasFile('attachment_1')) {
                        if ($request->file('attachment_1')->isValid()) {

                            if($oldAttachments->get(0)) {
                                if($request->file1_info == 2) {
                                    // Replace
                                    $oldAttachments->get(0)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->announcement_id;
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
                                    $attachment->form_id = $request->announcement_id;
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
                                    $attachment->form_id = $request->announcement_id;
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
                                    $attachment->form_id = $request->announcement_id;
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
                                    $attachment->form_id = $request->announcement_id;
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
                                    $attachment->form_id = $request->announcement_id;
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

                    
                    if ($request->hasFile('attachment_4')) {
                        if ($request->file('attachment_4')->isValid()) {

                            if($oldAttachments->get(3)) {
                                if($request->file4_info == 2) {
                                    // Replace
                                    $oldAttachments->get(3)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->announcement_id;
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
                                    $attachment->form_id = $request->announcement_id;
                                    $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_4);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            
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
                                    $attachment->form_id = $request->announcement_id;
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
                                    $attachment->form_id = $request->announcement_id;
                                    $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_5);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            
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
                $audit->add($request,5,"AnnouncementController",null,null,"Update Announcement ".$request->announcement_id);

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            }else{
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

}
