<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign up</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/forms.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../JS/scripts.js"></script>
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

    $error = $FirstName = $LastName = $ID = $BDate = $Phone = $Email = $Address = $GetNotification = $Password = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $FirstName = test_input($_POST["FirstName"]);
      $LastName = test_input($_POST["LastName"]);
      $ID = test_input($_POST["ID"]);
      $BDate = test_input($_POST["BDate"]);
      $Phone = test_input($_POST["Phone"]);
      $Email = test_input($_POST["Email"]);
      $Address = test_input($_POST["Address"]);
      $Password = test_input($_POST["Password"]);

      $isEmailExistQuery = "SELECT * from Customers WHERE email='$Email'";
      $isEmailExistResult = $conn->query($isEmailExistQuery);
      if ($isEmailExistResult->num_rows > 0) {
        $error = "Email already exist. Please register with different mail address.";
        
      } else {
        $insertNewCustomerQuery = "INSERT INTO Customers(customer_id, first_name, last_name, date_of_birth, phone, email, address, password) VALUES ('".$ID."','".$FirstName."','".$LastName."','".$BDate."','".$Phone."','".$Email."','".$Address."','".$Password."');";
        $insertNewCustomerResult = $conn->query($insertNewCustomerQuery);

        if ($insertNewCustomerResult == TRUE) {
            session_regenerate_id();
            $_SESSION['ID'] = $ID;
            setcookie("ID", $ID, time()+3600);
            echo '<script>
                sessionStorage.setItem("isLoggedIn", true);
                sessionStorage.setItem("first_name","'.$FirstName.'");
                window.location = "/";
            </script>';
        } else {
            echo '<script> alert("Error: we couldn\'t save your details, this email already been signed in the system, please try with another one") </script>';
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

<form class="SignForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="form">
	    <div class="formBackground">
	    <p><fieldset>
	    <div class="form-title-row">Please fill your personal details
    </div>
                
	<div class="form-row">
		<p><label><span>First Name:</span><input type="text" name="FirstName" required></label></p></div>
		        <div class="form-row">
				    
		<p><label><span>Last Name:</span><input type="text" name="LastName" required></label></p></div>
				<div class="form-row">
				    
		<p><label><span>ID:</span><input type="text" name="ID" id="ID" pattern="^[0-9]{9}$" title="ID must contain 9 digits" required></label></p></div>          
				<div class="form-row">
				    
		<p><label><span>Date Of Birth:</span><input type="date" name="BDate" id="BDate" min="1920-01-01" max="2004-01-01" required></label></p></div>
				<div class="form-row">
				    
		<p><label><span>Phone:</span><input type="tel" name="Phone" id="Phone" pattern = "^0(5[^7]|[2-4]|[8-9]|7[0-9])[0-9]{7}$" title="Please validate your phone number" required></label></p></div>
				<div class="form-row">
				    
		<p><label><span>Email:</span><input type="E-mail" name="Email" id="Email" pattern = "(?:[a-z0-9!#$%&*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&*+/=?^_`{|}~-]+)*|(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" title="E-mail address is not valid" required></label></p></div>
                <div class="form-row">
                
        <p><label><span>Address:</span><input type="text" name="Address" required></label></p>
               
                
		<p><label><span>Password:</span><input type="Password" name="Password" id="Password" pattern ="^[a-zA-Z0-9]{8,}$" title="The password must be at least 8 characters" required></label></p> </div>
			
        <div class="form-row-radio">
		<p><label>
        <a id="conditions" href="#">I have read the conditions<input type="checkbox" name="terms" required></a>
            </label></p></div>
            
            <span style="color:red;"><?php echo $error; ?></span>
        <div class="form-row">

		<p><button type="submit">Sign Up</button></p></div>
		
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
    
<footer>
        <ol id="down-page" style="padding-left: 0px;" ;></ol>

        <script>
        $( "#down-page" ).load( "../index.html #down-page" );
        </script>
</footer>	
        

<script type="text/javascript">
 var vsid = "sa58193";
 (function() { 
 var vsjs = document.createElement('script'); vsjs.type = 'text/javascript'; vsjs.async = true; vsjs.setAttribute('defer', 'defer');
  vsjs.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'www.virtualspirits.com/vsa/chat-'+vsid+'.js';
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(vsjs, s);
 })();
</script>

</body>
</html>
