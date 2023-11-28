<?php

namespace App\Controllers;

class Home extends BaseController
{
     /*Load model*/
     function __construct() {
   
        
     
        
    }
    function _load_view() {
     //   $this->data ['pending_activation'] = count($this->dawati_model->getPendingMentors());
    //    $this->data ['notification'] = $this->session->flashdata('notification');
        $this->load->view("template/temp");
    }  
    public function index()
    {
        //return view('products/products_index');
       return view('products/table');
      // return view('dash');


      
    }
    public function products()
    {
        return view('dashboard/products_dash');

    }
    public function sales()
    {
        return view('dashboard/sales_dash');

    }

}
    