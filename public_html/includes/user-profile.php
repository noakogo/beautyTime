<!DOCTYPE html>
<?php
    require_once "db-connection.php";
    session_start();

    $userID = $_SESSION["ID"];
    $firstName = "test";
    $userProfileQuery = "SELECT * FROM Customers WHERE customer_id='".$userID."'";
    $userProfileResult = $conn->query($userProfileQuery);
    if ($userProfileResult->num_rows > 0) {
        $userRow = $userProfileResult->fetch_assoc();
        $firstName = $userRow['first_name'];
        $lastName = $userRow['last_name'];
        $phone = $userRow['phone'];
        $email = $userRow['email'];
        $address = $userRow['address'];
        $birthDay = $userRow['date_of_birth'];
        $dbPassword = $userRow['password'];
    }
    
    $error = '';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $firstName = test_input($_POST["FirstName"]);
      $lastName = test_input($_POST["LastName"]);
      $phone = test_input($_POST["Phone"]);
      $email = test_input($_POST["Email"]);
      $address = test_input($_POST["Address"]);
      $oldPassword = test_input($_POST["Old_Password"]);
      $newPassword = test_input($_POST["New_Password"]);
      
      $isEmailExistQuery = "SELECT * from Customers WHERE email='$email'";
      $isEmailExistResult = $conn->query($isEmailExistQuery);
      
      if ($isEmailExistResult->num_rows > 1) {
        $error = "Email already exist. Please use different email address.";
        
      } else {
          if ($newPassword) {
              if ($oldPassword === $dbPassword) {
                  $password = $newPassword;
              } else {
                  $error = "Wrong old password";
              }
          }
          
          if (!$error) {
                $insertNewCustomerQuery = "Update Customers SET first_name='".$firstName."',last_name='".$lastName."',phone='".$phone."',email='".$email."',address='".$address."',password='".$password."' WHERE customer_id=".$userID."";
                $insertNewCustomerResult = $conn->query($insertNewCustomerQuery);
            
                if ($insertNewCustomerResult == TRUE) {
                    $userProfileQuery = "SELECT * FROM Customers WHERE customer_id='".$userID."'";
                    $userProfileResult = $conn->query($userProfileQuery);
                    if ($userProfileResult->num_rows > 0) {
                        $userRow = $userProfileResult->fetch_assoc();
                        $firstName = $userRow['first_name'];
                        $lastName = $userRow['last_name'];
                        $phone = $userRow['phone'];
                        $email = $userRow['email'];
                        $address = $userRow['address'];
                        $birthDay = $userRow['date_of_birth'];
                        $dbPassword = $userRow['password'];
                        
                    echo '<script>
                        alert("success");
                        sessionStorage.setItem("first_name","'.$firstName.'");
                    </script>';
                    }
                } else {
                    echo '<script> alert("Error: we couldn\'t save your details, please contact us for support") </script>';
                }
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

<html lang="en">
<head>
    <title>Beauty Zone - Profile </title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script type="text/javascript" src="/JS/common.js"></script>
    <script src="/JS/profile.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/profile.css">
    <link rel="stylesheet" type="text/css" href="../CSS/forms.css">

</head>
<header>
	<div id="common"></div>
</header>
<body>
    

<div class="patternBackground">
    <div class="btn-group" style="width:100%">
        <button id="my-profile" class="navigation-btn" style="width:33.3%" onclick=switchNavigation('my-profile')>Profile</button>
        <button id="my-appointments" class="navigation-btn" style="width:33.3%" onclick=switchNavigation('my-appointments')>My Appointments</button>
        <button id="my-payments" class="navigation-btn" style="width:33.3%" onclick=switchNavigation('my-payments')>Payments</button>
    </div>
    <div class="profile-content">
        <div id="update-profile-content">
            <form class="SignForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form">
                    <div class="formBackground">
                        <p>
                            <fieldset>
                                <div class="form-title-row">Please fill your personal details
                                </div>
                                <div class="form-row">
                                    <p>
                                        <label>
                                            <span>First Name:</span>
                                            <input type="text" name="FirstName"  value="<?php echo $firstName ?>">
                                        </label>
                                    </p>
                                </div>
                                <div class="form-row">
                                    <p>
                                        <label>
                                            <span>Last Name:</span>
                                            <input type="text" name="LastName" value="<?php echo $lastName ?>">
                                        </label>
                                    </p>
                                </div>
                            	<div class="form-row">
                                    <p>
                                        <label>
                                            <span>ID:</span>
                                            <input type="text" value="<?php echo $userID ?>" disabled>
                                        </label>
                                    </p>
                                </div>          
                                <div class="form-row">
                                    <p>
                                        <label>
                                            <span>Date Of Birth:</span>
                                            <input type="date" value="<?php echo $birthDay ?>" disabled>
                                        </label>
                                    </p>
                                </div>
                            	<div class="form-row">
                                    <p>
                                        <label>
                                            <span>Phone:</span>
                                            <input type="tel" name="Phone" id="Phone" pattern="^0(5[^7]|[2-4]|[8-9]|7[0-9])[0-9]{7}$" title="Please validate your phone number" value="<?php echo $phone ?>">
                                        </label>
                                    </p>
                                </div>
                            	<div class="form-row">
                                    <p>
                                        <label>
                                            <span>Email:</span>
                                            <input type="E-mail" name="Email" id="Email" pattern = "(?:[a-z0-9!#$%&*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&*+/=?^_`{|}~-]+)*|(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" title="E-mail address is not valid" value="<?php echo $email ?>">
                                        </label>
                                    </p>
                                </div>
                                <div class="form-row">
                                    <p>
                                        <label>
                                            <span>Address:</span>
                                            <input type="text" name="Address" value="<?php echo $address ?>">
                                        </label>
                                    </p>
                                </div>
                                <div class="form-row">
                                    <p>
                                        <label>
                                            <span>Old password:</span>
                                            <input type="Password" name="Old_Password" id="Old_Password" pattern ="^[a-zA-Z0-9]{8,}$" title="The password must be at least 8 characters">
                                        </label>
                                    </p>
                                </div>
                                <div class="form-row">
                                    <p>
                                        <label>
                                            <span>New password:</span>
                                            <input type="Password" name="New_Password" id="New_Password" pattern ="^[a-zA-Z0-9]{8,}$" title="The password must be at least 8 characters">
                                        </label>
                                    </p>
                                </div>
                                <span style="color:red;"><?php echo $error; ?></span>
                                <div class="form-row">
                                    <p>
                                        <button type="submit">Update profile</button>
                                    </p>
                                </div>
                            </fieldset>
                        </p>
                    </div>
                </div>
            </form>
        </div>
        
        <div id="appointments-content">
            <?php 
                $appointmentsQuery = "SELECT * FROM Appointments WHERE customer_id='".$userID."'";
                        echo '
                        <div class="container">
                          <table style="" class="table" id="appointmentsTbl">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Type</th>
                              </tr>
                            </thead>
                            <tbody>';
                            $appointmentsResult = $conn->query($appointmentsQuery);

                            if ($appointmentsResult->num_rows > 0) {

                                    
                                while ($appointmentsResultItem = $appointmentsResult->fetch_assoc()) {
                                        $a_id = $appointmentsResultItem['id'];
                                        $a_date = $appointmentsResultItem['a_date'];
                                        $a_hour = $appointmentsResultItem['a_hour'];
                                        $a_type = $appointmentsResultItem['a_type'];

                                          
                                        $a_date_datetime = new DateTime($a_date.' '.$a_hour);
                                        $now_datetime = new DateTime("now");
                                        
                                        if ($now_datetime < $a_date_datetime) {
                                            echo '
                                               <tr>
                                                    <td>' .$a_date. '</td>
                                                    <td>' .$a_hour. '</td>
                                                    <td>' .$a_type. '</td>
                                                    <td><form action="cancel-appointment.php?id='.$a_id.'" method="post"><input name="a_id" type="text" style="display:none;" value="'.$a_id.'"><input type="submit" class="btn btn-default" value="Cancel"></form></td>
                                                </tr>
                                            ';
                                            
                                        }
                                }
                            }
                              echo '
                                    </tbody>
                                  </table>
                                </div>';
                    ?>
            
        </div>
        
                <div id="payments-content">
            <?php 
                $paymentsQuery = "SELECT * FROM Payments WHERE customer_id='".$userID."'";
                        echo '
                        <div class="container">
                          <table class="table" id="appointmentsTbl">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Purchase Time</th>
                                <th>Price</th>
                              </tr>
                            </thead>
                            <tbody>';
                            $paymentsResult = $conn->query($paymentsQuery);

                            if ($paymentsResult->num_rows > 0) {
                                while ($paymentsResultItem = $paymentsResult->fetch_assoc()) {
                                        $productTitle = $paymentsResultItem['product_title'];
                                        $purchaseDate = $paymentsResultItem['purchase_date'];
                                        $price = $paymentsResultItem['price'].'$';

                                        echo '
                                           <tr>
                                                <td>' .$productTitle. '</td>
                                                <td>' .$purchaseDate. '</td>
                                                <td>' .$price. '</td>
                                            </tr>';
  
                                }
                            }
                              echo '
                                    </tbody>
                                  </table>
                                </div>';
                    ?>
            
        </div>

    </div>
</div>
    


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

