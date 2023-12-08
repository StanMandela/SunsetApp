<?php
// App\Services\ProductService.php
namespace App\Services;

use App\Controllers\Prices;
use App\Controllers\ProductsStock;
use App\Models\ProductsStockModel; 

class Services 
{
    protected $pricesModel;

    public function __construct()
    {
        $this->pricesModel = new Prices();
    }

    public function showPrice($productId)
    {
        // Logic to retrieve the price based on the product ID
        //  var_dump($productId);
         $pricesModel = new Prices();
         $price= $pricesModel->show($productId);
        return $price;
        
    }
    public function updateDailyQuantities($data){
        $model = new ProductsStockModel();
        $productController = new ProductsStock();

        $timestamp = date('Y-m-d h:i:s')   ;
        // if ($pricesModel->insert($data) === false) {
        //     $message= $pricesModel->errors();
        //     return $message->message;
        // }
       
      
        if($data['action_type'] ==="sales"){
            // Calculate the total_quantity
            $data["total_quantity"] = (int)$data["old_quantity"] - (int)$data["new_quantity"];         
            
        }elseif($data['action_type'] ==="restock"){
            $data["total_quantity"] = (int)$data["old_quantity"] + (int)$data["new_quantity"];
        }

        $data["updated_at"]=$timestamp;
      
        //update the new total quantity 
        $price= $productController->update($data);
        return $price;
        //$status=$model->insert($data);

    }
}
