<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['office_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDepartments()
    {
        return $this->all();
    }
}
