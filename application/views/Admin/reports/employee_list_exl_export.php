<?php

$this->load->library('excel'); 
				header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  header('Content-Disposition: attachment;filename="Employee_list.xls"');
	  $styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );
$styleArray1 = array(
    'font'  => array(
        'bold'  => true,       
        'size'  => 8,
        'name'  => 'Arial'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
		
		$styleArray2 = array(
    'font'  => array(
        'size'  => 8,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
	  $object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->mergeCells('B2:AR2');
		$object->getActiveSheet()->getStyle('B2:AR2')->getFont()->setBold(true);
		$object->getActiveSheet()->getStyle('B2:AR2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
		$object->getActiveSheet()->mergeCells('B3:AR3');        
		$object->getActiveSheet()->getStyle('B3:AR3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
		$object->getActiveSheet()->mergeCells('B7:AR7');  
		$object->getActiveSheet()->getStyle('B7:AR7')->getFont()->setBold(true);      
		$object->getActiveSheet()->getStyle('B7:AR7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B7', 'Employee List');
		$object->getActiveSheet()->setCellValue('B8', 'Sr.no');
		$object->getActiveSheet()->getStyle('B8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('C8', 'Emp ID');
		$object->getActiveSheet()->getStyle('C8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('D8', 'Name');
		$object->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('E8', 'Gender');
		$object->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('F8', 'School');
		$object->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('G8', 'Department');
		$object->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('H8', 'Designation');
		$object->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('I8', 'Staff Type');
		$object->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('J8', 'Joining Date');
		$object->getActiveSheet()->getStyle('J8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('K8', 'Personal Email Id');
		$object->getActiveSheet()->getStyle('K8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('L8', 'Official Email Id');
		$object->getActiveSheet()->getStyle('L8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('M8', 'Mobile No');
		$object->getActiveSheet()->getStyle('M8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('N8', 'Blood Group');
		$object->getActiveSheet()->getStyle('N8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('O8', 'Scale Type');
		$object->getActiveSheet()->getStyle('O8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('P8', 'Pay Band');
		$object->getActiveSheet()->getStyle('P8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('Q8', 'Date of Birth');
		$object->getActiveSheet()->getStyle('Q8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('R8', 'PAN No');
		$object->getActiveSheet()->getStyle('R8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('S8', 'UAN/PF No');
		$object->getActiveSheet()->getStyle('S8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('T8', 'Aadhar Number');
		$object->getActiveSheet()->getStyle('T8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('U8', 'Category');
		$object->getActiveSheet()->getStyle('U8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('V8', 'Cast');
		$object->getActiveSheet()->getStyle('V8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('W8', 'Sub Cast');
		$object->getActiveSheet()->getStyle('W8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('X8', 'Qualification');
		$object->getActiveSheet()->getStyle('X8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('Y8', 'Physical Status');
		$object->getActiveSheet()->getStyle('Y8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('Z8', 'PF Status');
		$object->getActiveSheet()->getStyle('Z8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AA8', 'Weekly Off');
		$object->getActiveSheet()->getStyle('AA8')->applyFromArray($styleArray)->applyFromArray($styleArray1);	
		$object->getActiveSheet()->setCellValue('AB8', 'Industrial Experience');
		$object->getActiveSheet()->getStyle('AB8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AC8', 'Total Experience');
		$object->getActiveSheet()->getStyle('AC8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AD8', 'Bank Account No.');
		$object->getActiveSheet()->getStyle('AD8')->applyFromArray($styleArray)->applyFromArray($styleArray1);$object->getActiveSheet()->setCellValue('AE8', 'Local Address');
		$object->getActiveSheet()->setCellValue('AE8', 'Local Address');
		$object->getActiveSheet()->getStyle('AE8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AF8', 'Local Taluka');
		$object->getActiveSheet()->getStyle('AF8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AG8', 'Local Dist/City');
		$object->getActiveSheet()->getStyle('AG8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AH8', 'Local Pin Code');
		$object->getActiveSheet()->getStyle('AH8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AI8', 'Local State');
		$object->getActiveSheet()->getStyle('AI8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AJ8', 'Local Country');
		$object->getActiveSheet()->getStyle('AJ8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AK8', 'Permanent Address');
		$object->getActiveSheet()->getStyle('AK8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AL8', 'Permanent Taluka');
		$object->getActiveSheet()->getStyle('AL8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AM8', 'Permanent Dist/City');
		$object->getActiveSheet()->getStyle('AM8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AN8', 'Permanent Pin Code');
		$object->getActiveSheet()->getStyle('AN8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AO8', 'Permanent State');
		$object->getActiveSheet()->getStyle('AO8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AP8', 'Permanent Country');
		$object->getActiveSheet()->getStyle('AP8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AQ8', 'Resignation Date');
		$object->getActiveSheet()->getStyle('AQ8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AR8', 'Experience');
		$object->getActiveSheet()->getStyle('AR8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AS8', 'Hiring type');
		$object->getActiveSheet()->getStyle('AS8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AT8', 'Hiring type');
		$object->getActiveSheet()->getStyle('AT8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('AU8', 'IFSC code');
		$object->getActiveSheet()->getStyle('AU8')->applyFromArray($styleArray)->applyFromArray($styleArray1);

		
		$i=1;
		$j=9;
	  foreach($emp_list as $val){
		  $school = $this->Admin_model->getSchoolById($val['emp_school']);
		  $department =  $this->Admin_model->getDepartmentById($val['department']); 
		  $desig = $this->Admin_model->getDesignationById($val['designation']);
		  $styp = $this->Admin_model->getAllEmpCategoryById($val['staff_type']);
		   $object->getActiveSheet()->setCellValue('B'.$j, $i);
$object->getActiveSheet()->getStyle('B'.$j.':AU'.$j)->applyFromArray($styleArray);
$object->getActiveSheet()->setCellValue('C'.$j, $val['emp_id']);
$object->getActiveSheet()->setCellValue('D'.$j, $val['fname']." ".$val['mname']." ".$val['lname']);
$object->getActiveSheet()->setCellValue('E'.$j, $val['gender']);
$object->getActiveSheet()->setCellValue('F'.$j, $school[0]['college_code']);
$object->getActiveSheet()->setCellValue('G'.$j, $department[0]['department_name']);
$object->getActiveSheet()->setCellValue('H'.$j, $desig[0]['designation_name']);
$object->getActiveSheet()->setCellValue('I'.$j, $styp[0]['emp_cat_name']);
$object->getActiveSheet()->setCellValue('J'.$j, date('d-m-Y',strtotime($val['joiningDate'])));
$object->getActiveSheet()->setCellValue('K'.$j, $val['pemail']);
$object->getActiveSheet()->setCellValue('L'.$j, $val['oemail']);
$object->getActiveSheet()->setCellValue('M'.$j, $val['mobileNumber']);
$object->getActiveSheet()->setCellValue('N'.$j, $val['blood_gr']);
$object->getActiveSheet()->setCellValue('O'.$j, $val['scaletype']);
if(!empty($val['pay_band_min1'])&&!empty($val['pay_band_max1'])&&!empty($val['pay_band_gt1'])){
$object->getActiveSheet()->setCellValue('P'.$j, $val['pay_band_min1']."-".$val['pay_band_max1']."+AGP ".$val['pay_band_gt1']);
}else{
$object->getActiveSheet()->setCellValue('P'.$j, "NA" );
}
$object->getActiveSheet()->setCellValue('Q'.$j, date('d-m-Y',strtotime($val['date_of_birth'])));
$object->getActiveSheet()->setCellValue('R'.$j, $val['pan_no']);
$object->getActiveSheet()->setCellValue('S'.$j, $val['pf_no']);
$object->getActiveSheet()->setCellValue('T'.$j, $val['adhar_no']);
$object->getActiveSheet()->setCellValue('U'.$j, $val['category']);
$object->getActiveSheet()->setCellValue('V'.$j, $val['cast']);
$object->getActiveSheet()->setCellValue('W'.$j, $val['sub-cast']);
$object->getActiveSheet()->setCellValue('X'.$j, $val['qualifiaction']);
if($val['phy_status']=='0'){
$object->getActiveSheet()->setCellValue('Y'.$j, 'Y');
}else{
$object->getActiveSheet()->setCellValue('Y'.$j, 'N');	
}
if($val['pf_status']=='0'){
$object->getActiveSheet()->setCellValue('Z'.$j, 'Y');
}else{
$object->getActiveSheet()->setCellValue('Z'.$j, 'N');	
}
$object->getActiveSheet()->setCellValue('AA'.$j, $val['week_off']);

$object->getActiveSheet()->setCellValue('AB'.$j, $val['inexp_yr'].".".$val['inexp_mnth']."Yr");
$object->getActiveSheet()->setCellValue('AC'.$j, $val['texp_yr'].".".$val['texp_mnth']."Yr");
$object->getActiveSheet()->setCellValue('AD'.$j, $val['bank_acc_no']);
$object->getActiveSheet()->setCellValue('AE'.$j, $val['lflatno'].",".$val['larea_name']);
$object->getActiveSheet()->setCellValue('AF'.$j, $val['ltaluka']);
$ldist = $this->Admin_model->getCityByID($val['ldist']);
$object->getActiveSheet()->setCellValue('AG'.$j, $ldist);
$object->getActiveSheet()->setCellValue('AH'.$j, $val['lpincode']);
$lstate = $this->Admin_model->getStateByID($val['lstate']);
$object->getActiveSheet()->setCellValue('AI'.$j, $lstate);
$object->getActiveSheet()->setCellValue('AJ'.$j, $val['lcountry']);
$object->getActiveSheet()->setCellValue('AK'.$j, $val['pflatno'].",".$val['parea_name']);
$object->getActiveSheet()->setCellValue('AL'.$j, $val['ptaluka']);
$pdist = $this->Admin_model->getCityByID($val['pdist']);
$object->getActiveSheet()->setCellValue('AM'.$j, $pdist);
$object->getActiveSheet()->setCellValue('AN'.$j, $val['p_pincode']);
$pstate = $this->Admin_model->getStateByID($val['pstate']);
$object->getActiveSheet()->setCellValue('AO'.$j, $pstate);
$object->getActiveSheet()->setCellValue('AP'.$j, $val['pcountry']);
$object->getActiveSheet()->setCellValue('AQ'.$j, date('d-m-Y',strtotime($val['resign_date'])));


$date1 = $val['joiningDate'];
 $date2 = date("Y-m-d");
                                                            $diff = abs(strtotime($date2) - strtotime($date1));
                                                            $years = floor($diff / (365*60*60*24));
                                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
															
															$dur=$years." Years $months months $days days ";
		$object->getActiveSheet()->setCellValue('AR'.$j, $dur);													
         $object->getActiveSheet()->setCellValue('AS'.$j,$val['hiring_type']);	                                                  
$object->getActiveSheet()->setCellValue('AT'.$j, (($val['gratuity_status']==1) ?'Yes':'No'));
$object->getActiveSheet()->setCellValue('AU'.$j,$val['ifsc_code']);

$i++;
$j++;
	  }  
	  
	  
	  
	  
	  
	  
	  $objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
$objDrawing->setPath('assets/images/logo_exl.jpg');
$objDrawing->setCoordinates('R1');                      
//setOffsetX works properly
$objDrawing->setOffsetX(5); 
$objDrawing->setOffsetY(5);                
//set width, height
$objDrawing->setWidth(80); 
$objDrawing->setHeight(80); 
$objDrawing->setWorksheet($object->getActiveSheet());
			 $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		$objWriter->setPreCalculateFormulas(true);      
		
		
		
			echo $objWriter->save('php://output');


?>