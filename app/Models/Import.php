<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [

        'product',
        'amount',
        'user_id',
        'date',
        'amountOld',
    ];

    public function user():BelongsTo
    {

        return $this->belongsTo('users');
    }


}
