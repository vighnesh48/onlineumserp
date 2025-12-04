<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/xxbootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/xxbootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/pick.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
		
        $('#form1').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }
                    }
                },
                mname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters.'
                        }
                    }
                },
				fname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters.'
                        }
                    }
                },
				slname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Student Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Student Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Student Last name should be 2-50 characters'
                        }
                    }
                },
                smname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Student Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Student Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Student Middle name should be 2-50 characters.'
                        }
                    }
                },
				sfname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Student First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Student First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Student First name should be 2-50 characters.'
                        }
                    }
                },
				slname1:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Father Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Father Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Father Last name should be 2-50 characters'
                        }
                    }
                },
                smname1:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Father Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Father Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Father Middle name should be 2-50 characters.'
                        }
                    }
                },
				sfname1:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Father First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Father First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Father First name should be 2-50 characters.'
                        }
                    }
                },
				sfname2:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mother name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Mother name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Mother name should be 2-50 characters.'
                        }
                    }
                },
				parent_lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Guardian last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Guardian last name should be 2-50 characters.'
                        }
                    }
                },
				parent_fname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian first name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Guardian first name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Guardian first name should be 2-50 characters.'
                        }
                    }
                },
				parent_mname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Guardian middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Guardian middle name should be 2-50 characters.'
                        }
                    }
                },
				dob: {
					validators: {
						date: {
							format: 'YYYY-MM-DD',
							message: 'The value is not a valid birth date'
						}
					}
				},
				mobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mobile number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile number should be numeric'
                      },
                      stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        }
                    }
                },
				parent_mobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mobile number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile number should be numeric'
                      },
                      stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        }
                    }
                },
				email_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Email should not be empty'
                      },
                      regexp: 
                      {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'This is not a valid email'
                      }
                      
                    }
                },
				parent_email:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Parent Email should not be empty'
                      },
                      regexp: 
                      {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'This is not a valid email'
                      }
                      
                    }
                },
				category:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Category should not be empty'
                      }
                    }
                },
				parent_address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian Address should not be empty'
                      }
                    }
                },
				religion:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'religion should not be empty'
                      }
                    }
                },
				res_state:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'State should not be empty'
                      }
                    }
                },
				hostel:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Hostel Facility should not be empty'
                      }
                    }
                },
				transport:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Transport Facility should not be empty'
                      }
                    }
                },
				relationship:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian Relationship should not be empty'
                      }
                    }
                },
				occupation:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian occupation should not be empty'
                      }
                    }
                },
				bill_A:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Local Address should not be empty'
                      }
                    }
                },
				/* shipping_A:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Permanent Address should not be empty'
                      }
                    }
                }, */
               bill_C:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address City should not be empty'
                      }
                    }
                },
				/* shipping_C:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address City should not be empty'
                      }
                    }
                }, */
				bill_D:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address State should not be empty'
                      }
                    }
                },
				/* shipping_D:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address State should not be empty'
                      }
                    }
                }, */
				bill_country:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address Country should not be empty'
                      }
                    }
                },
				/* shipping_country:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address Country should not be empty'
                      }
                    }
                }, */
				bill_pc:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address PostCode should not be empty'
                      }
                    }
                }/* ,
				shipping_pc:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address PostCode should not be empty'
                      }
                    }
                } */
            }       
        }) ; 

 $('#form2').bootstrapValidator	
({
	 message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
				qexam:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Entrance qualifying exam should not be empty'
                      },                    
                    
					 regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Entrance qualifying exam name should be alphabate characters'
                      }
					 }
                },
				pyexam:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Entrance qualifying exam passing year should not be empty'
                      },                   
                  
					 regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Entrance qualifying exam name should be Numeric'
                      }
				   } 
                },
				cexam:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'school/college name should not be empty'
                      }
                      
                    }
                },
				roll_exam:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Exam Roll Number should not be empty'
                      }
                      
                    }				 
			   },
			   exam_rank:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Exam Rank should not be empty'
                      }
                      
                    }				 
			   },
			   /* tssc_eng:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'SSC English Mark should not be empty'
                      },                  
                    
					 regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'SSC English Mark should be Numeric'
                      }
				   }	  
                },
				ossc_eng:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'SSC English Mark should not be empty'
                      },                    
                
					 regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'SSC English Mark should be Numeric'
                      }
					}
                },
				sscpass_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'SSC passing date should not be empty'
                      }
                      
                    }
                }, */
				college_name:
				{
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Education Details Should be entered'
                      }
                      
                    }
                }
			}
}) ;
/* $('#form4').bootstrapValidator	
({
	
	message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
                 {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
                  },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
                  },
            fields: 
                  {
				      fref1:
                          {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Reference name  should not be empty'
                                         }
                      
                                }
						  },
						 frefcont1:
                          {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Reference contact Number should not be empty'
                                         },
					               regexp: 
                                          {
                                             regexp: /^[0-9/]+$/,
                                             message: 'Reference contact Number should be Numeric'
                                          }
                      
                                }
						  }, 
						  fref2:
                          {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Reference name  should not be empty'
                                         }
                                   
                                }
						  },
						  frefcont2:
                          {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Reference name  should not be empty'
                                         },
								   regexp: 
                                          {
                                             regexp: /^[0-9/]+$/,
                                             message: 'Reference contact Number should be Numeric'
                                          }		 
                      
                                }
						  }	 			  
				  }
})  */
/*;$('#form5').bootstrapValidator	
({
	message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
                 {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
                  },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
                  },
            fields: 
                  {
					dd_no:	
                         {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'DD Number should not be empty'
                                         }                     
                                }
						  },
                    dd_bank:
					   {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'DD Drawn Bank Name should not be empty'
                                         }                
                                }
						  },					  
				  }
});*/
// script for tabs navigation based on next button click
$(function(){
    $('.btnNext').click(function () {
      $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
      $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
})

});
</script>
<script type="text/javascript">
<!--
function copyBilling (f) {
	var s, i = 0;
	if(f.same.checked == true) {

	while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value = f.elements['bill_' + s].value};
	}
	if(f.same.checked == false) {
    // alert(false);
	while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value ="";};
	}
}
// -->
</script>
<script>
$(function(){
 
	$('#txt1').keyup(function()
	{
		var yourInput = $(this).val();
		//re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt2').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
    $('#txt3').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt11').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt12').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt13').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt21').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt22').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt23').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt31').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt32').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	$('#txt33').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
});
function sub() {
            var txtFirstNumberValue = document.getElementById('txt1').value;
            var txtSecondNumberValue = document.getElementById('txt2').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt3').value = result;
            }
        }
		function sub1() {
            var txtFirstNumberValue = document.getElementById('txt11').value;
            var txtSecondNumberValue = document.getElementById('txt12').value;
            var result1 = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result1)) {
                document.getElementById('txt13').value = result1;
            }
        }
		function sub2() {
            var txtFirstNumberValue = document.getElementById('txt21').value;
            var txtSecondNumberValue = document.getElementById('txt22').value;
            var result2 = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result2)) {
                document.getElementById('txt23').value = result2;
            }
		 }
		function sub3() {
			//////////
			var txtFirstNumberValue1=document.getElementById('txt1').value;
		    var txtFirstNumberValue11=document.getElementById('txt11').value;
		    var txtFirstNumberValue21=document.getElementById('txt21').value;
			var totalapp=parseInt(txtFirstNumberValue1)+parseInt(txtFirstNumberValue11)+parseInt(txtFirstNumberValue21);
			if (!isNaN(totalapp)) {
                document.getElementById('txt31').value = totalapp;
            }
			///////////////////
			var txtFirstNumberValue2=document.getElementById('txt2').value;
			var txtFirstNumberValue12=document.getElementById('txt12').value;
			var txtFirstNumberValue22=document.getElementById('txt22').value;
			var totalpaid=parseInt(txtFirstNumberValue2)+parseInt(txtFirstNumberValue12)+parseInt(txtFirstNumberValue22);
			if (!isNaN(totalpaid)) {
                document.getElementById('txt32').value = totalpaid;
				 document.getElementById('paidfee').value = totalpaid;
            }
			////////
			var txtFirstNumberValue3=document.getElementById('txt3').value
			var txtFirstNumberValue13=document.getElementById('txt13').value;
			var txtFirstNumberValue23=document.getElementById('txt23').value
			var totalbal=parseInt(txtFirstNumberValue3)+parseInt(txtFirstNumberValue13)+parseInt(txtFirstNumberValue23);
			if (!isNaN(totalbal)) {
                document.getElementById('txt33').value = totalbal;
            }
			////////
            var txtFirstNumberValue = document.getElementById('txt31').value;
            var txtSecondNumberValue = document.getElementById('txt32').value;
            var result4 = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result4)) {
                document.getElementById('txt33').value = result4;
            }
		 }
