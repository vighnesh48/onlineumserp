<?php

class Career_model extends CI_Model 
{

    function __construct()
    {

        parent::__construct();
		$defaultdb = $this->load->database('default', TRUE); 

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


public function get_datatables_report($date='',$type_param='',$ctype='',$Document_status='',$admission_status='')
	{  
	    $role_id =$this->session->userdata('role_id');
	    $DB1=$this->load->database('umsdb',TRUE);
		//return $type_status;
		//exit();
		$sql=$this->_Enquiry_list_report($DB1,$date,$type_param,$ctype,$Document_status,$admission_status);
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


 WHERE sm.cancelled_admission='N' AND sm.is_detained='N' AND sm.admission_session ='2020' AND 
 sm.academic_year ='2020' AND sm.enrollment_no !='' AND sm.admission_confirm='Y' GROUP BY vv.stream_name,sm.current_year) AS p ON p.stream_id=s.admission_stream AND p.admission_year=s.admission_year
 
 
 LEFT JOIN (#COUNT(ms.stud_id) AS total_mh,staa.state_name,
 SELECT ms.stud_id,
                SUM(CASE WHEN staa.state_name='MAHARASHTRA' THEN 1 ELSE 0 END )AS totall_mh,
                SUM(CASE WHEN staa.state_name!='MAHARASHTRA' THEN 1 ELSE 0 END ) AS totall_omh


  FROM student_master AS ms
  LEFT JOIN vw_stream_details vv ON vv.stream_id=ms.admission_stream

 LEFT JOIN address_details AS aads ON aads.student_id=ms.stud_id AND aads.address_type='CORS'
 LEFT JOIN states AS staa ON staa.state_id=aads.state_id
 WHERE ms.cancelled_admission='N' AND ms.is_detained='N' AND ms.admission_session ='2020' AND  ms.academic_year ='2020' AND ms.enrollment_no !='' 
 GROUP BY vv.stream_name,ms.current_year
)  AS om ON om.stud_id=s.`stud_id`

LEFT JOIN (#COUNT(ms.stud_id) AS total_mh,staa.state_name,
 SELECT ms.stud_id,
                SUM(CASE WHEN ms.nationality='International' THEN 1 ELSE 0 END )AS totall_International
                


  FROM student_master AS ms
  LEFT JOIN vw_stream_details vv ON vv.stream_id=ms.admission_stream

 WHERE ms.cancelled_admission='N' AND ms.is_detained='N' AND ms.admission_session ='2020' AND  ms.academic_year ='2020' AND ms.enrollment_no !='' 
 GROUP BY vv.stream_name,ms.current_year
)  AS ni ON ni.stud_id=s.`stud_id`

LEFT JOIN (SELECT ms.stud_id,
                SUM(CASE WHEN ms.cancelled_admission='Y' THEN 1 ELSE 0 END )AS totall_cancle
                


  FROM student_master AS ms
  LEFT JOIN vw_stream_details vv ON vv.stream_id=ms.admission_stream
 WHERE   ms.is_detained='N' AND ms.admission_session ='2020' AND  ms.academic_year ='2020' AND ms.enrollment_no !='' 
 GROUP BY vv.stream_name,ms.current_year
)  AS cl ON cl.stud_id=s.`stud_id`


WHERE s.cancelled_admission='N' AND s.is_detained='N' AND s.admission_session ='2020' AND  s.academic_year ='2020' AND s.enrollment_no !='' 
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    function get_all_blog_details()
    {
		$this->db->select('*');
		$this->db->from('blog_master');
		$query=$this->db->get();
		$res=$query->result_array();
        return $res;

    }  

    function get_all_tag_details()
    {
    	$DB1 = $this->load->database('otherdb', TRUE);
		$DB1->select('*');
		$DB1->from('meta_details');
		//$DB1->where('id','305');
		$query=$DB1->get();
		$res=$query->result_array();
        return $res;
    }  

	function get_blog_details_byid($sid){

		$this->db->select('*');
		$this->db->from('blog_master');
		$this->db->where('blog_id',$sid);
		$query=$this->db->get();
		$res=$query->result_array();
        return $res;

	}

	function get_tag_details_byid($sid){
		$DB1 = $this->load->database('otherdb', TRUE);
		$DB1->select('*');
		$DB1->from('meta_details');
		$DB1->where('id',$sid);
		$query=$DB1->get();
		$res=$query->result_array();
        return $res;

	}

	function insert_blog_details($post){	

		
$arr['blog_title']=(stripslashes($post['blog_title']));
$arr['des_thumb']=(stripslashes($post['des_thumb']));
$arr['description']=(($post['description']));
$arr['blog_image']=(stripslashes($post['blog_image']));
$arr['image_alt_title']=(stripslashes($post['image_alt_title']));
$arr['blog_date']=date('Y-m-d',strtotime($post['blog_date']));
$arr['is_active']='Y';
//$insert_array=array("school_name"=>$post['school_name'],"event_description"=>$post['event_description'],"event_date"=>$post['event_date'].':00',"event_to_date"=>$post['event_to_date'].':00' ,"image_url"=>$post['event_image'],"school_id"=>$post['school_id'],"eventfor"=>$eventfor);                                                               

       $ins =  $this->db->insert("blog_master",$arr); 
//echo $this->db->last_query();exit;
       return $ins;   

	}

	function insert_tag_details($post){	
  	$DB1 = $this->load->database('otherdb', TRUE);
  	$arr['created_by'] = $this->session->userdata('uid');
    $arr['created_on'] = date('Y-m-d H:i:s');	
	$arr['title']=(stripslashes($post['Tag_title']));
	$arr['desc']=(stripslashes($post['description']));
	$arr['keyword']=(($post['Keywords']));
	$arr['custom_script']=htmlentities($post['customscript'], ENT_QUOTES);
	$arr['url']=(stripslashes($post['url']));
	$arr['is_active']='1';
    $ins =  $DB1->insert("meta_details",$arr); 
//echo $this->db->last_query();exit;
     return $ins;   

	}

	function update_tag_details($post)
	{
		$DB1 =$this->load->database('otherdb',TRUE);
		$aa_update['updated_by']=$this->session->userdata('uid');
		$aa_update['updated_on']=date('Y-m-d H:i:s');
		$aa_update['title']=(stripslashes($post['Tag_title']));
		$aa_update['desc']=(stripslashes($post['description']));
		$aa_update['keyword']=($post['Keywords']);
		$aa_update['custom_script']=htmlentities($post['customscript'], ENT_QUOTES);
		$aa_update['url']=(stripslashes($post['url']));
		$DB1->where('id',$post['Tag_id']);
		$DB1->update('meta_details',$aa_update);
		return 1;

	}

	public function delete_tag_details($sid)
	{
		$DB1 =$this->load->database('otherdb',TRUE);
		$DB1->where('id',$sid);
		$DB1->delete('meta_details');
		return 1;
	}

	function update_blog_details($post){

		
		$arr['blog_title']=nl2br((stripslashes($post['blog_title'])));

		$arr['des_thumb']=nl2br((stripslashes($post['des_thumb'])));
		//echo (stripslashes($post['des_thumb']));
		//$arr['description']=nl2br((stripslashes($post['description'])));

		$arr['description']=nl2br((($post['description'])));
		/*echo "<br/>";
		echo (stripslashes($post['description']));
		die;*/
		$arr['blog_image']=(($post['blog_image']));
		$arr['image_alt_title']=(stripslashes($post['image_alt_title']));
		$arr['blog_date']=date('Y-m-d',strtotime($post['blog_date']));

         $this->db->where('blog_id', $post['blog_id']);

		 $this->db->update("blog_master", $arr);		

		return 1;

		

	}

	 function get_all_school_course()
    {
    	$DB1 = $this->load->database('otherdb', TRUE);
		$DB1->select('scw.*,sm.school_name,spn.sprogramm_name');
		$DB1->from('school_course_website_link as scw ');
		$DB1->join('school_master as sm','sm.school_id=scw.school_id','left');
		$DB1->join('school_programs_new as spn','spn.sp_id=scw.course_id','left');
		$DB1->where('sm.active','Y');
		$DB1->group_by('scw.school_id,scw.course_id');

		$query=$DB1->get();
		$res=$query->result_array();
        return $res;
    }  

    function get_all_school(){
		$DB1 = $this->load->database('otherdb', TRUE);
		$DB1->select('*');
		$DB1->from('school_master');
		$DB1->where('active','Y');
		$query=$DB1->get();
		$res=$query->result_array();
        return $res;

	}

	function load_course($data){

		$DB1 = $this->load->database('otherdb', TRUE); 
		$sql="SELECT * FROM school_programs_new where school_id='".$data['school']."'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
		return $res =  $query->result_array();  
	}

	function insert_url_details($post){	
  	$DB1 = $this->load->database('otherdb', TRUE);
  	$arr['created_by'] = $this->session->userdata('uid');
    $arr['created_date'] = date('Y-m-d H:i:s');	
	$arr['school_id']=(stripslashes($post['school']));
	$arr['course_id']=(stripslashes($post['course']));
	$arr['url']=(($post['url']));
	$arr['status']='Y';
    $ins =  $DB1->insert("school_course_website_link",$arr); 
//echo $this->db->last_query();exit;
     return $ins;   

	}
	function get_url_details_byid($sid){
		$DB1 = $this->load->database('otherdb', TRUE);
		$DB1->select('*');
		$DB1->from('school_course_website_link');
		$DB1->where('id',$sid);
		$query=$DB1->get();
		$res=$query->result_array();
        return $res;

	}

	function update_website_url_details($post)
	{
		$DB1 =$this->load->database('otherdb',TRUE);
		$aa_update['updated_by']=$this->session->userdata('uid');
		$aa_update['updated_date']=date('Y-m-d H:i:s');
		$aa_update['school_id']=(stripslashes($post['school']));
		$aa_update['course_id']=(stripslashes($post['course']));
		$aa_update['url']=(($post['url']));
		$aa_update['status']='Y';
		$DB1->where('id',$post['websiteurl_id']);
		$DB1->update('school_course_website_link',$aa_update);
		return 1;

	}


	

}