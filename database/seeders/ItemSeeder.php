<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'type_id' => 1,
                'name' => 'Design',
                'unit_price' => 230.00,
            ],
            [
                'type_id' => 1,
                'name' => 'Development',
                'unit_price' => 330.00,
            ],
            [
                'type_id' => 1,
                'name' => 'Meetings',
                'unit_price' => 60.00,
            ],
            [
                'type_id' => 2,
                'name' => 'Printer',
                'unit_price' => 100.00,
            ],
            [
                'type_id' => 2,
                'name' => 'Monitor',
                'unit_price' => 90.00,
            ],
        ];

        foreach ($data as $key => $value) {
            Item::firstOrCreate([
                'type_id' => $value['type_id'],
                'name' => $value['name'],
                'unit_price' => $value['unit_price'],
            ]);
        }
    }
}
