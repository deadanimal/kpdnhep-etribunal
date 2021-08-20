<?php

namespace App\Http\Controllers\Portal;

use App;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterDirectoryBranch;
use App\PortalModel\Portal;
use App\PortalModel\PortalMenu;
use App\PortalModel\PortalAnnouncement;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class PortalController extends Controller
{
    /**
     * PortalController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'index', 'view', 'delete', 'create', 'edit', 'store', 'update'
        ]]);
    }

    /**
     * Open portal page based on request
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function openPage(Request $request)
    {
        if (!session('visited', false)) {
            session(['visited' => true]);
            $this->addCounter();
        }

        $l10n = App::getLocale();
        $page = Portal::where("url", "LIKE", "%" . strtolower($request->url) . "%")->first();
        $menu = PortalMenu::whereNull("parent_menu_id")->orderBy("priority")->get();
        $announcements = PortalAnnouncement::whereDate('start_date', '<=', Carbon::today())
            ->whereDate('end_date', '>=', Carbon::today()->subDay())
            ->get();
        $directoryBranches = $request->url == "home"
            ? MasterDirectoryBranch::where('is_active',1)
                ->orderBy('created_at', 'asc')
                ->get()
            : [];

        // read by segment 2 uri
        switch ($request->segment(2)) {
            case 'contact':
                return view('portal.contact_' . $l10n, compact('menu'));
                break;
            case 'directory':
            default:
                if ($page) {
                    $view = $request->url == "home" ? 'portal.home_v3' : 'portal.page';
                    return view($view, compact('page', 'menu', 'announcements', 'l10n', 'directoryBranches'));
                } else {
                    return abort(404);
                }
                break;
        }
    }

    /**
     * Announcement
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function announcement(Request $request, $id)
    {
        if ($id) {
            $announcement = PortalAnnouncement::find($id);
            return view('portal.announcement.readModal', compact('announcement'));
        }
    }

    /**
     * @param $key
     * @param $value
     */
    protected function changeEnv($key, $value)
    {
        $key = strtoupper($key);

        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $key . '="' . $_ENV[$key] . '"', $key . '="' . $value . '"', file_get_contents($path)
            ));
        }
    }

    protected function addCounter()
    {
//        $this->changeEnv("PORTAL_COUNTER", (string)(env("PORTAL_COUNTER") + 1));
    }

    protected function rules_insert()
    {

        $rules = [
            'title_en' => 'required',
            'title_my' => 'required',
            'content_en' => 'required',
            'content_my' => 'required',
            'url' => 'required'

        ];

        return $rules;
    }

    protected function rules_update()
    {

        $rules = [
            'title_en' => 'required',
            'title_my' => 'required',
            'content_en' => 'required',
            'content_my' => 'required',
            'url' => 'required'
        ];

        return $rules;
    }

    public function index(Request $request)
    {

        $this->middleware('auth');

        if ($request->ajax()) {

            $page = Portal::orderBy('created_at', 'desc')->get();

            $datatables = Datatables::of($page);

            return $datatables
                ->editColumn('url', function ($page) {
                    return $page->url;
                })->editColumn('title', function ($page) {
                    $locale = App::getLocale();
                    $title_lang = 'title_' . $locale;
                    return $page->$title_lang;
                })->editColumn('subtitle', function ($page) {
                    $locale = App::getLocale();
                    $subtitle_lang = 'subtitle_' . $locale;
                    if ($page->$subtitle_lang)
                        return $page->$subtitle_lang;
                    else return '-';
                })->editColumn('created_by_user_id', function ($page) {
                    return $page->created_by->name;
                })->editColumn('action', function ($page) {
                    $button = "";

                    $button .= '<a value="' . route('cms.page.view', $page->portal_id) . '" rel="tooltip" data-original-title="' . __('button.view') . '" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    $button .= actionButton('green-meadow', __('button.edit'), route('cms.page.edit', ['id' => $page->portal_id]), false, 'fa-edit', false);

                    $button .= '<a class="btn btn-xs btn-danger" rel="tooltip" data-original-title="' . __('button.delete') . '" onclick="deletePage(' . $page->portal_id . ')"><i class="fa fa-trash-o"></i></a>';

                    return $button;
                })->make(true);

        }
        return view("portal.page.list");
    }

    public function view(Request $request, $id)
    {

        $this->middleware('auth');

        if ($id) {
            $page = Portal::find($id);
            return view('portal.page.viewModal', compact('page'), ['id' => $id])->render();
        }
    }

    public function delete(Request $request, $id)
    {
        $this->middleware('auth');

        if ($id) {
            $page = Portal::find($id)->delete();
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function create()
    {
        $this->middleware('auth');

        $page = new Portal;
        return view("portal.page.create", compact('page'));
    }

    public function edit($id)
    {
        $this->middleware('auth');

        if ($id) {
            $page = Portal::find($id);
            return view("portal.page.create", compact('page'));
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_insert());

        if ($request->portal_id == NULL) {

            if ($validator->passes()) {

                $portal_id = DB::table('portal')->insertGetId([
                    'title_en' => $request->title_en,
                    'title_my' => $request->title_my,
                    'subtitle_en' => $request->subtitle_en ? $request->subtitle_en : null,
                    'subtitle_my' => $request->subtitle_my ? $request->subtitle_my : null,
                    'content_en' => $request->content_en,
                    'content_my' => $request->content_my,
                    'url' => $request->url,
                    'created_by_user_id' => Auth::id()
                ]);

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_update());

        if ($request->portal_id != NULL) {

            if ($validator->passes()) {
                $portal_id = Portal::find($request->portal_id)->update([
                    'title_en' => $request->title_en,
                    'title_my' => $request->title_my,
                    'subtitle_en' => $request->subtitle_en ? $request->subtitle_en : null,
                    'subtitle_my' => $request->subtitle_my ? $request->subtitle_my : null,
                    'content_en' => $request->content_en,
                    'content_my' => $request->content_my,
                    'url' => $request->url
                ]);
                return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }
}
