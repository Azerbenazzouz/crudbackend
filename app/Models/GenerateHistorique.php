<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GenerateHistorique extends Model {

    use Query;
    protected $fillable = [
        'prompt',
        'additional',
        'response',
        'user_id',
        'product_id'
    ];

    protected $table = 'generate_historique';

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

}