</script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<?php
 /*  echo"<pre>";
		print_r($fee);
		echo"</pre>";
  die();  */  
//$stud_id=$_REQUEST['s'];
//echo $stud_id;
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Admission Form</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Form</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    
                    <div class="panel-body">
                        <div class="table-info">
						<!--<label>Note:<span>Fields marked with asterisk(<?=$astrik?>) are mandatory to be filled.</span></label>--> 
                         <div id="dashboard-recent" class="panel panel-warning">   
                                <div class="panel-heading">
                                <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Details</span>
                       <ul class="nav nav-tabs nav-tabs-xs">
					 <!--  <li class="<?php //echo ($activeTab == "profile") ? "active" : ""; ?>"><a href="<?php// echo base_url(); ?>profile">PROFILE</a></li>-->
							<li class="active"><a data-toggle="tab" href="#personal-details">1.Personal Information</a></li>
                            <li><a data-toggle="tab" href="#educational-details">2.Educational Details</a></li>
                            <li><a data-toggle="tab" href="#documents-certificates">3.Documents & Certificates</a></li>
                            <li><a data-toggle="tab" href="#references">4.References</a></li>
                            <li><a data-toggle="tab" href="#payment-photo">5.Payment Details & Photo</a></li>
						</ul>
                                </div>
                      <div class="tab-content">
					  <label><span style="padding-left:10px;">Note:Fields marked with asterisk( <?=$astrik?> ) are mandatory to be filled.</span></label>
                     <div class="form-group11">
					   <?php 
					   echo "<span id='flash-messages' style='color:red;padding-left:110px;'>".@$this->session->flashdata('message')."</span>";
					   ?>
					  <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('msg1'); ?></span>
                      <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('msg2'); ?></span>
                      <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('msg3'); ?></span>
                      <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('msg4'); ?></span>
                      <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('msg5'); ?></span>
                      </div>
                     
						<!-- Comments widget -->

						<!-- Without padding -->
			<!--start  of personal-details -->			
						<div id="personal-details" class="widget-comments panel-body tab-pane fade active in">
						 <form id="form1" name="form1" action="<?=base_url($currentModule.'/form1step1')?>" method="POST">
							<!-- Panel padding, without vertical padding -->
                            <div class="panel">
                            	<div class="panel-heading">Personal Details<?=$astrik?></div>
                                <div class="panel-body">
								                                                               
                              <!--  <input type="hidden" value="" id="campus_id" name="campus_id" />-->
                                
                                <div class="panel-padding no-padding-vr">
								<div class="form-group">
                         <label class="col-sm-3">Admission To</label>  
                       <div class="col-sm-3"> 
					                <select name="admission-course" class="form-control">
									<option value="">Select</option>
									<?php
									foreach($course_details as $course){
										if($course['course_code']==$personal[0]['admission-course']){
											$sel="selected";
										}else{$sel='';}
										echo '<option value="'.$course['course_code'].'"'.$sel.'>'.$course['course_code'].'</option>';
									} ?></select></div>
                       <label class="col-sm-3">Branch </label>
                       <div class="col-sm-3"><select name="admission-branch" class="form-control" data-bvalidator="required">
									<option value="">Select</option>
									<?php
									foreach($branches as $branch){
										if($branch['branch_code']==$personal[0]['admission-branch']){
											$sel="selected";
										}else{$sel='';}
										echo '<option value="'.$branch['branch_code'].'" '.$sel.'>'.$branch['branch_code'].'</option>';
									} ?></select></div>                       
                   </div> 
                          <div class="form-group">
         <label class="col-sm-3">Student Name</label>
        <div class="col-sm-3">
		<input data-bv-field="slname" id="slname" name="slname" class="form-control" value="<?=isset($personal[0]['lname'])?$personal[0]['lname']:'';?>" placeholder="Last Name" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Last name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="regexp" class="help-block" style="display: none;">Last name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="stringLength" class="help-block" style="display: none;">Last name should be 2-50 characters</small>
		</div>  
		
        <div class="col-sm-3">
		<input data-bv-field="sfname" id="sfname" name="sfname" class="form-control" value="<?=isset($personal[0]['fname'])?$personal[0]['fname']:'';?>" placeholder="First Name" type="text"><i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small>
		</div>
		
        <div class="col-sm-3">
		<input data-bv-field="smname" id="smname" name="smname" class="form-control" value="<?=isset($personal[0]['mname'])?$personal[0]['mname']:'';?>" placeholder="Middle Name" type="text"><i data-bv-icon-for="smname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Middle name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="regexp" class="help-block" style="display: none;">Middle name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="stringLength" class="help-block" style="display: none;">Middle name should be 2-50 characters.</small>
		</div>
        </div>
       <div class="form-group">
         <label class="col-sm-3">Father's/Husband Name</label>
        <div class="col-sm-3">
		<input data-bv-field="slname" id="slname1" name="slname1" class="form-control" value="<?=isset($personal[0]['plname'])?$personal[0]['plname']:'';?>" placeholder="Last Name" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Last name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="regexp" class="help-block" style="display: none;">Last name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="stringLength" class="help-block" style="display: none;">Last name should be 2-50 characters</small>
		</div> 
		
        <div class="col-sm-3">
		<input data-bv-field="sfname" id="sfname1" name="sfname1" class="form-control" value="<?=isset($personal[0]['pfname'])?$personal[0]['pfname']:'';?>" placeholder="First Name" type="text"><i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small>
		</div>
        <div class="col-sm-3">
		<input data-bv-field="smname" id="smname1" name="smname1" class="form-control" value="<?=isset($personal[0]['pmname'])?$personal[0]['pmname']:'';?>" placeholder="Middle Name" type="text"><i data-bv-icon-for="smname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Middle name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="regexp" class="help-block" style="display: none;">Middle name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="stringLength" class="help-block" style="display: none;">Middle name should be 2-50 characters.</small>
		</div>
        </div>
        <div class="form-group">
         <label class="col-sm-3">Mother Name</label>
       <div class="col-sm-3">
	   <input data-bv-field="sfname" id="sfname2" name="sfname2" class="form-control" value="<?=isset($personal[0]['mothernm'])?$personal[0]['mothernm']:'';?>" placeholder="First Name" type="text"><i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small>
	   </div>
        </div>
       
        <div class="form-group">
       <label class="col-sm-3">Date of Birth</label>
       <div class="col-sm-3 input-group date" id="dob-datepicker">
       <input type="text" id="dob" name="dob" class="form-control"  value="<?=isset($personal[0]['dob'])?$personal[0]['dob']:'';?>" placeholder="Date of Birth" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
      <div class="form-group">
                 	<label class="col-sm-3">Gender </label>
					<?php
					$val='';$val1='';$val2='';
				if($personal[0]['gender']=="M"){
						$val="checked";
				}elseif($personal[0]['gender']=="F"){
					$val1="checked";
					}elseif($personal[0]['gender']=="T"){
						$val2="checked";
						}?>
                                    <div class="col-sm-2">
									<label><input type="radio"  <?php echo $val;?> value="M" id="gender" name="gender">&nbsp;&nbsp;Male</label>
                                	</div>
                                    <div class="col-sm-2">
                                	<label><input type="radio" <?php echo $val1;?> value="F" id="gender" name="gender">&nbsp;&nbsp;Female</label>
                                	</div>
                                    <div class="col-sm-2">
                                	<label><input type="radio" <?php echo $val2;?> value="T" id="gender" name="gender" >&nbsp;&nbsp;TG</label>
                                	</div>
								</div>
       <div class="form-group">
                       <label class="col-sm-3">Mobile</label>
                       <div class="col-sm-3"><input type="text" id="mobile" name="mobile" class="form-control" value="<?=isset($personal[0]['mobile'])?$personal[0]['mobile']:'';?>" placeholder="contact no" maxlength="10" /></div>
                       <label class="col-sm-3">Email</label>
                       <div class="col-sm-3"><input type="text" id="email_id" name="email_id" class="form-control" value="<?=isset($personal[0]['email_id'])?$personal[0]['email_id']:'';?>" placeholder="Email" /></div>                       
                   </div>             
                   <div class="form-group">
                       <label class="col-sm-3">Nationality</label>
					   <div class="col-sm-3"><input type="text" id="nationality" name="nationality" class="form-control" value="<?=isset($personal[0]['nationality'])?$personal[0]['nationality']:'Indian';?>" placeholder="" /></div>
				   <label class="col-sm-3">Category</label>
                       <div class="col-sm-3">
                       <select id="category" name="category" class="form-control">
					  <option value="">Select</option>
					<?php foreach($category as $category){
										if($category['caste_code']==$personal[0]['caste']){
											$sel="selected";
										}else{$sel='';}
										echo '<option value="'.$category['caste_code'].'" '.$sel.'>'.$category['caste_name'].'</option>';
									} ?>
					</select></div>
				   </div>
                   
                   <div class="form-group">
                       <label class="col-sm-3">Religion </label>
                       <div class="col-sm-3">
                       <select id="religion" name="religion" class="form-control"><option value="">Select</option>
					   <?php foreach($religion as $religion){
										if($religion['rel_code']==$personal[0]['religion']){
											$sel="selected";
										}else{$sel='';}
										echo '<option value="'.$religion['rel_code'].'" '.$sel.'>'.$religion['rel_name'].'</option>';
									} ?>
					</select>
                       </div>
					   <label class="col-sm-3">OMS/MS</label>
                       <div class="col-sm-3">
                       <select id="res_state" name="res_state" class="form-control"><option value="">Select</option>
					    <?php
						$val="";$val1="";
						if($personal[0]['res_state']=="MS")
						{$val="selected";
					    }elseif($personal[0]['res_state']=="OMS"){
						$val1="selected";
						}?>
                        <option <?php echo $val;?> value="MS">MS</option>
                        <option <?php echo $val1;?> value="OMS">OMS</option></select>
                       </div> 
                   </div>
				   <div class="form-group">
                      <label class="col-sm-3">Aadhar Card No </label> 
					  <div class="col-sm-3"><input type="text" id="saadhar" value="<?=isset($personal[0]['aadhar_no'])?$personal[0]['aadhar_no']:'';?>" name="saadhar" class="form-control" ></div>
                   </div> 
			<div class="form-group">
					<label class="col-sm-3">Hostel(Fill Enclosure I)</label>
					 <div class="col-sm-3">
					  <select id="hostel" name="hostel" class="form-control">
					  <option value="">Select</option>
					   <?php
						$val="";$val1="";
						if($personal[0]['hostelfacility']=="Yes")
						{$val="selected";
					    }elseif($personal[0]['hostelfacility']=="No"){
						$val1="selected";
						}?>
                        <option <?php echo $val;?> value="Yes">Yes</option>
                        <option <?php echo $val1;?>value="No">No</option></select>
					 </div>
					<div class="col-sm-2">
					<label><input type="radio" checked value="reg" id="hosteltype" name="hosteltype">&nbsp;&nbsp;Regular</label>
                   	</div>
									
                    <div class="col-sm-3">
                    <label><input type="radio" value="day" id="hosteltype" name="hosteltype">&nbsp;&nbsp;Day Boarding</label>
                    </div>
				</div>
					<div class="form-group">
					<label class="col-sm-3">Transport(Fill Enclosure II)</label>
					 <div class="col-sm-3">
					  <select id="transport" name="transport" class="form-control"><option value="">Select</option>
					  <?php
						$val="";$val1="";
						if($personal[0]['transportfacility']=="Yes")
						{$val="selected";
					    }elseif($personal[0]['transportfacility']=="No"){
						$val1="selected";
						}?>
					    <option <?php echo $val;?>  value="Yes">Yes</option>
                        <option <?php echo $val1;?> value="No">No</option></select>
					 </div>
					 <label class="col-sm-3">Bording Point</label>
					 <div class="col-sm-3"><input type="text" name="bording_point" value="<?=isset($personal[0]['bording_point'])?$personal[0]['bording_point']:'';?>" placeholder="Bording Point" class="form-control">
					 </div>
					</div>	 
                                  
                                </div>
                                </div>
                            </div>
							
                          
                            <div class="panel">
                             <div class="panel-heading">Contact Address<?=$astrik?></div>
							 <div class="panel-body" style="font-size:12px!important">   
                       		<table class="table table-new">
		<tr><th>Local Address</th>
        <th>Permanent Address</th></tr>
			<tr>
		<!--Local Address-->
		<td width="47%">
