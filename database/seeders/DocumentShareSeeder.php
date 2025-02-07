<?php

namespace Database\Seeders;

use App\Models\DocumentShare;
use Illuminate\Database\Seeder;

class DocumentShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentShare::factory()->count(1)->create();
    }
}
