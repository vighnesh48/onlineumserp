<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

    var $view_dir = 'Upload/';
    public function __construct() {
        parent::__construct();
        try{
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
          $this->load->library('Awssdk');
        }catch(Exception $e){
            echo "here";
            die();
        }
    }

    public function index() {
        $this->load->view($this->view_dir.'upload_form', array('error' => ' ' ));
    }

    public function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|PNG|JPEG|JPG|PDF';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        // if ( ! $this->upload->do_upload('userfile')) {
        //     $error = array('error' => $this->upload->display_errors());
        //     $this->load->view('upload_form', $error);
        // } else {
        //     $data = array('upload_data'  => $this->upload->data());
        //     $file_path = $data['upload_data']['full_path'];
        //     $file_name = $data['upload_data']['file_name'];
        //     $bucket_name = 'erp-asset';
        //     $key_name = 'uploads/' . $file_name;
      
        //     try {
        //         $result = $this->awssdk->uploadFile($bucket_name, $key_name, $file_path);
        //         echo "File uploaded successfully.";
        //     } catch (Exception $e) {
        //         echo "Error uploading file: " . $e->getMessage();
        //     }
        // }

         if ($_FILES && $_FILES['userfile']['name']) {
            $file_path = $_FILES['userfile']['tmp_name'];
            $fileName = 'uploads/'.$_FILES['userfile']['name'];
            $bucket_name = 'erp-asset';
            try {
                    $result = $this->awssdk->uploadFile($bucket_name, $fileName, $file_path);
                    // Success message
                    echo 'File uploaded successfully to S3!';
            } catch (AwsException $e) {
                // Handle error
                echo 'Error uploading file to S3: ' . $e->getMessage();
            }
        } else {
            // No file uploaded
            echo 'Please select a file to upload.';
        }
    }

    public function validateFile() {
        // Your file upload validation logic here
        // For example, checking the file size and file type
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = $_FILES['userfile']['name'];
        $allowed = array('gif', 'png', 'jpg');
        $fieldName = $_POST['fieldname'];
        if ($_FILES['userfile']['size'] > 1048576) { // 0.5 MB (in bytes)
            $response['status'] = 'error';
            $response['message'] = $fieldName. ' file size exceeds the maximum limit (1MB).';
        } elseif(!in_array($ext, $allowed)) {
            $response['status'] = 'error';
            $response['message'] = $fieldName. 'file extension is not allowed, allowed file types are gif,png,jpg';
        } else {
            // File is valid, you can proceed with further actions
            $response['status'] = 'success';
            $response['message'] = 'File is valid and can be uploaded.';
        }

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    public function validateAllFile() {

        // var_dump($_POST);
        // var_dump($_FILES);die();
        $allowed = array('gif', 'png', 'jpg', 'pdf', 'PNG', 'PDF', 'jpeg');
        $response = [];
        for ($i=0; $i < count($_POST['fieldname']) ; $i++) { 
            $filename = $_FILES['userfile']['name'][$i];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $fieldName = !empty($_POST['fieldname'][$i]) ? $_POST['fieldname'][$i] : $filename;
            if($filename){
                if ($_FILES['userfile']['size'][$i] > 1048576) { // 1 MB (in bytes)
                    $response[$i]['status'] = 'error';
                    $response[$i]['message'] = $fieldName. ' file size exceeds the maximum limit (1MB).';
                } elseif(!in_array($ext, $allowed)) {
                    $response[$i]['status'] = 'error';
                    $response[$i]['message'] = $fieldName. ' file extension is not allowed, allowed file types are gif,png,jpg';
                } else {
                    // File is valid, you can proceed with further actions
                    $response[$i]['status'] = 'success';
                    $response[$i]['message'] = 'File is valid and can be uploaded.';
                }
            }
        }

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function download_pdfdocument($doc_path){
        $main_path = $_GET['b_name'];
        $bucketname = 'erp-asset';
        $keyname= $main_path.$doc_path;
        $result = $this->awssdk->getFile($bucketname, $keyname);
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$doc_path.'"');
        echo $result['Body'];
    }

    public function get_document($doc_path) {
        $main_path = $_GET['b_name'];
        $doc_path = $main_path.$doc_path;
        $bucketname = 'erp-asset';
        $result = $this->awssdk->getFile($bucketname, $doc_path);
        $ext_arr = explode('.', $doc_path);
        $imageData = base64_encode($result['Body']);
        // Determine the image MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $imageMimeType = $finfo->buffer($result['Body']);
        $dataURI = 'data:' . $imageMimeType . ';base64,' . $imageData;
        if ($ext_arr[1] == 'jpg' || $ext_arr[1] == 'jpeg' || $ext_arr[1] == 'png') {
			
             echo '<!DOCTYPE html><html><head><title>Octet Stream Image</title></head><body><img src="'.$dataURI.'" alt="Octet Stream Image"></body></html>';
		
			
			
        } else {
            header('Content-type: '.$imageMimeType);
        header('Content-Disposition: attachment; filename="'.$doc_path.'"');
        echo $result['Body'];
		exit();	
			
        }
    }

    public function get_image($doc_path) {
        // $main_path = $_GET['b_name'];
        // $doc_path = $main_path.$doc_path;
        // $bucketname = 'erp-asset';
        // $imageData = $this->awssdk->getImageData($bucketname, $doc_path);
        // header('Content-Type: image/jpg');
        // // Output the image data
        // echo $imageData;
        $main_path = $_GET['b_name'];
        $doc_path = $main_path.$doc_path;
        $bucketname = 'erp-asset';
        $result = $this->awssdk->getImageData($bucketname, $doc_path);
        $ext_arr = explode('.', $doc_path);
        $imageData = base64_encode($result['Body']);
        
    }

    public function Changefile(){
        $directory = 'student_document';
        //$this->awssdk->RenameFIles($directory);
		$this->awssdk->move_failed_files();
    }


    public function getfileData(){
        $siteUrl = site_url().'Upload/get_document';
        $bucketname = 'uploads/student_photo/';
        $enrollment_no = '160106021002.jpg'; 
        $url = $siteUrl. '/'. $enrollment_no.'?b_name='.$bucketname;
        // $im = file_get_contents($url);
        // header('Content-type: image/jpeg');
        header('Content-Disposition: inline; filename="myimage.jpg"');
        $main_path = 'uploads/student_photo/160104021002.jpg';
        $doc_path = $main_path;
        $bucketname = 'erp-asset';
        $result = $this->awssdk->getImageData($doc_path);
        $imageData = base64_encode($result['Body']);
        
        header("Content-type: image/jpg");
        //$data = "";
        echo base64_decode($imageData);
    }

    public function getImageInfo($mainpath){
        $bucketname = $_REQUEST['b_name'];
        $key = $bucketname.$mainpath; 
        $result = $this->awssdk->getImageData($key);
        $img = array('imageData' => $result);
        echo json_encode($img);
    }
	 public function download_s3file($doc_path){
        $main_path = $_GET['b_name'];
        $bucketname = 'erp-asset';
        $keyname= $main_path.$doc_path;
        $result = $this->awssdk->getFile($bucketname, $keyname);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $imageMimeType = $finfo->buffer($result['Body']);
        header('Content-type: '.$imageMimeType);
        header('Content-Disposition: attachment; filename="'.$doc_path.'"');
        echo $result['Body'];
    }
}
