<?php
    // Include DB config file
    require_once "db-connection.php";
    session_start();

    $queryString = '?'.$_SERVER['QUERY_STRING'];
    $userId = $_GET['id'];
    $volunteering_id = $_POST["volunteeringid"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $delete_vol_subscription_query = "DELETE FROM volunteerings_to_users WHERE user_id=$query_param_user AND volunteering_id=$volunteering_id";

        if (mysqli_query($conn, $delete_vol_subscription_query)) {
            echo '<script>
                alert("Subscription deleted successfuly '.$delete_vol_subscription_query.'");
                window.location = "/volunteering-project/includes/php/profile.php?user='.$query_param_user.'";
            </script>';

        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

    }
    
    $conn -> close();
?>