<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
class patient extends  Model implements AuditableContract
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'patients';
    protected $primaryKey ='id';
    protected $fillable = [
        'id',
        'name',
        'phone',
        'email',
        'address',
        'DOB',
        'gender',
        'allergies',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
