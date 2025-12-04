<!DOCTYPE html>
<html>
<head>
    <title>Support Ticket</title>

    <!-- Bootstrap 3 -->



    <style>
        body {
            background: #f2f2f2;
            font-family: "Roboto", sans-serif;
        }
        .ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
           
        }
        .ticket-title {
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 25px;
        }
        .form-control {
            height: 52px;
            border-radius: 9px;
            box-shadow: none;
        }
        textarea.form-control {
            height: 150px;
            resize: none;
        }
        label {
            font-weight: 600;
        }
        .attach-box {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            margin-top: 10px;
            cursor: pointer;
            display: inline-block;
        }
        .glyphicon-upload:before {
            content: "\e027";
            font-size: 27px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .btn-cancel {
            background: #ffffff;
            border: 1px solid #1c8eb3;
            color: #1c8eb3;
            padding: 8px 25px;
            border-radius: 25px;
            margin-right: 10px;
        }
        .btn-submit {
            background: #1c8eb3;
            color: #ffffff;
            padding: 8px 25px;
            border-radius: 25px;
            border: none;
        }
        .upload-label {
            font-weight: 600;
            margin-right: 10px;
            vertical-align: middle;
        }
        .upload-icon {
            color: #1c8eb3;
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
<div class="container-fluid" style="padding:40px 25px;margin-top:20px">
    <div class="ticket-container">

        <div class="ticket-title">Support Ticket</div>

        <form id="supportTicketForm" enctype="multipart/form-data" novalidate>

            <!-- Ticket Type -->
            <div class="form-group">
                <label>Ticket Type *</label>
                <select class="form-control" name="ticketType" required>
                    <option value="">Select Type</option>
                    <option>General</option>
                    <option>Technical</option>
                </select>
            </div>

            <!-- Ticket Sub Type -->
            <div class="form-group">
                <label>Ticket Sub Type *</label>
                <select class="form-control" name="ticketSubType" required>
                    <option value="">Select Sub Type</option>
                    <option>Issue</option>
                    <option>Request</option>
                </select>
            </div>

            <!-- Ticket Subject -->
            <div class="form-group">
                <label>Ticket Subject *</label>
                <input type="text" class="form-control" name="ticketSubject" placeholder="Enter Ticket Subject" required>
            </div>

            <!-- Ticket Description -->
            <div class="form-group">
                <label>Ticket Description *</label>
                <textarea class="form-control" name="ticketDescription" placeholder="Enter Ticket Description" required></textarea>
            </div>

           <div class="form-group">

    <div class="attach-box" id="attachBox">
        <span class="upload-icon glyphicon glyphicon-upload"></span>
        <span class="upload-label">Upload Attachment</span>
        <span id="fileName" style="font-weight:600;"></span>
    </div>
    <input type="file" name="attachment" id="fileInput" style="display:none;">
</div>

            <!-- Buttons -->
            <button type="button" class="btn btn-cancel" id="btnCancel">CANCEL</button>
            <button type="submit" class="btn btn-submit">SUBMIT</button>

        </form>
    </div>
</div>

<script>
$(document).ready(function(){



    // Clicking the box triggers the hidden file input
    $('#attachBox').on('click', function(){
        $('#fileInput').click();  // trigger file select
    });

    // Show selected file name when user selects a file
    $('#fileInput').on('change', function(){
        var fileName = $(this).val().split('\\').pop(); // get file name only
        if(fileName) {
            $('#fileName').text(fileName);
        } else {
            $('#fileName').text('');
        }
    });


    // Cancel button resets form
    $('#btnCancel').on('click', function(){
        $('#supportTicketForm')[0].reset();
        $('#fileName').text('');
    });

    // Form validation
    $('#supportTicketForm').on('submit', function(e){
        e.preventDefault();

        var isValid = true;
        $(this).find('[required]').each(function(){
            if(!$(this).val()){
                $(this).css('border','1px solid red');
                isValid = false;
            } else {
                $(this).css('border','1px solid #ccc');
            }
        });

        if(!isValid){
            alert('Please fill all required fields.');
            return false;
        }

        // Example: submit form via AJAX or regular POST
        alert('Form submitted successfully!');

        // Reset after submission (optional)
        $(this)[0].reset();
        $('#fileName').text('');
    });

});
</script>

</body>
</html>
