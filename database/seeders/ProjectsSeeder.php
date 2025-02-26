<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Attribute;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        // Create Project A with some users and attributes
        $projectA = Project::create([
            'name' => 'Project A',
            'status' => 'active',
        ]);

        // Assign first two users to Project A
        $projectA->users()->attach($users->take(2)->pluck('id'));

        // Add attribute values
        $projectA->attributeValues()->createMany([
            [
                'attribute_id' => Attribute::where('name', 'department')->first()->id,
                'value' => 'IT'
            ],
            [
                'attribute_id' => Attribute::where('name', 'budget')->first()->id,
                'value' => '10000'
            ],
        ]);

        // Create Project B with different users and attributes
        $projectB = Project::create([
            'name' => 'Project B',
            'status' => 'active',
        ]);

        // Assign last two users to Project B
        $projectB->users()->attach($users->take(-2)->pluck('id'));

        // Add attribute values
        $projectB->attributeValues()->createMany([
            [
                'attribute_id' => Attribute::where('name', 'department')->first()->id,
                'value' => 'Marketing'
            ],
            [
                'attribute_id' => Attribute::where('name', 'budget')->first()->id,
                'value' => '15000'
            ],
        ]);
    }
} 