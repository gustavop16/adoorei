<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;

    
    protected $fillable  = ['sales_id','product_id', 'amount'];
    public $primaryKey   = ['sales_id','product_id'];
    public $incrementing = false;
  
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('sales_id', $this->getAttribute('sales_id'))
            ->where('product_id', $this->getAttribute('product_id'));
    }

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    

}
