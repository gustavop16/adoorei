<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository 
{
    private $sale_model;
    
    public function __construct(Sale $sale_model){
		$this->sale_model = $sale_model;
	}

    public function create(array $attributes){
        return $this->sale_model->create($attributes);
    }

    public function getByStatus($status){
        return $this->sale_model
        ->where('status',$status)
        ->get();
    }

    public function getById($id){
        return $this->sale_model->find($id);
    }

    public function update(array $attributes, Sale $sale){   
        return $sale->update($attributes);
    }
    

}
