<?php

namespace App\Http\Controllers\Portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\PortalModel\PortalMenu;
use App;
use DB;
use Carbon\Carbon;

class PortalMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'menu_en' => 'required',
                    'menu_my' => 'required',
                    'url' => 'required',
                    'priority' => 'required',
                   
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'menu_en' => 'required',
                    'menu_my' => 'required',
                    'url' => 'required',
                    'priority' => 'required',
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

            $menu = PortalMenu::orderBy('created_at', 'desc')->get();

            $datatables = Datatables::of($menu);

            return $datatables
                ->editColumn('menu', function ($menu) {
                    $locale = App::getLocale();
                    $menu_lang = 'menu_'.$locale;
                    return $menu->$menu_lang;
                })->editColumn('url', function ($menu) {
                    if($menu->url)
                        return $menu->url;
                    else return '-';
                })->editColumn('parent_menu', function ($menu) {
                    $locale = App::getLocale();
                    $menu_lang = 'menu_'.$locale;
                    if($menu->parent)
                        return $menu->parent->$menu_lang;
                    else return '-';
                })->editColumn('priority', function ($menu) {
                    return $menu->priority;
                })->editColumn('action', function ($menu) {
                    $button = "";

                    $button .= '<a value="' . route('cms.menu.view', $menu->portal_menu_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    $button .= actionButton('green-meadow', __('button.edit'), route('cms.menu.edit', ['id'=>$menu->portal_menu_id]), false, 'fa-edit', false);

                    $button .= '<a class="btn btn-xs btn-danger" rel="tooltip" data-original-title="'.__('button.delete').'" onclick="deleteMenu('. $menu->portal_menu_id .')"><i class="fa fa-trash-o"></i></a>';

                    return $button;
                })->make(true);
    		
        }
    	return view("portal.menu.list");
    }

    public function create(){
        $menu = new PortalMenu;
        $menu_list = PortalMenu::all();
    	return view("portal.menu.create", compact('menu', 'menu_list'));
    }

    public function edit($id){
    	if($id){
	    	$menu =PortalMenu::find($id);
            $menu_list = PortalMenu::all();
	    	return view("portal.menu.create", compact('menu', 'menu_list'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$menu = PortalMenu::find($id);
    		return view('portal.menu.viewModal', compact('menu') ,['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$menu = PortalMenu::find($id)->delete();
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->portal_menu_id == NULL){

    		if($validator->passes()){

                $portal_menu_id = DB::table('portal_menu')->insertGetId([
                        'menu_en' => $request->menu_en,
                        'menu_my' => $request->menu_my,
                        'url' => $request->url,
                        'parent_menu_id' => $request->parent_menu_id ? $request->parent_menu_id : NULL,
                        'priority' => $request->priority
                    ]);

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->portal_menu_id != NULL){

    		if($validator->passes()){
                $portal_menu_id = PortalMenu::find($request->portal_menu_id)->update([
                        'menu_en' => $request->menu_en,
                        'menu_my' => $request->menu_my,
                        'url' => $request->url,
                        'parent_menu_id' => $request->parent_menu_id ? $request->parent_menu_id : NULL,
                        'priority' => $request->priority
                    ]);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
