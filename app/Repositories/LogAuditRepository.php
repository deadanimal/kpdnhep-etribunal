<?php

namespace App\Repositories;

use App\LogModel\LogAudit;
use Auth;
use Illuminate\Http\Request;

class LogAuditRepository
{
    /**
     * Store audit trail
     *
     * @param \Illuminate\Http\Request $request
     * @param $type
     * @param $model
     * @param $data_old
     * @param $data_new
     * @param $description
     */
    public static function store(Request $request, $type, $model, $data_old, $data_new, $description)
    {
        LogAudit::create([
            'audit_type_id' => $type,
            'created_by_user_id' => auth()->id ?? null,
            'ip_address' => $request->ip(),
            'description' => $description,
            'model' => $model,
            'data_old' => $data_old,
            'data_new' => $data_new,
            'url' => $request->fullUrl(),
        ]);

        return;
    }
}
