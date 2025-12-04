<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
      <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
.table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border-color: #1166b7!important;
}
   ::-webkit-scrollbar {
   width: 8px;
   }
   /* Track */
   ::-webkit-scrollbar-track {
   background: #f1f1f1; 
   }
   /* Handle */
   ::-webkit-scrollbar-thumb {
   background: #888; 
   }
   /* Handle on hover */
   ::-webkit-scrollbar-thumb:hover {
   background: #555; 
   } @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
   * {
   margin: 0;
   padding: 0;
   box-sizing: border-box;
   font-family: 'Roboto', sans-serif
   }
   .plus-btn::before {
   content: "+";
   }
   .minus-btn::before {
   content: "-";
   }
   #2{text-align: center!important;}
   .pic {
   width: 50px;
   height: 50px;
   object-fit: contain;
   }
   .table thead {
   background-color: #2c80c3;
   }
   .table thead th {
   padding: 10px;
   font-size: 14px;
   color: white;
   }
   .table tbody td input[type="checkbox"] {
   appearance: none;
   width: 20px;
   height: 20px;
   background-color: #eee;
   position: relative;
   border-radius: 3px;
   cursor: pointer;
   }
   .container .table-wrap {
   margin: 20px auto;
   overflow-x: auto
   }
   .container .table-wrap::-webkit-scrollbar {
   height: 5px;
   }
   .container .table-wrap::-webkit-scrollbar-thumb {
   border-radius: 5px;
   background-image: linear-gradient(to right, #5D7ECD, #0C91E6);
   }
   .table>:not(caption)>*>* {
   padding: 2rem 0.5rem;
   }
   .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color: #f1fafd;
}
.text-muted {
    color: #544b4b;
}
   .alert {
    background: #fffdf1;
    border-color: #dfd2b7;
    color: #b77300;
    background-size: 20px 20px;
}
   .qty {
   width: 30px;
   height: 30px;
   color: black;
   font-weight: 600;
   outline: none;;
   border: #ccc solid 1px;
   }
   input{
   margin: 0;
   font-family: inherit;
   font-size: inherit;
   line-height: inherit;
   background: #f2f2f2;
   border: #ccc solid 1px;
   padding: 3px;
   text-align: center;
   width:40px;
   }
   .table tbody td input[type="checkbox"]:after {
   position: absolute;
   width: 100%;
   height: 100%;
   font-family: "Font Awesome 5 Free";
   font-weight: 600;
   content: "\f00c";
   color: #fff;
   font-size: 15px;
   display: none
   }
   .table tbody td input[type="checkbox"]:checked,
   .table tbody td input[type="checkbox"]:checked:hover {
   background-color: #1166b7;
   }
   .table tbody td input[type="checkbox"]:checked::after {
   display: flex;
   align-items: center;
   justify-content: center;
   }
   .table tbody td input[type="checkbox"]:hover {
   background-color: #ddd;
   }
   .table tbody td {
   padding: 10px;
   margin: 0;
   font-size: 14.5px;
   font-weight: 600;
   }
   .table tbody td .fa-times {
   color: #D32F2F;
   }
   .text-muted {
   font-size: 12.5px;
   }
   .table tbody tr td:nth-of-type(3) {
   min-width: 320px;
   }
   @media(min-width: 992px) {
   .container .table-wrap {
   overflow: hidden;
   }
   }
   .disabled {
   pointer-events: none;
   cursor: default;
   opacity: 0.6;
   }
   .table{width: 100%;}
   table{max-width: 100%;}
   .blinking{
   animation:blinkingText 7.2s infinite;
   }
   @keyframes blinkingText{
   0%{     color: red;    }
   49%{    color: transparent; }
   50%{    color: red; }
   99%{    color:red;  }
   100%{   color: red;    }
   }

   .wrap input::-webkit-outer-spin-button,
   .wrap input::-webkit-inner-spin-button {
   -webkit-appearance: none;
    margin: 0;
   }
