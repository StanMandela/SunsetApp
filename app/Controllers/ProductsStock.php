<?php

namespace App\Controllers;

use App\Models\PricesModel;
use App\Models\ItemTypeModel;
use App\Services\Services;
use App\Models\ProductsStockModel;
use App\Models\StockValueModel;



use App\Controllers\BaseController;

class ProductsStock extends BaseController
{
    protected $model;
    public function __construct()
    {
        // Load the model in the constructor
        $this->model = new ProductsStockModel();
    }
    public function index()
    {
        $model = new ProductsStockModel();
        $query = $model->select('products_stock.*,products.product_name')
            ->join('products', 'products_stock.product_id=products.product_id')
            ->get();
        $result = $query->getResult();
        return $this->response->setJSON($result);
    }
    public function create()
    {
        //enter the quantity and into the db 
        $model = new ProductsStockModel();

        // Get the last inserted item_id
        $productId = $this->request->getPost('product_id');
        // $lastItemId = $model->selectMax('product_id')->get()->getRow()->product_id;
        $query = $model->select('product_id')
            ->where('product_id', $productId)
            ->orderBy('id', 'DESC')  // Assuming 'id' is your primary key; adjust as needed
            ->limit(1)
            ->get();
        $lastItemId = $query->getRow();

        if ($lastItemId === null) {
            $timestamp = date('Y-m-d h:i:s');
            // Retrieve JSON data using getJSON

            $data = [
                'product_id'    => $this->request->getPost('product_id'),
                'quantity'    => $this->request->getPost('quantity'),
                'latest_action'    => $this->request->getPost('action_type'),
                'updated_on'    => $timestamp
            ];
            if ($this->model->insert($data) === false) {
                //return redirect()->back()->withInput()->with('errors', $this->model->errors());
                $message = $this->model->errors();
                $error = array(
                    "status" => 201,
                    "message" => $message
                );
                return $this->response->setJSON($error);
            }

            //return redirect()->back()->with('success', 'Saved Successfully!');
            $data = array(
                "status" => 200,
                "message" => "Saved Successfully!"
            );
            return $this->response->setJSON($data);
        }
        $error = array(
            "code" => 200,
            "status" => false,
            "message" => "Product Stock already exits. Try Updating"
        );
        return $this->response->setJSON($error);
    }

