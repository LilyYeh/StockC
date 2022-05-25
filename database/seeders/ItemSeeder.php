<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Barn;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory()
            ->count(5)
            ->has(Barn::factory()
                        ->count(10)
                        ->state(new Sequence(
                            ['type' => 1],
                            ['type' => 2]
                )),'barns')
            ->create();
    }
}
