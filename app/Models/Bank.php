<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    public function transactions(): HasMany
{
    return $this->HasMany(Transaction::class);
}
}
