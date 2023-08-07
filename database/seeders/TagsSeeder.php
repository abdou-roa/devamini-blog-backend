<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tags = [
            [
                'tag_name' => 'technology',
                'tag_description' => 'this tag has posts related to technology and modern inventions',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tag_name' => 'web dev',
                'tag_description' => 'this tag has posts related to web dev',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tag_name' => 'machine learning',
                'tag_description' => 'this tag has posts related to machine learning',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tag_name' => 'artificial inteligence',
                'tag_description' => 'this tag has posts related to Ai',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            
        ];

        Tag::insert($tags);
    }
}
