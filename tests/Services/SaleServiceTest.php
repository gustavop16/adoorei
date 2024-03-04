<?php

namespace Tests\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\SaleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaleServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void{
        
        $product_repository = new ProductRepository(new Product());

        $service = new SaleService($product_repository);

        $products = 
        [ 
            [
            "product_id" => 1,
            "amount" => 1
            ],
            [
            "product_id" => 2,
            "amount" => 4
            ]
                
        ];

        $amount = $service->calculateAmount($products);

        $this->assertIsFloat($amount, 'tipo de valor total incorreto ');

        $debit = $service->debitStock($products[0]);
        $this->assertTrue($debit, 'Erro ao debitar estoque');
    }
}
