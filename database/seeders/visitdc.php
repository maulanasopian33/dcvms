<?php

namespace Database\Seeders;

use App\Models\visit_dc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\visitdcFactory;

class visitdc extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        visit_dc::factory(100)->create();
    }
}
