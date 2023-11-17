<?php

namespace App\Controllers;

class Home extends BaseController
{
     /*Load model*/
     function __construct() {
       //parent::__construct();
        $this->data ['title']       = "Dawati - Admin";
        $this->data ['description'] = "";
        
     
        
    }
    function _load_view() {
     //   $this->data ['pending_activation'] = count($this->dawati_model->getPendingMentors());
    //    $this->data ['notification'] = $this->session->flashdata('notification');
        $this->load->view("template/temp");
    }  
    public function index()
    {
        return view('dash_dash');
    }
}
    