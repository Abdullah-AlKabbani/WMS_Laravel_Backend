<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [

        'product',
        'amount',
        'user_id',
        'siz',
        'colore',
        'category_id'

    ];



    public function user():BelongsTo
    {
        return $this->belongsTo('users');
    }


    public function category():BelongsTo
    {
        return $this->belongsTo('categories');
    }


}
