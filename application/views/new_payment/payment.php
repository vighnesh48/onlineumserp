<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
	};
</script>
<div class="container" >
    <div class="row">
      <div class="col-md-12">
		<form method="post" name="customerData" action="<?php echo base_url();?>Payment_handler/save">

		<table width="40%" height="100" border='1' align="center">
			<table width="40%" height="100"  align="center" class="table" style="border:1px solid blue;">
				<center><h2 style="color:green;">CCavenue Payment Gateway Integration In PHP</h2></center>
				
				<tr>
					<td>TID	:</td><td><input type="text" name="tid" id="tid" value="<?php echo date('YmdHis');?>" readonly /></td>
				</tr>
				<tr>
					<td>Merchant Id	:</td><td><input type="text" name="merchant_id" value="268753"/></td>
				</tr>
				<tr>
					<td>Order Id	:</td><td><input type="text" name="order_id" value="123654789"/></td>
				</tr>
				<tr>
					<td>Amount	:</td><td><input type="text" name="amount" value="1.00"/></td>
				</tr>
				<tr>
					<td>Currency	:</td><td><input type="text" name="currency" value="INR"/></td>
				</tr>
				<tr>
					<td>Redirect URL	:</td><td><input type="text" name="redirect_url" value="<?php echo base_url();?>Payment_handler/payment_succes/"/></td>
				</tr>
			 	<tr>
			 		<td>Cancel URL	:</td><td><input type="text" name="cancel_url" value="<?php echo base_url();?>Payment_handler/payment_succes/"/></td>
			 	</tr>
			 	<tr>
					<td>Language	:</td><td><input type="text" name="language" value="EN"/></td>
				</tr>
		     	
		        <tr>
		        	<td colspan="2">Shipping information(optional)</td>
		        </tr>
		        <tr>
		        	<td>merchant_param1:</td><td><input type="text" name="merchant_param1" value="merchant_param"/></td>
		        </tr>
		        <tr>
		        	<td>merchant_param2	:</td><td><input type="text" name="merchant_param2" value="room no.701 near bus stand"/></td>
		        </tr>
		        <tr>
		        	<td>merchant_param3	:</td><td><input type="text" name="merchant_param3" value="Hyderabad"/></td>
		        </tr>
		        <tr>
		        	<td>merchant_param4	:</td><td><input type="text" name="merchant_param4" value="Andhra"/></td>
		        </tr>
		        <tr>
		        	<td>merchant_param5	:</td><td><input type="text" name="merchant_param5" value="425001"/></td>
		        </tr>
		       
		        <tr>
		        	<td></td><td><INPUT TYPE="submit" value="CheckOut"></td>
		        </tr>
	      	</table>
	      </form>
	    </div>
	</div>
</INPUT>