<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact-Us</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/forms.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/JS/common.js"></script>
</head>
<body>
<header>
	<div id="common"></div>
</header>
 
<main>
	
<div class="centerPattern">
<?php

    require_once "db-connection.php";
    
    session_start();
        
    // Instantiation and passing `true` enables exceptions

    $successMSG = $error = $first_name = $last_name = $email = $question = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $FirstName = test_input($_POST["FirstName"]);
      $LastName = test_input($_POST["LastName"]);
      $Email = test_input($_POST["Email"]);
      $Question = test_input($_POST["Question"]);

     $insertNewQuestionQuery = "INSERT INTO Questions(email, first_name, last_name, question) VALUES ('".$Email."','".$FirstName."','".$LastName."','".$Question."');";
     $insertNewQuestionResult = $conn->query($insertNewQuestionQuery);
        
         if ($insertNewQuestionResult == TRUE) {

            $to = 'beautyzoneproject@gmail.com';
            $subject = "New User ".$FirstName."".$LastName."| contact us page";
            $txt = "The content is: ".$Question." From user email: ".$Email."";
            $headers = 'From: noako-is.mtacloud.co.il';

            $retval = mail($to,$subject,$txt,$headers);

             if( $retval == true ) {
                $successMSG= '<div class="alert alert-success" role="alert">Thank you for contacting us! we will reply ASAP</div>';
             }
             else {
                $error = '<div class="alert alert-danger">We are having issues at the moment with processing your request</div>';
             }

         }
    }
    
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
   
    
?>

<form id="contact" class="SignForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="form">
	    <div class="formBackground">
	    <p><fieldset>
	    <div class="form-title-row" 
	    style="font-family: 'Arapey';
	           font-size: 40px;
               font-style: italic;
               font-weight: 400;">We would love to hear from you !
         </div>
    <span><?php echo $successMSG; ?></span>

	<div class="form-row">
		<p><label><span>First Name:</span><input type="text" name="FirstName" required></label></p></div>
		        <div class="form-row">
				    
		<p><label><span>Last Name:</span><input type="text" name="LastName" required></label></p></div>
				<div class="form-row">
				    
		<p><label><span>Email:</span><input type="E-mail" name="Email" id="Email" pattern = "(?:[a-z0-9!#$%&*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&*+/=?^_`{|}~-]+)*|(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" title="E-mail address is not valid" required></label></p></div>
                <div class="form-row">
                
		<p><label><span>Your Question:</span></label></p>
			
			    <textarea name="Question" id="Question" form="contact" rows="7"></textarea>

        </label></p></div>
            
        <span style="color:red;"><?php echo $error; ?></span>
        <div class="form-row">

		<p><button type="submit">Submit</button></p></div>
		
		</p></div>
		    </fieldset>
	    </div>
	</div>
</form>

<?php
    $conn->close();
?>
</div>
</main>
</body>
</html>