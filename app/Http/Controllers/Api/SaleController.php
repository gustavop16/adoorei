<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Repositories\ProductSaleRepository;
use App\Repositories\SaleRepository;
use App\Services\SaleService;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    private $sale_repository;
    private $product_sale_repository;
    private $sale_service;
    
    public function __construct(
        SaleRepository $sale_repository, 
        ProductSaleRepository $product_sale_repository,
        SaleService $sale_service
    ){
		$this->sale_repository          = $sale_repository;
        $this->product_sale_repository  = $product_sale_repository;
        $this->sale_service             = $sale_service;
	}

    public function store(SaleRequest $request){
        $products       = $request->products;
        $input['amount'] = $this->sale_service->calculateAmount($products);
        $input['status'] = Sale::CONCLUDED;
        try{
            DB::beginTransaction();
                $sale = $this->sale_repository->create($input);
                foreach ($products as $value) {
                    $product = [
                        'product_id' => $value['product_id'],
                        'amount'     => $value['amount'],
                        'sales_id'   => $sale->id
                    ];
                    $this->sale_service->debitStock($value);
                    $this->product_sale_repository->create($product);
                }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => 'Houve algum erro, tente novamente!'], 400, ['X-Header-One' => 'Header Value']);
        }
        return new SaleResource($sale);
    }

    public function getAll(){
        $sales = $this->sale_repository->getByStatus(Sale::CONCLUDED);
        return SaleResource::collection($sales);
    }
   
    public function getById(int $id){
        $data = $this->sale_repository->getById($id);
        if (empty($data)) {
            return response()->json(['data' => []], 200, ['X-Header-One' => 'Header Value']);
        }
        return new SaleResource($data);
    }

    public function cancel(int $id){
        $data = $this->sale_repository->getById($id);
        if (empty($data)) {
            return response()->json(['msg' => 'Registro não encontrada!'], 200, ['X-Header-One' => 'Header Value']);
        }
        $this->sale_repository->update(['status'=> Sale::CANCELED],$data);
        return response()->json(['msg' => 'Registro cancelado!'], 200, ['X-Header-One' => 'Header Value']);
    }

    public function update($id, SaleRequest $request){

        $data = $this->sale_repository->getById($id);
        if (empty($data)) {
            return response()->json(['msg' => 'Registro não encontrada!'], 200, ['X-Header-One' => 'Header Value']);
        }
        $products       = $request->products;
        $input['amount'] = ($data->amount + $this->sale_service->calculateAmount($products));
        try{
            DB::beginTransaction();
                $this->sale_repository->update($input, $data);
                foreach ($products as $value) {
                    $product = $this->product_sale_repository->getBySaleProduct($data->id, $value['product_id']);
                    $amount  = (!empty($product)) ? ($value['amount']+$product->amount) : $value['amount'];

                    $arr_product = [
                        'product_id' => $value['product_id'],
                        'amount'     => $amount,
                        'sales_id'   => $data->id
                    ];
                    $this->sale_service->debitStock($value);
                    $this->product_sale_repository->updateOrCreate($arr_product);
                }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => 'Houve algum erro, tente novamente!'], 400, ['X-Header-One' => 'Header Value']);
        }
        return new SaleResource($data);
    }

}
