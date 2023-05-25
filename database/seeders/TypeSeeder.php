<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Services',
            'Hardware',
        ];

        foreach ($data as $key => $value) {
            Type::firstOrCreate([
                'name' => $value
            ]);
        }
    }
}
