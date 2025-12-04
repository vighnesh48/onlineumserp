<?php

class Revalphd_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    } 
	
//Revalidate result
    function get_stud_result_subjects($stud_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);  
        $sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_component,sm.subject_code1,sm.semester, e.cia_marks,e.exam_marks,e.final_grade, eas.exam_subject_id,ed.exam_master_id,eas.reval_appeared,eas.photocopy_appeared,ed.reval_fees,ed.photocopy_fees FROM `phd_exam_result_data` as e 
left join subject_master sm on sm.sub_id=e.subject_id 
left join phd_exam_details ed on e.student_id=ed.stud_id and e.exam_id=ed.exam_id 
left join phd_exam_applied_subjects eas on e.exam_id=eas.exam_id and eas.stud_id=e.student_id and eas.subject_id=e.subject_id
where e.student_id='".$stud_id."' and e.exam_id='$exam_id' order by sm.subject_order";        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // revalidation list
    function get_revalidation_list($stream_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$reval = $this->session->userdata('reval');  		
        if($reval==0){
            $type_appeared = "photocopy_appeared";
            $type_appeared1 = "photocpy_appeared";
			$type_id=9;
        }else{
            $type_appeared = "reval_appeared";
            $type_appeared1 = "reval_appeared";
			$type_id=8;
        } 

        $sql = "select distinct ed.stud_id,s.first_name as stud_name,s.enrollment_no,ed.semester,vw.stream_short_name,ed.reval_fees, ed.photocopy_fees,ed.reval_fees,x.sub_cnt ,ed.exam_month,ed.exam_year,f.amount 
from phd_exam_details as ed 
left join student_master s on s.stud_id = ed.stud_id 
left join vw_stream_details vw on vw.stream_id = ed.stream_id 
left join fees_details f on f.student_id = ed.stud_id and f.exam_session=ed.exam_id and f.type_id='$type_id'
inner join (SELECT stud_id as studid, count(*) as sub_cnt FROM `phd_exam_applied_subjects` WHERE $type_appeared = 'Y' group by studid) x on studid=ed.stud_id        where ed.exam_id='".$exam_id."' and ed.$type_appeared1='Y'"; 
        if($stream_id !=0){
            $sql .=" AND ed.stream_id='".$stream_id."'";
        }    
        $sql .=" order by ed.stud_id asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    //
        function get_stud_reval_subjects($stud_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata("role_id");
		if($role_id ==4){
			$reval = REVAL;
		}else{
			$reval = $this->session->userdata('reval');
		}
        $sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_component,sm.subject_code1,sm.semester, eas.cia_marks,eas.exam_marks,eas.final_grade, e.reval_appeared,e.photocopy_appeared,ed.reval_fees,ed.photocopy_fees FROM `phd_exam_applied_subjects` as e left join phd_exam_result_data eas on e.exam_id=eas.exam_id and eas.student_id=e.stud_id and eas.subject_id=e.subject_id left join subject_master sm on sm.sub_id=e.subject_id left join phd_exam_details ed on e.stud_id=ed.stud_id and e.exam_id=ed.exam_id 
where e.stud_id='".$stud_id."' and e.exam_id='$exam_id'  ";
        if($reval==0){
            $sql .= "and e.photocopy_appeared='Y'";
        }else{
            $sql .= "and e.reval_appeared='Y'";
        }        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_exam_session_for_reval(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type,exam_name");
		$DB1->from('phd_exam_session');
		$DB1->where("active_for_reval", 'Y');
		$DB1->where("is_active", 'Y');	
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
	// get_summary_stream_list 
    function get_summary_stream_list($stream_id, $exam_id,$reval_type){
        $DB1 = $this->load->database('umsdb', TRUE);  
        $sql="SELECT DISTINCT e.`stream_id`, v.stream_name FROM `phd_exam_applied_subjects` e LEFT JOIN vw_stream_details v on v.stream_id=e.stream_id WHERE e.exam_id='$exam_id' "; 
		if($reval_type==0){
			$sql .=" AND e.photocopy_appeared='Y'";
		}else{
			$sql .=" AND e.reval_appeared='Y'";
		}
        if($stream_id !=0){
            $sql .=" and e.stream_id='$stream_id'";
        }  
        $sql .=" ORDER BY v.stream_name";     
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // get_summary_subject_list 
    function get_summary_subject_list($stream_id, $exam_id, $reval_type){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct ess.subject_id,ess.semester,sm.subject_name, sm.subject_code FROM phd_exam_applied_subjects ess 
left join subject_master sm on sm.sub_id=ess.subject_id
WHERE ess.`stream_id` = '$stream_id'  and ess.exam_id='$exam_id'";
if($reval_type==0){
	$sql .=" AND ess.photocopy_appeared='Y'";
}else{
	$sql .=" AND ess.reval_appeared='Y'";
}
$sql .="  ORDER BY sm.subject_order";
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    }  
    //fetch_revalsub_students 
    function fetch_revalsub_students($stream_id,$subject_id, $exam_id, $reval_type){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct ess.stud_id,ess.semester,s.enrollment_no,UPPER(CONCAT(s.first_name,' ',s.middle_name,' ',s.last_name)) as stud_name FROM phd_exam_applied_subjects ess 
left join student_master s on s.stud_id=ess.stud_id
WHERE ess.`stream_id` = '$stream_id' and ess.subject_id='$subject_id' and ess.exam_id='$exam_id' ";
if($reval_type==0){
	$sql .=" AND ess.photocopy_appeared='Y'";
}else{
	$sql .=" AND ess.reval_appeared='Y'";
}
$sql .=" ORDER BY s.enrollment_no";
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    } 	
    function get_stud_photocopy_subjects($stud_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);  
        $sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_component,sm.subject_code1,sm.semester, e.cia_marks,e.exam_marks,e.final_grade, eas.exam_subject_id,ed.exam_master_id,eas.reval_appeared,eas.photocopy_appeared,ed.reval_fees,ed.photocopy_fees FROM `phd_exam_result_data` as e 
left join subject_master sm on sm.sub_id=e.subject_id 
left join phd_exam_details ed on e.student_id=ed.stud_id and e.exam_id=ed.exam_id 
left join phd_exam_applied_subjects eas on e.exam_id=eas.exam_id and eas.stud_id=e.student_id and eas.subject_id=e.subject_id
where e.student_id='".$stud_id."' and e.exam_id='$exam_id' and eas.photocopy_appeared='Y' order by sm.subject_order";        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }

function get_stud_photocopy_reval_subjects($stud_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);  
        $sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_component,sm.subject_code1,sm.semester, eas.cia_marks,eas.exam_marks,eas.final_grade, e.reval_appeared,e.photocopy_appeared,ed.reval_fees,ed.photocopy_fees FROM `phd_exam_applied_subjects` as e left join phd_exam_result_data eas on e.exam_id=eas.exam_id and eas.student_id=e.stud_id and eas.subject_id=e.subject_id left join subject_master sm on sm.sub_id=e.subject_id left join phd_exam_details ed on e.stud_id=ed.stud_id and e.exam_id=ed.exam_id 
where e.stud_id='".$stud_id."' and e.exam_id='$exam_id'  and e.reval_appeared='Y'";        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// rval student details
    function get_revalidation_studdetails($stud_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$reval = $this->session->userdata('reval');  		
        if($reval==0){
            $type_appeared = "photocopy_appeared";
            $type_appeared1 = "photocpy_appeared";
        }else{
            $type_appeared = "reval_appeared";
            $type_appeared1 = "reval_appeared";
        } 
        $sql = "select distinct ed.stud_id,s.enrollment_no,UPPER(CONCAT(s.first_name,' ',s.middle_name,' ',s.last_name)) as stud_name,ed.semester,vw.stream_short_name,ed.reval_fees, ed.photocopy_fees,ed.reval_fees,x.sub_cnt ,ed.exam_month,ed.exam_year 
from phd_exam_details as ed 
left join student_master s on s.stud_id = ed.stud_id 
left join vw_stream_details vw on vw.stream_id = ed.stream_id 
inner join (SELECT stud_id as studid, count(*) as sub_cnt FROM `phd_exam_applied_subjects` WHERE $type_appeared = 'Y' group by studid) x on studid=ed.stud_id        where ed.exam_id='".$exam_id."' and ed.$type_appeared1='Y' and ed.stud_id='$stud_id'"; 
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
// fees
	function pay_revalexam_fee($data, $payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
		$feedet['student_id']=$data['stud_id'];
		$feedet['amount']=$data['paidfee'];
		if($reval==0){
            $feedet['type_id']=9;
        }else{
            $feedet['type_id']=8;
        }
		
		$feedet['fees_paid_type']=$data['payment_type'];
		$feedet['academic_year']= $data['academic_year'];
				
		$feedet['receipt_no']=$data['dd_no'];
		$feedet['fees_date']=$data['dd_date']; 
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
		$feedet['exam_fee_fine']=$data['ffine'];
		$feedet['exam_session']=$data['exam_session'];
		$feedet['remark']=$data['remark'];
		$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];	
		$feedet['college_receiptno']=$data['clreceipt'];
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//print_r($feedet);exit;
		$DB1->insert('fees_details',$feedet);   
		
		//echo $DB1->last_query();exit;
		return true;
		
	}	
	public function fetch_revalfees_details($studId,$exam)
	{
		if($reval==0){
            $type_id=9;
        }else{
            $type_id=8;
        }
		$DB1 = $this->load->database('umsdb', TRUE);
    	$DB1->select("f.fees_paid_type,f.fees_id,f.canc_charges,f.chq_cancelled,f.exam_fee_fine, f.receipt_no,
		f.receipt_file, f.fees_date, b.bank_name, f.bank_city, f.amount as amt_paid, b.bank_name,f.college_receiptno");
		$DB1->from('fees_details as f');
		$DB1->join('bank_master b','f.bank_id = b.bank_id','left');

		//$DB1->where('fid.no_of_installment >', 1);
		$DB1->where('f.student_id', $studId);
		$DB1->where('f.exam_session', $exam);
		$DB1->where('f.type_id', $type_id);
		$DB1->where('f.is_deleted', 'N');
		$DB1->order_by("f.fees_id", "ASC");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}	
}
?>