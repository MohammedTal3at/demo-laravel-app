<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributesSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = [
            ['name' => 'department', 'type' => 'text'],
            ['name' => 'budget', 'type' => 'number'],
            ['name' => 'start_date', 'type' => 'date'],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
}
