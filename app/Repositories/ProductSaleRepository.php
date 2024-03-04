<?php

namespace App\Repositories;

use App\Models\ProductSale;

class ProductSaleRepository 
{
    private $product_sale_model;
    
    public function __construct(ProductSale $product_sale_model){
		$this->product_sale_model = $product_sale_model;
	}

    public function create(array $attributes){           
        return $this->product_sale_model->create($attributes);
    }
   
    public function getBySale($sales_id){
        return $this->product_sale_model
        ->where('sales_id',$sales_id)
        ->get();
    }

    public function getBySaleProduct($sales_id, $product_id){
        return $this->product_sale_model
        ->where('sales_id',$sales_id)
        ->where('product_id',$product_id)
        ->first();
    }

    public function update(array $attributes, ProductSale $target){   
        return $target->update($attributes);
    }

    public function updateOrCreate(array $attributes){   
        return $this->product_sale_model->updateOrCreate(['product_id' => $attributes['product_id'], 'sales_id'=>$attributes['sales_id']],$attributes);
    }
    
    
}
