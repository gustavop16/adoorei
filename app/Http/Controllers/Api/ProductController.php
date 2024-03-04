<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product_repository;
    
    public function __construct(ProductRepository $product_repository)
	{
		$this->product_repository = $product_repository;
	}


    public function getAvailable(){
        $data = $this->product_repository->getAvailable();
        return ProductResource::collection($data);
    }
}
