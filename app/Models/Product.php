<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model {

    use Query;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'user_id'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

}
