<?php

namespace App\Http\Controllers\Portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterDirectoryBranch;
use App\PortalModel\PortalMenu;
use App\PortalModel\Portal;
use App\PortalModel\PortalDirectoryBranch;

class PortalDirectoryBranchController extends Controller
{
	public function index(Request $request)
	{
		$page = Portal::where('url', 'directory/branches')->first();
		$menu = PortalMenu::whereNull('parent_menu_id')->orderBy('priority')->get();
		$directoryBranch = MasterDirectoryBranch::where('is_active',1)->orderBy('created_at', 'asc')->get();

		return view('portal.directory.branch', compact('menu','page','directoryBranch'));
	}
}