<div class="form-group">
<label  class="col-sm-3">House no.:</label><div class="col-sm-3"><INPUT TYPE="TEXT" data-bv-field="bill_A" id="bill_A" NAME="bill_A" value="<?=isset($personal[0]['lhouseno'])?$personal[0]['lhouseno']:'';?>" SIZE=30><i data-bv-icon-for="bill_A" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="bill_A" data-bv-validator="notEmpty" class="help-block" style="display: none;">House No .should not be empty</small></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Street:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_B" NAME="bill_B" value="<?=isset($personal[0]['lstreet'])?$personal[0]['lstreet']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">City:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_C" NAME="bill_C" value="<?=isset($personal[0]['lcity'])?$personal[0]['lcity']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">State:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_D" NAME="bill_D" value="<?=isset($personal[0]['lstate'])?$personal[0]['lstate']:'';?>" SIZE=30></div> 
</div>
<div class="form-group">
<label  class="col-sm-3">Country:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_country" NAME="bill_country" value="<?=isset($personal[0]['lcountry'])?$personal[0]['lcountry']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Post Code:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_pc" NAME="bill_pc" value="<?=isset($personal[0]['lpostal'])?$personal[0]['lpostal']:'';?>" SIZE=30></div>
</div>
</fieldset>
		</td>
		<!--Permanent Address-->
		<td width="50%"><fieldset>
<div class="form-group">
<label  class="col-sm-3">House no.:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_A" NAME="shipping_A" value="<?=isset($personal[0]['phouseno'])?$personal[0]['phouseno']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Street:</label><div class="col-sm-3"><INPUT TYPE="TEXT" NAME="shipping_B" value="<?=isset($personal[0]['pstreet'])?$personal[0]['pstreet']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">City:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_C" NAME="shipping_C" value="<?=isset($personal[0]['pcity'])?$personal[0]['pcity']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">State:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_D" NAME="shipping_D" value="<?=isset($personal[0]['pstate'])?$personal[0]['pstate']:'';?>" SIZE=30></div> 
</div>
<div class="form-group">
<label  class="col-sm-3">Country:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_country" NAME="shipping_country" value="<?=isset($personal[0]['pcountry'])?$personal[0]['pcountry']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Post Code:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_pc" NAME="shipping_pc" value="<?=isset($personal[0]['ppostal'])?$personal[0]['ppostal']:'';?>" SIZE=30></div>
</div>
</td></tr>
<?php if($personal[0]['same']=="on"){
	$val="checked";
	}
