<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Lost extends Model
{
    use HasFactory;

    protected $fillable = [

        'product',
        'amount',
        'date',
        'user_id',

    ];


    public function user():BelongsTo
    {

        return $this->belongsTo('users');
    }

    
}
