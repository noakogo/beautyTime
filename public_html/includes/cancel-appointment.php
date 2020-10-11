<!DOCTYPE html>
<?php
    require_once "db-connection.php";
    session_start();

    $userID = $_SESSION["ID"];
    $firstName = "test";
    
    $queryParams = '?'.$_SERVER['QUERY_STRING'];
    $queryParamAppointmentId = $_GET['id'];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cancelAppointmentsQuery = "DELETE FROM Appointments WHERE id=$queryParamAppointmentId";

        if (mysqli_query($conn, $cancelAppointmentsQuery)) {
            echo '<script>
                window.location = "/includes/user-profile.php";
            </script>';

        }
    }
    

?>  