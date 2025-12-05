<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Filterable FAQ - Bootstrap 3</title>

<!-- Bootstrap 3 CSS -->


<style>
  .ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
           
        }
    /* Top Buttons */
    .header-btns { float:right; margin-top:-10px; }
.btn-ticket {
    background: #b01a2c;
    color: #fff !important;
    background: #1c8eb3;
    color: #fff;
    border-radius: 25px;
}


.btn-ticket:hover {
    color: #000000;
    border-color: #abd3e9;
    border-bottom-color: #000000;
    background: #abd3e9 !important;
    background-image: -webkit-linear-gradient(top, #efefef 0, #e5e5e5 100%) !important;
    background-image: linear-gradient(to bottom, #efefef 0, #e5e5e5 100%) !important;
    background-repeat: repeat-x;
}
    /* Category Tabs */
   
  .faq-tabs .btn.active {
    background: #1c6f8a!important;
    color: white!important;
}

 .faq-tabs .btn {
    background: #abd3e9;
    border: 1px solid #f4fbff;
    border-radius: 20px;
    color: #270707;
    margin-right: 6px;
}
   .faq-item {
    background: white;
    border: 1px solid #eee;
    padding: 18px;
    margin-bottom: 6px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    position: relative;
    border-radius: 15px;
}
.btn {
    border-width: 0;
    padding: 12px 14px;
    font-size: 14px;
    outline: none !important;
    background-image: none !important;
    filter: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    text-shadow: none;
}
    .faq-arrow {
        position:absolute;
        right:20px;
        top:19px;
        font-size:18px;
    }
  .faq-answer {
    background: #fff;
    border-left: 3px solid #1c8eb3;
    padding: 18px;
    display: none;
    margin-bottom: 10px;
}
</style>
</head>
<body>

<div class="container-fluid" style="padding:40px 25px;">
<div class="ticket-container">
    <!-- Header Section -->
    <h3 style="display:inline-block;"><strong>Recent Tickets</strong></h3>
    <div class="header-btns">
        <button class="btn btn-ticket">FAQS</button>
        <button class="btn btn-ticket">+ NEW TICKET</button>
    </div>
    <div class="clearfix"></div>
    <p><strong>No tickets found.</strong></p>

    <!-- FAQ Filter Tabs -->
    <h3><strong>FAQs</strong></h3>

    <div class="faq-tabs">
        <button class="btn active" data-filter="all">All</button>
        <button class="btn" data-filter="profile">Profile Update</button>
        <button class="btn" data-filter="general">General Query</button>
        <button class="btn" data-filter="assignments">Assignments</button>
        <button class="btn" data-filter="fee">Fee Query</button>
        <button class="btn" data-filter="results">Results Online</button>
    </div>

    <br>

    <!-- FAQ LIST -->
    <div class="faq-list">

        <!-- Each FAQ needs category data-category="profile/general/etc" -->

        <div class="faq-block" data-category="profile">
            <div class="faq-item">
                1. Edit Name
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">You can request a name change by contacting support.</div>
        </div>

        <div class="faq-block" data-category="profile">
            <div class="faq-item">
                2. Edit Email ID
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">Email update requires verification by admin.</div>
        </div>

        <div class="faq-block" data-category="assignments">
            <div class="faq-item">
                3. What is the due date for assignment submission?
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">Assignments must be submitted before the posted deadline.</div>
        </div>

        <div class="faq-block" data-category="assignments">
            <div class="faq-item">
                4. How do I submit my assignments online?
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">Upload your file in the assignment section.</div>
        </div>

        <div class="faq-block" data-category="assignments">
            <div class="faq-item">
                5. What should I keep in mind while attempting the assignment?
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">Follow guidelines and review instructions before submission.</div>
        </div>

        <div class="faq-block" data-category="assignments">
            <div class="faq-item">
                6. Can I attempt the assignment more than once?
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">Some assignments allow multiple attempts, others do not.</div>
        </div>

        <div class="faq-block" data-category="general">
            <div class="faq-item">
                7. What if I face a technical issue while submitting assignment?
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">Contact support immediately with a screenshot.</div>
        </div>

        <div class="faq-block" data-category="fee">
            <div class="faq-item">
                8. How can I check my fee status?
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">Fee details are available in your student dashboard.</div>
        </div>

        <div class="faq-block" data-category="results">
            <div class="faq-item">
                9. How do I view my results online?
                <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="faq-answer">Visit the results section in your portal.</div>
        </div>

    </div>
</div></div>


<script>

    /*------------------------------
        FAQ ACCORDION
    ------------------------------*/
    $(".faq-item").click(function () {
        $(this).next(".faq-answer").slideToggle();
        $(this).find(".faq-arrow")
            .toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });

    /*------------------------------
        FAQ FILTER BUTTON LOGIC
    ------------------------------*/
    $(".faq-tabs .btn").click(function () {

        // activate tab style
        $(".faq-tabs .btn").removeClass("active");
        $(this).addClass("active");

        let filter = $(this).data("filter");

        if (filter === "all") {
            $(".faq-block").show();
        } else {
            $(".faq-block").hide();
            $('.faq-block[data-category="' + filter + '"]').show();
        }
    });

</script>

</body>
</html>
