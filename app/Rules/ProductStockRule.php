<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductStockRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {   
        foreach ($value as $key => $target) {
            if( (empty($target['product_id'])) || (!is_int($target['product_id'])) ){
                $fail('Produto inválido!');
            }
            elseif( (empty($target['amount'])) || (!is_int($target['amount']) || ($target['amount'] < 1) )){
                $fail('Quantidade de produtos inválido!');
            }
            else{
                $product = Product::find($target['product_id']);
                if(empty($product)){
                    $fail('Produto não encontrado!');
                }
                elseif($target['amount'] > $product->stock){
                    $fail('Não há estoque suficiente!');
                }
            }
        }
    }
}
