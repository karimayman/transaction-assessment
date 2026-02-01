<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model


{
    protected $fillable = [
        'date',
        'uuid',
        'reference_number',
        'direction',
        'raw_request',
        'amount',
        'bank_id',
        'notes',
        'processed',
        'stored_request_id',
        ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function storedTransactions(): belongsTo {
        return $this->belongsTo(storedRequest::class , 'stored_request_id');
    }

}
