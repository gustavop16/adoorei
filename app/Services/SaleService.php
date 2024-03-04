<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class SaleService 
{
    private $product_repository;
    
    public function __construct(ProductRepository $product_repository){
		$this->product_repository = $product_repository;
	}

    public function calculateAmount(array $products){
        $amount = 0;
        foreach ($products as $value) {
            $product =  $this->product_repository->getById($value['product_id']);
            $amount += ($value['amount'] * $product->price);
        }
        return $amount;
    }

    public function debitStock($target){
        $product =  $this->product_repository->getById($target['product_id']);
        $stock   = $product->stock - $target['amount'];
        return $this->product_repository->update(['stock' => $stock], $product);
    }

   
    
    

    
       
  

}
