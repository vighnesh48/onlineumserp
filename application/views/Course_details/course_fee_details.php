<!DOCTYPE html>
<html>
<head>
    <title>Fee Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body {
            background: #f7f7f7;
     
        }

        /* Top Section */
        .header-box {
            background: linear-gradient(to right, #1a8eb4, #2fb3d8);
            padding: 30px 20px;
            border-radius: 25px;
            margin-bottom: 30px;
            color: #fff;
            position: relative;
        }

        .pay-now-btn {
            position: absolute;
            right: 20px;
            top: 30px;
        }

       .circle-box {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 10px solid #056e8f;
    position: relative;
    margin: -2px auto;
    text-align: center;
    color: #ffffff;
    font-weight: bold;
}

        .circle-box span {
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            font-size: 20px;
        }

        /* Section titles */
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0 10px;
        }

        /* Tables */
        .table > thead > tr > th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .table-striped > tbody > tr:nth-child(even) {
            background: #fff;
        }

        .approved {
            background: #d9f5dd;
            padding: 5px 15px;
            border-radius: 20px;
            color: #37a34a;
            font-size: 13px;
            font-weight: bold;
        }

       .receipt-btn {
    background: #dbb9b7;
    border: none;
    color: #d11c1c;
    padding: 4px 19px;
    font-size: 13px;
    border-radius: 25px;
}

           .ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
           
        }
    </style>
</head>
<body>

<div class="container-fluid" style="padding:40px 25px;margin-top:20px">
    <div class="ticket-container">

    <!-- TOP SUMMARY BOX -->
    <div class="header-box">

        <div class="row">
            <div class="col-sm-2 text-center">
                <div class="circle-box">
                    <span>₹85,000<br>paid</span>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="row text-center">
                    <div class="col-sm-4">
                        <h3>Fee Plan</h3>
                        <strong>Annual Payment</strong>
                    </div>
                    <div class="col-sm-4">
                        <h3>Total Fee</h3>
                        <strong>₹170,000</strong>
                    </div>
                    <div class="col-sm-4">
                        <h3>Due Amount</h3>
                        <strong>₹42,500</strong>
                    </div>
                </div><hr/>
                <div class="row text-center" style="margin-top:10px;">
                    <div class="col-sm-12">
                        <h3>Due Date</h3>
                        <strong>June 2026</strong>
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <button class="btn btn-danger pay-now-btn">Pay Now</button>
            </div>
        </div>
    </div>

    <!-- INSTALLMENT DETAILS -->
    <div class="section-title">Installment Details</div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Payment Head</th>
            <th>Due Date</th>
            <th>Inst. Amount</th>
            <th>Paid Amount</th>
            <th>Due Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Installment 1</td>
            <td>June 2025</td>
            <td>₹42,500</td>
            <td>₹42,500</td>
            <td>₹0</td>
        </tr>
        <tr>
            <td>Installment 2</td>
            <td>December 2025</td>
            <td>₹42,500</td>
            <td>₹42,500</td>
            <td>₹0</td>
        </tr>
        <tr>
            <td>Installment 3</td>
            <td>June 2026</td>
            <td>₹42,500</td>
            <td>₹0</td>
            <td>₹42,500</td>
        </tr>
        <tr>
            <td>Installment 4</td>
            <td>December 2026</td>
            <td>₹42,500</td>
            <td>₹0</td>
            <td>₹42,500</td>
        </tr>
        </tbody>
    </table>

    <p class="text-muted">Installment due dates are tentative and based on your academic calendar.</p>

    <!-- PAYMENT HISTORY -->
    <div class="section-title">Payment History</div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Payment Head</th>
            <th>Payment Date</th>
            <th>Mode</th>
            <th>Amount</th>
            <th>Tran ID</th>
            <th>Approval Status</th>
            <th>Receipt</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Application Fee</td>
            <td>05 May 2025</td>
            <td>Cash</td>
            <td>₹1,500</td>
            <td>11000276810381</td>
            <td><span class="approved">approved</span></td>
            <td><button class="receipt-btn">Receipt</button></td>
        </tr>

        <tr>
            <td>Course Fees</td>
            <td>19 May 2025</td>
            <td>Cash</td>
            <td>₹79,772</td>
            <td>513912490977</td>
            <td><span class="approved">approved</span></td>
            <td><button class="receipt-btn">Receipt</button></td>
        </tr>

        <tr>
            <td>Course Fees</td>
            <td>19 May 2025</td>
            <td>Cash</td>
            <td>₹5,228</td>
            <td>513912490977</td>
            <td><span class="approved">approved</span></td>
            <td><button class="receipt-btn">Receipt</button></td>
        </tr>
        </tbody>
    </table>

</div>
</div>


</body>
</html>
