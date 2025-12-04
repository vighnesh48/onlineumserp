<script>
   //<![CDATA[
   $(document).ready(function(){
   		$("#myModal").modal('show');
   	});
   //]]>
  function hide_model(){
 $("#myModal").modal('hide');
  }
</script>
<div id="myModal" class="modal fade ">
   
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <span style="font-size: 36px; float: right; color: #fff!important; margin-top: -15px;cursor: pointer;" onclick="hide_model()">×</span>               
            
            <br />
         </div>
         <div class="modal-body">
		
            <p>Dear Students & Staff, </p>

 <p>Sandip University has launched <strong>Sandip Care</strong>, a unique online portal to address student and staff grievances. Each student and staff member will be provided with personalised login credentials to utilise the portal and raise tickets to address any issue they may be facing.</p>

 <p>Each ticket will be resolved in 48 working hours (conditions apply). The ticket will be assigned to concerned departments and will be addressed by concerned authorities. We have designed a fool-proof system to address each issue as quickly and as accurately as possible.</p>

 <p>Visit<strong> <a href="https://wecare.sandipuniversity.edu.in/login/switchtoref_erp/<?=$username?>/<?=$campus?>/<?=$rolid?>" target="_blank">https://wecare.sandipuniversity.edu.in</a> </strong>to utilise Sandip Care. Users can login and click on <strong>“User Manual”</strong> to learn how to raise a ticket effectively. </p> 

 <p>We are here to make your experience at Sandip University the very best, because we care!</p>

 <p>Thank you<br/>
Management, Sandip University </p>

            
         </div>
      </div>
   </div>
</div>

<style>
.modal-header {
    background: #00385c!important;
}
.modal-body {
    background-color: #edf8ff!important;
}
p{font-size:15px;line-height:24px;}
.site-header {
    position: relative;
    z-index: 999!important;
}
.close {
    display: inline-block;
    margin-top: 0px;
    margin-right: 0px;
    width: 9px;
    height: 9px;
    background-repeat: no-repeat !important;
    text-indent: 0px!important;
    outline: none;
    background-image: url(../img/remove-icon-small.png) !important;
}
</style>