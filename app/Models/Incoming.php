<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incoming extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'file_id',
        'received_by',
        'status',
        'remarks'
    ];


    /**
     * Relationships
     */


     public function departments()
     {
        return $this->hasMany(Department::class, 'id', 'department_id');
     }

     public function files()
     {
        return $this->hasMany(Files::class, 'document_id', 'file_id');
     }
}
