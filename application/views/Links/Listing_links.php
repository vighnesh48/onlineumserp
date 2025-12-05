<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Useful Links</title>

<style>
.main-wrapper {
    background: #abd3e9; !important;
    padding: 60px 0 !important;
    min-height: 100vh !important;
}

.links-container {
    max-width: 92% !important;
    margin: auto !important;
    background: rgba(255, 255, 255, 0.95) !important;
    border-radius: 25px !important;
    padding: 50px 60px !important;
    box-shadow: 0px 10px 35px rgba(0, 41, 92, 0.35) !important;
}

.section-title {
    font-size: 32px !important;
    font-weight: 800 !important;
    text-align: center !important;
    color: #004aad !important;
    margin-bottom: 20px !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
}

.link-card {
    background: #ffffff !important;
    border-radius: 18px !important;
    padding: 25px !important;
    border: 1px solid #d9eaff !important;
    margin-bottom: 25px !important;
    transition: all .3s ease-in-out !important;
    box-shadow: 0 5px 12px rgba(0, 89, 170, 0.18) !important;
}

.link-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 12px 28px rgba(0, 79, 159, 0.35) !important;
}

.card-accent {
    height: 6px !important;
    background: linear-gradient(90deg, #004aad, #0078d7) !important;
    width: 100% !important;
    border-radius: 8px !important;
    margin-bottom: 10px !important;
}

.link-title {
    font-size: 20px !important;
    color: #004aad !important;
    font-weight: 700 !important;
    margin-bottom: 8px !important;
}

.link-desc {
    color: #333 !important;
    font-size: 15px !important;
    margin-bottom: 20px !important;
    min-height: 60px !important;
    font-weight: 500 !important;
}

.btn-visit {
    background: linear-gradient(90deg, #004aad, #0078d7) !important;
    color: #fff !important;
    padding: 10px 22px !important;
    border-radius: 50px !important;
    font-weight: 700 !important;
    float: right !important;
    border: none !important;
    font-size: 14px !important;
    transition: .3s !important;
}

.btn-visit:hover {
    background: #003b8e !important;
    transform: scale(1.06) !important;
}
</style>

</head>

<body>

<div class="main-wrapper">
    <div class="links-container">
        <h1 class="section-title">
            <span class="glyphicon glyphicon-link"></span> Useful Academic & Student Links
        </h1>
        <hr>

        <div class="row">
            <?php foreach($links as $link): ?>
            <div class="col-md-4 col-sm-6">
                <div class="link-card">
                    <div class="card-accent"></div>

                    <div class="link-title"><?= $link['link_title']; ?></div>

                    <div class="link-desc"><?= nl2br($link['description']); ?></div>

                    <a href="<?= $link['url']; ?>" target="_blank" class="btn btn-visit">
                        Visit Link &nbsp; <span class="glyphicon glyphicon-arrow-right"></span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

</body>
</html>
