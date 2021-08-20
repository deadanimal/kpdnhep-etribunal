<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class L10nController extends Controller
{
    public function change(Request $request)
    {
        if (in_array($request->l10n, Config::get('app.locales'))) {
            Session::put('locale', $request->l10n);
        }

        return redirect()->back();
    }
}
