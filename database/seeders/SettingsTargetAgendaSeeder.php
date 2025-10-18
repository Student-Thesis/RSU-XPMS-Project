<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettingsTargetAgenda;
use Illuminate\Support\Str;

class SettingsTargetAgendaSeeder extends Seeder
{
    public function run(): void
    {
        $items = ['Environmental Awareness', 'Community Development', 'Health and Wellness', 'Education', 'Technology Advancement'];

        foreach ($items as $name) {
            SettingsTargetAgenda::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name), 'is_active' => true]
            );
        }
    }
}
