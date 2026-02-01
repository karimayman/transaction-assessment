<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class banksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->insert([
            [
                'name' => 'PayTech',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Acme',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
