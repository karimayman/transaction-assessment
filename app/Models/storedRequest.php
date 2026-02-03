<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class storedRequest extends Model
{
    protected $fillable = ['request',
        'processed',
        'direction',
        ];

    protected $casts = [
        'request' => 'array',
    ];

    public function transaction(): hasMany {
        return $this->hasMany(transaction::class, 'stored_request_id');
    }
    //
}
