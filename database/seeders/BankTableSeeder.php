<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create(['description' => 'Banco de Crédito del Perú', 'abbreviation' => 'BCP']);
        Bank::create(['description' => 'Banco Interamericano de Finanzas', 'abbreviation' => 'BANBIF']);
        Bank::create(['description' => 'BBVA', 'abbreviation' => 'BBVA']);
        Bank::create(['description' => 'Interbank', 'abbreviation' => 'INTERBANK']);
        Bank::create(['description' => 'Scotiabank Perú', 'abbreviation' => 'SCOTIABANK']);
    }
}
