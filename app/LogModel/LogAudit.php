<?php

namespace App\LogModel;

use Illuminate\Database\Eloquent\Model;

class LogAudit extends Model
{
    protected $table = 'log_audit';
    protected $primaryKey = 'log_audit_id';

    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function type()
    {
        return $this->belongsTo('App\MasterModel\MasterAuditType', 'audit_type_id', 'audit_type_id');
    }
}
