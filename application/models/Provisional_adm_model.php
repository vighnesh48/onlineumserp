<?php

class Provisional_adm_model extends CI_Model{
    
	var $table = 'student_master';
	var $column_order = array(null, 'sm.stud_id','sm.created_on','scs.docuemnt_confirm'); //set column field database for datatable orderable
	var $column_search = array('sm.stud_id','sm.enrollment_no_new','sm.enrollment_no','sm.first_name','sm.email','sm.mobile','sm.adhar_card_no'); //set column field database for datatable searchable 
	var $order = array('scs.final_confirm' => 'asc','scs.docuemnt_confirm' => 'desc'); // default order ,'sm.stud_id' => 'DESC','scs.docuemnt_confirm' => 'ASCE'
	
	
	function __construct(){
		parent::__construct();
	}

public function search_student($mobile)
{
     $DB1 = $this->load->database('icdb', TRUE);
//$this->db->select('smd.id,smd.mobile1,smd.student_name,pad.adm_id');
 $DB1->select('smd.*,pad.*');
 $DB1->from('student_meet_details smd');
 $DB1->join('provisional_admission_details pad','smd.id=pad.adm_id','left');
// $DB1->join('ic_registration ir','smd.id=ir.ic_code','left');
 $DB1->where('smd.mobile1',$mobile);
 $DB1->or_where('smd.mobile2',$mobile);
$query = $DB1->get();
//echo  $DB1->last_query();
//exit();
$result = $query->row_array();
return $result;
    
}

public function search_student_byid($sid)
{
 $DB1 = $this->load->database('icdb', TRUE);
 $DB1->select('smd.*');
 $DB1->from('student_meet_details smd');

 $DB1->where('smd.id',$sid);

$query = $DB1->get();

$result = $query->row_array();
return $result;
    
}



