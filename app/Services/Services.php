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
        $price = $pricesModel->show($productId);
        return $price;
    }
    public function updateDailyQuantities($data)
    {
        $productsStockModel = new ProductsStockModel();
        $productController = new ProductsStock();
        $dailyQuantiesModel = new DailyQuantiesModel();


        $timestamp = date('Y-m-d');

        if ($data['action_type'] === "sales") {
            // Calculate the total_quantity
            $data["total_quantity"] = (int)$data["old_quantity"] - (int)$data["quantity"];
        } elseif ($data['action_type'] === "restock") {
            $data["total_quantity"] = (int)$data["old_quantity"] + (int)$data["quantity"];
        }

        $data["updated_at"] = $timestamp;


        //update the new total quantity in Product Stock
        $stockUpdate = $productController->update($data);



        if ($stockUpdate === false) {
            return false;
        }
        //return $stockUpdate;
        // check if there is a duplicate record
        $today = date('Y-m-d');
        $existingRecord = $dailyQuantiesModel
            ->where('product_id', $data['product_id'])
            ->where('updated_at', $today)
            ->first();
        // If a duplicate record is found, return an error message
        if (!empty($existingRecord)) {
            return false;
        }

        //No duplicate
        if ($dailyQuantiesModel->insert($data) === false) {
            //return redirect()->back()->withInput()->with('errors', $this->model->errors());
            $message = $dailyQuantiesModel->errors();
            $error = array(
                "status" => 201,
                "message" => $message
            );
            return $error;
        }
        return true;
    }
    public function checkDuplicateRecord($productId)
    {
        $dailyQuantiesModel = new DailyQuantiesModel();

        $today = date('Y-m-d');

        $existingRecord = $dailyQuantiesModel
            ->where('product_id', $productId)
            ->where('updated_at', $today)
            ->first();

        return !empty($existingRecord);
    }
}
