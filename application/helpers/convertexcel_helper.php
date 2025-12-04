<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CSV Helpers
 * Inspiration from PHP Cookbook by David Sklar and Adam Trachtenberg
 * 
 * @author		Jérôme Jaglale
 * @link		http://maestric.com/en/doc/php/codeigniter_csv
 */

// ------------------------------------------------------------------------

/**
 * Array to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('array_to_csv'))
{
	function array_to_csv($array,$filename,$trep,$title,$dt)
	{
		$CI =& get_instance();
     $CI->load->library('excel'); 
	 
	 $CIS =& get_instance();
     $CIS->load->model('Staff_payment_model'); 
		header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  $filename1 = $filename.".xls";
	  header('Content-Disposition: attachment;filename="'.$filename1.'"');
	  
	  
	   
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

        $styleArray3 = array(
    'font'  => array(
        'size'  => 8,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'LEFT' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));

$CI->excel->setActiveSheetIndex(0);
        $CI->excel->getActiveSheet()->setTitle($filename);
		if($trep=='salary_reg'){
			$CI->excel->getActiveSheet()->mergeCells('A1:AI1');
			$CI->excel->getActiveSheet()->getStyle('A1:AI1')->getFont()->setBold(true);
			$CI->excel->getActiveSheet()->getStyle('A1:AI1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$CI->excel->getActiveSheet()->setCellValue('A1', 'SANDIP UNIVERSITY');
			$CI->excel->getActiveSheet()->mergeCells('A2:AI2');        
			$CI->excel->getActiveSheet()->getStyle('A2:AI2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$CI->excel->getActiveSheet()->setCellValue('A2', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
			$CI->excel->getActiveSheet()->mergeCells('A3:AI3');  
			$CI->excel->getActiveSheet()->getStyle('A3:AI3')->getFont()->setBold(true);      
			$CI->excel->getActiveSheet()->getStyle('A3:AI3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$CI->excel->getActiveSheet()->setCellValue('A3', 'SALARY REGISTER FOR THE MONTH OF '.date('M Y',strtotime($dt)));
		  
			$CI->excel->getActiveSheet()->getStyle('A6:AI6')->applyFromArray($styleArray1);
			$CI->excel->getActiveSheet()->getStyle('A7:AI7')->applyFromArray($styleArray1);
			$CI->excel->getActiveSheet()->mergeCells('A6:A7');
			$CI->excel->getActiveSheet()->getStyle('A6:A7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('B6:B7');
			$CI->excel->getActiveSheet()->getStyle('B6:B7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('C6:C7');
			$CI->excel->getActiveSheet()->getStyle('C6:C7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('D6:D7');
			$CI->excel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('E6:E7'); 
			$CI->excel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('F6:F7'); 
			$CI->excel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('G6:G7'); 
			$CI->excel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('H6:H7'); 
			$CI->excel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('I6:I7'); 
			$CI->excel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->mergeCells('J6:R6'); 
			$CI->excel->getActiveSheet()->setCellValue('J6', 'Earnings');	 
			$CI->excel->getActiveSheet()->getStyle('J6:R6')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->getStyle('J6:R6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$CI->excel->getActiveSheet()->mergeCells('J6:R6');			
			$CI->excel->getActiveSheet()->setCellValue('J6', 'Earnings');	 
			$CI->excel->getActiveSheet()->getStyle('J6:R6')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->getStyle('J6:R6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$CI->excel->getActiveSheet()->mergeCells('S6:S7'); 
			$CI->excel->getActiveSheet()->setCellValue('S6', 'Gross Salary');
			$CI->excel->getActiveSheet()->getStyle('S6:S7')->applyFromArray($styleArray);

			$CI->excel->getActiveSheet()->mergeCells('T6:V6'); 
			$CI->excel->getActiveSheet()->setCellValue('T6', 'CTC SALARY');	 
			$CI->excel->getActiveSheet()->getStyle('T6:V6')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->getStyle('T6:V6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$CI->excel->getActiveSheet()->mergeCells('W6:AF6'); 
			$CI->excel->getActiveSheet()->setCellValue('W6', 'Deduction');	
			$CI->excel->getActiveSheet()->getStyle('W6')->applyFromArray($styleArray);	
			$CI->excel->getActiveSheet()->getStyle('W6:AF6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$CI->excel->getActiveSheet()->getStyle('W6:AF6')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->mergeCells('AG6:AG7');		
			$CI->excel->getActiveSheet()->setCellValue('AG6', 'Totol Ded.');
			$CI->excel->getActiveSheet()->getStyle('AG6:AG7')->applyFromArray($styleArray);	
			$CI->excel->getActiveSheet()->getStyle('AG6:AG7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$CI->excel->getActiveSheet()->mergeCells('AH6:AH7');
			$CI->excel->getActiveSheet()->setCellValue('AH6', 'Net Salary');
			$CI->excel->getActiveSheet()->getStyle('AH6:AH7')->applyFromArray($styleArray);	
			$CI->excel->getActiveSheet()->getStyle('AH6:AH7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$CI->excel->getActiveSheet()->mergeCells('AI6:AI7');
			$CI->excel->getActiveSheet()->setCellValue('AI6', 'Remark');
			$CI->excel->getActiveSheet()->getStyle('AI6:AI7')->applyFromArray($styleArray);	
			$CI->excel->getActiveSheet()->getStyle('AI6:AI7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			
			$CI->excel->getActiveSheet()->setCellValue('A6', 'Sr.no');
			$CI->excel->getActiveSheet()->setCellValue('B6', 'Staff ID');
			$CI->excel->getActiveSheet()->setCellValue('C6', 'Name of Staff');
			$CI->excel->getActiveSheet()->setCellValue('D6', 'Designation');
			$CI->excel->getActiveSheet()->setCellValue('E6', 'Pay Band');
			$CI->excel->getActiveSheet()->setCellValue('F6', 'Basic');
			$CI->excel->getActiveSheet()->setCellValue('G6', 'Sex');
			$CI->excel->getActiveSheet()->setCellValue('H6', 'M.Days');
			$CI->excel->getActiveSheet()->setCellValue('I6', 'P.Days');
			$CI->excel->getActiveSheet()->setCellValue('J7', 'Basic');
			$CI->excel->getActiveSheet()->getStyle('J7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('K7', 'DP');
			$CI->excel->getActiveSheet()->getStyle('K7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('L7', 'DA');
			$CI->excel->getActiveSheet()->getStyle('L7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('M7', 'HRA');
			$CI->excel->getActiveSheet()->getStyle('M7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('N7', 'TA');
			$CI->excel->getActiveSheet()->getStyle('N7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('O7', 'INCREMIENT.');
			$CI->excel->getActiveSheet()->getStyle('O7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('P7', 'DIFF.');
			$CI->excel->getActiveSheet()->getStyle('P7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('Q7', 'OtherAllow.');
			$CI->excel->getActiveSheet()->getStyle('Q7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('R7', 'Special Allow.');	  
			$CI->excel->getActiveSheet()->getStyle('R7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('T7', 'Gratuity');
			$CI->excel->getActiveSheet()->getStyle('T7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('U7', 'ER EPF');
			$CI->excel->getActiveSheet()->getStyle('U7')->applyFromArray($styleArray);
			$CI->excel->getActiveSheet()->setCellValue('V7', 'Total CTC');
			$CI->excel->getActiveSheet()->getStyle('V7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('W7', 'EPF');
			$CI->excel->getActiveSheet()->getStyle('W7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('X7', 'Gratuity');
			$CI->excel->getActiveSheet()->getStyle('X7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('Y7', 'ER EPF');
			$CI->excel->getActiveSheet()->getStyle('Y7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('Z7', 'PTAX');
			$CI->excel->getActiveSheet()->getStyle('Z7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('AA7', 'TDS');
			$CI->excel->getActiveSheet()->getStyle('AA7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('AB7', 'BUS');
			$CI->excel->getActiveSheet()->getStyle('AB7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('AC7', 'MOBILE');
			$CI->excel->getActiveSheet()->getStyle('AC7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('AD7', 'Co-Op.Soc.');
			$CI->excel->getActiveSheet()->getStyle('AD7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('AE7', 'Office Adv.');
			$CI->excel->getActiveSheet()->getStyle('AE7')->applyFromArray($styleArray);
			
			$CI->excel->getActiveSheet()->setCellValue('AF7', 'Other/ Adv.');	
			$CI->excel->getActiveSheet()->getStyle('AF7')->applyFromArray($styleArray);
			

		$i=1;
		  $j=8;
			$CI->excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setWrapText(true);
			  $CI->excel->getActiveSheet()->getColumnDimension('E7')->setAutoSize(TRUE);
			$CI->excel->getActiveSheet()->getColumnDimension('C')->setWidth("25");
		   $tgross = array();$tepf=array();$tptax=array();$ttds=array();$tbus=array();$tmobile=array();$tsoc=array();$toffadv=array();$tothadv=array();$tdet=array();$tnet=array();
		   $d_mo = cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($dt)),date('Y',strtotime($dt)));
		   foreach($array as $val){
			   if(!empty($val['pay_band_min'])&&!empty($val['pay_band_max'])&&!empty($val['pay_band_gt'])){
						$pband = $val['pay_band_min']."-".$val['pay_band_max']."+AGP ".$val['pay_band_gt'];
					}else{
					   $pband = $val['basic_salary']; 
					}
						if($val['gender']=='male'){ 
						$m = 'M';
						$ms = 'Mr.';
						}elseif($val['gender']=='female'){  
						$m = 'F'; 
						$ms = 'Mrs.';
						}
				//if($val['staff_type']==3)
				$deg = $CIS->Staff_payment_model->getDesignationById($val['designation']);
			   $CI->excel->getActiveSheet()->setCellValue('A'.$j, $i);
				$CI->excel->getActiveSheet()->getStyle('A'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);		   
				$CI->excel->getActiveSheet()->setCellValue('B'.$j, $val['emp_id']);
				$CI->excel->getActiveSheet()->getStyle('B'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('C'.$j,
				$ms." ".$val['fname']." ".$val['mname']." ".$val['lname']);
				$CI->excel->getActiveSheet()->getStyle('C'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray3);	
				 $CI->excel->getActiveSheet()->setCellValue('D'.$j, $deg[0]['designation_name']);
				$CI->excel->getActiveSheet()->getStyle('D'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('E'.$j, $pband );
				$CI->excel->getActiveSheet()->getStyle('E'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	


				$CI->excel->getActiveSheet()->setCellValue('F'.$j, $val['basic_salary']);
				$CI->excel->getActiveSheet()->getStyle('F'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('G'.$j, $m);
				$CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('H'.$j, $d_mo);
				$CI->excel->getActiveSheet()->getStyle('H'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('I'.$j, $val['pdays']);
				$CI->excel->getActiveSheet()->getStyle('I'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('J'.$j, $tot_bas[] = $val['basic_sal']);
				$CI->excel->getActiveSheet()->getStyle('J'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('K'.$j, $tot_dp[] = $val['dp']);
				$CI->excel->getActiveSheet()->getStyle('K'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('L'.$j, $tot_da[] = $val['da']);
				$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('M'.$j, $tot_hra[] = $val['hra']);
				$CI->excel->getActiveSheet()->getStyle('M'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('N'.$j, $tot_ta[] = $val['ta']);
				$CI->excel->getActiveSheet()->getStyle('N'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('O'.$j, $tot_incriment[] = $val['incriment']);
				$CI->excel->getActiveSheet()->getStyle('O'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('P'.$j, $tot_diff[] = $val['difference']);
				$CI->excel->getActiveSheet()->getStyle('P'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('Q'.$j, $tot_othd[] = $val['other_allowance']);
				$CI->excel->getActiveSheet()->getStyle('Q'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('R'.$j, $tot_spa[] = $val['special_allowance']);
				$CI->excel->getActiveSheet()->getStyle('R'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->getStyle('S'.$j)->getFont()->setBold(true);
				$CI->excel->getActiveSheet()->setCellValue('S'.$j, $tot_gross[] = $val['gross']);
				$CI->excel->getActiveSheet()->getStyle('S'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
				
				$CI->excel->getActiveSheet()->getStyle('T'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);				
				$CI->excel->getActiveSheet()->setCellValue('T'.$j, $gratuity[] = $val['gratuity']);
				$CI->excel->getActiveSheet()->getStyle('U'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('U'.$j, $tot_epf_er[] = $val['epf_er']);
				$CI->excel->getActiveSheet()->getStyle('V'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);	
				$CI->excel->getActiveSheet()->setCellValue('V'.$j, $tot_ctc[] = $val['ctc']);
				
				$CI->excel->getActiveSheet()->getStyle('W'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('W'.$j, $tot_epf[] = $val['epf']);
				$CI->excel->getActiveSheet()->getStyle('X'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);				
				$CI->excel->getActiveSheet()->setCellValue('X'.$j, $gratuity[] = $val['gratuity']);
				$CI->excel->getActiveSheet()->getStyle('Y'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('Y'.$j, $tot_epf_er[] = $val['epf_er']);
				$CI->excel->getActiveSheet()->getStyle('Z'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('Z'.$j, $tot_ptax[] = $val['ptax']);
				$CI->excel->getActiveSheet()->getStyle('AA'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('AA'.$j, $tot_tds[] = $val['TDS']);
				$CI->excel->getActiveSheet()->getStyle('AB'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('AB'.$j, $bus_fare[] = $val['bus_fare']);
				$CI->excel->getActiveSheet()->getStyle('AC'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('AC'.$j, $tot_mobf[] = $val['mobile_bill']);
				$CI->excel->getActiveSheet()->getStyle('AD'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('AD'.$j, $tot_cos[] = $val['co_op_society']);
				$CI->excel->getActiveSheet()->getStyle('AE'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				$CI->excel->getActiveSheet()->setCellValue('AE'.$j, $tot_offa[] = $val['Off_Adv']);
				$CI->excel->getActiveSheet()->getStyle('AF'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);									
				$CI->excel->getActiveSheet()->setCellValue('AF'.$j, $tot_otha[] = $val['other_advance']);
				$CI->excel->getActiveSheet()->getStyle('AF'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);	
				
				$CI->excel->getActiveSheet()->setCellValue('AG'.$j, $tot_ded[] = $val['total_deduct']);
				$CI->excel->getActiveSheet()->getStyle('AG'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);	
				
				$CI->excel->getActiveSheet()->setCellValue('AH'.$j, $tot_finsal[] = $val['final_net_sal']);
				$CI->excel->getActiveSheet()->getStyle('AH'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);						
			  //  $CI->excel->getActiveSheet()->getStyle('Z'.$j)->getFont()->setBold(true);
			   $tgross[] = $val['gross'];
			   $tepf[] = $val['epf'];
			   $tptax[]=$val['ptax'];
			   $ttds[]=$val['TDS'];
			   $tbus[]=$val['bus_fare'];
			   $tmobile[]=$val['mobile_bill'];
			   $tsoc[]=$val['co_op_society'];
			   $toffadv[]=$val['Off_Adv'];
			   $tothadv[]=$val['other_advance'];
			   $tdet[]=$val['total_deduct'];
			   $tnet[]=$val['final_net_sal'];
			   $tot_ctc[]=$val['ctc'];
			   $j=$j+1;
			   $i=$i+1;
			//}
			}
				$CI->excel->getActiveSheet()->getStyle('A'.$j.':AH'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);	
				$CI->excel->getActiveSheet()->mergeCells('A'.$j.':I'.$j)->setCellValue('A'.$j , 'Total');
				$CI->excel->getActiveSheet()->getStyle('A'.$j.':I'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$CI->excel->getActiveSheet()->getStyle('A'.$j.':AH'.$j)->getFont()->setBold(true);
				$CI->excel->getActiveSheet()->setCellValue('J'.$j ,array_sum($tot_bas));
				$CI->excel->getActiveSheet()->setCellValue('K'.$j ,array_sum($tot_dp));
				$CI->excel->getActiveSheet()->setCellValue('L'.$j ,array_sum($tot_da));
				$CI->excel->getActiveSheet()->setCellValue('M'.$j ,array_sum($tot_hra));
				$CI->excel->getActiveSheet()->setCellValue('N'.$j ,array_sum($tot_ta));
				$CI->excel->getActiveSheet()->setCellValue('O'.$j ,array_sum($tot_diff));
				$CI->excel->getActiveSheet()->setCellValue('P'.$j ,array_sum($tot_othd));
				$CI->excel->getActiveSheet()->setCellValue('Q'.$j ,array_sum($tot_spa));
				$CI->excel->getActiveSheet()->setCellValue('S'.$j ,array_sum($tot_gross));
				$CI->excel->getActiveSheet()->setCellValue('V'.$j ,array_sum($tot_ctc));
				$CI->excel->getActiveSheet()->setCellValue('W'.$j ,array_sum($tot_epf));
				$CI->excel->getActiveSheet()->setCellValue('Z'.$j ,array_sum($tot_ptax));
				$CI->excel->getActiveSheet()->setCellValue('AA'.$j ,array_sum($tot_tds));
				$CI->excel->getActiveSheet()->setCellValue('AB'.$j ,array_sum($bus_fare));
				$CI->excel->getActiveSheet()->setCellValue('AC'.$j ,array_sum($tot_mobf));
				$CI->excel->getActiveSheet()->setCellValue('AD'.$j ,array_sum($tot_cos));
				$CI->excel->getActiveSheet()->setCellValue('AE'.$j ,array_sum($tot_offa));
				$CI->excel->getActiveSheet()->setCellValue('AF'.$j ,array_sum($tot_otha));
				$CI->excel->getActiveSheet()->setCellValue('AG'.$j ,array_sum($tot_ded));
				$CI->excel->getActiveSheet()->setCellValue('AH'.$j ,array_sum($tot_finsal));
		   $j = $j+1;
			$k = $j + 1;
			$CI->excel->getActiveSheet()->getStyle('A'.$j.':AH'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);	
		   $CI->excel->getActiveSheet()->getStyle('A'.$k.':AH'.$k)->applyFromArray($styleArray)->applyFromArray($styleArray1);	
		   
		   
		   $CI->excel->getActiveSheet()->mergeCells('A'.$j.':B'.$k);
		   $CI->excel->getActiveSheet()->getStyle('A'.$j.':B'.$k)->applyFromArray($styleArray)->applyFromArray($styleArray1);	
			$CI->excel->getActiveSheet()->setCellValue('A'.$j , 'Total');
			$CI->excel->getActiveSheet()->getStyle('A'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);	
			$CI->excel->getActiveSheet()->mergeCells('C'.$j.':E'.$j);
			  $CI->excel->getActiveSheet()->setCellValue('C'.$j , 'Total Earnings');
			  $CI->excel->getActiveSheet()->getStyle('C'.$j.':E'.$j)->applyFromArray($styleArray1);	
		  $CI->excel->getActiveSheet()->setCellValue('C'.$k ,array_sum($tgross));
		  $CI->excel->getActiveSheet()->getStyle('C'.$k)->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('C'.$k.':E'.$k);		  
		$CI->excel->getActiveSheet()->mergeCells('F'.$j.':J'.$j);
		$CI->excel->getActiveSheet()->getStyle('F'.$j.':J'.$j)->applyFromArray($styleArray);
		$CI->excel->getActiveSheet()->setCellValue('F'.$j , 'EPF');
		$CI->excel->getActiveSheet()->getStyle('F'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);	
		$CI->excel->getActiveSheet()->mergeCells('F'.$k.':J'.$k);
		$CI->excel->getActiveSheet()->setCellValue('F'.$k , array_sum($tepf));
		$CI->excel->getActiveSheet()->getStyle('F'.$k)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('K'.$j.':M'.$j);
		$CI->excel->getActiveSheet()->setCellValue('K'.$j , 'PTAX');
		$CI->excel->getActiveSheet()->getStyle('K'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('K'.$k.':M'.$k);
		$CI->excel->getActiveSheet()->setCellValue('K'.$k , array_sum($tptax));
		$CI->excel->getActiveSheet()->getStyle('K'.$k)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('N'.$j.':P'.$j);
		$CI->excel->getActiveSheet()->setCellValue('N'.$j , 'TDS');
		$CI->excel->getActiveSheet()->getStyle('N'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('N'.$k.':P'.$k);
		$CI->excel->getActiveSheet()->setCellValue('N'.$k , array_sum($ttds));
		$CI->excel->getActiveSheet()->getStyle('N'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('Q'.$j.':S'.$j);
		$CI->excel->getActiveSheet()->setCellValue('Q'.$j , 'BUS FARE');
		$CI->excel->getActiveSheet()->getStyle('Q'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('Q'.$k.':S'.$k);
		$CI->excel->getActiveSheet()->setCellValue('Q'.$k , array_sum($tbus));
		$CI->excel->getActiveSheet()->getStyle('Q'.$k)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('T'.$j.':V'.$j);
		$CI->excel->getActiveSheet()->setCellValue('T'.$j , 'MOBILE');
		$CI->excel->getActiveSheet()->getStyle('T'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('T'.$k.':V'.$k);
		$CI->excel->getActiveSheet()->setCellValue('T'.$k , array_sum($tmobile));
		$CI->excel->getActiveSheet()->getStyle('T'.$k)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('U'.$j.':W'.$j);
		$CI->excel->getActiveSheet()->setCellValue('U'.$j , 'CO-OP.SOC');
		$CI->excel->getActiveSheet()->getStyle('U'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('U'.$k.':W'.$k);
		$CI->excel->getActiveSheet()->setCellValue('U'.$k , array_sum($tsoc));
		$CI->excel->getActiveSheet()->getStyle('U'.$k)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('X'.$j.':Z'.$j);
		$CI->excel->getActiveSheet()->setCellValue('X'.$j , 'OFFICE ADV.');
		$CI->excel->getActiveSheet()->getStyle('X'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('X'.$k.':Z'.$k);
		$CI->excel->getActiveSheet()->setCellValue('X'.$k , array_sum($toffadv));
		$CI->excel->getActiveSheet()->getStyle('X'.$k)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('AA'.$j.':AC'.$j);
		$CI->excel->getActiveSheet()->setCellValue('AA'.$j , 'OTHER');
		$CI->excel->getActiveSheet()->getStyle('AA'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('AA'.$k.':AC'.$k);
		$CI->excel->getActiveSheet()->setCellValue('AA'.$k , array_sum($tothadv));
		$CI->excel->getActiveSheet()->getStyle('AA'.$k)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('AD'.$j.':AF'.$j);
		$CI->excel->getActiveSheet()->setCellValue('AD'.$j , 'TOTAL DEDUCTION');
		$CI->excel->getActiveSheet()->getStyle('AD'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('AD'.$k.':AF'.$k);
		$CI->excel->getActiveSheet()->setCellValue('AD'.$k , array_sum($tdet));
		$CI->excel->getActiveSheet()->getStyle('AD'.$k)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('AG'.$j.':AH'.$j);
		$CI->excel->getActiveSheet()->setCellValue('AG'.$j , 'Total Net Salary');
		$CI->excel->getActiveSheet()->getStyle('AG'.$j)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->mergeCells('AG'.$k.':AH'.$k);
		$CI->excel->getActiveSheet()->setCellValue('AG'.$k , array_sum($tnet));
		$CI->excel->getActiveSheet()->getStyle('AG'.$k)->applyFromArray($styleArray1);
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('test_img');
		$objDrawing->setDescription('test_img');
		$objDrawing->setPath('assets/images/logo_exl.jpg');
		$objDrawing->setCoordinates('B1');                      
		//setOffsetX works properly
		$objDrawing->setOffsetX(5); 
		$objDrawing->setOffsetY(5);                
		//set width, height
		$objDrawing->setWidth(80); 
		$objDrawing->setHeight(80); 
		$objDrawing->setWorksheet($CI->excel->getActiveSheet());
	}elseif($trep=='salary_soc' || $trep=='salary_attendance' || $trep=='salary_ptax' || $trep=='salary_busfare' || $trep=='salary_tds' || $trep=='salary_epf' || $trep=='salary_status' || $trep=='mobile_list' || $trep=='salary_bank'){
	
	

$CI->excel->getActiveSheet()->mergeCells('B2:H2');
        $CI->excel->getActiveSheet()->getStyle('B2:H2')->getFont()->setBold(true);
        $CI->excel->getActiveSheet()->getStyle('B2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$CI->excel->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
      $CI->excel->getActiveSheet()->mergeCells('B3:H3');        
        $CI->excel->getActiveSheet()->getStyle('B3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$CI->excel->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
      $CI->excel->getActiveSheet()->mergeCells('A6:H6');  
        $CI->excel->getActiveSheet()->getStyle('A6:H6')->getFont()->setBold(true);      
        $CI->excel->getActiveSheet()->getStyle('A6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$CI->excel->getActiveSheet()->setCellValue('A6', $title);
		
		 $CI->excel->getActiveSheet()->setCellValue('B8', 'Sr.no');
		 $CI->excel->getActiveSheet()->getStyle('B8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $CI->excel->getActiveSheet()->setCellValue('C8', 'Staff ID');
	  $CI->excel->getActiveSheet()->getStyle('C8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $CI->excel->getActiveSheet()->setCellValue('D8', 'Name of Staff');
	  $CI->excel->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	 $CI->excel->getActiveSheet()->setCellValue('E8','School');
	 $CI->excel->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $CI->excel->getActiveSheet()->setCellValue('F8','Department');
	 $CI->excel->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	
	  if($trep=='salary_attendance'){
	  $CI->excel->getActiveSheet()->setCellValue('G8', 'Days');
	  $CI->excel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  }elseif($trep=='salary_tds'){
		  
       		  $CI->excel->getActiveSheet()->setCellValue('G8', 'Gross Salary'); 
			  $CI->excel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $CI->excel->getActiveSheet()->setCellValue('H8', 'TDS Amount'); 
	  $CI->excel->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $CI->excel->getActiveSheet()->getColumnDimension('I')->setWidth("10");
	   $CI->excel->getActiveSheet()->setCellValue('I8', 'PAN No.'); 
	   $CI->excel->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  }elseif($trep=='salary_epf'){
		  
       		  $CI->excel->getActiveSheet()->setCellValue('G8', 'DOB'); 
     $CI->excel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1); 
	 $CI->excel->getActiveSheet()->setCellValue('H8', 'PF. No'); 
     $CI->excel->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $CI->excel->getActiveSheet()->setCellValue('I8', 'Applicable Salary'); 
	   $CI->excel->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	   $CI->excel->getActiveSheet()->setCellValue('J8', 'PF Amount.'); 
	    $CI->excel->getActiveSheet()->getStyle('J8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->setCellValue('K8', 'Present Days'); 
	    $CI->excel->getActiveSheet()->getStyle('K8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->setCellValue('L8', 'Actual GrossSalary'); 
	    $CI->excel->getActiveSheet()->getStyle('L8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->setCellValue('M8', 'Earned GrossSalary'); 
	    $CI->excel->getActiveSheet()->getStyle('M8')->applyFromArray($styleArray)->applyFromArray($styleArray1);

	 
	  }elseif($trep=='mobile_list'){
$CI->excel->getActiveSheet()->setCellValue('G8', 'Mobile No.'); 
		 $CI->excel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	
	$CI->excel->getActiveSheet()->setCellValue('H8', 'Limit'); 
		 $CI->excel->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	
	  }elseif($trep=='salary_bank'){
		$CI->excel->getActiveSheet()->setCellValue('G8', 'Account No.');
		$CI->excel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$CI->excel->getActiveSheet()->setCellValue('H8', 'Net Pay');
		$CI->excel->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  }else{
		 $CI->excel->getActiveSheet()->setCellValue('G8', 'Amount'); 
		 $CI->excel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  }
//$CI->excel->getActiveSheet()->getStyle('A8:D8')->getFont()->setBold(true);
	
	  $j=9;
	  $i=1;
	  $tsoc = array();
	  $am =&get_instance();
   $am->load->model('admin_model');

	  $CI->excel->getActiveSheet()->getColumnDimension('D')->setWidth("25");
	  foreach($array as $val){
		  if($val['gender']=='male'){
                                       $html1 = 'Mr.';
									   }else if($val['gender']=='female'){ 
									   $html1 = 'Mrs.';}
									   $department =  $am->admin_model->getDepartmentById($val['department']); 
								 $school =  $am->admin_model->getSchoolById($val['emp_school']);
	    $CI->excel->getActiveSheet()->setCellValue('B'.$j, $i);		
		$CI->excel->getActiveSheet()->getStyle('B'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		  
		  $CI->excel->getActiveSheet()->setCellValue('C'.$j, $val['emp_id']);
		   $CI->excel->getActiveSheet()->getStyle('C'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		   $CI->excel->getActiveSheet()->setCellValue('D'.$j, $html1." ".$val['fname']." ".$val['mname']." ".$val['lname'] );
		   $CI->excel->getActiveSheet()->getStyle('D'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	  $CI->excel->getActiveSheet()->setCellValue('E'.$j, $school[0]['college_code'] );
		   $CI->excel->getActiveSheet()->getStyle('E'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	  $CI->excel->getActiveSheet()->setCellValue('F'.$j, $department[0]['department_name'] );
		   $CI->excel->getActiveSheet()->getStyle('F'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	  

	  if($trep=='salary_attendance'){
		   $CI->excel->getActiveSheet()->setCellValue('G'.$j, $val['Total'] );
		   		   $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	 $tsoc[] = $val['Total'];
	  }elseif($trep=='salary_ptax'){
		   $CI->excel->getActiveSheet()->setCellValue('G'.$j, $val['ptax'] );
		   		   $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	 $tsoc[] = $val['ptax'];
	  }elseif($trep=='salary_busfare'){
		   $CI->excel->getActiveSheet()->setCellValue('G'.$j, $val['bus_fare'] );
		   		   $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	 $tsoc[] = $val['bus_fare'];
	  }elseif($trep=='salary_tds'){
		  
		  $CI->excel->getActiveSheet()->setCellValue('G'.$j, $val['gross'] );
		  		   $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		   $CI->excel->getActiveSheet()->setCellValue('H'.$j, $val['TDS'] );
		   		   $CI->excel->getActiveSheet()->getStyle('H'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		   $CI->excel->getActiveSheet()->setCellValue('I'.$j, $val['pan_no'] );
		   		   $CI->excel->getActiveSheet()->getStyle('I'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	 $tsoc[] = $val['TDS'];
	  }elseif($trep=='salary_epf'){
		    $dob=date('d/m/Y', strtotime($val['date_of_birth'])); 
		  $CI->excel->getActiveSheet()->setCellValue('G'.$j, $dob );
		  $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		  $CI->excel->getActiveSheet()->setCellValue('H'.$j, $val['pf_no'] );
		  $CI->excel->getActiveSheet()->getStyle('H'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		   if($val['epf']=='1800'){
			 $CI->excel->getActiveSheet()->setCellValue('I'.$j, '15,000' );	
		   $CI->excel->getActiveSheet()->getStyle('I'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);			 
		   }else{
		   $CI->excel->getActiveSheet()->setCellValue('I'.$j, $val['basic_sal'] );
		   		   $CI->excel->getActiveSheet()->getStyle('I'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		   }
		   $CI->excel->getActiveSheet()->setCellValue('J'.$j, $val['epf'] );
		   $CI->excel->getActiveSheet()->getStyle('J'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		   $CI->excel->getActiveSheet()->setCellValue('K'.$j, $val['pdays'] );
		   $CI->excel->getActiveSheet()->getStyle('K'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		   $CI->excel->getActiveSheet()->setCellValue('L'.$j, $val['gross'] );
		   $CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
		   $CI->excel->getActiveSheet()->setCellValue('M'.$j, $val['final_net_sal'] );
		   $CI->excel->getActiveSheet()->getStyle('M'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	 $tsoc[] = $val['epf'];

	  }elseif($trep=='salary_status'){
 $CI->excel->getActiveSheet()->setCellValue('G'.$j, $val['final_net_sal'] );
	  $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	  $CI->excel->getActiveSheet()->setCellValue('H'.$j, $val['rel_status'] );
	  $CI->excel->getActiveSheet()->getStyle('H'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	 
	  }elseif($trep=='mobile_list'){
	  	 $CI->excel->getActiveSheet()->setCellValue('G'.$j, $val['mobile'] );
	  $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	  $CI->excel->getActiveSheet()->setCellValue('H'.$j, $val['mobile_limit'] );
	  $CI->excel->getActiveSheet()->getStyle('H'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	
	  }elseif($trep=='salary_bank'){
		$CI->excel->getActiveSheet()->setCellValue('G'.$j, $val['bank_acc_no']);
	  $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	  $CI->excel->getActiveSheet()->setCellValue('H'.$j, $val['final_net_sal']);
	  $CI->excel->getActiveSheet()->getStyle('H'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	  
	  }else{
	  $CI->excel->getActiveSheet()->setCellValue('G'.$j, $val['co_op_society'] );
	  $CI->excel->getActiveSheet()->getStyle('G'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	  $tsoc[] = $val['co_op_society'];
	  }
	 
	  $i++;
	  $j++;
	  }
	  if($trep!='salary_attendance' ){
	  	if($trep!='mobile_list'){
	  $k=$j+1;
//$CI->excel->getActiveSheet()->getStyle('A'.$k.':E'.$k)->getFont()->setBold(true);

		  $CI->excel->getActiveSheet()->mergeCells('B'.$k.':C'.$k);  
	$CI->excel->getActiveSheet()->setCellValue('B'.$k, 'TOTAL STAFF:- '.count($tsoc));
	$CI->excel->getActiveSheet()->getStyle('B'.$k)->applyFromArray($styleArray1);
	$CI->excel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->applyFromArray($styleArray)->applyFromArray($styleArray1);
      $CI->excel->getActiveSheet()->mergeCells('D'.$k.':E'.$k);  
	$CI->excel->getActiveSheet()->setCellValue('D'.$k, 'TOTAL AMOUNT IN RS. :-'.array_sum($tsoc));
	$CI->excel->getActiveSheet()->getStyle('D'.$k)->applyFromArray($styleArray1);
	$CI->excel->getActiveSheet()->getStyle('D'.$k.':E'.$k)->applyFromArray($styleArray);
      }}
	  
// 	  $objDrawing = new PHPExcel_Worksheet_Drawing();
// $objDrawing->setName('test_img');
// $objDrawing->setDescription('test_img');
// $objDrawing->setPath('assets/images/logo_exl.jpg');
// $objDrawing->setCoordinates('A1');                      
// //setOffsetX works properly
// $objDrawing->setOffsetX(5); 
// $objDrawing->setOffsetY(5);                
// //set width, height
// $objDrawing->setWidth(80); 
// $objDrawing->setHeight(80); 
// $objDrawing->setWorksheet($CI->excel->getActiveSheet());
	  
	}
	
	
		  $objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');
		$objWriter->setPreCalculateFormulas(true);      
		
		
			echo $objWriter->save('php://output');
				
	}
}

// ------------------------------------------------------------------------

/**
 * Query to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('query_to_csv'))
{
	function query_to_csv($query, $headers = TRUE, $download = "")
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('invalid query');
		}
		
		$array = array();
		
		if ($headers)
		{
			$line = array();
			foreach ($query->list_fields() as $name)
			{
				$line[] = $name;
			}
			$array[] = $line;
		}
		
		foreach ($query->result_array() as $row)
		{
			$line = array();
			foreach ($row as $item)
			{
				$line[] = $item;
			}
			$array[] = $line;
		}

		echo array_to_csv($array, $download);
	}
}

/* End of file csv_helper.php */
/* Location: ./system/helpers/csv_helper.php */