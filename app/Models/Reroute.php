<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reroute extends Model
{
    use HasFactory;

    protected $fillable = [
        'incoming_id',
        'from_office',
        'to_office',
        'status',
        'remarks',
        'date_rerouted'
    ];


    public function incoming()
    {
        return $this->belongsTo(Incoming::class, 'incoming_id', 'id');
    }

    
}
