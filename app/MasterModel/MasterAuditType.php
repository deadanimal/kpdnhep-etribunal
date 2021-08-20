<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterAuditType extends Model
{
    protected $table = 'master_audit_type';
    protected $primaryKey = 'audit_type_id';
}
