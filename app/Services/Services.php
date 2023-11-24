<?php
// App\Services\ProductService.php
namespace App\Services;

use App\Controllers\Prices;

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
        // ...
         $pricesModel = new Prices();
         $price= $pricesModel->show($productId);
        return $price;
        
    }
}
