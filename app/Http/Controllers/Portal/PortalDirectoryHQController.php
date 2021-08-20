<?php

namespace App\Http\Controllers\Portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterDirectoryHQ;
use App\PortalModel\PortalMenu;
use App\PortalModel\Portal;
use App\MasterModel\MasterBranch;
use App\PortalModel\PortalDirectoryHQ;
use App\MasterModel\MasterDirectoryBranch;

class PortalDirectoryHQController extends Controller
{
	public function index(Request $request)
	{
		$page = Portal::where('url', 'directory/headquarters')->first();
		$menu = PortalMenu::whereNull('parent_menu_id')->orderBy('priority')->get();
		$hq = MasterBranch::where('branch_id',16)->first();
		$directoryHQ = MasterDirectoryHQ::where('is_active',1)->orderBy('directory_hq_sort', 'asc')->get();
		$directoryHQDivision = new PortalDirectoryHQ;
		$directoryBranch = MasterDirectoryBranch::where('is_active',1)->orderBy('created_at', 'asc')->get();

		return view('portal.directory.hq', compact('menu','page','hq','directoryHQ','directoryHQDivision','directoryBranch'));
	}
}

