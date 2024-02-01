<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\File;
use App\Models\Folder;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Folder::truncate();
        File::truncate();
        Type::truncate();

        User::factory(3)->create();

        $folder1 = Folder::factory()->create();
        $folder2 = Folder::factory()->create();

        $type1 = Type::factory()->create();
        $type2 = Type::factory()->create();
        $type3 = Type::factory()->create();
        $type4 = Type::factory()->create();
        $type5 = Type::factory()->create();

        File::factory()->create([
            'folder_id' => $folder1->id,
            'type_id' => $type1->id
        ]);
        File::factory()->create([
            'folder_id' => $folder2->id,
            'type_id' => $type2->id
        ]);
        File::factory()->create([
            'folder_id' => $folder1->id,
            'type_id' => $type3->id
        ]);
        File::factory()->create([
            'folder_id' => $folder2->id,
            'type_id' => $type4->id
        ]);
        File::factory()->create([
            'folder_id' => $folder1->id,
            'type_id' => $type5->id
        ]);
        File::factory()->create([
            'folder_id' => $folder2->id,
            'type_id' => $type5->id
        ]);
    }
}
