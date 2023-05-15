<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
class appointment extends  Model implements AuditableContract
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'appointments';
    protected $primaryKey ='id';
    protected $fillable = [
        'id',
        'patient_id',
        'dentisti_id',
        'date',
        'time',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
