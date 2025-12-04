function makeaction(val,emp_id){
	var post_data=actionvsal=empid='';
	post_data="ajax=1";
	post_data+="&actionvsal="+val+"&empid="+emp_id;
	jQuery.ajax({
			type: "POST",
			url: base_url+"Empdetail/update_empstatus",
		   	data: post_data,
			success: function(responce_data){
			location.reload(true);			
			}	
		});

}

function getlocation(compval){

	var post_data=comp_value='';
	post_data="ajax=1";
	post_data+="&comp_value="+compval;
	jQuery.ajax({
			type: "POST",
			url: base_url+"Empdetail/get_location",
		   	data: post_data,
			success: function(responce_data){
				$('#locdisp').html(responce_data);					
			}	
		});


}


function makeaction_delete(id){
	 var delitem=confirm("Are you sure to delete record?")
	 if (delitem) {
		var post_data=design_id='';
		post_data="ajax=1";
		post_data+="&design_id="+id;
		jQuery.ajax({
		type: "POST",
		url: base_url+"masterdesignation/delete_designation",
		data: post_data,
		success: function(responce_data){
		location.reload(true);			
		}	
		});

	} else {
		return false;
   }
}


function makeaction_delete_allowance(id){
	
	var delitem=confirm("Are you sure to delete record?")
	 if (delitem) {
		var post_data=allowance_id='';
		post_data="ajax=1";
		post_data+="&allowance_id="+id;
		jQuery.ajax({
		type: "POST",
		url: base_url+"Masterallowance/delete_allowance",
		data: post_data,
		success: function(responce_data){
		location.reload(true);			
		}	
		});

	} else {
		return false;
   }
}

function makeaction_delete_ot(id){

	var delitem=confirm("Are you sure to delete record?")
	 if (delitem) {
		var post_data=pt_id='';
		post_data="ajax=1";
		post_data+="&ot_id="+id;
		jQuery.ajax({
		type: "POST",
		url: base_url+"Overtime/delete_ot",
		data: post_data,
		success: function(responce_data){
		location.reload(true);			
		}	
		});

	} else {
		return false;
   }

}

function makeactiondel_pt(id){
	
	var delitem=confirm("Are you sure to delete record?")
	 if (delitem) {
		var post_data=pt_id='';
		post_data="ajax=1";
		post_data+="&pt_id="+id;
		jQuery.ajax({
		type: "POST",
		url: base_url+"Addsal/delete_pt",
		data: post_data,
		success: function(responce_data){
		location.reload(true);			
		}	
		});

	} else {
		return false;
   }

}


function makeactiondel_pf(id){

	var delitem=confirm("Are you sure to delete record?")
	 if (delitem) {
		var post_data=pt_id='';
		post_data="ajax=1";
		post_data+="&pf_id="+id;
		jQuery.ajax({
		type: "POST",
		url: base_url+"Pf/delete_pf",
		data: post_data,
		success: function(responce_data){
		location.reload(true);			
		}	
		});

	} else {
		return false;
   }

}


function makeaction_design(val,id){
	var post_data=actionvsal=design_id='';
	post_data="ajax=1";
	post_data+="&actionvsal="+val+"&design_id="+id;
	jQuery.ajax({
			type: "POST",
			url: base_url+"masterdesignation/update_designstatus",
		   	data: post_data,
			success: function(responce_data){
			 location.reload(true);			
			}	
		});

}



function updatecat(id){
	url=base_url+"menuescat/editcat?cat_id="+id;
	window.location =url
	return false;
}

