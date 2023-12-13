<?php
// App\Services\ProductService.php
namespace App\Services;

use App\Controllers\Prices;
use App\Controllers\ProductsStock;
use App\Models\ProductsStockModel; 
use App\Models\DailyQuantiesModel; 


class Services 
{
    protected $pricesController;

    public function __construct()
    {
        $this->pricesController = new Prices();
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
        $productsStockModel = new ProductsStockModel();
        $productController = new ProductsStock();
        $dailyQuantiesModel = new DailyQuantiesModel();



        $timestamp = date('Y-m-d h:i:s')   ; 
      
        if($data['action_type'] ==="sales"){
            // Calculate the total_quantity
            $data["total_quantity"] = (int)$data["old_quantity"] - (int)$data["new_quantity"];         
            
        }elseif($data['action_type'] ==="restock"){
            $data["total_quantity"] = (int)$data["old_quantity"] + (int)$data["new_quantity"];
        }

        $data["updated_at"]=$timestamp;
      
        //update the new total quantity in Product Stock
        $stockUpdate= $productController->update($data);
        return $stockUpdate;

        if($stockUpdate === false){
            return false;
        }
        // $status=$productsStockModel->insert($data);
         if ($dailyQuantiesModel->insert($data) === false)
         {
             //return redirect()->back()->withInput()->with('errors', $this->model->errors());
             $message= $dailyQuantiesModel->errors();
             $error= array(
                 "status"=> 201,
                 "message"=>$message
             );
             return $error;
         }
        return "Yes";

    }
}
