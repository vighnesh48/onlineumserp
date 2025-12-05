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
    <div class="header-btns">
        <button class="btn btn-ticket">FAQS</button>
    </div>
    <!-- FAQ Filter Tabs -->
    <h3><strong>FAQs</strong></h3>

<div class="faq-tabs">
    <button class="btn active" data-filter="all">All</button>
    <?php 
    $cats = array_unique(array_column($faqs,'category'));
    foreach($cats as $c){ ?>
    <button class="btn" data-filter="<?= $c ?>"><?= ucfirst($c) ?></button>
    <?php } ?>
</div>
<br>

<div class="faq-list">
<?php $i = 1; foreach($faqs as $row){ ?>
    <div class="faq-block" data-category="<?= $row['category']; ?>">
        <div class="faq-item">
            <?= $i++ . ". " . $row['question']; ?>
            <span class="faq-arrow glyphicon glyphicon-chevron-down"></span>
        </div>
        <div class="faq-answer"><?= nl2br($row['answer']); ?></div>
    </div>
<?php } ?>
</div>

<script>
$(".faq-item").click(function () {
    $(this).next(".faq-answer").slideToggle();
    $(this).find(".faq-arrow").toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
});

$(".faq-tabs .btn").click(function () {
    $(".faq-tabs .btn").removeClass("active");
    $(this).addClass("active");
    let filter = $(this).data("filter");
    if (filter === "all") { $(".faq-block").show(); }
    else {
        $(".faq-block").hide();
        $('.faq-block[data-category="' + filter + '"]').show();
    }
});
</script>

</body>
</html>
