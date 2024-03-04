<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository 
{
    private $product_model;
    
    public function __construct(Product $product_model){
		$this->product_model = $product_model;
	}
    
    public function getAvailable(){
        return $this->product_model
        ->where('stock','>',0)
        ->get();
    }

    public function getById($id){
        return $this->product_model
        ->find($id);
    }
    
    public function update(array $attributes, Product $product){   
        return $product->update($attributes);
    }
  

}
