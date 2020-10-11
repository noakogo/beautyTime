<!DOCTYPE html>
<?php

    // Include DB config file
    require_once "db-connection.php";
    session_start();
    $customer_id = $_SESSION['ID'];
     $insertNewPaymentQuery = "INSERT INTO Payments(customer_id, product_title, price) VALUES ('.$customer_id.','555','555'";
     $insertNewPaymentResult = $conn->query($insertNewCustomerQuery);
    echo "test";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $insertNewPaymentQuery = "INSERT INTO Payments(customer_id, product_title, price) VALUES ('.$customer_id.','444','444'";
     $insertNewPaymentResult = $conn->query($insertNewCustomerQuery);
        echo "post: <br>";
        echo $_POST['data'];
        $data = $_POST['itmesInCart'];
        echo "postttttttttt<br>";
        
         $insertNewPaymentQuery = "INSERT INTO Payments(customer_id, product_title, price) VALUES ('.$customer_id.','123','123'";

        $insertNewPaymentResult = $conn->query($insertNewCustomerQuery);

        if ($insertNewPaymentResult == TRUE) {
            header( "Location:http://noako-is.mtacloud.co.il/profile.php");
        } else {
            echo '<script> alert("Error: we couldn\'t save your details, please contact us for support") </script>';
        }
        if(isset($data)) {
                    echo "true";

        } else {
                    echo "false";

        }

    }
    

    
    $conn -> close();
    
    
?>