</style>
<?php $role_id = $this->session->userdata('role_id'); ?>
<div id="content-wrapper">
   <ul class="breadcrumb breadcrumb-page">
      <div class="breadcrumb-label text-light-gray">You are here: </div>
      <li class="active"><a href="#">Masters</a></li>
      <li class="active"><a href="#">Subject Master</a></li>
   </ul>
   <div class="page-header">
      <div class="row">
         <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-book page-header-icon"></i>&nbsp;&nbsp;Uniform Distribution</h1>
         <!--span class="blinking pull-left">Last date for adding/updating Course master is 13<sup>rd</sup> JAN 2020 </span-->
         <div class="col-xs-12 col-sm-8">
            <div class="row">
               <hr class="visible-xs no-grid-gutter-h">
               <?php// if(in_array("Add", $my_privileges)) { ?>
               <div class="visible-xs clearfix form-group-margin"></div>
               <?php //} ?>
            </div>
         </div>
      </div>
      <div class="row ">
         <div class="col-sm-12">&nbsp;</div>
      </div>
      <div class="row ">
         <div class="col-sm-12">
            <div class="panel">
               <div class="panel-heading">
                  <span class="panel-title">Uniform List</span>
               </div>
               <div class="panel-body" style="overflow-y: auto;">
                  <div class="row ">
                     <div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
                        <?php
                           if ($this->session->flashdata('message') != ''): 
                           	echo $this->session->flashdata('message'); 
                           endif;
                           ?>
                     </div>
                  </div>
                  <!--Item Alread added-->
				  <div class="row" id="prnentry">
				   <div class="col-md-4 col-md-offset-4 text-center">
                        <form action="javascript:void(0)">
                           <div class="form-group">
                              <input type="text" class="form-control" id="enrollment_no" placeholder="Enter Your PRN" name="enrollment_no" value="<?=$id; ?>"
							  >
							  <span style="color:red" id="enrollment_error"></span>
                           </div>
                           <button type="submit" id="btnsearch" class="btn btn-primary">Submit</button>
                        </form>
                     </div>
					 </div> 
				     
               <div id="allprndata">
                  
               </div>
               <div id="allprndatap">
                  
               </div>

                  <div class="row hidden">
                    
                     <div class="col-md-12">
                        <h4> Name:Swaminath Sonawane School:SITRC Stream:Mechanical Engineering PRN:1210000</h4>
                     </div>
                     <!--Item Alread added-->
                     <div class="table-wrap table-responsive">
                        <table class="table  table-bordered table-striped">
                           <thead>
                             
                              <th width="20%">Product</th>
                              <th width="50%">Product Name</th>
                              <th width="10%">Size</th>
                              <th width="15%">Quantity</th>
                           </thead>
                           <tbody>
                              <tr class="align-middle alert border-bottom" role="alert">
                                 
                                 <td class="text-center">
                                    <img class="pic"
                                       src="https://www.freepnglogos.com/uploads/shoes-png/dance-shoes-png-transparent-dance-shoes-images-5.png"
                                       alt="">
                                 </td>
                                 <td>
                                    <div>
                                       <p class="m-0 fw-bold">Sneakers Shoes 2020 For Men</p>
                                       <p class="m-0 text-muted">Fugiat Voluptates quasi nemo,ipsa perferencis</p>
                                    </div>
                                 </td>
                                 <td class="d-">
                                    <div id="field2">
                                       <p class="m-0 fw-bold">XL</p>
                                    </div>
                                 </td>
                                 <td class="d-">
                                    <div id="field2">
                                       <p class="m-0 fw-bold">1</p>
                                    </div>
                                 </td>
                              </tr>
                             
                           </tbody>
                        </table>
                     </div>
                  </div>

                  <!--Item added-->
                  <div class="row hidden">
                     <div class="table-wrap table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                              <th width="5%">ID</th>
                              <th width="20%">Product</th>
                              <th width="50%">Product Name</th>
                              <th width="10%">Size</th>
                              <th width="15%">Quantity</th>
                           </thead>
                           <tbody>
                              <tr class="align-middle alert border-bottom" role="alert">
                                 <td>
                                    <input type="checkbox" id="check">
                                 </td>
                                 <td class="text-center">
                                    <img class="pic"
                                       src="https://www.freepnglogos.com/uploads/shoes-png/dance-shoes-png-transparent-dance-shoes-images-5.png"
                                       alt="">
                                 </td>
                                 <td>
                                    <div>
                                       <p class="m-0 fw-bold">Sneakers Shoes 2020 For Men</p>
                                       <p class="m-0 text-muted">Fugiat Voluptates quasi nemo,ipsa perferencis</p>
                                    </div>
                                 </td>
                                 <td>
                                    <select class="form-select selects" aria-label="Default select example">
                                       <option selected>Select Size:</option>
                                       <option value="l">L</option>
                                       <option value="m">M</option>
                                       <option value="s">S</option>
                                       <option value="xl">XL</option>
                                       <option value="xxl">XXL</option>
                                    </select>
                                 </td>
                                 <td class="d-">
                                    <div id="field2">
                                       <button type="button"  id="sub2" class="sub qty">-</button>
                                       <input type="number"  id="2"  value="1" min="1" max="3" />
                                       <button type="button" id="add2" class="add qty">+</button>
                                    </div>
                                 </td>
                              </tr>
                              <tr class="align-middle alert border-bottom" role="alert">
                                 <td>
                                    <input type="checkbox" id="check">
                                 </td>
                                 <td class="text-center">
                                    <img class="pic"
                                       src="https://www.freepnglogos.com/uploads/shoes-png/dance-shoes-png-transparent-dance-shoes-images-5.png"
                                       alt="">
                                 </td>
                                 <td>
                                    <div>
                                       <p class="m-0 fw-bold">Sneakers Shoes 2020 For Men</p>
                                       <p class="m-0 text-muted">Fugiat Voluptates quasi nemo,ipsa perferencis</p>
                                    </div>
                                 </td>
                                  <td>
                                    <select class="form-select selects" aria-label="Default select example">
                                       <option selected>Select Size:</option>
                                       <option value="l">L</option>
                                       <option value="m">M</option>
                                       <option value="s">S</option>
                                       <option value="xl">XL</option>
                                       <option value="xxl">XXL</option>
                                    </select>
                                 </td>
                                 <td class="d-">
                                    <div id="field2">
                                       <button type="button"  id="sub2" class="sub qty">-</button>
                                       <input type="number"  id="2"  value="1" min="1" max="3" />
                                       <button type="button" id="add2" class="add qty">+</button>
                                    </div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!--Item added-->
               </div>

              

            </div>
         </div>
      </div>

   </div>