else{
	$val="";
}?>
<!--<tr><td><label style="text-align:left"><input name="same" <?php echo $val;?> onclick="copyBilling (this.form) " type="checkbox">Permanent Address is Same as Local Address</label></td></tr>-->
</table>
<label style="text-align:left"><input name="same" <?php echo $val;?> onclick="copyBilling (this.form) " type="checkbox"> Permanent Address is Same as Local Address</label>					   
                            		
							 	</div>
                                
                               </div>
                  
							   <div class="panel">
                             <div class="panel-heading">Parent's/Guardian's Details<?=$astrik?></div>
                              <div class="panel-body">  
                           <div class="form-group">
                                    <label class="col-sm-3">Parent/Guardian's Name</label>
                                    <div class="col-sm-3"><input type="text" id="parent_lname" name="lname" class="form-control" value="<?=isset($personal[0]['glname'])?$personal[0]['glname']:''?>" placeholder="Last Name" /></div>                                    
                                    <div class="col-sm-3"><input type="text" id="parent_fname" name="fname" class="form-control" value="<?=isset($personal[0]['gfname'])?$personal[0]['gfname']:''?>" placeholder="First Name" /></div>
                                    <div class="col-sm-3"><input type="text" id="parent_mname" name="mname" class="form-control" value="<?=isset($personal[0]['gmname'])?$personal[0]['gmname']:''?>" placeholder="Middle Name" /></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Relationship </label>
                                    <div class="col-sm-3"><select name="relationship" class="form-control">
                                	<option value="">Select</option>
									<?php $val1=$val2=$val3=$val4="";
									if($personal[0]['grelationship']=="Father"){$val1="selected";
									}elseif($personal[0]['grelationship']=="Mother"){$val2="selected";
									}elseif($personal[0]['grelationship']=="Uncle"){$val3="selected";
									}elseif($personal[0]['grelationship']=="Other"){$va4="selected";}?>
									<option <?php echo $val1;?> value="Father">Father</option>
                                    <option <?php echo $val2;?> value="Mother">Mother</option>
                                    <option <?php echo $val3;?> value="Uncle">Uncle</option>
                                    <option <?php echo $val4;?> value="Other">Other</option></select>
                                	</div>                                    
                                    <label class="col-sm-3">Occupation </label>
                                    <div class="col-sm-3"><select name="occupation" class="form-control">
                                	<option value="">Select</option>
									<?php $val1=$val2=$val3=$val4="";
									if($personal[0]['goccupation']=="Service"){$val1="selected";
									}elseif($personal[0]['goccupation']=="Business"){$val2="selected";
									}elseif($personal[0]['goccupation']=="Farmer"){$val3="selected";
									}elseif($personal[0]['goccupation']=="Other"){$va4="selected";}?>
                                    <option <?php echo $val1;?> value="Service">Service</option>
                                    <option <?php echo $val2;?> value="Business">Business</option>
                                    <option <?php echo $val3;?> value="Farmer">Farmer</option>
                                    <option <?php echo $val4;?> value="Other">Other</option></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Annual Income  </label>
                                    <div class="col-sm-3"><input type="text" id="annual_income" name="annual_income" class="form-control" value="<?=isset($personal[0]['gannual_income'])?$personal[0]['gannual_income']:''?>" placeholder="Annual Income in Rs." /></div>                                    
                                    <label class="col-sm-3">E-Mail </label>
                                    <div class="col-sm-3"><input type="text" id="parent_email" name="parent_email" class="form-control" value="<?=isset($personal[0]['gparent_email'])?$personal[0]['gparent_email']:''?>" placeholder="Email" /></div>                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Mobile</label>
                                    <div class="col-sm-3"><input type="text" id="parent_mobile" name="parent_mobile" class="form-control" value="<?=isset($personal[0]['gparent_mobile'])?$personal[0]['gparent_mobile']:''?>" maxlength="10"/></div>
                                    <label class="col-sm-3">Phone No</label>
                                    <div class="col-sm-3"><input type="text" id="parent_phone" name="parent_phone" class="form-control" value="<?=isset($personal[0]['gparent_phone'])?$personal[0]['gparent_phone']:''?>" /></div>                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Address</label>
                                    <div class="col-sm-3">
                                 <textarea id="parent_address" name="parent_address" class="form-control" rows="3" cols="50" style="resize: vertical;" ><?=isset($personal[0]['gparent_address'])?$personal[0]['gparent_address']:''?></textarea></div>
                                                                        
                                </div>
                  </div>
				   </div>
				  <div class="form-group">
                                    <div class="col-sm-4"></div>
                                   
           <?php 
		   $stepfirst=$this->session->userdata('stepfirst_status');
		   if($stepfirst=='success'){
			   if($this->session->userdata('updatestep1flag')=='active'){
			   ?>
		                           <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
			   </div> <?php } ?>
		                            <div class="col-sm-2">
                                       <!--<a class="btn btn-primary form-control" id="next" href="#educational-details">Next</a>  --> 
                                     <!--  <a  data-toggle="tab" class="btn btn-primary form-control" id="btnNext" href="#educational-details">Next</a>-->
									   <a  data-toggle="tab" class="btn-all btnNext btn-primary form-control" id="btnNext" href="#educational-details">Next</a>									   
                                    </div>
									<div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel1')?>">Cancel</a>                                        
                                    </div>	
                                                						
		   <?php }?>
		   <?php if($stepfirst!='success'){?>
                                   <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
                                    </div>
									 <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel1')?>">Cancel</a>                                        
                                    </div>			
		   <?php } ?>

		   
				 </div>	
</form>				 
     </div>
	 <!--end   of personal-details -->
						<!-- / .widget-comments -->
<!--start  of educational-details -->
						<div id="educational-details" class="widget-comments panel-body tab-pane fade ">
						<h3></h3>
					<form id="form2" name="form2" action="<?=base_url($currentModule.'/form2step2')?>" method="POST"/>
					    <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
						<input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
						<div class="panel">
                             <div class="panel-heading">Admission & Qualifying exam Details <?=$astrik?></div>
                              <div class="panel-body">
							   <div class="form-group">
         <label class="col-sm-3">Name Of Qualifying Exam</label>
        <div class="col-sm-3"><input data-bv-field="slname" id="qexam" name="qexam" class="form-control" value="<?=isset($qualiexam[0]['qexam_name'])?$qualiexam[0]['qexam_name']:''?>" placeholder="Qualifying Exam" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Qualifying Exam name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="regexp" class="help-block" style="display: none;">Qualifying Exam name should be alphabate characters</small></div>                                    
        <label class="col-sm-3">Year of Passing</label>
		<div class="col-sm-3"><input data-bv-field="slname" id="pyexam" name="pyexam" class="form-control" value="<?=isset($qualiexam[0]['qexam_pyear'])?$qualiexam[0]['qexam_pyear']:''?>" placeholder="Year of Passing" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Qualifying Exam name should not be empty</small></div>                                    
       </div>
       <div class="form-group">	   
		<label class="col-sm-3">Name Of College/School/Institute</label>
		<div class="col-sm-3"><input data-bv-field="slname" id="cexam" name="cexam" class="form-control" value="<?=isset($qualiexam[0]['qexam_colleg'])?$qualiexam[0]['qexam_colleg']:''?>" placeholder="Name Of College" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Name Of College/School/Institute should not be empty </small></div>                                           
	                                       
	  </div>
      	<div class="form-group">
                 	<label class="col-sm-3">Admission Basis</label>
					<?php
				if($qualiexam[0]['adm_basis']=="EN"){
						$rad="checked";
				}elseif($qualiexam[0]['adm_basis']=="GD"){
					$rad1="checked";
					}elseif($qualiexam[0]['adm_basis']=="M"){
						$rad2="checked";
						}else{
							$rad='';$rad1='';$rad2='';						
						}?>
                                    <div class="col-sm-2">
						<label><input type="radio" <?php echo $rad;?> value="EN" id="admission_basis" name="admission_basis">&nbsp;&nbsp;Entrance Exam</label>
                                	</div>
                                    <div class="col-sm-2">
                        <label><input type="radio" <?php echo $rad1;?> value="GD" id="admission_basis" name="admission_basis">&nbsp;&nbsp;GD/PI</label>
                                	</div>
                                    <div class="col-sm-2">
                               <label><input type="radio"<?php echo $rad2;?> value="M" id="admission_basis" name="admission_basis">&nbsp;&nbsp;Merit</label>
                                	</div>
								</div>	
