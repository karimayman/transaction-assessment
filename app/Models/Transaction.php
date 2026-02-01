<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    public function bank(): BelongsTo {
        return $this->BelongTo(Bank::class);
    }
}