    public function update()
    {
        $model = new ProductsStockModel();
        $timestamp = date('Y-m-d h:i:s');
        $today = date('Y-m-d');
        $data = [];

        $productId = $this->request->getPost('product_id');
        $newStock = $this->request->getPost('new_stock');
        $productName = $this->request->getPost('product_name');


        $query = $model->select('*')
            ->where('product_id', $productId)
            //  ->where('updated_on', $timestamp)
            ->orderBy('id', 'DESC')  // Assuming 'id' is your primary key; adjust as needed
            ->limit(1)
            ->get();
        $productStock = $query->getRow();
        $dbDate =  date('Y-m-d', strtotime($productStock->updated_on));
        if ($dbDate === $today && $productStock->latest_action === 'restock') {
            //if last action is sales we can edit stock and if 
            $data = array(
                "code" => 200,
                "status" => false,
                "product_id" => $productId,
                "message" => "Already Restocked " . $productName . "for today."
            );
            return $this->response->setJSON($data);
        } else {
            //
            $updateData = [
                'quantity'    => $productStock->quantity + $newStock,
                'latest_action'    => "restock",
                'updated_on'    => $timestamp
            ];



            // get the last quantity 


            if ($model->where('product_id', $productId)->set($updateData)->update() === false) {
                $message = $this->model->errors();
                $error = array(
                    "status" => 201,
                    "message" => $message
                );
                return false;
            }

            $data = array(
                "status" => 200,
                "message" => $productName . "Updated Successfully!"
            );
            return $this->response->setJSON($data);
        }
    }
    public function calculateStockValue($date)
    {
        $model = new ProductsStockModel();
        $priceModel = new PricesModel();
        $services = new Services();
        $stockModel = new StockValueModel;
        $timestamp = date('Y-m-d');

        // step 1 : get all products that have > 1 
        // loop through the items and get their price
        // them prices together
        $query = $model->select('*,products.product_name')
            ->join('products', 'products.product_id=products_stock.product_id')
            ->orderBy('products_stock.id', 'DESC')  // Assuming 'id' is your primary key; adjust as needed
            ->get();
        $productData = $query->getResult();
        $totalSum = 0;
        foreach ($productData as $product) {

            $price = $services->showPrice($product->product_id);
            if ($price['status'] === 404) {
                $data = array(
                    "code" => 200,
                    "status" => false,
                    "message" => $product->product_name . "Doent have a Price!"
                );
                return $this->response->setJSON($data);
            }
            $totalValue = $product->quantity * $price['price'];
            // var_dump($product->quantity);

            // Accumulate the total value to the overall sum
            $totalSum += $totalValue;
        }


        //check if the stock value of today exists
        $query = $stockModel->select('*')
            ->where('DATE_FORMAT(updated_on, "%Y-%m-%d")', $timestamp)
            ->get();
        $result = $query->getResult();

        if ($result) {
            $error = array(
                "code" => 201,
                "status" => false,
                "message" => 'Stock Value for Today(' . $timestamp . ') Already Calculated. Refresh Page'
            );
            return $this->response->setJSON($error);
        }
        // prepare data
        $data = [
            'updated_on' => $timestamp,
            'stock_value' => $totalSum,
            'date' => $timestamp

        ];
        //  return $this->response->setJSON($data);
        if ($stockModel->insert($data) === false) {
            $message = $stockModel->errors();
            $error = array(
                "code" => 201,
                "status" => false,
                "message" => $message
            );
            return $this->response->setJSON($message);
        }
        $data = array(
            "code" => 200,
            "status" => true,
            "totalSum" => $totalSum,
            "message" => "Stock Value Calculated successfully."
        );
        return $this->response->setJSON($data);
    }
    public function getStockValue()
    {
        $model = new StockValueModel();
        $today = date('Y-m-d');

        $query = $model->select('*')
            ->where('DATE_FORMAT(updated_on, "%Y-%m-%d")', $today)
            ->get();
        $result = $query->getResult();

        return $this->response->setJSON($result);
    }
    public function editStockValue()
    {
        $model = new StockValueModel();
        $timestamp = date('Y-m-d h:i:s');
        $today = date('Y-m-d');
        $data = [

            "updated_on" => $timestamp,
            "lodging" => $this->request->getPost('lodging'),
            "mpesa_balance" => $this->request->getPost('mpesa_balance'),
            "purchases" => $this->request->getPost('purchases')
        ];

        if ($model->where('date', $today)->set($data)->update() === false) {
            $message = $model->errors();
            $error = array(
                "status" => false,
                "code" => 201,
                "message" => $message
            );
            return   $this->response->setJSON($error);
        }

        $data = array(
            "status" => false,
            "code" => 200,
            "message" => $today . "'s Values Updated Successfully!"
        );
        return $this->response->setJSON($data);
    }
    public function uploadFile()
    {

        // Validation
        $input = $this->validate([
            'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,jpg,jpeg,docx,pdf],'
        ]);

        if (!$input) { // Not valid
            $data['validation'] = $this->validator;
            //return view('dashboard/upload_file', $data);
            $data = array(
                "status" => false,
                "code" => 200,
                "message" => "File not uploaded"
            );
            return $this->response->setJSON($data);
        } else { // Valid

            if ($file = $this->request->getFile('file')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Get file name and extension
                    $name = $file->getName();
                    $ext = $file->getClientExtension();

                    // Get random file name
                    $newName = $file->getRandomName();

                    // Store file in public/uploads/ folder
                    $file->move('../public/uploads/Receipts', $newName);

                    // File path to display preview
                    $filepath = base_url() . "/uploads/Receipts/" . $newName;

                    // Set Session
                    session()->setFlashdata('message', 'Uploaded Successfully!');
                    session()->setFlashdata('alert-class', 'alert-success');
                    session()->setFlashdata('filepath', $filepath);
                    session()->setFlashdata('extension', $ext);
                    $data = array(
                        "status" => true,
                        "code" => 200,
                        "message" => "Uploaded Successfully!"
                    );
                } else {
                    // Set Session
                    session()->setFlashdata('message', 'File not uploaded.');
                    session()->setFlashdata('alert-class', 'alert-danger');
                    //   return redirect()->route('pic'); 
                    $data = array(
                        "status" => false,
                        "code" => 200,
                        "message" => "File not uploaded"
                    );
                }
            }
        }


        return $this->response->setJSON($data);
    }
}