<div class="form-group">	   
		<label class="col-sm-3">Roll No</label>
		<div class="col-sm-3"><input data-bv-field="slname" id="roll_exam" name="roll_exam" class="form-control" value="<?=isset($qualiexam[0]['qexam_roll'])?$qualiexam[0]['qexam_roll']:''?>" placeholder="Roll Number" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Roll Number should not be empty </small></div>                                           
	    <label class="col-sm-3">Entrance Exam Rank</label>
		<div class="col-sm-3"><input data-bv-field="slname" id="exam_rank" name="exam_rank" class="form-control" value="<?=isset($qualiexam[0]['qexam_rank'])?$qualiexam[0]['qexam_rank']:''?>" placeholder="Exam rank" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Name Of College/School/Institute should not be empty </small></div>                                                                              
	  </div>
							  </div>
							  </div>
							  <div class="panel">
                             <div class="panel-heading">Academic Details <?=$astrik?></div>
                              <div class="panel-body">
                        <div class="panel-padding no-padding-vr">
                            <div class="table-primary">
					<div class="table-header" style="width:97%!important">
						<div class="table-caption">
							Educational Background
						</div>
					</div>
                    <div class="table-responsive">
					<table id="eduDetTable" class="table table-bordered">
						<thead>
							<tr>
								<th>Exam</th>
								<th>Name of the School/College</th>
								<th>Month & Year of Passing</th>
								<th>Seat No.</th>
                                <th>Name of Board/University</th>
                                <th>Marks Obtained</th>
                                <th>Marks Out of</th>
                                <th>Percentage</th>
                                <th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php if(!empty($education)){
							// for updation and preform filled
							foreach($education as $key=>$val){ ?>
							<tr>
							<input type="hidden" value="<?php echo $education[$key]['id']?>" name="row_id[]">
								<td>
                                <select name="exam_id[]" class="form-control">
								<?php if($education[$key]['exam_id']=='SSC'){
									$val="selected";
									}elseif($education[$key]['exam_id']=='HSC'){
										$val1="selected";
										}elseif($education[$key]['exam_id']=='Graduation'){
										      $val2="selected";	
										}elseif($education[$key]['exam_id']=='Post Graduation'){
										      $val3="selected";	
										}elseif($education[$key]['exam_id']=='PHD'){
										      $val4="selected";	
										}else{$val=$val1=$val2=$val3=$val4="";} ?>
                                <option value="">Select</option>
								<option <?php echo $val;?> value="SSC">SSC</option>
								<option <?php echo $val1;?> value="HSC">HSC</option>
                                <option <?php echo $val2;?> value="Graduation">Graduation</option>
								<option <?php echo $val3;?> value="Post Graduation">Post Graduation</option>
								<option <?php echo $val4;?> value="PHD">PHD</option>
                                </select></td>
								<td><input data-bv-field="college_name" type="text"  id="college_name" name="college_name[]" class="form-control" value="<?=isset($education[$key]['college_name'])?$education[$key]['college_name']:''?>" placeholder="Name of the School/College" /><i data-bv-icon-for="college_name" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="college_name" data-bv-validator="notEmpty" class="help-block" style="display: none;">Educational Details should not be empty </small></td>
								<td><select name="pass_year[]" class="form-control">
                                <option value="">Year</option>
                                <?php for($y=date("Y");$y>=date("Y")-60;$y--){
									if($education[$key]['pass_year']==$y){
										$tds="selected";
									}
									else{$tds="";}
									echo '<option '.$tds.' value="'.$y.'">'.$y.'</option>';
								} ?>
                                </select>
                                <select name="pass_month[]" class="form-control">
		<?php 
          $val=$val1=$val2=$val3=$val4=$val5=$val6=$val7=$val8=$val9=$val10=$val11="";
		if($education[$key]['pass_month']=='JAN'){
									$val="selected";
									}elseif($education[$key]['pass_month']=='FEB'){
										$val1="selected";
										}elseif($education[$key]['pass_month']=='MAR'){
										      $val2="selected";	
										}elseif($education[$key]['pass_month']=='APR'){
										      $val3="selected";	
										}elseif($education[$key]['pass_month']=='MAY'){
										      $val4="selected";	
										}elseif($education[$key]['pass_month']=='JUN'){
										      $val5="selected";	
										}elseif($education[$key]['pass_month']=='JUL'){
										      $val6="selected";	
										}elseif($education[$key]['pass_month']=='AUG'){
										      $val7="selected";	
										}elseif($education[$key]['pass_month']=='SEP'){
										      $val8="selected";	
										}elseif($education[$key]['pass_month']=='OCT'){
										      $val9="selected";	
										}elseif($education[$key]['pass_month']=='NOV'){
										      $val10="selected";	
										}elseif($education[$key]['pass_month']=='DEC'){
										      $val11="selected";	
										}else{$val=$val1=$val2=$val3=$val4=$val5=$val6=$val7=$val8=$val9=$val10=$val11="";} ?>						
                                <option value="">Month</option>
								<option  <?php echo $val;?> value="JAN">JAN</option>
								<option  <?php echo $val1;?> value="FEB">FEB</option>
								<option   <?php echo $val2;?> value="MAR">MAR</option>
								<option  <?php echo $val3;?> value="APR">APR</option>
								<option  <?php echo $val4;?> value="MAY">MAY</option>
								<option  <?php echo $val5;?> value="JUN">JUN</option>
								<option  <?php echo $val6;?> value="JUL">JUL</option>
								<option  <?php echo $val7;?> value="AUG">AUG</option>
								<option  <?php echo $val8;?> value="SEP">SEPT</option>
								<option  <?php echo $val9;?>value="OCT">OCT</option>
								<option  <?php echo $val10;?>value="NOV">NOV</option>
								<option  <?php echo $val11;?>value="DEC">DEC</option>
								</select>
								</td>
								<td><input type="text" name="seat_no[]" class="form-control" value="<?=isset($education[$key]['seat_no'])?$education[$key]['seat_no']:''?>" placeholder="Seat No." /></td>
                                <td><input type="text" name="institute_name[]" class="form-control" value="<?=isset($education[$key]['institute_name'])?$education[$key]['institute_name']:''?>" placeholder="Name of Board/University" /></td>
								<td><input type="text" name="marks_obtained[]" class="form-control" value="<?=isset($education[$key]['marks_obtained'])?$education[$key]['marks_obtained']:''?>" /></td>
								<td><input type="text" name="marks_outof[]" class="form-control" value="<?=isset($education[$key]['marks_outof'])?$education[$key]['marks_outof']:''?>" placeholder="" /></td>
								<td><input type="text" name="percentage[]" class="form-control" value="<?=isset($education[$key]['percentage'])?$education[$key]['percentage']:''?>" placeholder="" /></td>
                                <td><input type="button" class="btn btn-xs btn-primary btn-flat" id="addMore" value="Add More" name="addMore" />
								<input type="button" class="btn btn-xs btn-danger btn-flat" id="remove" value="Remove" name="remove" /></td>
							</tr>
						<?php } }else{ //for registration?>	
						         <tr>
								<td>
                                <select name="exam_id[]" class="form-control">
                                <option value="">Select</option>
								<option value="SSC">SSC</option>
								<option value="HSC">HSC</option>
                                <option value="Graduation">Graduation</option>
								<option value="Post Graduation">Post Graduation's</option>
								<option value="PHD">PHD</option>
                                </select></td>
								<td><input data-bv-field="college_name" type="text"  id="college_name" name="college_name[]" class="form-control" value="<?=isset($_REQUEST['college_name'])?$_REQUEST['college_name']:''?>" placeholder="Name of the School/College" /><i data-bv-icon-for="college_name" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="college_name" data-bv-validator="notEmpty" class="help-block" style="display: none;">College Name should not be empty </small></td>
								<td><select name="pass_year[]" class="form-control">
                                <option value="">Year</option>
                                <?php for($y=date("Y");$y>=date("Y")-60;$y--){
									echo '<option value="'.$y.'">'.$y.'</option>';
								}?>
                                </select>
                                <select name="pass_month[]" class="form-control">
                                <option value="">Month</option><option value="JAN">JAN</option><option value="FEB">FEB</option><option value="MAR">MAR</option><option value="APR">APR</option><option value="MAY">MAY</option><option value="JUN">JUN</option><option value="JUL">JUL</option><option value="AUG">AUG</option><option value="SEP">SEPT</option><option value="OCT">OCT</option><option value="NOV">NOV</option><option value="DEC">DEC</option></select></td>
								<td><input type="text" name="seat_no[]" class="form-control" value="<?=isset($_REQUEST['seat_no'])?$_REQUEST['seat_no']:''?>" placeholder="Seat No." /></td>
                                <td><input type="text" name="institute_name[]" class="form-control" value="<?=isset($_REQUEST['institute_name'])?$_REQUEST['institute_name']:''?>" placeholder="Name of Board/University" /></td>
								<td><input type="text" name="marks_obtained[]" class="form-control" value="<?=isset($_REQUEST['marks_obtained'])?$_REQUEST['marks_obtained']:''?>" /></td>
								<td><input type="text" name="marks_outof[]" class="form-control" value="<?=isset($_REQUEST['marks_outof'])?$_REQUEST['marks_outof']:''?>" placeholder="" /></td>
								<td><input type="text" name="percentage[]" class="form-control" value="<?=isset($_REQUEST['percentage'])?$_REQUEST['percentage']:''?>" placeholder="" /></td>
                                <td><input type="button" class="btn btn-xs btn-primary btn-flat" value="Add More" name="addMore" /><input type="button" class="btn btn-xs btn-danger btn-flat" id="remove" value="Remove" name="remove" /></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
                		</div>
						</div>
						</div>
						<div class="panel">
                             <div class="panel-heading">Marks Detail</div>
                              <div class="panel-body">
							  <table class="table table-bordered">
		<tr><th>Exam</th><th>Subject</th><th>Total Marks</th><th>Marks Obtained</th><th>Date Of Passing</th></tr>
		<!--<tr><td>12th(Intermediate)or Equivalent</td><td><table ><tr><td><label>Physics</label></td></tr><tr><td><label>Chemistry</label></td></tr><tr><td><label>Maths/Bio.</label></td></tr></table></td></tr>-->
		<tr><td rowspan="4">12th(Intermediate)or Equivalent</td><td><label>Physics</label></td><td><input type="text" id="thsc_phy" value="<?=isset($qualiexam[0]['htotal_phy'])?$qualiexam[0]['htotal_phy']:''?>" name="thsc_phy"></td><td><input type="text" id="ohsc_phy" value="<?=isset($qualiexam[0]['hobt_phy'])?$qualiexam[0]['hobt_phy']:''?>" name="ohsc_phy"></td>
		<td rowspan="4"><!--<input type="text" id="hscpass_date" value="<?//=isset($qualiexam[0]['hscpass_date'])?$qualiexam[0]['hscpass_date']:''?>" name="hscpass_date" placeholder="yyyy-mm-dd">-->
		<div class="input-group date" id="doc-sub-datepicker_hsc">
       <input data-bv-field="slname" type="text" id="hscpass_date" name="hscpass_date" value="<?=isset($qualiexam[0]['hscpass_date'])?$qualiexam[0]['hscpass_date']:''?>" placeholder="yyyy-mm-dd">
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>
		</td></tr>
		<tr><td><label>chemistry</label></td><td><input type="text" id="thsc_chem" value="<?=isset($qualiexam[0]['htotal_chem'])?$qualiexam[0]['htotal_chem']:''?>" name="thsc_chem"></td><td><input type="text" id="ohsc_chem" name="ohsc_chem" value="<?=isset($qualiexam[0]['hobt_chem'])?$qualiexam[0]['hobt_chem']:''?>"></td></tr>
		<tr><td><label>Math/Bio</label></td><td><input type="text" id="thsc_bio" value="<?=isset($qualiexam[0]['htotal_bio'])?$qualiexam[0]['htotal_bio']:''?>" name="thsc_bio"></td><td><input type="text" id="ohsc_bio" name="ohsc_bio" value="<?=isset($qualiexam[0]['hobt_bio'])?$qualiexam[0]['hobt_bio']:''?>" ></td></tr>
		<tr><td><label>English</label></td><td><input type="text" id="thsc_eng" value="<?=isset($qualiexam[0]['htotal_eng'])?$qualiexam[0]['htotal_eng']:''?>" name="thsc_eng"></td><td><input type="text" id="ohsc_eng" name="ohsc_eng" value="<?=isset($qualiexam[0]['hobt_eng'])?$qualiexam[0]['hobt_eng']:''?>"></td></tr>
		<tr><td><label>10th(Matriculation)Or Equivalent</label></td><td><label>English</label></td>
		<td><input data-bv-field="tssc_eng" type="text" id="tssc_eng" name="tssc_eng" value="<?=isset($qualiexam[0]['stotal_eng'])?$qualiexam[0]['stotal_eng']:''?>" ><i data-bv-icon-for="tssc_eng" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="tssc_eng" data-bv-validator="notEmpty" class="help-block" style="display: none;">Mark should not be empty </small></td>
		<td><input data-bv-field="slname" type="text" id="ossc_eng" name="ossc_eng" value="<?=isset($qualiexam[0]['sobt_eng'])?$qualiexam[0]['sobt_eng']:''?>" ></td>
		<td><!--<input data-bv-field="slname" type="text" id="sscpass_date" name="sscpass_date" value="<?//=isset($qualiexam[0]['ssc_passing_dt'])?$qualiexam[0]['ssc_passing_dt']:''?>" placeholder="yyyy-mm-dd">-->
		<div class="input-group date" id="doc-sub-datepicker_ssc">
       <input data-bv-field="slname" type="text" id="sscpass_date" name="sscpass_date" value="<?=isset($qualiexam[0]['ssc_passing_dt'])?$qualiexam[0]['ssc_passing_dt']:''?>" placeholder="yyyy-mm-dd">
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div> </td>
		
		</tr>
		</table>
							  </div>
							  </div>
						<div class="form-group">
                                    <div class="col-sm-4"></div>
                                                             
           <?php 
		   $stepsecond=$this->session->userdata('stepsecond_status');
		   if($stepsecond=='success'){
			   if($this->session->userdata('updatestep2flag')=='active'){
			   ?>
		                           <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Update</button>                                        
			   </div> <?php } ?>
		                            <div class="col-sm-2">
                                       <!--<a class="btn btn-primary form-control" id="next" href="#educational-details">Next</a>  --> 
                                       <a  data-toggle="tab" class="btn-all btnNext btn-primary form-control" id="next" href="#documents-certificates">Next</a>									   
                                    </div> 
									 <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel2')?>">Cancel</a>                                        
                                    </div>
		   <?php }?>
		   <?php if($stepsecond!='success'){?>
                                   <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
                                    </div>
									<div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel2')?>">Cancel</a>                                        
                                    </div>
		   <?php } ?>
                   			
				 </div>	
				 </form>
</div>
	<!--end  of educational -->					
		<!--start  of documents-certificates -->				
        <div id="documents-certificates" class="widget-threads panel-body tab-pane fade">
		<form id="form3" name="form3"  multiple enctype="multipart/form-data"  action="<?=base_url($currentModule.'/form3sub3')?>" method="POST">
		<input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
		<input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
		<input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
                        <div class="panel">
                             <div class="panel-heading">List Of Documents To Be Submitted <?=$astrik?></div>
                              <div class="panel-body">
		 <div class="table-responsive">
		<table class="doc-tbl table-bordered">
		<tr><th>Sr No.</th><th>Particulars</th><th>Mark 'NA'if not applicable</th><th>Mark'O' if Submitted in original and 'X' if xerox submitted</th>
		<th>If Pending for submission(Specify Date of Submission)</th><th>Upload Scan Copy</th><th>Remark</th></tr>
		<?php foreach($document as $key=>$val){?>
			<input type="hidden" name="updoc_id[]" value="<?=$document[$key]['doc_id']?>">
		<?php } ?>
		<?php foreach($doc_list as $doc){?>
		<tr><td><?=$doc['document_id']?><input type="hidden" name="doc_id[]" value="<?=$doc['document_id']?>"></td><td><label><?=$doc['document_name']?></label></td><td><select name="dapplicable[<?=$doc['document_id']?>]"><option value="">Select</option><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox[<?=$doc['document_id']?>]"><option value="">Select</option><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group"> 
       <div class="input-group date" id="doc-sub-datepicker<?=$doc['document_id']?>">
       <input type="text" id="docsubdate[]" name="docsubdate[<?=$doc['document_id']?>]" class="form-control" value="<?=isset($_REQUEST['docsubdate'])?$_REQUEST['docsubdate']:''?>" placeholder="Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td>
		<input type="file" name="scandoc[<?=$doc['document_id']?>]">
		</td>
		<td><input type="text" name="remark[<?=$doc['document_id']?>]?>"/></td>	
		</tr>
		<?php }?>
		</table>
		</div>
     		
      				  
</div>
</div>
                             <div class="panel">
                             <div class="panel-heading">Certificates Details  </div>
                              <div class="panel-body">
							  <table class="table table-bordered">
		<tr><th>Certificate Name</th><th>Certificate No.</th><th>Issue Date</th><th>Validity</th></tr>
		<tr><td><input type="hidden" name="cert_id[]" value="<?=isset($certificate[0]['cid'])?$certificate[0]['cid']:''?>"><label>Income</label><input type="hidden" name="cnm[]" value="Income" readonly></td><td><input type="text" name="cno[]" value="<?=isset($certificate[0]['certificate_no'])?$certificate[0]['certificate_no']:''?>"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker17">
       <input type="text" id="issuedt1" name="issuedt[]" class="form-control" value="<?=isset($certificate[0]['cissue_dt'])?$certificate[0]['cissue_dt']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td><input type="text" name="cval[]" value="<?=isset($certificate[0]['cvalidity'])?$certificate[0]['cvalidity']:''?>"></td></tr>
		
		<tr><td><input type="hidden" name="cert_id[]" value="<?=isset($certificate[1]['cid'])?$certificate[1]['cid']:''?>"><label>Cast-category</label><input type="hidden"name="cnm[]" value="Cast-category" readonly></td><td><input type="text" name="cno[]" value="<?=isset($certificate[1]['certificate_no'])?$certificate[1]['certificate_no']:''?>"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker18">
       <input type="text" id="issuedt2" name="issuedt[]" class="form-control" value="<?=isset($certificate[1]['cissue_dt'])?$certificate[1]['cissue_dt']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td><input type="text" name="cval[]" value="<?=isset($certificate[1]['cvalidity'])?$certificate[1]['cvalidity']:''?>"></td></tr>
		
		<tr><td><input type="hidden" name="cert_id[]" value="<?=isset($certificate[2]['cid'])?$certificate[2]['cid']:''?>"><label>Residence-State Subject</label><input type="hidden" name="cnm[]" value="Residence-State Subject" readonly></td><td><input type="text" name="cno[]" value="<?=isset($certificate[2]['certificate_no'])?$certificate[2]['certificate_no']:''?>"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker19">
       <input type="text" id="issuedt3" name="issuedt[]" class="form-control" value="<?=isset($certificate[2]['cissue_dt'])?$certificate[2]['cissue_dt']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td><input type="text" name="cval[]" value="<?=isset($certificate[2]['cvalidity'])?$certificate[2]['cvalidity']:''?>"></td></tr>
		
		</table>
							  
							  </div>
							  </div>
                 <div class="form-group">
                   <div class="col-sm-4"></div>
                                    <?php 
		   $stepthird=$this->session->userdata('stepthird_status');
		   if($stepthird=='success'){
			   if($this->session->userdata('updatestep3flag')=='active'){
			   ?>
		                           <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
			   </div> <?php } ?>
		                            <div class="col-sm-2">
                                       <!--<a class="btn btn-primary form-control" id="next" href="#educational-details">Next</a>  --> 
                                       <a  data-toggle="tab" class="btn-all btnNext btn-primary form-control" id="next" href="#references">Next</a>									   
                                    </div> 
									 <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel3')?>">Cancel</a>                                        
                                    </div>
		   <?php }?>
		   <?php if($stepthird!='success'){?>
                                   <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
                                    </div>
									<div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel3')?>">Cancel</a>                                        
                                    </div>
		   <?php } ?>  
				 </div>	
				 </form>
</div>
<!--end of documents-certificates -->
 <!--start  of references -->	
<div id="references" class="widget-threads panel-body tab-pane fade">
<form id="form4" name="form4" action="<?=base_url($currentModule.'/form4sub4')?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
		<input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
		<input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
		<input type="hidden" name="step3statusval" value="<?= $this->session->userdata('stepthird_status') ?>">
 <div class="panel">
                             <div class="panel-heading">References details</div>
                              <div class="panel-body">
							  <label class="col-sm-6">References(Other than Blood Relatives)</label>
		<table class="table table-bordered">
		<tr><td width="14px">Sr No.</td><td>Reference Name</td><td>Contact Number</td></tr>
		<tr><td>1</td><td><input type="text" name="fref1" value="<?=isset($references[0]['for_stud_refer_name1'])?$references[0]['for_stud_refer_name1']:''?>" required/></td><td><input type="text" name="frefcont1" maxlength="10" value="<?=isset($references[0]['for_stud_refer_cont1'])?$references[0]['for_stud_refer_cont1']:''?>" required></td></tr>
		<tr><td>2</td><td><input type="text" name="fref2" value="<?=isset($references[0]['for_stud_refer_name2'])?$references[0]['for_stud_refer_name2']:''?>"required/></td><td><input type="text" name="frefcont2" maxlength="10" value="<?=isset($references[0]['for_stud_refer_cont2'])?$references[0]['for_stud_refer_cont2']:''?>" required></td></tr>
		</table>
		<table class="table table-bordered">
		<tr ><td colspan="3"><label >Are you related to any person employed with Sandip University: </label>
		<select name="reletedsandip">
		<?php $val=$val1=""; if($references[0]['ex_emp_rel']=='Y'){ $val="selected";}else{$val1="selected";}?>
		<option value="">Select</option><option <?php echo $val; ?> value="Y">Yes</option><option <?php echo $val1; ?> value="N">No</option></select></td></tr>
		<tr><td><label>Name:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="relatedname" value="<?=isset($references[0]['ex_emp_rname'])?$references[0]['ex_emp_rname']:''?>"/></td><td><label>Designation:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="relateddesig" value="<?=isset($references[0]['ex_emp_rdesig'])?$references[0]['ex_emp_rdesig']:''?>"/></td><td><label>Relation:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="relatedrelation" value="<?=isset($references[0]['ex_emp_relat'])?$references[0]['ex_emp_relat']:''?>" /></td></tr>
		<tr ><td colspan="3"><label >Are you related to Alumini of  Sandip University: </label>
		<select name="aluminisandip">
		<?php $val=$val1=""; if($references[0]['alumini_rel']=='Y'){ $val="selected";}else{$val1="selected";}?>
		<option value="">Select</option><option <?php echo $val; ?> value="Y">Yes</option><option <?php echo $val1; ?> value="N">No</option></select></td></tr>
		<tr><td><label>Name:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="alumininame" value="<?=isset($references[0]['alumini_rel_name'])?$references[0]['alumini_rel_name']:''?>"/></td><td><label>passing Year:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="aluminiyear" value="<?=isset($references[0]['alumini_rel_passyear'])?$references[0]['alumini_rel_passyear']:''?>"/></td><td><label>Relation:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="aluminirelation" value="<?=isset($references[0]['alumini_relat'])?$references[0]['alumini_relat']:''?>" /></td></tr>
		<tr ><td colspan="3"><label >Are your relatives studying in Sandip University: </label>
		<select name="relativesandip">
		<?php $val=$val1=""; if($references[0]['rel_stud_san']=='Y'){ $val="selected";}else{$val1="selected";}?>
		<option value="">Select</option><option <?php echo $val; ?> value="Y">Yes</option><option <?php echo $val1; ?> value="N">No</option></select></td></tr>
		<tr><td><label>Name:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="relativename" value="<?=isset($references[0]['rel_stud_san_name'])?$references[0]['rel_stud_san_name']:''?>"/></td><td><label>CourseName:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="relativecoursenm" value="<?=isset($references[0]['rel_stud_san_course'])?$references[0]['rel_stud_san_course']:''?>"/></td><td><label>Relation:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="relativerelation" value="<?=isset($references[0]['rel_stud_san_relat'])?$references[0]['rel_stud_san_relat']:''?>"/></td></tr>
		</table>
</div>
</div>
 <div class="panel">
                             <div class="panel-heading">How Did You Come To Know About Sandip University</div>
                              <div class="panel-body">
							  <div class="form-group">
        <label class="col-sm-3">Select The Publicity Media:</label>
        <div class="col-sm-8">
		<select name="publicitysandip[]" multiple="multiple" >
		<option value=""><strong>Select</strong></option>
		<?php
$val=$val1=$val2=$val3=$val4=$val5=$val6=$val7=$val8=$val9="";
         $arr=explode(',',$references[0]['publicity_media']);
		// print_r($references[0]['publicity_media']);
		 foreach($arr as $key=>$val){
		if($arr[$key]=='newspaper-advt'){
			$val="selected";
			}elseif($arr[$key]=='newspaper-insert'){
				$val1="selected";
			} elseif($arr[$key]=='tv'){
				$val2="selected";
			}elseif($arr[$key]=='radio'){
				$val3="selected";
			}elseif($arr[$key]=='hording'){
				$val4="selected";
			}elseif($arr[$key]=='cstudent'){
				$val5="selected";
			}elseif($arr[$key]=='alumini'){
				$val6="selected";
			}elseif($arr[$key]=='staff'){
				$val7="selected";
			}elseif($arr[$key]=='website'){
				$val8="selected";
			}elseif($arr[$key]=='otherweb'){
				$val9="selected";
			}else{
				$val=$val1=$val2=$val3=$val4=$val5=$val6=$val7=$val8=$val9="";
			}
			}?>
		<option <?php echo $val; ?> value="newspaper-advt">Newspaper Advt</option>
		<option <?php echo $val1; ?> value="newspaper-insert">Newspaper Insertions</option>
		<option <?php echo $val2; ?> value="tv">TV Advt.</option>
		<option <?php echo $val3; ?> value="radio">Radio Advt.</option>
		<option <?php echo $val4; ?> value="hording">Hording</option>
		<option <?php echo $val5; ?> value="cstudent">Current Student</option>
		<option <?php echo $val6; ?> value="alumini">University Alumani</option>
		<option <?php echo $val7; ?> value="staff">University Staff</option>
		<option <?php echo $val8; ?> value="website">University Website</option>
		<option <?php echo $val9; ?> value="otherweb">Other Website</option>
		</select>
		</div>
        </div>
		<div class="form-group">
		<label class="col-sm-12">Give the Reference of the candidate who may be interested to pursue academic program in sandip university:</label>
		</div>
		<div class="form-group">
         <label class="col-sm-3">Name of Candidate</label>
        <div class="col-sm-3"><input data-bv-field="refcandidatenm" id="refcandidatenm" name="refcandidatenm" class="form-control" value="<?=isset($references[0]['ref_bystud_name'])?$references[0]['ref_bystud_name']:''?>" placeholder="Candidate Name" type="text"></div> <label class="col-sm-3">Contact No.</label>
 		 <div class="col-sm-3"><input data-bv-field="refcandidatecont" id="refcandidatecont" name="refcandidatecont" class="form-control" maxlength="10" value="<?=isset($references[0]['ref_bystud_cont'])?$references[0]['ref_bystud_cont']:''?>" placeholder="Candidate contact" type="text"></div>                                    
        </div>
		<div class="form-group">
		 <label class="col-sm-3">Email Id</label>
		 <div class="col-sm-3"><input data-bv-field="refcandidateemail" id="refcandidateemail" name="refcandidateemail" class="form-control" value="<?=isset($references[0]['ref_bystud_email'])?$references[0]['ref_bystud_email']:''?>" placeholder="Candidate Email" type="email"></div>
<label class="col-sm-3">Relation with Candidate</label>
 		 <div class="col-sm-3"><input data-bv-field="refcandidaterelt" id="refcandidaterelt" name="refcandidaterelt" class="form-control" value="<?=isset($references[0]['ref_bystud_relat'])?$references[0]['ref_bystud_relat']:''?>" placeholder="With Candidate relation" type="text"></div> 		 
	   </div>
	   <div class="form-group">
		 <label class="col-sm-3">Area of Interest</label>
		 <div class="col-sm-3"><input data-bv-field="refcandidateinterest" id="refcandidateinterest" name="refcandidateinterest" class="form-control" value="<?=isset($references[0]['ref_bystud_area'])?$references[0]['ref_bystud_area']:''?>" placeholder="Candidate Interest Area" type="text"></div>       
	   </div>
							  </div>
							  </div>
<div class="form-group">
                                    <div class="col-sm-4"></div>
                                       <?php 
		   $stepfourth=$this->session->userdata('stepfourth_status');
		   if($stepfourth=='success'){
			   if($this->session->userdata('updatestep4flag')=='active'){
			   ?>
		                           <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
			   </div> <?php } ?>
		                            <div class="col-sm-2">
                                       <!--<a class="btn btn-primary form-control" id="next" href="#educational-details">Next</a>  --> 
                                       <a  data-toggle="tab" class="btn-all btnNext btn-primary form-control" id="next" href="#payment-photo">Next</a>									   
                                    </div> 
									 <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel4')?>">Cancel</a>                                        
                                    </div>
		   <?php }?>
		   <?php if($stepfourth!='success'){?>
                                   <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
                                    </div>
									<div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel4')?>">Cancel</a>                                        
                                    </div>
		   <?php } ?> 
				 </div>	
				 </form>
</div>
<!--end of references -->
      <!--start  of photos -->
						  
                        <div id="payment-photo" class="widget-threads panel-body tab-pane fade">
						<form id="form5" name="form5" enctype="multipart/form-data" action="<?=base_url($currentModule.'/form5sub5')?>" method="POST">
						<input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
		<input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
		<input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
		<input type="hidden" name="step3statusval" value="<?= $this->session->userdata('stepthird_status') ?>">
		<input type="hidden" name="step4statusval" value="<?= $this->session->userdata('stepfourth_status') ?>">
                        <div class="panel">
                             <div class="panel-heading">Payment Details <?=$astrik?></div>
                              <div class="panel-body">
                            	<table class="table table-bordered">
		<tr><th>particulars</th><th>Applicable Fee</th><th>Amount Paid</th><th>Balance(if any)</th><th>Payment particulars</th></tr>
		<tr><td>Admission Form/prospectus Fee(Not to pay if already paid)</td><td><input type="text" id="txt1" name="formfeeappli" onkeyup="sub();" value="<?=isset($fee[0]['formfeeappli'])?$fee[0]['formfeeappli']:''?>"></td><td><input type="text" id="txt2" name="formfeepaid" onkeyup="sub();" value="<?=isset($fee[0]['formfeepaid'])?$fee[0]['formfeepaid']:''?>"></td><td><input type="text" id="txt3" name="formfeebal" onkeyup="sub();" value="<?=isset($fee[0]['formfeebal'])?$fee[0]['formfeebal']:''?>"></td>
		<td rowspan="4"><p>Payment of Rs.
		<input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control" value="<?=isset($fee[0]['totalfeepaid'])?$fee[0]['totalfeepaid']:''?>" placeholder="Paid Fee" type="text" required readonly><i data-bv-icon-for="paidfee" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="paidfee" data-bv-validator="notEmpty" class="help-block" style="display: none;">Total Paid Fee should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="paidfee" data-bv-validator="regexp" class="help-block" style="display: none;">Total Paid Fee should be numeric characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="stringLength" class="help-block" style="display: none;">Last name should be 2-50 characters</small>
		Made through CashRecipt/DD No.<input type="text" name="dd_no"  required value="<?=isset($fee[0]['dd_no'])?$fee[0]['dd_no']:''?>" placeholder="DD No."><br>
		Dated <div class="input-group date" id="doc-sub-datepicker20">
       <input type="text" id="dd_date" name="dd_date" required value="<?=isset($fee[0]['dd_drawn_date'])?$fee[0]['dd_drawn_date']:''?>" placeholder="DD Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>Drawn On<br><input type="text" id="dd_bank" name="dd_bank" required value="<?=isset($fee[0]['dd_drawn_bank_branch'])?$fee[0]['dd_drawn_bank_branch']:''?>" placeholder="Bank & Branch"><br>(Name of Bank & Branch) </p></td></tr>
		<tr><td>Tution Fee</td><td><input type="text" id="txt11" name="tutionfeeappli" value="<?=isset($fee[0]['tutionfeeappli'])?$fee[0]['tutionfeeappli']:''?>" onkeyup="sub1();" ></td><td><input type="text" id="txt12" name="tutionfeepaid" value="<?=isset($fee[0]['tutionfeepaid'])?$fee[0]['tutionfeepaid']:''?>" onkeyup="sub1();"></td><td><input id="txt13" type="text" name="tutionfeebal" value="<?=isset($fee[0]['tutionfeebal'])?$fee[0]['tutionfeebal']:''?>" onkeyup="sub1();"></td></tr>
		<tr><td>Other</td><td><input type="text" id="txt21" name="otherfeeappli" value="<?=isset($fee[0]['otherfeeappli'])?$fee[0]['otherfeeappli']:''?>" onkeyup="sub2();"></td><td><input id="txt22" type="text" name="otherfeepaid" value="<?=isset($fee[0]['otherfeepaid'])?$fee[0]['otherfeepaid']:''?>"  onkeyup="sub2();"></td><td><input type="text" id="txt23" name="otherfeebal" value="<?=isset($fee[0]['otherfeebal'])?$fee[0]['otherfeebal']:''?>" onkeyup="sub2();"></td></tr>
		<tr><td>Total</td><td><input type="text" id="txt31" name="totalfeeappli" value="<?=isset($fee[0]['totalfeeappli'])?$fee[0]['totalfeeappli']:''?>" onkeyup="sub3();" readonly></td><td><input type="text" id="txt32" name="totalfeepaid" value="<?=isset($fee[0]['totalfeepaid'])?$fee[0]['totalfeepaid']:''?>" onkeyup="sub3();" readonly ></td><td><input type="text" id="txt33" name="totalfeebal" value="<?=isset($fee[0]['totalfeebal'])?$fee[0]['totalfeebal']:''?>" onkeyup="sub3();" readonly></td></tr>
		
		
		</table>
		<div class="form-group">
                       <label class="col-sm-3">Bank Name</label>
                       <div class="col-sm-3">
                       <input type="text" id="bank_name" name="bank_name" class="form-control" value="<?=isset($fee[0]['bank_name'])?$fee[0]['bank_name']:''?>" placeholder="BOI Account No." />
                       </div>
                       <label class="col-sm-3"> Bank Account No.</label>
                       <div class="col-sm-3"><input type="text" id="account_no" name="account_no" class="form-control" value="<?=isset($fee[0]['account_no'])?$fee[0]['account_no']:''?>" placeholder="Other Bank Account No." /></div>
                   </div>
                   <div class="form-group">
                       <label class="col-sm-3">IFSC code</label>
                       <div class="col-sm-3">
                       <input type="text" id="ifsc" name="ifsc" class="form-control" value="<?=isset($fee[0]['ifsc'])?$fee[0]['ifsc']:''?>" placeholder="IFSC code" />
                       </div>
                      
                   </div>
                               </div>
                            </div>
				<div class="panel">
                             <div class="panel-heading">Photo Uplod <?=$astrik?></div>
                              <div class="panel-body">	
<div class="form-group">
		<label class="col-sm-3">Upload Photo:</label>
		<?php
		if(!empty($fee[0]['profile_img'])){
			$profile=base_url()."uploads/student_profilephotos/".$fee[0]['profile_img'];
		}else{
	$profile="";}?><input type="hidden" name="profile_img" value="<?=isset($fee[0]['profile_img'])?$fee[0]['profile_img']:''?>">
		<img id="blah" alt="Student Profile image" src="<?php echo $profile;?>"width="100" height="100" border="1px solid black" />
        <input type="file" name="profile_img" value="<?=isset($fee[0]['profile_img'])?$fee[0]['profile_img']:''?>" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
</div>							  
							</div>
							</div>
							<div class="form-group">
                                    <div class="col-sm-4"></div>
									<?php if($this->session->userdata('updatestep5flag')=='active'){
			   ?>
		                           <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
			   </div> <?php }else{ ?>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
                                    </div>  
			   <?php }?>
				           </div>	
				 </form>
</div><!--end of photos -->
                        
					</div>
                   </div>             
                                
                              
                                
                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker4').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker5').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker6').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker7').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker8').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker9').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker10').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker11').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker12').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker13').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker14').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker15').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker16').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker17').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker18').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker19').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker_ssc').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker_hsc').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	// hide the remove button in education table
	var rowCount = $('#eduDetTable >tbody >tr').length;
if(rowCount<2){$('#remove').hide();}
else{$('#remove').show();}
///
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);	
		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;

		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	
});
</script>