</div>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js'>
   
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type='text/javascript'>
   
   $("#btnsearch").click(function(){
   //  alert("ee");
	   var prn= $("#enrollment_no").val();
	   if(prn !=""){
		$.ajax({
		type:'POST',
      dataType:'JSON',
		url: '<?php echo base_url()?>Uniform/check_for_data', 
		//data: enrollment_no : prn,
      data: {enrollment_no:prn},
		success: function (data) {
         //console.log(data);
         //alert(data.data);
          $("#allprndata").html(data.data);
          $("#allprndatap").html(data.data1);
		}
		});		
	   }
       else{
		  $("#enrollment_error").html("Please enter PRN"); 
	   }	 
   });
 
 $(document).ready(function(){

var enrollment_no=$("#enrollment_no").val();

if(enrollment_no !=''){
	$("#prnentry").addClass('hidden');
	$('#btnsearch').trigger('click');
	
}


////HK///////////////////////////////////////////////////////////

$("#content-wrapper").on('click', '#btnsearch1', function () {
    $('#btnsearch1').prop('disabled', true);
    var eid = $("#enrollment_no").val();
    var chk = [];
    var productID = [];
    var sizeID = [];
    var qtyID = [];
    var gender = $("#gender").val();
    var remark = $("#remark").val();

    if (gender === '') {
        alert('Select the gender');
        $('#btnsearch1').prop('disabled', false);
        return false;
    }

    $.each($("input[name='pID']:checked"), function () {
        chk = $(this).val();
        var srn = $('#sID' + chk).val();
        var qty = $('#qty' + chk).val();
       
        if (srn === '' || qty === '') {
            alert('Select size and quantity for all products');
            $('#btnsearch1').prop('disabled', false);
            return false;
        }

        productID.push($('#pID' + chk).val());
        sizeID.push($('#sID' + chk).val());
        qtyID.push($('#qty' + chk).val());
    });
 //
 var remark = $("#remark").val();
        if (remark === '') {
        alert('Please enter a remark');
        $('#btnsearch1').prop('disabled', false);
        return false;
    }
        //
    if (productID.length > 0) {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo base_url()?>Uniform/checkinventory',
            data: { productID: productID, sizeID: sizeID, qtyID: qtyID, eid: eid, gender: gender ,remark: remark},
            success: function (data) {
                if (data.status == '1') {
                    window.location.reload(true);
                } else {
                  alertAndEnable(data.message);
                }
            }
        });
    } else {
        $('#btnsearch1').prop('disabled', false);
        alertAndEnable('At least one product and gender should be selected');
    }
});


$("#content-wrapper").on('click', '.add', function () {   

    var th = $(this).closest('.wrap').find('.count');  
    var qtyNumber = parseInt(th.attr("maxlength"));
    var currentValue = parseInt(th.val());
    
    // Identify the product by its index or any other suitable condition  
    var productIndex = th.closest('tr').index();
    //var takeclostofcheckbox
    var chk= th.closest('tr').find('input:checkbox').attr('id');
    chk=chk.replace("pID", "");
    chk=Math.round(chk);
    var max_qty=1;

    var product_id = [2,4,7,8];
    if(product_id.includes(chk)){
      
      max_qty=2;
    }


    //alert(chk);
    //console.log(chk);
    // alert(chk);
   //var chk= th.closest('tr').find('[type=checkbox]').id;
  // console.log(chk);
   //var chk=th.closest('tr').prev().find('input[type=checkbox]');
  // console.log(chk);
    // Set different default values based on the product index
    //var max_qty = (productIndex === 0 || productIndex === 1) ? 2 : 1;
    var submited_qty=currentValue+1;

  
   if(max_qty<submited_qty){
   alert("reached to max limit of "+currentValue);
   }
   else{
   var newValue = Math.min(currentValue + 1, max_qty);
      th.val(newValue);
   }


});





   $("#content-wrapper").on('click', '.sub', function () {
     var th = $(this).closest('.wrap').find('.count');      
         if (th.val() > 1) th.val(+th.val() - 1);
   });
   
   function alertAndEnable(message) {
        alert(message);
        $('#btnsearch1').prop('disabled', false);
    }

});   
</script>