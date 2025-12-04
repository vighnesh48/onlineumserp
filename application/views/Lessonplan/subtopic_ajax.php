<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

<script>
$(document).ready(function() {
  $('#stopic_no').multiselect({
    buttonWidth : '160px',
    //includeSelectAllOption : true,
	enableFiltering: true
  });
    });
  </script>
  
<select name="subtopic_no[]" id="stopic_no" class="form-control"  multiple='multiple' required>
<?php if (!empty($subtpc)) {
                foreach ($subtpc as $value) {
                    echo '<option value="' .$value['unit_no'].'_'.$value['topic_no'].'_'.$value['subtopic_no'].'">' . $value['unit_no'].'.'.$value['topic_no'].'.'.$value['subtopic_no'].'.'.$value['topic_contents'] . '</option>';
                }
				//echo '<option value="Other">Other</option>';
            } else {
                echo '<option value="">subtopic not available</option>';
            }
?>			
</select>