	function generate_payment_receipt($fees_id){
 // error_reporting(E_ALL);
//ini_set('display_errors', 1);
 $DB1 = $this->load->database('icdb', TRUE);
	/*	 $DB1->select("fd.*,bm.bank_name,sm.student_name,pad.*,spn.sprogramm_acro,ffd.fees_id as sys_fees_id");
		 $DB1->from('provisional_fees_details fd');
		 $DB1->join('bank_master as bm','fd.bank_id = bm.bank_id','left');
 $DB1->join('provisional_admission_details as pad','fd.student_id = pad.adm_id ','left');		
	 $DB1->join('student_meet_details as sm','fd.student_id = sm.id','left');
	 $DB1->join('sandipun_univerdb.school_programs_new spn','pad.program_id=spn.sp_id','left');
	 	 $DB1->join('sandipun_ums.fees_details as ffd','fd.fees_id = ffd.prov_fees_id','left');
	 	 
	 $DB1->where('fd.fees_id',$fees_id);*/
	 
	 $this->db->select("fd.*,bm.bank_name,sm.student_name,pad.*,spn.sprogramm_acro,ffd.fees_id as sys_fees_id");
		 $this->db->from('sandipun_ic_erp.provisional_fees_details fd');
		 $this->db->join('sandipun_ic_erp.bank_master as bm','fd.bank_id = bm.bank_id','left');
 $this->db->join('sandipun_ic_erp.provisional_admission_details as pad','fd.student_id = pad.adm_id ','left');		
	 $this->db->join('sandipun_ic_erp.student_meet_details as sm','fd.student_id = sm.id','left');
	 $this->db->join('sandipun_univerdb.school_programs_new spn','pad.program_id=spn.sp_id','left');
	 	 $this->db->join('sandipun_ums.fees_details as ffd','fd.fees_id = ffd.prov_fees_id','left');
	 	 
	 $this->db->where('fd.fees_id',$fees_id);
	 
	 
	$query=  $this->db->get();
//	echo  $this->db->last_query();
		$result=$query->row_array();
//var_dump($result);
//	exit();
		return $result;
		
			/*	 $this->db->select("fd.*,bm.bank_name,sm.student_name,pad.*,spn.sprogramm_acro,ffd.fees_id as sys_fees_id");
		 $this->db->from('sandipun_ic_erp.provisional_fees_details fd');
		 $this->db->join('sandipun_ic_erp.bank_master as bm','fd.bank_id = bm.bank_id','left');
 $this->db->join('sandipun_ic_erp.provisional_admission_details as pad','fd.student_id = pad.adm_id ','left');		
	 $this->db->join('sandipun_ic_erp.student_meet_details as sm','fd.student_id = sm.id','left');
	 $this->db->join('sandipun_univerdb.school_programs_new spn','pad.program_id=spn.sp_id','left');
	 	 $this->db->join('sandipun_ums.fees_details as ffd','fd.prov_fees_id = ffd.fees_id','left');
	 	 
	 $this->db->where('fd.fees_id',$fees_id);*/
	
	}
	
	


function get_fees_details_byid($std)
{
    
     $DB1 = $this->load->database('icdb', TRUE);
 
 $DB1->select('*');
 $DB1->from('provisional_fees_details');

 $DB1->where('student_id',$std);

$query = $DB1->get();

$result = $query->result_array();
return $result;   
    
}

function get_fees_details_academic($std)
{
  /*$DB1 = $this->load->database('icdb', TRUE);
 $DB1->select('*');
 $DB1->from('provisional_fees_details');

 $DB1->where('student_id',$std);
 $DB1->where('type_id',5);

$query = $DB1->get();

$result = $query->result_array();*/
return $result=array();   
    
}


function get_fees_details_hostel($std)
{
 /*$DB1 = $this->load->database('icdb', TRUE);
 $DB1->select('*');
 $DB1->from('provisional_fees_details');

 $DB1->where('student_id',$std);
 $DB1->where('type_id',3);

$query = $DB1->get();

$result = $query->result_array();*/
return $result=array();;   
    
}








function list_ics($ic='')
{
     $DB1 = $this->load->database('icdb', TRUE);
  $DB1->select('ic_id,ic_code,ic_name');
 $DB1->from('ic_registration');
 $DB1->where('center_type','ic');
if($ic!='')
{
    $DB1->where('ic_id',$ic); 
}
 $DB1->where('status','Y');
$query = $DB1->get();
$result = $query->result_array();
return $result;
    
}



public function total_fees_paid($stdid)
{
    

     $DB1 = $this->load->database('icdb', TRUE);
     $DB1->select('sum(amount) as fees_paid');
 $DB1->from('provisional_fees_details pfd');
$DB1->where('pfd.payment_status','V');
 $DB1->where('pfd.student_id',$stdid);
$DB1->where('pfd.is_deleted','N');   
$query = $DB1->get();

$result = $query->row_array();
return $result['fees_paid'];

}   
    
    

   
  public function received_payment_details($stdid='')
{
    
//  error_reporting(E_ALL);
//ini_set('display_errors', 1);
    
    $this->db->select('pfd.*,smd.student_name,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year,pad.adm_form_no,bk.bank_name as ubname,spn.sprogramm_name,spn.course_type,pad.is_cancelled,pad.is_confirmed,pad.is_verified,sm.school_name');
 $this->db->from('sandipun_ic_erp.provisional_fees_details pfd');
 $this->db->join('sandipun_ic_erp.provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $this->db->join('sandipun_ic_erp.student_meet_details smd','pfd.student_id=smd.id','left');
 $this->db->join('sandipun_ic_erp.bank_master bm','pfd.bank_id=bm.bank_id','left');

 $this->db->join('sandipun_univerdb.school_programs_new spn','pad.program_id=spn.sp_id','left');  
  $this->db->join('sandipun_univerdb.school_master sm','spn.school_id=sm.school_id','left'); 
  
  
 $this->db->join('sandipun_erp.bank_master bk','pfd.bank_id=bk.bank_id','left');
 //$this->db->where('pad.prov_reg_no is not null');
 $this->db->like('pad.prov_reg_no', '19SUN', 'after');  
if($_POST['pstatus'] !='')
{
$this->db->where('pfd.payment_status',$_POST['pstatus']);   
}else{
$this->db->where('pfd.payment_status','p');
}
if($stdid !='')
{
$this->db->where('pfd.student_id',$stdid);   
}
   

//$this->db->where('pfd.type_id','2'); 
$this->db->where('pfd.is_deleted','N');   
$this->db->order_by('pfd.fees_id','desc');
     //$DB1 = $this->load->database('icdb', TRUE);
     /* $DB1->select('pfd.*,smd.student_name,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year,bk.bank_name as ubname');
 $DB1->from('provisional_fees_details pfd');
 $DB1->join('provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $DB1->join('student_meet_details smd','pfd.student_id=smd.id','left');
 $DB1->join('bank_master bm','pfd.bank_id=bm.bank_id','left');
 
 $DB1->join('sandipun_erp.bank_master bk','pfd.bank_id=bk.bank_id','left');
 
if($_POST['pstatus'] !='')
{
$DB1->where('pfd.payment_status',$_POST['pstatus']);   
}
if($stdid !='')
{
$DB1->where('pfd.student_id',$stdid);   
}

$DB1->order_by('pfd.fees_id','desc');
*/

$query = $this->db->get();
//echo $this->db->last_query();
//exit();

$result = $query->result_array();

//var_dump($result);
//exit();
return $result;


} 
   
    public function received_payment_details_in($stdid='')
{
    
//  error_reporting(E_ALL);
//ini_set('display_errors', 1);
    
    $this->db->select('pfd.*,smd.student_name,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year,pad.adm_form_no,bk.bank_name as ubname,spn.sprogramm_name,spn.course_type,pad.is_cancelled,pad.is_confirmed,pad.is_verified,sm.school_name');
 $this->db->from('sandipun_ic_erp.provisional_fees_details pfd');
 $this->db->join('sandipun_ic_erp.provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $this->db->join('sandipun_ic_erp.student_meet_details smd','pfd.student_id=smd.id','left');
 $this->db->join('sandipun_ic_erp.bank_master bm','pfd.bank_id=bm.bank_id','left');

 $this->db->join('sandipun_univerdb.school_programs_new spn','pad.program_id=spn.sp_id','left');  
  $this->db->join('sandipun_univerdb.school_master sm','spn.school_id=sm.school_id','left'); 
  
  
 $this->db->join('sandipun_erp.bank_master bk','pfd.bank_id=bk.bank_id','left');
 //$this->db->where('pad.prov_reg_no is not null');
 $this->db->like('pad.prov_reg_no', '19SUN', 'after');  
if($_POST['pstatus'] !='')
{
$this->db->where('pfd.payment_status',$_POST['pstatus']);   
}
if($stdid !='')
{
$this->db->where('pfd.student_id',$stdid);   
}
//$this->db->where('pfd.payment_status','p');   

//$this->db->where('pfd.type_id','2'); 
$this->db->where('pfd.is_deleted','N');   
$this->db->order_by('pfd.fees_id','desc');
     //$DB1 = $this->load->database('icdb', TRUE);
     /* $DB1->select('pfd.*,smd.student_name,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year,bk.bank_name as ubname');
 $DB1->from('provisional_fees_details pfd');
 $DB1->join('provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $DB1->join('student_meet_details smd','pfd.student_id=smd.id','left');
 $DB1->join('bank_master bm','pfd.bank_id=bm.bank_id','left');
 
 $DB1->join('sandipun_erp.bank_master bk','pfd.bank_id=bk.bank_id','left');
 
if($_POST['pstatus'] !='')
{
$DB1->where('pfd.payment_status',$_POST['pstatus']);   
}
if($stdid !='')
{
$DB1->where('pfd.student_id',$stdid);   
}

$DB1->order_by('pfd.fees_id','desc');
*/
$query = $this->db->get();

/*$uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo $this->db->last_query();
			exit();
		}*/
//echo $this->db->last_query();
//exit();
$result = $query->result_array();

//var_dump($result);
//exit();
return $result;


} 
   
   public function received_payment_details_search($stdid='')
{
    
//  error_reporting(E_ALL);
//ini_set('display_errors', 1);
    
    $this->db->select('pfd.*,smd.student_name,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year,pad.adm_form_no,bk.bank_name as ubname,spn.sprogramm_name,spn.course_type,pad.is_cancelled,pad.is_confirmed,pad.is_verified,sm.school_name');
 $this->db->from('sandipun_ic_erp.provisional_fees_details pfd');
 $this->db->join('sandipun_ic_erp.provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $this->db->join('sandipun_ic_erp.student_meet_details smd','pfd.student_id=smd.id','left');
 $this->db->join('sandipun_ic_erp.bank_master bm','pfd.bank_id=bm.bank_id','left');

 $this->db->join('sandipun_univerdb.school_programs_new spn','pad.program_id=spn.sp_id','left');  
  $this->db->join('sandipun_univerdb.school_master sm','spn.school_id=sm.school_id','left'); 
  
  
 $this->db->join('sandipun_erp.bank_master bk','pfd.bank_id=bk.bank_id','left');
 //$this->db->where('pad.prov_reg_no is not null');
 $this->db->like('pad.prov_reg_no', '19SUN', 'after');  
if($_POST['pstatus'] !='')
{
$this->db->where('pfd.payment_status',$_POST['pstatus']);   
}
if($stdid !='')
{
$this->db->where('pfd.student_id',$stdid);   
}
//$this->db->where('pfd.payment_status','p');   

//$this->db->where('pfd.type_id','2'); 
$this->db->where('pfd.is_deleted','N');   
$this->db->order_by('pfd.fees_id','desc');
     //$DB1 = $this->load->database('icdb', TRUE);
     /* $DB1->select('pfd.*,smd.student_name,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year,bk.bank_name as ubname');
 $DB1->from('provisional_fees_details pfd');
 $DB1->join('provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $DB1->join('student_meet_details smd','pfd.student_id=smd.id','left');
 $DB1->join('bank_master bm','pfd.bank_id=bm.bank_id','left');
 
 $DB1->join('sandipun_erp.bank_master bk','pfd.bank_id=bk.bank_id','left');
 
if($_POST['pstatus'] !='')
{
$DB1->where('pfd.payment_status',$_POST['pstatus']);   
}
if($stdid !='')
{
$DB1->where('pfd.student_id',$stdid);   
}

$DB1->order_by('pfd.fees_id','desc');
*/
$query = $this->db->get();
//echo $this->db->last_query();
//exit();
$result = $query->result_array();

//var_dump($result);
//exit();
return $result;


} 
   
    


public function received_payment_details_new_search($new_search,$status, $searchby)
{
    
//  error_reporting(E_ALL);
//ini_set('display_errors', 1);
    
    $this->db->select('pfd.*,smd.student_name,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year,pad.adm_form_no,bk.bank_name as ubname,spn.sprogramm_name,spn.course_type,pad.is_cancelled,pad.is_confirmed,pad.is_verified,sm.school_name');
 $this->db->from('sandipun_ic_erp.provisional_fees_details pfd');
 $this->db->join('sandipun_ic_erp.provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $this->db->join('sandipun_ic_erp.student_meet_details smd','pfd.student_id=smd.id','left');
 $this->db->join('sandipun_ic_erp.bank_master bm','pfd.bank_id=bm.bank_id','left');

 $this->db->join('sandipun_univerdb.school_programs_new spn','pad.program_id=spn.sp_id','left');  
  $this->db->join('sandipun_univerdb.school_master sm','spn.school_id=sm.school_id','left'); 
  
  
 $this->db->join('sandipun_erp.bank_master bk','pfd.bank_id=bk.bank_id','left');
 //$this->db->where('pad.prov_reg_no is not null');
 $this->db->like('pad.prov_reg_no', '19SUN', 'after');  
//if($_POST['pstatus'] !='')
{
//$this->db->where('pfd.payment_status',$status);   
}
/*if($stdid !='')
{
$this->db->where('pfd.student_id',$stdid);   
}*/
//$this->db->where('pfd.payment_status','p');   

//$this->db->where('pfd.type_id','2'); 
if($searchby=='adm_form_no'){
	$this->db->like('pad.adm_form_no', $new_search);
}elseif($searchby=='student_name'){
	$this->db->like('smd.student_name', $new_search);
}elseif($searchby=='prov_reg_no'){
	$this->db->like('pad.prov_reg_no', $new_search);
}else{
	$this->db->like('smd.student_name', $new_search);
}

$this->db->where('pfd.is_deleted','N');   
$this->db->order_by('pfd.fees_id','desc');
     //$DB1 = $this->load->database('icdb', TRUE);
     /* $DB1->select('pfd.*,smd.student_name,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year,bk.bank_name as ubname');
 $DB1->from('provisional_fees_details pfd');
 $DB1->join('provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $DB1->join('student_meet_details smd','pfd.student_id=smd.id','left');
 $DB1->join('bank_master bm','pfd.bank_id=bm.bank_id','left');
 
 $DB1->join('sandipun_erp.bank_master bk','pfd.bank_id=bk.bank_id','left');
 
if($_POST['pstatus'] !='')
{
$DB1->where('pfd.payment_status',$_POST['pstatus']);   
}
if($stdid !='')
{
$DB1->where('pfd.student_id',$stdid);   
}

$DB1->order_by('pfd.fees_id','desc');
*/
$query = $this->db->get();
//echo $this->db->last_query();
//exit();
$result = $query->result_array();

//var_dump($result);
//exit();
return $result;


} 





public function update_payment_status()
{
     $DB1 = $this->load->database('icdb', TRUE);
    $prdet['payment_status']=$_POST['upstatus'];
   $prdet['modified_by']=$_SESSION['uid'];
     $prdet['modified_on']=date('Y-m-d h:i:s');
  $prdet['modify_from_ip']=$_SERVER['REMOTE_ADDR'];

  $DB1->where('fees_id',$_POST['fees_id']);

		 $DB1->update('provisional_fees_details',$prdet);    
  
    redirect('Provisional_admission/received_payment_details/');  
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchjlist_new($sid){
		    $DB6 = $this->load->database('umsdb', TRUE);
		    /*$stid=array('190101221944','190101221945','190101221946','190101221947','190102201001','190102201002','190102201003','190102201004','190102201005','190102201006','190102201007');*/
			/*$stid=array('200109041005','200101191005','200109061001','200114021003','200105261001','200101181008','200101181009','200104151003','200109041006','200116281004','200109031004','200101051034','200105011013','200105181004','200105121014','200102011002','200104141001','200102261005','200104061008','200105181005','200101051035','200105131003','200101181010','200105011014','200101191006','200102161011','200101171008','200106111014','200101051036','200101201003','200101381004','200102261006','200101051037','200102251003','200101191007');*/
		    //die;
		$admission_session =ADMISSION_SESSION;
		$DB6->select("sm.*,stm.stream_name,cm.course_name");
		$DB6->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left'); 
		$DB6->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB6->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB6->where("sm.cancelled_admission",'N');
		$DB6->where("sm.admission_session",$admission_session);	
		$DB6->where("sm.academic_year",$admission_session);
		$DB6->where("sm.is_detained",'N');
		//$DB1->where("sm.admission_cycle");
		//$DB1->where("length(sm.enrollment_no)",'9');
		$DB6->where("sm.stud_id",$sid);
		//$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB6->get();
		  //echo $DB6->last_query();
		//exit();
		$result=$query->result_array();
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
	
	function check_if_exists($table,$cname1,$cvalue1,$cname2,$cvalue2)
{
    
   
        $DB5 = $this->load->database('umsdb', TRUE);
		$DB5->select("count(*) as ucount");
		$DB5->from($table);
		$DB5->where($cname1,$cvalue1);
		$DB5->where($cname2,$cvalue2);
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB5->get(); 
		$cn = $query->row_array();
		return $cn['ucount'];
    
}
	
	
function create_student_login($sid)
{
    $DB3 = $this->load->database('umsdb', TRUE);
    $dat  = $this->searchjlist_new($sid);
 //exit;  
//print_r($dat);exit();
  foreach($dat as $sdata)
    {
        
        $rcnt = $this->check_if_exists('user_master','username',$sdata['enrollment_no'],'roles_id','9');
        if($rcnt<1)
        {
        $par1['username'] = $sdata['enrollment_no'];    
        $par1['password'] = rand(4999,999999);
         $par1['inserted_by'] = $_SESSION['uid'];
          $par1['inserted_datetime'] = date('Y-m-d h:i:s');
           $par1['status'] ='Y';
            $par1['roles_id'] = 9;
      $DB3->insert('user_master',$par1);
        }

      $rcnt3 = $this->check_if_exists('user_master','username',$sdata['enrollment_no'],'roles_id','4');
        if($rcnt3<1)
        {
        $par['username'] = $sdata['enrollment_no'];    
        $par['password'] = rand(4999,999999);
        $par['inserted_by'] = $_SESSION['uid'];
        $par['inserted_datetime'] = date('Y-m-d h:i:s');
        $par['status'] ='Y';
        $par['roles_id'] = 4;
        $DB3->insert('user_master',$par);
		$par['email'] = $sdata['email']; 
		$par['mobile'] = $sdata['mobile']; 
		$this->load->view('Provisional/student_login_mail', $par);
        } 
		
		
		
    }
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    
}




function generate_allprn($sid)
{
    
    
   /* $names =array('20SUN0484','20SUN0204','20SUN0030','20SUN0202','20SUN0123','20SUN0066','20SUN0562','20SUN0756','20SUN0752','20SUN0750','20SUN0194','20SUN0757','20SUN0655','20SUN0285','20SUN0533','20SUN0627','20SUN0215','20SUN0275','20SUN0568','20SUN0574','20SUN0162','20SUN0023','20SUN0562','20SUN0292','20SUN0759','20SUN0012','20SUN0274','20SUN0576','20SUN0039','20SUN0720','20SUN0005','20SUN0297','20SUN0677','20SUN0078','20SUN0582','20SUN0375','200201176');*/
        $DB1 = $this->load->database('umsdb', TRUE); 
      
		$DB1->select("*");
		$DB1->from('student_master');
		$DB1->where("cancelled_admission", 'N');
		$DB1->where("admission_session", ADMISSION_SESSION);
		$DB1->where("univ_transfer", 'N');
		$DB1->where('admission_cycle IS NULL', NULL, FALSE);
		$whe=" prn_2018 =''";
		$DB1->where($whe);
		//$DB1->where_in('enrollment_no', $names);
		$DB1->where('stud_id', $sid);
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		$DB1->order_by("stud_id", "asc");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB1->get();
	//	echo $DB1->last_query();exit;
		//die();  
		$result=$query->result_array();
      $ac=ADMISSION_SESSION;
      
      if($result[0]['admission_stream']!=''){
   for($i=0;$i<count($result);$i++)
   {
      
      
        $stream="select programme_code from stream_master where stream_id='".$result[$i]['admission_stream']."'";
        $stmdet = $DB1->query($stream);
        $stream_details =  $stmdet->result_array();
     if($result[$i]['transefercase'] == 'N'){
      $sql = "SELECT max(enrollment_no) as enrollment_no from student_master where admission_session='$ac' and admission_stream ='".$result[$i]['admission_stream']."' 
	  and admission_year='".$result[$i]['admission_year']."'  AND transefercase='N' AND previous_stream is null AND enrollment_no REGEXP '^[0-9]+$'";  //AND `previous_stream` IS NULL
       // echo $sql;
		//exit;
        $query = $DB1->query($sql);
        $pnr_details =  $query->result_array();
	   
    if($pnr_details[0]['enrollment_no']!='')
    {
        $var = substr($pnr_details[0]['enrollment_no'], -3);

$var = ++$var;

$prn =  sprintf("%03d", $var);

 $finalprn = initial_year."01".$stream_details[0]['programme_code']."".$result[$i]['admission_year']."".$prn;


	// $finalprn;
	 	
		
		//exit;
    }
	else{
        
    //$finalprn = "16".$stream_details[0]['programme_code']."001";     
   $finalprn = initial_year."01".$stream_details[0]['programme_code']."".$result[$i]['admission_year']."001";     
    }
}

else{
      $sql = "SELECT max(enrollment_no) as enrollment_no from student_master where admission_session='$ac' and admission_stream ='".$result[$i]['admission_stream']."' 
	  and admission_year='".$result[$i]['admission_year']."' AND transefercase='Y' AND previous_stream is null AND enrollment_no REGEXP '^[0-9]+$'";  //AND `previous_stream` IS NULL
        //echo $sql;
		//exit;
        $query = $DB1->query($sql);
        $pnr_details =  $query->result_array();
	   
    if($pnr_details[0]['enrollment_no']!='')
    {
        $var = substr($pnr_details[0]['enrollment_no'], -3);
        $var = ++$var;
        $prn =  sprintf("%03d", $var);
        //$finalprn = "2201".$stream_details[0]['programme_code']."".$result[$i]['admission_year']."".$prn;
        $finalprn = initial_year."01".$stream_details[0]['programme_code']."3".$prn;
	    // $finalprn;
		//exit;
     }
	else{
     //$finalprn = "16".$stream_details[0]['programme_code']."001";     
     //$finalprn = "2201".$stream_details[0]['programme_code']."".$result[$i]['admission_year']."001";     
     $finalprn = initial_year."01".$stream_details[0]['programme_code']."3001";     
    }
}
	
	
    $chkstream="select enrollment_no from student_master where enrollment_no='".$finalprn."'";
        $chkstmdet = $DB1->query($chkstream);
        $chkstream_details =  $chkstmdet->result_array();
		if(!empty($chkstream_details[0]['enrollment_no'])){
			 $finalprn=($finalprn)+1; 
		}else{
			$finalprn;
		}
//echo $finalprn;





$quer ="update student_master set enrollment_no='".$finalprn."',prn_2018='".$finalprn."' where stud_id='".$result[$i]['stud_id']."'";
//echo $quer;
//exit();
 $DB1->query($quer);
 
 //echo $finalprn;
$quer_ad ="update admission_details set enrollment_no='".$finalprn."' where student_id='".$result[$i]['stud_id']."' AND academic_year='$ac'";
//echo $quer;
//exit();
 $DB1->query($quer_ad);
 

 
 
 
 //unset($quer);
    return $finalprn;  
   }
	  }else{
		  
	  }
}
///////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


public function Update_admission($values,$id){
	$DB4 = $this->load->database('umsdb', TRUE);  
    $confirm['confirm_admission']=$values;
	$confirm['confirm_date']=date('Y-m-d');
    $confirm['modified_by']=$_SESSION['uid'];
    $confirm['modified_on']=date('Y-m-d h:i:s');
    $DB4->where('student_id',$id);
    $DB4->update('student_confirm_status',$confirm);    
    
	if($values=="Y"){
	
		//echo 'hjjgjgj';
		// $Prn=$this->generate_allprn($id);////Prn generate
		//exit();
		/*if($Prn!=''){
			$get_student_details=$DB4->get_where('student_master',array('stud_id'=>$id))->row();
			if(!empty($get_student_details)){
				$oldprn=$get_student_details->enrollment_no_new;
				if (file_exists("uploads/student_photo/$oldprn.jpg")) {					
						rename("uploads/student_photo/$oldprn.jpg","uploads/student_photo/$Prn.jpg");
						$std['student_photo_path']="$Prn.jpg";
				}
				$create_login=$this->create_student_login($id);
			
			  /*SELECT * FROM sandipun_erp.sf_student_facilities where enrollment_no='17756' #27954
				SELECT * FROM sandipun_erp.sf_student_facility_allocation where student_id='17459' #13773
				SELECT * FROM sandipun_erp.sf_fees_details where enrollment_no='210110021096'

				SELECT * FROM sandipun_erp.sf_fees_challan where enrollment_no='210110021096'*/
				//$ac=ADMISSION_SESSION;
				/* $get_facility_details=$this->db->get_where('sf_student_facilities',array('enrollment_no'=>$Prn))->row();
				if(!empty($get_facility_details)){
					$registration_for_hostentranfer=$this->db->query("update sf_student_facilities set enrollment_no ='$Prn' where enrollment_no='$oldprn' and academic_year='$ac'");
					$facitlityallocation=$this->db->query("update sf_student_facility_allocation set enrollment_no ='$Prn' where enrollment_no='$oldprn' and academic_year='$ac'");
					$sf_fees_details=$this->db->query("update sf_fees_details set enrollment_no ='$Prn' where enrollment_no='$oldprn' and academic_year='$ac'");
					$sf_fees_challan=$this->db->query("update sf_fees_challan set enrollment_no ='$Prn' where enrollment_no='$oldprn' and academic_year='$ac'");
				}

			}
		}*/
		
	$std['admission_confirm']='Y';	 
    $std['admission_date']=date('Y-m-d');
	
	}else{
	$std['admission_confirm']='N';	
	$std['admission_date']=date('Y-m-d');
	$std['prn_2018']='';
	}
	
	$DB4->where('stud_id',$id);
    $DB4->update('student_master',$std);
	return 1;
	 
	
   // redirect('Provisional_admission/received_payment_details/');  
}


function get_student_detail_by_prn_new_for_login_sms($enrollment_no){
	//echo 'enrollment_no'.($enrollment_no);//exit;
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stud_id,first_name,last_name,middle_name,father_fname,father_mname,father_lname,mobile");
		$DB1->from('student_master');
		$DB1->where("enrollment_no", $enrollment_no);
		$query=$DB1->get();
		$result=$query->row_array();
		return $result;
        

}


function send_login(){
	
	$prn=$this->input->post('enrollment_no');
       $DB1 = $this->load->database('umsdb', TRUE);
              
		$DB1->select("*");
		$DB1->from("user_master");
			//$DB1->like('username', "19", 'after');
		$DB1->where("username",$prn);
		$DB1->where("roles_id",4);
		$DB1->where("status",'Y');
		//$DB1->order_by("um_id", "asc");
		$query=$DB1->get(); 
		/*echo $DB1->last_query();
		exit(0);
		die;*/
		
		$result = $query->result_array(); 
		 
		 
		 
		 
		 
		$udet = $this->get_student_detail_by_prn_new_for_login_sms($prn);
//print_r($udet);exit;
//$fname = $udet['first_name'].' '.$udet['middle_name'].' '.$udet['last_name'];
if($udet['mobile']!='')
{
$mobile= $udet['mobile'];
//$mobile= '8850633088';

$username = $result[0]['username'];
$password = $result[0]['password'];
$sms_message ="Dear Student
To get your academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php
Username: $username
Password: $password
Thank you
Sandip University.
";

//echo "<br>stu".$mobile.">>".$sms_message;exit;

  
	$sms=urlencode($sms_message);

	$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);         
        
 // $s++;
  //exit;
  return 1;
}else{
	return 2;
    // }
}
		
		
		
	}
	
	
	
	
	
	function searchjlist_new_by_prn($sid){
		    $DB6 = $this->load->database('umsdb', TRUE);
		    /*$stid=array('190101221944','190101221945','190101221946','190101221947','190102201001','190102201002','190102201003','190102201004','190102201005','190102201006','190102201007');*/
			/*$stid=array('200109041005','200101191005','200109061001','200114021003','200105261001','200101181008','200101181009','200104151003','200109041006','200116281004','200109031004','200101051034','200105011013','200105181004','200105121014','200102011002','200104141001','200102261005','200104061008','200105181005','200101051035','200105131003','200101181010','200105011014','200101191006','200102161011','200101171008','200106111014','200101051036','200101201003','200101381004','200102261006','200101051037','200102251003','200101191007');*/
		    //die;
		   
		$DB6->select("sm.*,stm.stream_name,cm.course_name");
		$DB6->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left'); 
		$DB6->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB6->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB6->where("sm.cancelled_admission",'N');
		$DB6->where("sm.admission_session",'2022');	//
		$DB6->where("sm.academic_year",'2022');//
		$DB6->where("sm.is_detained",'N');
		//$DB1->where("sm.admission_cycle");
		//$DB1->where("length(sm.enrollment_no)",'9');
		$DB6->where("sm.enrollment_no",$sid);
		//$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB6->get();
		/*  echo $DB1->last_query();
		exit(0);*/
		$result=$query->result_array();
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
	
	
	function create_student_login_by_prn($sid)
{
    $DB3 = $this->load->database('umsdb', TRUE);
	//echo $sid;
    $dat  = $this->searchjlist_new_by_prn($sid);
	$return='';
 //exit;  
//print_r($dat);exit();
  foreach($dat as $sdata)
    {
        
        $rcnt = $this->check_if_exists('user_master','username',$sdata['enrollment_no'],'roles_id','9');
        if($rcnt<1)
        {
        $par['username'] = $sdata['enrollment_no'];    
        $par['password'] = rand(4999,999999);
         $par['inserted_by'] = $_SESSION['uid'];
          $par['inserted_datetime'] = date('Y-m-d h:i:s');
           $par['status'] ='Y';
            $par['roles_id'] = 9;
      $DB3->insert('user_master',$par);
        }

      $rcnt3 = $this->check_if_exists('user_master','username',$sdata['enrollment_no'],'roles_id','4');
        if($rcnt3<1)
        {
        $par2['username'] = $sdata['enrollment_no'];    
        $par2['password'] = rand(4999,999999);
         $par2['inserted_by'] = $_SESSION['uid'];
          $par2['inserted_datetime'] = date('Y-m-d h:i:s');
           $par2['status'] ='Y';
            $par2['roles_id'] = 4;
      $DB3->insert('user_master',$par2);
	    $return= $par2['password'];
        }else{
			$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from("user_master");
			//$DB1->like('username', "19", 'after');
		$DB1->where("username",$sid);
		$DB1->where("roles_id",4);
		$DB1->where("status",'Y');
		//$DB1->order_by("um_id", "asc");
		$query=$DB1->get(); 
		/*echo $DB1->last_query();
		exit(0);
		die;*/
		
		$result = $query->result_array();
		 $return= $result[0]['password'];
		} 
    }
	
	
	
	
	
	 $mobile=$dat[0]['mobile'];
	
	if($mobile!=''){
		$username = $dat[0]['enrollment_no'];
$password = $return;
$sms_message ="Dear Student
To get your academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php

Username: $username
Password: $password

Thank you
Sandip University.
";

//echo "<br>stu".$mobile.">>".$sms_message;exit;

 
	$sms=urlencode($sms_message);

	$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);         
        
 // $s++;
  //exit;
  echo 1;
}else{
	echo 2;
     }
	
	
	$email=$dat[0]['email'];
	
	$body = "Dear Student
To get your academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php


Username: $username
Password: $password


Thanks
Sandip University
";
$subject="PRN Number With Login Details";
//$file=$_SERVER['DOCUMENT_ROOT'] . 'payment/chpdf/receipt_'.$user_id.'.pdf';

        $path=$_SERVER["DOCUMENT_ROOT"].'/erp/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
        require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
        $mail->Username = 'noreply@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
        $mail->Password = 'kiran234!';
        //Set who the message is to be sent from
        $mail->setFrom('noreply@sandipuniversity.com', 'Sandip University');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to pramod.karole@sandipuniversity.edu.in
    // $mail->addAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod Karole');
	    $mail->AddAddress($email);
		//$mail->AddAddress('balasaheb.lengare@carrottech.in');
	//	$mail->AddAddress('vighnesh.sukum@carrottech.in');
	  // $mail->AddAddress('kamlesh.kasar@sandipuniversity.edu.in');
	  // $mail->AddAddress('pramod.thasal@carrottech.in');
       //$mail->AddAddress('ar@sandipuniversity.edu.in');
       $mail->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
        //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually

        $mail->Body = $body;


        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        
        $mail->AddAttachment($file);
		//$mail->AddAttachment($provcertificate);
        //send the message, check for errors
       
	   
	   if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
			////header("location:thankyou");
		
        }

	
    return $return;
    
	
	
}
	
	
	
	
	

	
	
	
	
	function update_fee_det($data, $payfile){
		
		//juga
		$DB2 = $this->load->database('umsdb', TRUE);

		$DB2->select('*');
		$DB2->from('fees_details');
		$DB2->where('prov_fees_id',$data['eid']);
		$query =$DB2->get();
		//echo $this->db->last_query();
		$result = $query->row_array();
		$fee_id = $data['eid'];
		
	    $receip = $this->last_receipt_no();
	    $receip++;
  

		$feedet['amount']=$data['epaidfee'];
		$feedet['type_id']=2;
		//	$feedet['student_id']=$data['prov_no'];
				$condata = $this->check_admission_confirm($data['prov_no']);
		if($condata['enrollment_no']!='')
		{
		 	$feedet['student_id']=$condata['stud_id'];   
		}
		else
		{
		    	$feedet['student_id']=$data['prov_no'];
		}
		
		
		$feedet['fees_paid_type']=$data['epayment_type'];
		$feedet['academic_year']= $data['acyear'];
				
		$feedet['receipt_no']=$data['edd_no'];
		$feedet['fees_date']=date('Y-m-d',strtotime(str_replace("/","-",$data['edd_date']))); 
		$feedet['bank_id']=$data['edd_bank'];
		$feedet['bank_city']=$data['edd_bank_branch'];
	
			$feedet['prov_fees_id']=$fee_id;

			$feedet['remark']=$data['eremark'];
			$feedet['college_receiptno']=$data['eclreceipt'];
		
			$feedet['is_provisional']="Y";
		
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		
		
		if($result['prov_fees_id']!='')
		{
		    	$feedet['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modified_on']= date('Y-m-d h:i:s');
		$feedet['modified_by']= $_SESSION['uid'];
		
    	$DB2->where('prov_fees_id',$result['prov_fees_id']);    
    	$DB2->update('fees_details',$feedet);    
		}
		else
		{
		      $feedet['college_receiptno1']= $receip;
		    	$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];
		
			$feedet['prov_reg_no']=$data['prov_no'];
			$DB2->insert('fees_details',$feedet);    
		}
		
	

		
		    $DB1 = $this->load->database('icdb', TRUE);
		
		
		
		
		
			$feedet1['amount']=$data['epaidfee'];
		$feedet1['type_id']=2;
		
		$feedet1['fees_paid_type']=$data['epayment_type'];
		$feedet1['academic_year']= $data['acyear'];
				
		$feedet1['receipt_no']=$data['edd_no'];
		$feedet1['fees_date']=$data['edd_date']; 
		$feedet1['bank_id']=$data['edd_bank'];
		$feedet1['bank_city']=$data['edd_bank_branch'];
		$feedet1['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet1['modified_on']= date('Y-m-d h:i:s');
		$feedet1['modified_by']= $_SESSION['uid'];

			$feedet1['remark']=$data['eremark'];
			$feedet1['college_receiptno']=$data['eclreceipt'];
			$feedet1['payment_status']="V";
		
		if($payfile !=''){
			$feedet1['receipt_file']=$payfile;
		}
		

		
	//print_r($feedet);exit;
		 $DB1->where('fees_id', $fee_id);
	 $DB1->update('provisional_fees_details',$feedet1);

		//	echo  $DB1->last_query();
		//	exit();

		return true;
		
	}





	function add_payment($data, $payfile){
		
		
		
		
				
	   $DB1 = $this->load->database('icdb', TRUE);	
		
		
			$feedet1['student_id']=$data['sid'];
		
			$feedet1['amount']=$data['paidfee'];
		$feedet1['type_id']=2;
		
		$feedet1['fees_paid_type']=$data['payment_type'];
		$feedet1['academic_year']= $data['acyear'];
				
		$feedet1['receipt_no']=$data['dd_no'];
		$feedet1['fees_date']=$data['dd_date']; 
		$feedet1['bank_id']=$data['dd_bank'];
		$feedet1['bank_city']=$data['dd_bank_branch'];
		$feedet1['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet1['modified_on']= date('Y-m-d h:i:s');
		$feedet1['modified_by']= $_SESSION['uid'];

			$feedet1['remark']=$data['remark'];
			$feedet1['college_receiptno']=$data['clreceipt'];
			$feedet1['payment_status']="P";
		
		if($payfile !=''){
			$feedet1['receipt_file']=$payfile;
		}
		

		
	//print_r($feedet);exit;
//		 $DB1->where('fees_id', $fee_id);
	 $DB1->insert('provisional_fees_details',$feedet1);
		
	$lastid = $DB1->insert_id();	
		
		
		
		
		
		
		
		
		$DB2 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
	$fee_id = $data['eid'];
		//	$bfees = $data['bfees'];
			//	$pfees = $data['pfees'];prov_no
			//	$tfee = $data['bfees'] + $data['pfees'];

		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=2;
		$condata = $this->check_admission_confirm($data['prov_no1']);
		if($condata['enrollment_no']!='')
		{
		 	$feedet['student_id']=$condata['stud_id'];   
		}
		else
		{
		    	$feedet['student_id']=$data['prov_no1'];
		}
		
		$feedet['fees_paid_type']=$data['payment_type'];
		$feedet['academic_year']= $data['acyear'];
			$feedet['student_id']=$data['prov_no1'];
				$feedet['prov_reg_no']=$data['prov_no1'];
			$feedet['prov_fees_id']=$lastid;
			
		$feedet['receipt_no']=$data['dd_no'];
		$feedet['fees_date']=date('Y-m-d',strtotime(str_replace("/","-",$data['dd_date']))); 
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
		$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];
	/*	if($data['ccanc']=="N")
		{
		 	$feedet['canc_charges']=0;   
		}
		else
		{
		
			$feedet['canc_charges']=$data['cancamt']; 
		}
			$feedet['chq_cancelled']=$data['ccanc']; */
			$feedet['remark']=$data['remark'];
			$feedet['college_receiptno']=$data['clreceipt'];
		
			$feedet['is_provisional']="Y";
		
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		
	$DB2->insert('fees_details',$feedet);
		
	//	echo $DB2->last_query();
		
		
		


	//	echo  $DB1->last_query();
		//	exit();

		return true;
		
	}






public function get_bank_details()
{
     $DB1 = $this->load->database('icdb', TRUE);
     $DB1->select('*');
 $DB1->from('bank_master');

$query = $DB1->get();
//echo  $DB1->last_query();
$result = $query->result_array();
return $result;

}

public function get_academic_byid($stdid)
{
     $DB1 = $this->load->database('icdb', TRUE);
    $DB1->select('*');
$DB1->from('provisional_education_detail');

$DB1->where('adm_id',$stdid);
$query =$DB1->get();

$result = $query->result_array();
return $result;

}
function referby_details($det)
{
    $ref = $this->get_std_details_byid($det[0]['id']);
    if($ref['admission_refer_by']=="IC")
    {
   $ic = $this->list_ics($ref['admission_refer_id']);    
    $ret =  $ic[0]['ic_name'];
    }
      if($ref['admission_refer_by']=="STAFF")
    {
    $ret = $this->list_staff($ref['admission_refer_id']);    
   $ret =  $ret[0]['staff_name']."(".$ret[0]['institute']." ".$ret[0]['staff_id'].")";
    } 
       if($ref['admission_refer_by']=="KP")
    {
    $kp = $this->list_KP($ref['admission_refer_id']);    
   $ret =  $kp[0]['partner_name'];
    } 
    
    return $ret;
   // var_dump($det);
}


public function last_receipt_no()
{
        $DB1 = $this->load->database('umsdb', TRUE);        
    $DB1->select('college_receiptno1');
$DB1->from('fees_details');
$DB1->order_by('college_receiptno1','desc');
$DB1->limit(1);
$query =$DB1->get();
//echo $this->db->last_query();
$result = $query->row_array();
return $result['college_receiptno1'];
  
}

public function check_admission_confirm($enroll)
{
        $DB1 = $this->load->database('umsdb', TRUE);        
    $DB1->select('*');
$DB1->from('student_master');
$DB1->where('enrollment_no',$enroll);
$DB1->or_where('enrollment_no_new',$enroll);
$DB1->limit(1);
$query =$DB1->get();
//echo $this->db->last_query();
$result = $query->row_array();
return $result;
  
}




function generate_receipt_no()
{
      $DB1 = $this->load->database('umsdb', TRUE);     
    $receip = $this->last_receipt_no();
    $receip++;
    $prdet['college_receiptno1']= $receip;

  $DB1->where('fees_id',$_POST['feeid']);

		 $DB1->update('fees_details',$prdet);      
    echo "Y";
    
}



public function university_bank_details($bankid='')
{
  
    $this->db->select('*');
 $this->db->from('bank_master');
 $this->db->where('status','Y');
if($bankid!='')
{
 $this->db->where('bank_id',$bankid);
}
$query = $this->db->get();
//echo  $DB1->last_query();
$result = $query->result_array();
return $result;

}









public function send_verification($stud_id)
{
 //   $stud_id="350481";
   
    $stud_det = $this->get_std_details_byid($stud_id);
    
   // var_dump($stud_det);
    
   $test = NEW Message_api();
					$mob = $stud_det['mobile1']; //"8169767169";
				    //$mob = trim('9987928501');mobile1
					$content="Dear ".$stud_det['student_name']."
You have been registered for ".$stud_det['sprogramm_acro']."
Your Reference Number is ".$stud_det['prov_reg_no']."

Regards,
Sandip University";
			$test->send_sms($mob,$content);


    
}












/*
public function get_std_details_byid($stdid)
{
     $DB1->select('*');
 $DB1->from('provisional_admission_details');
 $DB1->where('adm_id',$stdid);
$query =$this->db->get();

$result = $query->row_array();
return $result;

}
*/


public function get_std_details_byid($stdid,$type='')
{
    $this->db->select('smd.*,pad.*,sm.state_name,cm.city_name,sandipun_univerdb.school_programs_new.sprogramm_acro,pfd.amount,pfd.bank_id');
$this->db->from('sandipun_ic_erp.provisional_admission_details pad');
$this->db->join('sandipun_ic_erp.student_meet_details smd','smd.id=pad.adm_id','left');
$this->db->join('sandipun_univerdb.school_programs_new','pad.program_id=sandipun_univerdb.school_programs_new.sp_id','left');
$this->db->join('sandipun_ic_erp.state_master sm','smd.state_id=sm.state_id','left');
$this->db->join('sandipun_ic_erp.city_master cm','smd.city_id=cm.city_id','left');
$this->db->join('sandipun_ic_erp.provisional_fees_details pfd','pad.adm_id=pfd.student_id','left');
if($type!='')
{

$this->db->where('pfd.type_id',$type);
}
$this->db->where('pad.adm_id',$stdid);
$query =$this->db->get();
//echo $this->db->last_query();
$result = $query->row_array();
return $result;

}



public function get_feedet_byid($stdid,$type='')
{
     $DB1 = $this->load->database('icdb', TRUE);
     $DB1->select('pfd.*,bm.bank_name');
 $DB1->from('provisional_fees_details pfd');
 $DB1->join('bank_master bm','pfd.bank_id=bm.bank_id','left');
 $DB1->where('pfd.student_id',$stdid);

$query = $DB1->get();

$result = $query->result_array();
return $result;

}




public function get_feedet_byfeesid($stdid,$type='')
{
    
     $DB1 = $this->load->database('icdb', TRUE);
     $DB1->select('pfd.*,bm.bank_name,pad.prov_reg_no');
 $DB1->from('provisional_fees_details pfd');
 $DB1->join('bank_master bm','pfd.bank_id=bm.bank_id','left');
 $DB1->join('provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
 $DB1->where('pfd.fees_id',$stdid);

$query = $DB1->get();

$result = $query->result_array();
return $result;

}


public function online_feedet_byfeesid($feesid)
{
    
     $DB1 = $this->load->database('icdb', TRUE);
     $DB1->select('op.*');
 $DB1->from('online_payment op');
 $DB1->where('op.fees_id',$feesid);

$query = $DB1->get();

$result = $query->row_array();
return $result;

}





public function city_by_state($state)
{
    
     $DB1 = $this->load->database('icdb', TRUE);
     $DB1->select('*');
 $DB1->from('city_master');
 $DB1->where('state_id',$state);
$query = $DB1->get();
//echo  $DB1->last_query();
$result = $query->result_array();
return $result;

}



public function admissions_get_count($mobile=''){
	$this->db->select('sandipun_ic_erp.student_meet_details.*,sandipun_ic_erp.provisional_admission_details.*,sandipun_univerdb.school_programs_new.sprogramm_name,sandipun_univerdb.school_master.school_name,sandipun_ic_erp.state_master.state_name,sandipun_ic_erp.city_master.city_name,sandipun_ums.student_master.enrollment_no');
$this->db->from('sandipun_ic_erp.provisional_admission_details');
$this->db->join('sandipun_ic_erp.student_meet_details','sandipun_ic_erp.student_meet_details.id=sandipun_ic_erp.provisional_admission_details.adm_id','left');
$this->db->join('sandipun_univerdb.school_programs_new','sandipun_ic_erp.provisional_admission_details.program_id=sandipun_univerdb.school_programs_new.sp_id','left');
$this->db->join('sandipun_univerdb.school_master','sandipun_univerdb.school_programs_new.school_id=sandipun_univerdb.school_master.school_id','left');
$this->db->join('sandipun_ic_erp.state_master','student_meet_details.state_id=sandipun_ic_erp.state_master.state_id','left');
$this->db->join('sandipun_ic_erp.city_master','student_meet_details.city_id=sandipun_ic_erp.city_master.city_id','left');
$this->db->join('sandipun_ums.student_master','sandipun_ums.student_master.enrollment_no=sandipun_ic_erp.provisional_admission_details.prov_reg_no','left');
//$this->db->join('sandipun_ums.fees_details','sandipun_ums.fees_details.prov_reg_no=sandipun_ic_erp.provisional_admission_details.prov_reg_no','inner');
$this->db->where('sandipun_ic_erp.student_meet_details.provisional_admission','Y');


if($_POST['doa']!='')
{
 $this->db->where('sandipun_ic_erp.provisional_admission_details.doa',$_POST['doa']);   
}

if($_POST['ic']!='')
{
     $this->db->where('sandipun_ic_erp.provisional_admission_details.admission_refer_by','IC');  
 $this->db->where('sandipun_ic_erp.provisional_admission_details.admission_refer_id',$_POST['ic']);     
}




if($mobile!='')
{
    
 $this->db->where('sandipun_ic_erp.provisional_admission_details.adm_id',$mobile);   
}

$this->db->order_by('sandipun_ic_erp.provisional_admission_details.prov_reg_no','desc');
$query =$this->db->get();
/*echo $this->db->last_query();
exit();*/
$result = $query->result_array();
for($i=0;$i<count($result);$i++)
{
    $acd = $this->get_fees_details_academic($result[$i]['adm_id']);
        $host = $this->get_fees_details_hostel($result[$i]['adm_id']);
  $result[$i]['host_fees']  =$host[0]['amount'];
   $result[$i]['host_fees_type']  =$host[0]['fees_paid_type'];
  $result[$i]['acd_fees']  =$acd[0]['amount'];
   $result[$i]['acd_fees_type']  =$acd[0]['fees_paid_type'];  
    $result[$i]['fees_id']  =$acd[0]['fees_id'];   
        $result[$i]['hfees_id']  =$host[0]['fees_id'];    
    
}
return count($result);
}
public function list_admissions_new($mobile='',$limit, $start)
{
	//echo $limit.''.$start;exit;
 //$this->db->limit($limit, $start);
$this->db->select('sandipun_ic_erp.student_meet_details.*,sandipun_ic_erp.provisional_admission_details.*,sandipun_univerdb.school_programs_new.sprogramm_name,sandipun_univerdb.school_master.school_name,sandipun_ic_erp.state_master.state_name,sandipun_ic_erp.city_master.city_name,sandipun_ums.student_master.enrollment_no');
$this->db->from('sandipun_ic_erp.provisional_admission_details');
$this->db->join('sandipun_ic_erp.student_meet_details','sandipun_ic_erp.student_meet_details.id=sandipun_ic_erp.provisional_admission_details.adm_id','left');
$this->db->join('sandipun_univerdb.school_programs_new','sandipun_ic_erp.provisional_admission_details.program_id=sandipun_univerdb.school_programs_new.sp_id','left');
$this->db->join('sandipun_univerdb.school_master','sandipun_univerdb.school_programs_new.school_id=sandipun_univerdb.school_master.school_id','left');
$this->db->join('sandipun_ic_erp.state_master','student_meet_details.state_id=sandipun_ic_erp.state_master.state_id','left');
$this->db->join('sandipun_ic_erp.city_master','student_meet_details.city_id=sandipun_ic_erp.city_master.city_id','left');
$this->db->join('sandipun_ums.student_master','sandipun_ums.student_master.enrollment_no=sandipun_ic_erp.provisional_admission_details.prov_reg_no','left');
//$this->db->join('sandipun_ums.fees_details','sandipun_ums.fees_details.prov_reg_no=sandipun_ic_erp.provisional_admission_details.prov_reg_no','inner');
$this->db->where('sandipun_ic_erp.student_meet_details.provisional_admission','Y');


if($_POST['doa']!='')
{
 $this->db->where('sandipun_ic_erp.provisional_admission_details.doa',$_POST['doa']);   
}

if($_POST['ic']!='')
{
     $this->db->where('sandipun_ic_erp.provisional_admission_details.admission_refer_by','IC');  
 $this->db->where('sandipun_ic_erp.provisional_admission_details.admission_refer_id',$_POST['ic']);     
}




if($mobile!='')
{
    
 $this->db->where('sandipun_ic_erp.provisional_admission_details.adm_id',$mobile);   
}

$this->db->order_by('sandipun_ic_erp.provisional_admission_details.prov_reg_no','desc');
 $this->db->limit($limit, $start);
$query =$this->db->get();
//echo $this->db->last_query();
//exit();
$result = $query->result_array();
for($i=0;$i<count($result);$i++)
{
    $acd = $this->get_fees_details_academic($result[$i]['adm_id']);
        $host = $this->get_fees_details_hostel($result[$i]['adm_id']);
  $result[$i]['host_fees']  =$host[0]['amount'];
   $result[$i]['host_fees_type']  =$host[0]['fees_paid_type'];
  $result[$i]['acd_fees']  =$acd[0]['amount'];
   $result[$i]['acd_fees_type']  =$acd[0]['fees_paid_type'];  
    $result[$i]['fees_id']  =$acd[0]['fees_id'];   
        $result[$i]['hfees_id']  =$host[0]['fees_id'];    
    
}
return $result;
    
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function list_admissions($m='')
{

$adms=ADMISSION_SESSION;
$DB = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");		
		 $sql="SELECT vw.`school_name`,vw.`course_short_name`,vw.`stream_name`,st.state_name,dt.`district_name`,tm.`taluka_name`,
		 em.* FROM student_master AS em 
LEFT JOIN `vw_stream_details` AS vw ON vw.stream_id=em.admission_stream
LEFT JOIN address_details AS ads ON ads.student_id=em.stud_id AND ads.address_type='CORS' 
LEFT JOIN `states` AS st ON st.state_id=ads.state_id
LEFT JOIN `district_name` AS dt ON dt.`district_id`=ads.district_id
LEFT JOIN `taluka_master` AS tm ON tm.`taluka_id`=ads.`city`

WHERE em.academic_year='$adms' AND em.admission_session='$adms' AND em.cancelled_admission='N' AND em.enrollment_no!=''
 AND em.admission_confirm='$m' AND admission_cycle IS NULL";
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $dept= $empsch[0]['department'];
			 $sql .=" AND vw.stream_id in(select ums_stream_id from sandipun_erp.department_ums_stream_mapping where department_id='$dept')";
		 }else if(isset($role_id) && $role_id==44){
				$empsch = $this->loadempschool($emp_id);
				$schid= $empsch[0]['school_code'];
				$sql .=" AND vw.school_code = $schid";
		}else if(isset($role_id) && ($role_id==10)){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
		}		
//echo  $sql;exit;		
$query = $DB->query($sql);
		
$result = $query->result_array();
for($i=0;$i<count($result);$i++)
{
$acd = $this->get_fees_details_academic($result[$i]['adm_id']);
$host = $this->get_fees_details_hostel($result[$i]['adm_id']);
$result[$i]['host_fees']  =$host[0]['amount'];
$result[$i]['host_fees_type']  =$host[0]['fees_paid_type'];
$result[$i]['acd_fees']  =$acd[0]['amount'];
$result[$i]['acd_fees_type']  =$acd[0]['fees_paid_type'];  
$result[$i]['fees_id']  =$acd[0]['fees_id'];   
$result[$i]['hfees_id']  =$host[0]['fees_id'];    
    
}
return $result;
    
}

 function loadempschool($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT v.school_code,f.department from vw_faculty f 
		LEFT JOIN sandipun_erp.employee_master e  ON e.emp_id=f.emp_id
		INNER JOIN school_master c  ON c.erp_mapp_school_id=f.emp_school
		LEFT JOIN vw_stream_details v ON v.school_id=c.school_id where f.emp_id='$emp_id' group by v.school_code
		";
        $query = $DB1->query($sql);
        return $query->result_array();
 }


public function get_datatables($year='',$type_param='',$ctype='',$Document_status='',$admission_status='')
	{  

 $role_id =$this->session->userdata('role_id');
	    $DB1=$this->load->database('umsdb',TRUE);
		//return $type_status;
		//exit();
		$this->_Enquiry_list1($DB1,$year,$type_param,$ctype,$Document_status,$admission_status);
		//$this->_Enquiry_list($DB1);
		if($_POST['length'] != -1)
		$DB1->limit($_POST['length'], $_POST['start']);
		$query = $DB1->get();


		//echo $DB1->last_query();exit;


		return $query->result();
	}

private function _Enquiry_list1($DB,$year='',$type_param='',$ctype='',$Document_status='',$admission_status=''){
		
		$updated_by =$this->session->userdata('uid');
		$role_id =$this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		//$empStreamid =$this->getFacultyStream($emp_id);
		
        $DB->select('o.payment_id,scs.docuemnt_confirm,scs.final_confirm,scs.confirm_admission,vw.course_id,vw.`school_name`,vw.`school_short_name`,vw.course_short_name,vw.`stream_name`,st.state_name,dt.`district_name`,tm.`taluka_name`,uw.username,uw.password,sm.*');
		
		$DB->from('student_master as sm');
		$DB->join('admission_details as ad','ad.student_id=sm.stud_id','INNER');
		$DB->join('student_confirm_status as scs','scs.student_id=sm.stud_id','left');
		$DB->join('vw_stream_details as vw','vw.stream_id=sm.admission_stream','left');
		$DB->join('user_master as uw','sm.enrollment_no=uw.username and uw.roles_id=4','left');
		$DB->join('address_details as ads','ads.student_id=sm.stud_id AND ads.address_type="CORS"','left');
		$DB->join('states as st','st.state_id=ads.state_id','left');
		$DB->join('district_name as dt','dt.district_id=ads.district_id','left');
		$DB->join('taluka_master as tm','tm.taluka_id=ads.city','left');
		$DB->join('sandipun_erp.online_payment_facilities as o','o.student_id=sm.stud_id and o.org_frm="SU" and o.payment_status="success" and o.productinfo="Uniform"','left');
		/*if($date !=''){
		$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
		}*/
		/*if($type_param !=''){
			if($type_param==1){
					$DB->where("eq.form_taken='Y'");
				
			}
			else if($type_param==2){
					$DB->where("eq.provisional_no !='-'  and eq.provisional_no IS NOT NULL");
				
			}
			else if($type_param==3){
					$DB->where("eq.enquiry_status ='confirm'");
				
			}
		
		}*/
		$where="sm.admission_session='".$year."' AND sm.academic_year='".$year."' AND sm.cancelled_admission='N' AND sm.enrollment_no!='' AND admission_cycle IS NULL";
		$DB->where($where);	
		
		//echo $type_status;
		$DB->where('sm.admission_confirm',$ctype);
		//if($role_id==2){
			if($Document_status=="ALL"){
			//$DB->where('scs.docuemnt_confirm',$ctype);	
			}elseif($Document_status=="Pending"){
				$wheree="(scs.docuemnt_confirm='N')";//OR scs.docuemnt_confirm IS NULL
				$DB->where($wheree);
			}elseif($Document_status=="Confirm"){
				//$where="(scs.docuemnt_confirm='Y' OR scs.docuemnt_confirm IS NULL)";
				$DB->where('scs.docuemnt_confirm','Y');
			}elseif($Document_status=="Verified"){
				//$where="(scs.docuemnt_confirm='Y' OR scs.docuemnt_confirm IS NULL)";
				$DB->where('scs.final_confirm','Y');
			}
		
		if($admission_status=="ALL"){
		//$DB->where('scs.docuemnt_confirm',$ctype);	
		}elseif($admission_status=="Pending"){
			
			$wheree="(scs.`confirm_admission`='N')";//OR scs.confirm_admission IS NULL
			$DB->where($wheree);
		}elseif($admission_status=="Confirm"){
			//$DB->where('sm.admission_confirm','Y');
			$DB->where('scs.`confirm_admission','Y');
		}
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $dept= $empsch[0]['department'];
			 $subquery ="select ums_stream_id from sandipun_erp.department_ums_stream_mapping where department_id='$dept'";
			 //$DB->where_in(vw.stream_id, $subquery);
			 $DB->where("vw.stream_id IN ($subquery)");
		 }else if(isset($role_id) && $role_id==44){
				$empsch = $this->loadempschool($emp_id);
				$schid= $empsch[0]['school_code'];
				$DB->where('vw.`school_code',$schid);
		}else if(isset($role_id) && ($role_id==10 || $role_id==23)){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				if($role_id==23){
					//$sql .=" where course_id = 15";
					$DB->where('vw.`course_id',15);
				}else{
					//$sql .=" where school_code = $sccode";
					$DB->where('vw.`school_code',$sccode);
				}
		}
		//$DB->where('is_online', 'N');
		//if(($role_id==1)||($role_id==24)){}else{
	   // $DB->where("eq.created_by='".$updated_by."'");	
		//}
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				}
				else
				{
					$DB->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$DB->group_end(); //close bracket
			}
			$i++;
		}
		
		
		if(isset($_POST['order'])) // here order processing
		{
			$DB->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$DB->order_by(key($order), $order[key($order)]);
		}
		
		
	}

public function count_filtered($year='',$type_param='',$m='',$Document_status='',$admission_status='')
	{   $DB2=$this->load->database('umsdb',TRUE);
		$this->_Enquiry_list1($DB2,$year,$type_param,$m,$Document_status,$admission_status);
		$query = $DB2->get();
		return $query->num_rows();
	}

	public function count_all($m,$year)
	{  
	    $DB3=$this->load->database('umsdb',TRUE);
		$DB3->from('student_master');
		$where="admission_session='".$year."' AND academic_year='".$year."' AND enrollment_no!='' AND cancelled_admission='N' AND admission_confirm='$m' AND admission_cycle IS NULL";
		$DB3->where($where);	
		return $DB3->count_all_results();
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//By Arvind Thasal on 25Aug-18
public function provisional_admission_student_wise($year){
    
    $sql="SELECT a.prov_reg_no,s.student_name,sm.school_name,p.course_type,p.sprogramm_acro,YEAR,admission_year,actual_fees,exemption_fees,
                    applicable_fees,CASE WHEN f.fees_paid IS NULL THEN 0 ELSE f.fees_paid END AS fees_paid,doa,is_cancelled,is_verified,is_confirmed,cancelled_date
                     FROM sandipun_ic_erp.provisional_admission_details a 
                     LEFT JOIN sandipun_ic_erp.student_meet_details s ON s.id=a.adm_id
                    LEFT JOIN sandipun_univerdb.school_programs_new p ON p.sp_id=a.program_id
                    LEFT JOIN sandipun_univerdb.school_master sm ON sm.school_id=p.school_id
                    LEFT JOIN ( SELECT  prov_reg_no,SUM(amount)AS fees_paid FROM sandipun_ums.fees_details WHERE academic_year='2018' AND is_provisional='Y' 
                     AND is_deleted='N' AND chq_cancelled='N'
                     GROUP BY prov_reg_no ) f ON f.prov_reg_no=a.prov_reg_no
                     WHERE a.prov_reg_no!='' ORDER BY prov_reg_no" ;
                      $query=$this->db->query($sql);
                   // echo $this->db->last_query();exit();
                   $result= $query->result_array(); 
                   
	             return $result;   
	          
    
}

//end Here

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


public function get_datatables_report($year='',$type_param='',$ctype='',$Document_status='',$admission_status='')
	{  
	    $role_id =$this->session->userdata('role_id');
	    $DB1=$this->load->database('umsdb',TRUE);
		//return $type_status;
		//exit();
		$sql=$this->_Enquiry_list_report($DB1,$year,$type_param,$ctype,$Document_status,$admission_status);
		//$this->_Enquiry_list($DB1);
		if($_POST['length'] != -1)
		//$DB1->limit($_POST['length'], $_POST['start']);
		//$query = $DB1->get();
		$query=$DB1->query($sql);
		//if($role_id==1){
			//echo $DB1->last_query(); exit();
		//}
		return $query->result();
	}

private function _Enquiry_list_report($DB,$date='',$type_param='',$ctype='',$Document_status='',$admission_status=''){
		
		$updated_by =$this->session->userdata('uid');
		$role_id =$this->session->userdata('role_id');
		  $sql="SELECT v.school_name,v.`school_short_name`,v.course_name,v.stream_name,v.stream_short_name,s.current_semester,s.current_year,COUNT(s.stud_id) AS student_count,p.Confirm_count,
om.totall_mh,totall_omh,totall_International,totall_cancle
FROM student_master s 
LEFT JOIN vw_stream_details v ON v.stream_id=s.admission_stream
LEFT JOIN (SELECT vv.school_name,vv.`stream_id`,vv.stream_name,COUNT(sm.stud_id) AS Confirm_count,sm.`admission_year`,sm.stud_id FROM student_master AS sm
LEFT JOIN vw_stream_details vv ON vv.stream_id=sm.admission_stream


 WHERE sm.cancelled_admission='N' AND sm.is_detained='N' AND sm.admission_session ='2022' AND 
 sm.academic_year ='2022' AND sm.enrollment_no !='' AND sm.admission_confirm='Y' GROUP BY vv.stream_name,sm.current_year) AS p ON p.stream_id=s.admission_stream AND p.admission_year=s.admission_year
 
 
 LEFT JOIN (#COUNT(ms.stud_id) AS total_mh,staa.state_name,
 SELECT ms.stud_id,
                SUM(CASE WHEN staa.state_name='MAHARASHTRA' THEN 1 ELSE 0 END )AS totall_mh,
                SUM(CASE WHEN staa.state_name!='MAHARASHTRA' THEN 1 ELSE 0 END ) AS totall_omh


  FROM student_master AS ms
  LEFT JOIN vw_stream_details vv ON vv.stream_id=ms.admission_stream

 LEFT JOIN address_details AS aads ON aads.student_id=ms.stud_id AND aads.address_type='CORS'
 LEFT JOIN states AS staa ON staa.state_id=aads.state_id
 WHERE ms.cancelled_admission='N' AND ms.is_detained='N' AND ms.admission_session ='2022' AND  ms.academic_year ='2022' AND ms.enrollment_no !='' 
 GROUP BY vv.stream_name,ms.current_year
)  AS om ON om.stud_id=s.`stud_id`

LEFT JOIN (#COUNT(ms.stud_id) AS total_mh,staa.state_name,
 SELECT ms.stud_id,
                SUM(CASE WHEN ms.nationality='International' THEN 1 ELSE 0 END )AS totall_International
                


  FROM student_master AS ms
  LEFT JOIN vw_stream_details vv ON vv.stream_id=ms.admission_stream

 WHERE ms.cancelled_admission='N' AND ms.is_detained='N' AND ms.admission_session ='2022' AND  ms.academic_year ='2022' AND ms.enrollment_no !='' 
 GROUP BY vv.stream_name,ms.current_year
)  AS ni ON ni.stud_id=s.`stud_id`

LEFT JOIN (SELECT ms.stud_id,
                SUM(CASE WHEN ms.cancelled_admission='Y' THEN 1 ELSE 0 END )AS totall_cancle
                


  FROM student_master AS ms
  LEFT JOIN vw_stream_details vv ON vv.stream_id=ms.admission_stream
 WHERE   ms.is_detained='N' AND ms.admission_session ='2022' AND  ms.academic_year ='2022' AND ms.enrollment_no !='' 
 GROUP BY vv.stream_name,ms.current_year
)  AS cl ON cl.stud_id=s.`stud_id`


WHERE s.cancelled_admission='N' AND s.is_detained='N' AND s.admission_session ='2022' AND  s.academic_year ='2022' AND s.enrollment_no !='' 
GROUP BY v.stream_name,s.current_year
ORDER BY v.school_name,v.course_name, v.stream_name,s.current_year
" ;
                    //  $query=$DB->query($sql);
        /*$DB->select('scs.docuemnt_confirm,scs.confirm_admission,vw.`school_name`,vw.`school_short_name`,vw.course_short_name,vw.`stream_name`,st.state_name,dt.`district_name`,tm.`taluka_name`,sm.*');
		$DB->from('student_master as sm');
		$DB->join('admission_details as ad','ad.student_id=sm.stud_id','INNER');
		$DB->join('student_confirm_status as scs','scs.student_id=sm.stud_id','left');
		$DB->join('vw_stream_details as vw','vw.stream_id=sm.admission_stream','left');
		
		$DB->join('address_details as ads','ads.student_id=sm.stud_id AND ads.address_type="CORS"','left');
		$DB->join('states as st','st.state_id=ads.state_id','left');
		$DB->join('district_name as dt','dt.district_id=ads.district_id','left');
		$DB->join('taluka_master as tm','tm.taluka_id=ads.city','left');*/
		/*if($date !=''){
		$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
		}*/
		/*if($type_param !=''){
			if($type_param==1){
					$DB->where("eq.form_taken='Y'");
				
			}
			else if($type_param==2){
					$DB->where("eq.provisional_no !='-'  and eq.provisional_no IS NOT NULL");
				
			}
			else if($type_param==3){
					$DB->where("eq.enquiry_status ='confirm'");
				
			}
		
		}*/
		
		//$DB->where('is_online', 'N');
		//if(($role_id==1)||($role_id==24)){}else{
	   // $DB->where("eq.created_by='".$updated_by."'");	
		//}
		$i = 0;
	
		/*foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				}
				else
				{
					$DB->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$DB->group_end(); //close bracket
			}
			$i++;
		}*/
		
		
		/*if(isset($_POST['order'])) // here order processing
		{
			$DB->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$DB->order_by(key($order), $order[key($order)]);
		}*/
		
		return $sql;
	}

public function count_filtered_report($date='',$type_param='',$m='',$Document_status='',$admission_status='')
	{   /*$DB2=$this->load->database('umsdb',TRUE);
		$this->_Enquiry_list_report($DB2,$date,$type_param,$m,$Document_status,$admission_status);
		$query = $DB2->get();*/
		return 0;//$query->num_rows();
	}

	public function count_all_report($m)
	{  
	    /*$DB3=$this->load->database('umsdb',TRUE);
		$DB3->from('student_master');
		$where="admission_session='2020' AND academic_year='2020' AND enrollment_no!='' AND cancelled_admission='N' AND admission_confirm='$m'";
		$DB3->where($where);	*/
		return 0;//$DB3->count_all_results();
	}


function check_uniform_payments_old($value,$studid){
	//echo 'enrollment_no'.($enrollment_no);exit;
       // $this->db = $this->load->database();
		 $this->db->select("*");
		 $this->db->from('online_payment_facilities');
		 $this->db->where("payment_status",'success');
		 $this->db->where("productinfo",'Uniform');
		 $this->db->where("org_frm",'SU');
		 $this->db->where("student_id", $studid);
		$query= $this->db->get();
		//$result1= $this->db->last_query();
		$result=$query->row_array();
		
		if(!empty($result)){
			$result1= '1';
		}else{
			$result1= '0';
		}
		return $result1;
        

}
public function check_uniform_payments($value,$studid)
{
    $this->db->select("payment_id"); 
    $this->db->from("online_payment_facilities");
    $this->db->where([
        "payment_status" => "success",
        "productinfo"    => "Uniform",
        "org_frm"        => "SU",
        "student_id"     => $studid
    ]);

    $query = $this->db->get();
	//echo $this->db->last_query();exit; 
    return ($query->num_rows() > 0) ? 1 : 0;
}
function check_student_details($stud_id){
	$DB1=$this->load->database('umsdb',TRUE);
	 $sql="SELECT sm.nationality
		FROM  student_master sm 
		LEFT JOIN address_details ads ON ads.student_id=sm.stud_id AND ads.adds_of='STUDENT' AND ads.address_type='PERMNT' 
				LEFT JOIN states AS st ON st.state_id=ads.state_id 
				LEFT JOIN district_name AS dt ON dt.district_id=ads.district_id 
				LEFT JOIN taluka_master AS tm ON tm.taluka_id=ads.city 
				LEFT JOIN countries AS cc ON cc.id=ads.country_id 
				
		WHERE   cancelled_admission='N'  and sm.stud_id='$stud_id'";
		$query=$DB1->query($sql);

		return $query->result_array();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>