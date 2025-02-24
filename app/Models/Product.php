<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function generateHistoriques() : HasMany {
        return $this->hasMany(GenerateHistorique::class);
    }

}