function autocomplet() {

	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#empid').val();
	

	if (keyword.length >= min_length) {
		$.ajax({
			url: base_url+"addsal/get_emp",
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){

				$('#emp_list_id').show();
				$('#emp_list_id').html(data);
			}
		});
	} else {
		$('#emp_list_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item) {

	// change input value
	$('#empid').val(item);
	// hide proposition list
	$('#emp_list_id').hide();
	
		$.ajax({
			url: base_url+"addsal/get_emp_det",
			type: 'POST',
			data: {emp_id:item},
			success:function(data){
			var empdata=data.split("|");

				$('#fullname').val(empdata[0]);
				$('#Wing').val(empdata[2]);
				$('#design').val(empdata[1]);
				$('#tot_gross').val(empdata[3]);
				$('#curlocation').val(empdata[4]);
				$('#hidden_location').val(empdata[6]);
				$('#hidden_emp_type').val(empdata[7]);
				
			
			}
		});

} 

function getpresentday(presdays){

	var maxday=totgross='';
	var maxday=$("#maxdays").val();
	var totgross=$("#tot_gross").val();
	var curlocation=$("#curlocation").val();
	var companyid=$("#Wing").val();
	var hidden_location=$("#hidden_location").val();
	var hidden_emp_type=$("#hidden_emp_type").val();
	var hidden_month_name=$("#hidden_month_name").val();

	$.ajax({
			url: base_url+"addsal/calc_emp_sal",
			type: 'POST',
			data: {tot_pres_days:presdays,maxday:maxday,tot_gross_sal:totgross,curlocation:curlocation,companyid:companyid,hidden_location:hidden_location,hidden_emp_type:hidden_emp_type,hidden_month_name:hidden_month_name},
			success:function(data){
					
				var empsal=data.split("|");
			

				$('#gross_sal').val(empsal[0]);
				$('#basic').val(empsal[1]);
				$('#medicalallow').val(empsal[2]);
				$('#CCA').val(empsal[3]);
				$('#HRA').val(empsal[4]);
				$('#TA').val(empsal[5]);
				$('#sp_allowance').val(empsal[6]);
				$('#gross_tot').val(empsal[7]);
				$('#hidden_gross_tot').val(empsal[7]);
				$('#pf').val(empsal[8]);
				$('#pt').val(empsal[9]);
				$('#tot_ded').val(empsal[10]);
				$('#hidden_tot_dedu').val(empsal[10]);//hidden value for total deduction 
				$('#net_sal').val(empsal[11]);

				$('#hidden_ot_holiday').val(empsal[12]);
				$('#hidden_ot_day').val(empsal[13]);
				$('#hidden_ot_hour').val(empsal[14]);
				$('#hidden_ot_one_day').val(empsal[15]);
				

			}
		});

}

function saldeduction(){

	var tdsdedu         = $("#tds_dedu").val();
	var advmob          = $("#adv_mob").val();
	var hiddentodedu    = $("#hidden_tot_dedu").val();
	var gross_tot       = $('#gross_tot').val();

	
	$.ajax({
			url: base_url+"addsal/cal_deduction_emp_sal",
			type: 'POST',
			data: {tds_deduction:tdsdedu,adv_mobile:advmob,hidden_tot_deduc:hiddentodedu,gross_tot:gross_tot},
			success:function(data1){
						var emp_net_sal=data1.split("|");
		
				$('#tot_ded').val(emp_net_sal[0]);
				
				$('#net_sal').val(emp_net_sal[1]);
			}
		});


}

function additionalsal(){

	var extworkdays           = $("#extworkdays").val();
	var ot                    = $("#ot").val();
	var hrs                   = $("#hrs").val();
	var adv_arrear            = $("#adv_arrear").val();

	//*************get hidden values***********//

	var hidden_ot_holiday     = $("#hidden_ot_holiday").val();
	var hidden_ot_day         = $("#hidden_ot_day").val();
	var hidden_ot_hour        = $("#hidden_ot_hour").val();
	var gross_tot             = $("#gross_tot").val();
	var hidden_gross_tot      = $("#hidden_gross_tot").val();
	var tot_ded               = $("#tot_ded").val();
	//****************************************//
	
	//***************Calculation of ot for getting oneday sal*****************//

	var no_oneday_sal         = $("#no_oneday_sal").val();
	var tot_gross             = $("#tot_gross").val();
	var hidden_ot_one_day     = $("#hidden_ot_one_day").val();
	var maxdays               = $("#maxdays").val();



	//****************************End of calculation**************************//



	$.ajax({
			url: base_url+"addsal/cal_addition_emp_sal",
			type: 'POST',
			data: {extworkdays:extworkdays,ot:ot,hrs:hrs,adv_arrear:adv_arrear,hidden_ot_holiday:hidden_ot_holiday,hidden_ot_day:hidden_ot_day,hidden_ot_hour:hidden_ot_hour,gross_tot:gross_tot,hidden_gross_tot:hidden_gross_tot,tot_ded:tot_ded,hidden_ot_one_day:hidden_ot_one_day,tot_gross:tot_gross,no_oneday_sal:no_oneday_sal,maxdays:maxdays},
			success:function(data1){
				var emp_net_sal=data1.split("|");
						$('#gross_tot').val(emp_net_sal[0]);
						$('#net_sal').val(emp_net_sal[1]);
						$('#gross_tot_ot').val(emp_net_sal[2]);
						$('#tot_oneday_sal').val(emp_net_sal[3]);
			}
		});





}

function getmaxdays_month(){

	var month_year   = $("#yearMonthInput").val();
	
	$.ajax({
			url: base_url+"addsal/calmaxdays",
			type: 'POST',
			data: {monthyear:month_year},
			success:function(data){
				var days_mon=data.split("|");
				$('#maxdays').val(days_mon[0]);
				$('#hidden_month_name').val(days_mon[1]);
				
			}
		});


}

function viewsaldet(empid){

	$.ajax({
			url: base_url+"addsal/viewsalforid",
			type: 'POST',
			data: {emp_id:empid},
			success:function(data){
			$("#modal-sizes-2").html(data);
				
			}
		});
}
function getstaffdept_using_school(school_id){
//alert(school_id);
 var post_data=schoolid='';
	var schoolid=school_id;
           if(school_id!=null){

				post_data+="&school_id="+schoolid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getdepartmentByschool",
				data: encodeURI(post_data),
				success: function(data){
				//	alert(data);
				        
            //$('#reporting_dept').append(data);
            $('#department').html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});

	
}

function getdept_using_school(school_id){
//alert(school_id);
 var post_data=schoolid='';
	var schoolid=school_id;
           if(school_id!=null){

				post_data+="&school_id="+schoolid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getdepartmentByschool",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				        
            //$('#reporting_dept').append(data);
            $('#reporting_dept').html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});

	
}
/////
function getEmp_using_dept(dept_id){
var e = document.getElementById("reporting_school");
var school_id = e.options[e.selectedIndex].value;
var post_data='';
if(school_id!=null && dept_id!=null){
               
				post_data+="&school="+school_id+"&department="+dept_id;
				
			}
        
jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getEmpListDepartmentSchool",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				$('#reporting_person').html(data);
         		}	
			});

}
////
function getEmp_using_dept_forleave_allocation(dept_id){
	//alert('hooooo');
var e = document.getElementById("reporting_school");
var school_id = e.options[e.selectedIndex].value;
var post_data='';
if(school_id!=null && dept_id!=null){
               
				post_data+="&school="+school_id+"&department="+dept_id;
				
			}
        
jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getEmpListDepartmentSchoolForLeaveallocation",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				$('#reporting_person').html(data);
         		}	
			});

}
/*functions for employee leaves*/
function getdept_using_school_forod(school_id){
//alert(school_id);
 var post_data=schoolid='';
	var schoolid=school_id;
           if(school_id!=null){

				post_data+="&school_id="+schoolid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getdepartmentByschool",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				        
            //$('#reporting_dept').append(data);
            $('#reporting_dept_od').html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});

	
}
function getEmp_using_deptforLeave(dept_id){
var e = document.getElementById("reporting_school");
var lfrmdt= $("#dob-datepicker").val();
var ltodt= $("#dob-datepicker1").val();
var school_id = e.options[e.selectedIndex].value;
var post_data='';
if(school_id!=null && dept_id!=null){
               
				post_data+="&school="+school_id+"&department="+dept_id+"&fromdt="+lfrmdt+"&todt="+ltodt;
				
			}
       
jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getEmpListDepartmentSchoolforLeave",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				$('#emp-table').html(data);
         		}	
			});

}
function getEmp_using_deptforod(dept_id){
var e = document.getElementById("reporting_school_od");
var lfrmdt= $("#dob-datepicker2").val();
var ltodt= $("#dob-datepicker3").val();
var school_id = e.options[e.selectedIndex].value;
var post_data='';
if(school_id!=null && dept_id!=null){
               
				post_data+="&school="+school_id+"&department="+dept_id+"&fromdt="+lfrmdt+"&todt="+ltodt;
				
			}
        
jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getEmpListDepartmentSchoolforod",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				$('#emp-table-od').html(data);
         		}	
			});

}
function getcitybystatesod(state_id){
//	alert(state_id);
	var post_data=stateid='';
	var stateid=state_id;
           if(state_id!=null){

				post_data+="&state_id="+stateid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getStatewiseCity",
				data: encodeURI(post_data),
				success: function(data){
				//alert(data);
				
            $('#city').html(data);
          
				}	
			});
	
}



/*end of function for employee leave*/

function getTime(shift){
	//alert(shift);
	 var post_data='';
	var shiftid=shift;
           if(shiftid!=null){

				post_data+="&shiftid="+shift;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getshift",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
			       $("#duration").html(data);
				   
				}	
			});
}
function getcitybystates(state_id){
	//alert(state_id);
	var post_data=stateid='';
	var stateid=state_id;
           if(state_id!=null){

				post_data+="&state_id="+stateid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getStatewiseCity",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				        
            //$('#reporting_dept').append(data);
            $('#bill_C').html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});

	
	
}
function getcitybystates1(state_id){
	//alert(state_id);
	var post_data=stateid='';
	var stateid=state_id;
           if(state_id!=null){

				post_data+="&state_id="+stateid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getStatewiseCity",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				        
            //$('#reporting_dept').append(data);
            $('#shipping_C').html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});

	
	
}


