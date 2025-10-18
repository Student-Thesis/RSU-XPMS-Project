<?php

namespace Database\Seeders;

use App\Models\SettingsClassification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SettingsClassificationSeeder extends Seeder
{
    public function run(): void
    {
        $items = ['Project', 'Program'];

        foreach ($items as $name) {
            SettingsClassification::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name), 'is_active' => true]
            );
        }
    }
}
