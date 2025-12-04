<?php

$this->load->library('excel'); 
	  header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  header('Content-Disposition: attachment;filename="Employee_list_test.xls"');
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
	 'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'F28A8C')
        ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
		
		$styleArray2 = array(
    'font'  => array(
        'size'  => 9,
        'name'  => 'Calibri'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
		
		 $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
          ));		

	  $rowlb=2;
	  $object = new PHPExcel();
                  $object->setActiveSheetIndex(0);
				  $object->getActiveSheet()->mergeCells('A1:D1');
				  $object->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
				  $object->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				  $object->setActiveSheetIndex(0);
				  $object->getActiveSheet()->mergeCells('A3:D3');
				  $object->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true);
				  $object->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				  $object->getActiveSheet()->mergeCells('A4:D4');
				  $object->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);
				  $object->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				  $object->getActiveSheet()->mergeCells('A46:D46');
				  $object->getActiveSheet()->mergeCells('A47:D47');
				  $object->getActiveSheet()->mergeCells('A48:D48');
				  $object->getActiveSheet()->getStyle('A13:D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				  
				  /*  $object->getActiveSheet()->getStyle('A13:D45')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  */
				  
				  $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				  $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				  $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				  $object->getActiveSheet()->getColumnDimension('B14')->setAutoSize(true);

					
				  $object->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
				  $object->getActiveSheet()->getStyle('A1:D1')->applyFromArray($style);
				  $object->getActiveSheet()->getStyle('A13:D45')->applyFromArray($styleArray);
					
				$object->getActiveSheet()->setCellValue('A'.($rowlb-1), 'SANDIP FOUNDATION');
				$object->getActiveSheet()->setCellValue('A'.($rowlb+1), 'ADVANCE COMPUTATION OF INCOME TAX');
				 $object->getActiveSheet()->setCellValue('A'.($rowlb+2), 'FOR THE FINANCIAL YEAR '.FINANCIAL_YEAR.''); 
				 
				$object->getActiveSheet()->setCellValue('A6', 'NAME OF THE EMPLOYEE :' .$tax_cred_det['fname'].' '.$tax_cred_det['mname'].' '.$tax_cred_det['lname'].'');
				$object->getActiveSheet()->setCellValue('A7', 'DESIGNATION  :'.$tax_cred_det['designation_name'].'');
				$object->getActiveSheet()->setCellValue('C7', 'STAFF ID :');
				$object->getActiveSheet()->setCellValue('D7', $tax_cred_det['emp_id']);
				$object->getActiveSheet()->setCellValue('A8', 'PAN NO. (MANDATORY) :'.$tax_cred_det['pan_no'].'');
				$object->getActiveSheet()->setCellValue('A9', 'DATE OF JOINING (REQUIRED ONLY IF JOINED ON OR AFTER 1ST APRIL 2023) :'.$tax_cred_det['joiningDate']);
				$object->getActiveSheet()->setCellValue('A10', 'CONTACT NO. (MANDATORY): '.$tax_cred_det['mobileNumber'].'');
				$object->getActiveSheet()->setCellValue('A13', 'SR. NO.');
				$object->getActiveSheet()->setCellValue('B13', 'INVESTMENT DESCRIPTION ');
				$object->getActiveSheet()->setCellValue('C13', 'SECTION');
				$object->getActiveSheet()->setCellValue('D13', 'AMOUNT (RS.)');
				
                $texta="'HOUSE RENT (Relief provided against submission Rent agreement. If rent agreement is not available <br /> Please attach Rent Self Declaration & Declaration from Landlord. Monthly Rent _______ No. of Months_____'";
				$texta = str_replace("<br />", "\n", $texta);
				$object->getActiveSheet()->setCellValue('A14', '1');
				$object->getActiveSheet()->setCellValue('B14', $texta);
				$object->getActiveSheet()->setCellValue('C14', '10 (13A)');
				$object->getActiveSheet()->setCellValue('D14', $tax_details[0]['house_rent_amount']);
				
				$textb="INTEREST ON HOUSING LOAN. Maximum Limit for Self Occupied Property Rs. 200,000/- <br /> (before 1-4-1999) & Rs. 1,50,000/-(from 1-4-1999) (Submit Certificate received from <br /> Financial Institution/ Banks immediately). OWNERSHIP : JOINT OR SOLE'";
				$textb = str_replace("<br />", "\n", $textb);
				$object->getActiveSheet()->setCellValue('A15', '2');
				$object->getActiveSheet()->setCellValue('B15', $textb);
				$object->getActiveSheet()->setCellValue('C15', '24(1)(vi)');
				$object->getActiveSheet()->setCellValue('D15', $tax_details[0]['house_loan_interest_amount']);
				
				$object->getActiveSheet()->setCellValue('A16', '3');
				$object->getActiveSheet()->setCellValue('B16', 'A. VPF Contribution');
				$object->getActiveSheet()->setCellValue('C16', '80C');
				$object->getActiveSheet()->setCellValue('D16', $tax_details[0]['vpf_amount']);
				
				$object->getActiveSheet()->setCellValue('B17', 'B. Public Provident Fund (PPF)');
				$object->getActiveSheet()->setCellValue('C17', '80C');
				$object->getActiveSheet()->setCellValue('D17',$tax_details[0]['provident_fund_amount']);
				
				$object->getActiveSheet()->setCellValue('B18', 'C. Senior Citizen’s Saving Scheme (SCSS)');
				$object->getActiveSheet()->setCellValue('C18', '80C');
				$object->getActiveSheet()->setCellValue('D18', $tax_details[0]['scss_amount']);
				
				$object->getActiveSheet()->setCellValue('B19', 'D. N.S.C (Investment + accrued Interest before Maturity Year)');
				$object->getActiveSheet()->setCellValue('C19', '80C');
				$object->getActiveSheet()->setCellValue('D19', $tax_details[0]['nsc_amount']);
				
				$object->getActiveSheet()->setCellValue('B20', 'E. Tax Saving Fixed Deposit (5 Years and above)');
				$object->getActiveSheet()->setCellValue('C20', '80C');
				$object->getActiveSheet()->setCellValue('D20', $tax_details[0]['txfd_amount']);
				
				$object->getActiveSheet()->setCellValue('B21', 'F. Tax Savings Bonds');
				$object->getActiveSheet()->setCellValue('C21', '80C');
				$object->getActiveSheet()->setCellValue('D21', $tax_details[0]['tax_bond_amount']);
				
				$object->getActiveSheet()->setCellValue('B22', 'G. E.L.S.S (Tax Saving Mutual Fund)');
				$object->getActiveSheet()->setCellValue('C22', '80C');
				$object->getActiveSheet()->setCellValue('D22', $tax_details[0]['elss_amount']);
				
				$object->getActiveSheet()->setCellValue('B23', 'H. Life Insurance Premiums');
				$object->getActiveSheet()->setCellValue('C23', '80C');
				$object->getActiveSheet()->setCellValue('D23', $tax_details[0]['life_ins_prem_amount']);
				
				$object->getActiveSheet()->setCellValue('B24', 'I. New Pension Scheme (NPS) (u/s 80CCC)');
				$object->getActiveSheet()->setCellValue('C24', '80C');
				$object->getActiveSheet()->setCellValue('D24', $tax_details[0]['nps_80c_amount']);
				
				$object->getActiveSheet()->setCellValue('B25', 'J. Pension Plan from Insurance Companies/Mutual Funds (u/s 80CCC)');
				$object->getActiveSheet()->setCellValue('C25', '80C');
				$object->getActiveSheet()->setCellValue('D25', $tax_details[0]['pension_plan_amount']);
				
				$object->getActiveSheet()->setCellValue('B26', 'K. 80 CCD Central Govt. Employees Pension Plan (u/s 80CCD)');
				$object->getActiveSheet()->setCellValue('C26', '80C');
				$object->getActiveSheet()->setCellValue('D26', $tax_details[0]['emp_pension_amount']);
				
				$object->getActiveSheet()->setCellValue('B27', 'L. Housing. Loan (Principal Repayment)');
				$object->getActiveSheet()->setCellValue('C27', '80C');
				$object->getActiveSheet()->setCellValue('D27', $tax_details[0]['houseloan_prin_repay_amount']);
				
				$object->getActiveSheet()->setCellValue('B28', 'M. Sukanya Samriddhi Account ');
				$object->getActiveSheet()->setCellValue('C28', '80C');
				$object->getActiveSheet()->setCellValue('D28', $tax_details[0]['suk_sam_acc_amount']);
				
				$object->getActiveSheet()->setCellValue('B29', 'N. Stamp Duty & Registration Charges');
				$object->getActiveSheet()->setCellValue('C29', '80C');
				$object->getActiveSheet()->setCellValue('D29', $tax_details[0]['stamp_duty_amount']);
				
				$object->getActiveSheet()->setCellValue('B30', 'O. Tuition fees for 2 children');
				$object->getActiveSheet()->setCellValue('C30', '80C');
				$object->getActiveSheet()->setCellValue('D30', $tax_details[0]['tuition_fee_amount']);
				
				$object->getActiveSheet()->setCellValue('B31', 'P. OTHER (PLEASE SPECIFY)');
				$object->getActiveSheet()->setCellValue('C31', '80C');
				$object->getActiveSheet()->setCellValue('D31', $tax_details[0]['other_amount']);
				
				$object->getActiveSheet()->setCellValue('B32', 'Grand Total of Sr. No. 3 for rebate under section 80c');
				$object->getActiveSheet()->setCellValue('C32', '80C');
				$object->getActiveSheet()->setCellValue('D32', $tax_details[0]['total_80c']);
				
				$object->getActiveSheet()->setCellValue('A33', '4');
				$object->getActiveSheet()->setCellValue('B33', 'New Pension Scheme (NPS)');
				$object->getActiveSheet()->setCellValue('C33', '80CCC');
				$object->getActiveSheet()->setCellValue('D33', $tax_details[0]['nps_amount']);
				
				
				$textc="MEDICAL PREMIUM (For Self, Spouse, Dependent Childred & Parents) Max Rs. 25,000/ - & Rs. 50,000/- in case <br /> of premium on the health of Dependents above 65 years old otherwise of Rs. 25,000/-";
				$textc = str_replace("<br />", "\n", $textc);
				$object->getActiveSheet()->setCellValue('A34', '5');
				$object->getActiveSheet()->setCellValue('B34', $textc);
				$object->getActiveSheet()->setCellValue('C34', '80D');
				$object->getActiveSheet()->setCellValue('D34', $tax_details[0]['medical_premium_amount']);
				
				$textd="EXPENDITURE ON HANDICAPPED DEPENDENTS/ Deposit made for maintenance of handicapped Dependents<br /> (LIC, UTI etc.) Adhoc amount of Rs. 75,000/- & disability exceeding 80% the deduction will be Rs. 125,000/- <br />(attach Govt. hospital medical certificate)";
				$textd = str_replace("<br />", "\n", $textd);
				$object->getActiveSheet()->setCellValue('A35', '6');
				$object->getActiveSheet()->setCellValue('B35', $textd);
				$object->getActiveSheet()->setCellValue('C35', '80DD');
				$object->getActiveSheet()->setCellValue('D35', $tax_details[0]['expenditure_amount']);
				
				$texte="MEDICAL EXPENSES proposed to be incurred ON SPECIFIED DISEASES (Bill to be submitted by 31-12-2023)<br /> {AIDS, Cancer, Thalassaemia, Hemophilia, Chronic Renal Failure, Chronic Nero-logical Diseases) Max Rs. 40,000/- <br /> & Rs. 1,00,000/- in case aged above 65 years. (attach Govt. hospitals Medical Certificate)";
				$texte = str_replace("<br />", "\n", $texte);
				$object->getActiveSheet()->setCellValue('A36', '7');
				$object->getActiveSheet()->setCellValue('B36', $texte);
				$object->getActiveSheet()->setCellValue('C36', '80DDB');
				$object->getActiveSheet()->setCellValue('D36', $tax_details[0]['medical_exp_amount']);
				
				$object->getActiveSheet()->setCellValue('A37', '8');
				$object->getActiveSheet()->setCellValue('B37', 'INTEREST ON EDUCATION LOAN (for self education)');
				$object->getActiveSheet()->setCellValue('C37', '80E');
				$object->getActiveSheet()->setCellValue('D37', $tax_details[0]['edu_loan_amount']);
				
				$object->getActiveSheet()->setCellValue('A38', '9');
				$object->getActiveSheet()->setCellValue('B38', 'DONATION TO CERTAIN FUNDS (as prescribed by GOI ) - please specify separately');
				$object->getActiveSheet()->setCellValue('C38', '80G');
				$object->getActiveSheet()->setCellValue('D38', $tax_details[0]['certain_funds_amount']);
				
				$textf="PERMANENT DISABILITY BENEFIT (SELF) Adhoc deduction of Rs. 75,000/- & Rs. 125,000/- in case of disability<br /> exceeding 80% (attach Govt. Hospital Medical Certificate)";
				$textf = str_replace("<br />", "\n", $textf);
				$object->getActiveSheet()->setCellValue('A39', '10');
				$object->getActiveSheet()->setCellValue('B39', $textf);
				$object->getActiveSheet()->setCellValue('C39', '80U');
				$object->getActiveSheet()->setCellValue('D39', $tax_details[0]['disability_ben_amount']);
				
				$object->getActiveSheet()->setCellValue('A40', '11');
				$object->getActiveSheet()->setCellValue('B40', 'Interest on First Electric Vehicle and Loan taken in 2019 - 2023?');
				$object->getActiveSheet()->setCellValue('C40', '80EEB');
				$object->getActiveSheet()->setCellValue('D40', $tax_details[0]['medical_exp_amount']);
				
				$textg="Previous Employment Salary earned from 1/4/2023 to Date of Joining (if yes, attach <br /> Form 16 or Form 12 B with tax computation)";
				$textg = str_replace("<br />", "\n", $textg);
				$object->getActiveSheet()->setCellValue('A41', '12');
				$object->getActiveSheet()->setCellValue('B41', $textg);
				$object->getActiveSheet()->setCellValue('C41', '80EEB');
				$object->getActiveSheet()->setCellValue('D41', $tax_details[0]['vehical_loan_amount']);
				

				$object->getActiveSheet()->setCellValue('B42', 'A) GROSS SALARY______________        B) P.T.______________ ');
				
				$object->getActiveSheet()->setCellValue('B43', 'C)T.D.S.______________                    D)EPF______________ ');
				
				$object->getActiveSheet()->setCellValue('B44', 'E) T.A or Conveyance ');
				
                $object->getActiveSheet()->setCellValue('A46', 'I hereby declare that the information given above is correct and true in all respects'); 
				 
				 $texth="I also undertake that, proposed investment mentioned above will be completed on or before 10th Jan 2024 and relevant proofs will be submitted to accounts department before -";
				//$texth = str_replace("<br />", "\n", $texth);
				$object->getActiveSheet()->setCellValue('A47', $texth); 
				$object->getActiveSheet()->setCellValue('A48',"  10th Jan 2024 for final computation of income tax for the year ".FINANCIAL_YEAR."."); 
				
				$object->getActiveSheet()->setCellValue('A51', '(SIGNATURE OF EMPLOYEE)');
				
				$object->getActiveSheet()->setCellValue('A52', 'Date:');
				 
               $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
               $objWriter->setPreCalculateFormulas(true);      
			 		
		 echo $objWriter->save('php://output');

?>