<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class BankMatcher
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    public function detectBank($transaction): string{

        if (str_contains($transaction, '#')){
            $bankId = DB::Select("select id from banks where name = 'PayTech'");
            return $bankId[0]->id;
        }
        if (str_contains($transaction, '//')){
            $bankId = DB::Select("select id from banks where name = 'Acme'");
            return $bankId[0]->id;
        }
        return 1;
    }
}
