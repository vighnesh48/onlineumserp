<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class ScreenshotController extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="productsizemaster";
    var $model_name="productsize_model";
    var $model;
    var $view_dir='Productsize/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
               
    }
    
	
	public function capture_screenshot() {
    $json_data = json_decode(file_get_contents("php://input"), true);

    if (isset($json_data['image'])) {
        $image_data = str_replace('data:image/png;base64,', '', $json_data['image']);
        $image_data = base64_decode($image_data);

        $file_name = 'screenshots/attack_' . time() . '.png';
        file_put_contents($file_name, $image_data);

        echo json_encode(["message" => "Screenshot saved", "file" => $file_name]);
    }
}
   
}
?>