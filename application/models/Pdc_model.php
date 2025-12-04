<?php
class Pdc_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        $DB1 = $this->load->database('umsdb', TRUE); 
    }
    
  /*  function  get_pdc_details($pdc_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($pdc_id!="")
        {
            $where.=" AND pdc_id='".$pdc_id."'";
        }
        
        $sql="select pdc_id,pdc_code,pdc_name,pdc_type,duration,status From pdc_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } */

    function  get_pdc_details()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where=" WHERE 1=1 ";  
        
        
        $sql="select pdc.amount,pdc.enrollment_no,pdc.chq_dd_no,pdc.pdc_id,pdc.chq_dd_date,pdc.deposite_status,pdc.remark,pdc.deposited_on,pdc.encash_status,pdc.encashed_on,sm.first_name,sm.middle_name,sm.last_name,vsd.school_name,vsd.stream_name,sm.academic_year,sm.admission_semester,bm.bank_name from pdc_details as pdc join student_master as sm on sm.stud_id= pdc.student_id join  vw_stream_details as vsd on sm.admission_stream = vsd.stream_id join bank_master as bm on bm.bank_id=pdc.chq_bank_id where pdc.is_deleted='N' order by pdc_id desc ";
      
       
        $query = $DB1->query($sql); 
        if($query !== FALSE && $query->num_rows() > 0){
            foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }

    return $data;
    } 
    
    function  get_pdc_details_search($pdc_id='')
    {
         $DB1 = $this->load->database('umsdb', TRUE);
        $where=" WHERE 1=1 and  pdc.is_deleted='N' ";  
        
        if($pdc_id!="")
        {
            $where.=" AND pdc_id='".$pdc_id."' and pdc.is_deleted='N'";
        }
        
        $sql="select pdc.*,sm.first_name From pdc_details as pdc join student_master as sm on sm.stud_id=pdc.student_id $where ";
       
        $query = $DB1->query($sql); 
        if($query !== FALSE && $query->num_rows() > 0){
            foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        }

    return $data;
    }


       function  get_pdc_studentdetails($studentid='')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        //$where=" WHERE 1=1 "; 

        if($studentid!="")
        {
            $where =" AND student_id='".$studentid."' and pdc.is_deleted='N'";
        } 
        
        
        $sql="select pdc.amount,pdc.chq_dd_no,pdc.pdc_id,pdc.chq_dd_date,pdc.deposite_status,pdc.remark,pdc.deposited_on,pdc.encash_status,pdc.encashed_on,sm.first_name,sm.last_name,vsd.school_name,vsd.stream_name,sm.academic_year,sm.admission_semester,bm.bank_name from pdc_details as pdc join student_master as sm on sm.stud_id= pdc.student_id join  vw_stream_details as vsd on sm.admission_stream = vsd.stream_id join bank_master as bm on bm.bank_id=pdc.chq_bank_id where pdc.is_deleted='N' ".$where." order by pdc_id desc ";
      
       
        $query = $DB1->query($sql); 
        if($query !== FALSE && $query->num_rows() > 0){
            foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }

    return $data;
    } 
       function searchstudentmaster($prn){

        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select("sm.*,stm.stream_name,cm.course_name");
        $DB1->from('student_master as sm');
    //  $DB1->join('couse_master as scm','d.emp_id = e.emp_id','left'); 
        $DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
        $DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
        $DB1->where("sm.enrollment_no",$prn);
        $DB1->where("sm.cancelled_admission",'N');
        //$DB1->where("sm.admission_session",'2019');             
    
        $DB1->order_by("sm.enrollment_no", "asc");
        $query=$DB1->get();
         /* echo $DB1->last_query();
        exit(0);*/
        $result=$query->result_array();
        /*echo $DB1->last_query();
        
         die();*/
    //  $result=$query->result_array();
        return $result;
    }

    function bank_master(){

        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select("bank_id,bank_name");
        $DB1->from('bank_master');
        $DB1->where("active",'Y');             
        $DB1->order_by("bank_name", "asc");
        $query=$DB1->get();
        $result=$query->result_array();
        return $result;
    }

    public function add_pdc($post_array,$picture)
    {


       /*   ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/ 

            $DB1 = $this->load->database('umsdb', TRUE); 
            $insertdata=array('student_id'=>$post_array['student_id'],
            'enrollment_no'=>$post_array['prn'],
            'fees_paid_type'=>'CHQ',
            'type_id'=>'2',
            'chq_dd_no'=>$post_array['chk_no'],
            'amount'=>$post_array['amount'],
            'chq_dd_date'=>$post_array['idate'],
            'chq_bank_id'=>$post_array['bank_name'],
            'chq_bank_city'=>$post_array['city_name'],
            'academic_year'=>$post_array['academic_year'],
            'entry_from_ip'=>$this->input->ip_address(),
            'created_by'=>$this->session->userdata('uid'),
            'created_on'=>date('Y-m-d H:i:s'),
            'remark'=>$post_array['remark'],
             'chq_dd_file'=>$picture
    
    );
            
           
        $DB1->insert('pdc_details',$insertdata);
        $insert_id1 = $DB1->insert_id();
        return $insert_id1;

    }

    public function edit_pdc($post_array,$picture)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
            $updatedata=array('student_id'=>$post_array['student_id'],
            'enrollment_no'=>$post_array['prn'],
            'fees_paid_type'=>'CHQ',
            'type_id'=>'2',
            'chq_dd_no'=>$post_array['chk_no'],
            'amount'=>$post_array['amount'],
            'chq_dd_date'=>$post_array['idate'],
            'chq_bank_id'=>$post_array['bank_name'],
            'chq_bank_city'=>$post_array['city_name'],
            'academic_year'=>$post_array['academic_year'],
            'entry_from_ip'=>$this->input->ip_address(),
            'created_by'=>$this->session->userdata('uid'),
            'created_on'=>date('Y-m-d H:i:s'),
            'remark'=>$post_array['remark'],
             'chq_dd_file'=>$picture);
            $DB1->where('pdc_id',$post_array['pdc_idd']);
            $update= $DB1->update('pdc_details',$updatedata);
           
            return $update;

    }

    public function change_pdc_status($pdcid,$status)
    {
         $DB1 = $this->load->database('umsdb', TRUE); 
         if($status=='deposite_status')
         {
            $updatedata=array('deposite_status'=>'Y',
            'deposited_on'=>date('Y-m-d H:i:s'));
         }
         else
         {
            $updatedata=array('encash_status'=>'Y',
            'encashed_on'=>date('Y-m-d H:i:s'));
         }
          
          $DB1->where('pdc_id',$pdcid);
            $update= $DB1->update('pdc_details',$updatedata);
           
            return $update;
    }

    public function delete_pdc_status($pdcid)
    {
         $DB1 = $this->load->database('umsdb', TRUE); 
        
            $updatedata=array('is_deleted'=>'Y',
           );
          
            $DB1->where('pdc_id',$pdcid);
            $update= $DB1->update('pdc_details',$updatedata);
           
            return $update;
    }

    public function Encash_pdc_status_remark($post_array)
    {
            $DB1 = $this->load->database('umsdb', TRUE); 
            if($post_array['yesdata']=='Yes')
            {
                $updatedata=array('encash_status'=>'Y',
                'encashed_on'=>date('Y-m-d H:i:s'),
                'remark'=>htmlspecialchars($post_array['inputMessage']));
            }
            else
            {
                $updatedata=array('encash_status'=>'N',
                    'encashed_on'=>date('Y-m-d H:i:s'),
                    'remark'=>htmlspecialchars($post_array['inputMessage']));
            }
            
            $DB1->where('pdc_id',$post_array['getpdcid']);
            $update= $DB1->update('pdc_details',$updatedata);
            return $update;
    }
}