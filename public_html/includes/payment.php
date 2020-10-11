<!DOCTYPE html>

<?php
    // Include DB config file
    require_once "db-connection.php";
    session_start();
    $customer_id = $_SESSION['ID'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $data = $_POST['itmesInCart'];
        
        for ($i = 0; $i < count($data); $i++) {
            $insertNewPaymentQuery = "INSERT INTO Payments(customer_id, product_title, price) VALUES ('.$customer_id.','".$data[$i]['title']."','".$data[$i]['price']."')";
            $insertNewPaymentResult = $conn->query($insertNewPaymentQuery);
        }
    }

    $conn -> close();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PaymentPage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="/CSS/Payment.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/JS/payment.js"></script>
</head>
<body>
    <div id="common"></div>
		    <div class="container">
			<div class="card-holder">
			  <div class="card-box bg-news">
		       <div class="row">
				<div class="col-lg-6">
				<div class="card-body">
                <div id="payment-form" class="paymentForm">
				  <div class="card-details">
					<h3 class="title">Credit Card Details</h3>
					<div class="row">
					  <div class="form-group col-sm-7">
					   <div class="inner-addon right-addon">
						<label for="card-holder">Card Holder</label>
                        <i class="far fa-user"></i>
						<input id="card-holder" type="text" class="form-control" placeholder="Card Holder" aria-label="Card Holder" aria-describedby="basic-addon1" required>
					   </div>	
					  </div>
					  <div class="form-group col-sm-5">
						<label for="">Expiration Date</label>
						<div class="input-group expiration-date">
						  <input type="text" class="form-control" placeholder="MM" aria-label="MM" aria-describedby="basic-addon1" required>
						  <span class="date-separator">/</span>
						  <input type="text" class="form-control" placeholder="YY" aria-label="YY" aria-describedby="basic-addon1" required>
						</div>
					  </div>
					  <div class="form-group col-sm-8">
					   <div class="inner-addon right-addon">
						<label for="card-number">Card Number</label>
                        <i class="far fa-credit-card"></i>
   						<input id="card-number" type="text" class="form-control" placeholder="Card Number" aria-label="Card Holder" aria-describedby="basic-addon1" pattern="^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$" title="please verify your card number" required>

					   </div>	
					  </div>
					  <div class="form-group col-sm-4">
						<label for="cvc">CVC</label>
  						<input id="cvc" type="text" class="form-control" placeholder="CVC" aria-label="Card Holder" aria-describedby="basic-addon1" pattern="^[0-9]{3}$" required>

					  </div>
					  <div class="form-group col-sm-12">
						<button type="submit" id="payment-btn" class="btn btn-primary btn-block">Proceed</button>
					  </div>
					</div>
				  </div>
				</div>				
				</div>
		  		</div>
		       </div>
		       </div>
			  </div>
		</div>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="/JS/common.js"></script>
<script type="text/javascript"></script>
</body>
</html>