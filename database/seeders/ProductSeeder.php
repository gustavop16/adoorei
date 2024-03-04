<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(
            [
                [
                    "name" => "Celular 1",
                    "price" => 1.800,
                    "description"=> "Lorenzo Ipsulum",
                    'stock' => 15
                ],
                [
                    "name" => "Celular 2",
                    "price" => 3.200,
                    "description"=> "Lorem ipsum dolor",
                    'stock' => 15
                ],
                [
                    "name" => "Celular 3",
                    "price" => 9.800,
                    "description" => "Lorem ipsum dolor sit amet",
                    'stock' => 15
                ]
            ]
        );
    }
}
