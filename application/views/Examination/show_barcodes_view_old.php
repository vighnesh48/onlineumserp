<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Barcodes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .barcode-container {
            display: flex;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
            width: 100%; /* Ensure it uses the full width of the page */
            box-sizing: border-box;
            padding-top:14mm;
            padding-bottom:33mm!important;
            padding-left :13mm;
            /*padding-right:13mm;*/
        }
        .barcode-item {
            width:  3.4cm;
            height: 19mm; /* 2cm for the image and 1cm for the text */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            page-break-inside: avoid; /* Avoid breaking inside a barcode item */
            margin-right:1mm;
        }
        .barcode-item img {
            width: 2.0cm;
            height: 0.60cm;
            display: block;
           padding: 10px 5px 0px 5px;


        }
        .barcode-item p {
            margin: 1px 0 0; /* Small gap between the image and the number */
            font-size: 14px;
            text-align: center;
        }
        @page {
      size: A4 portrait;
   }


    </style>
</head>
<body>
    <div class="barcode-container">
        <?php if (isset($barcodess) && !empty($barcodess)): ?>
            <?php foreach ($barcodess as $barcodeImage): ?>
                <div class="barcode-item">
                    <img src="<?= $barcodeImage['image'] ?>" alt="Barcode">
                    <p><?= $barcodeImage['number'] ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No barcodes available</p>
        <?php endif; ?>
    </div>
</body>
</html>
