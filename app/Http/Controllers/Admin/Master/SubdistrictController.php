<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\UpdateMasterSubdistrictRequest;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class SubdistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subdistricts = MasterSubdistrict::orderBy('name', 'asc')->get();

            $datatables = Datatables::of($subdistricts);

            return $datatables->make(true);
        }

        return view("admin.master.subdistricts.index", compact('submission_types'));
    }

    public function edit(MasterSubdistrict $subdistrict)
    {
        if(!$subdistrict) {
            return redirect('sub');
        }
    }

    public function update(UpdateMasterSubdistrictRequest $request, MasterSubdistrict $subdistrict)
    {

    }
}
