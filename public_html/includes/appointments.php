<!DOCTYPE html>
<html lang="en">
<head>
    <title>Appointments</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/Appointments-php.css">
    <script type="text/javascript" src="../JS/appointments.js"></script>
    <script type="text/javascript" src="/JS/common.js"></script>
</head>

<body>
  
<main>
	<div id="common"></div>
<div class="centerPattern">
<?php
    require '/home/noakois/vendor/autoload.php';
    require_once "db-connection.php";
    session_start();
    
    $getAllAppointmentsQuery = "SELECT a_date,a_hour FROM Appointments";
    $allAppointments = $conn->query($getAllAppointmentsQuery);
    while ($appointmentRow = $allAppointments->fetch_assoc()) {
        $allRows[] = $appointmentRow;
    }
    
    $allAppontmentsJson = json_encode($allRows);
    // forward the appointments details to session storage, so we will can use it in js for disable unavailble meetings
    echo '<script>sessionStorage.setItem("allAppointments", JSON.stringify('.$allAppontmentsJson.'));</script>';
    
    $a_type = $a_date = $a_hour = $customer_id = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $a_type = test_input($_POST["a_type"]);
          $a_date = test_input($_POST["a_date"]);
          $a_hour = test_input($_POST["a_hour"]);
          $customer_id = $_SESSION['ID'];
          
        
        if (empty($customer_id)) {
            echo '<script>alert("Please login to the system")</script>';
        } else {
            if (empty($a_hour) || empty($a_date)) {
                echo '<script>alert("Date and time must be selected")</script>';
            } else if (empty($a_type)) {
                     echo '<script>alert("Appointment type must be selected")</script>';
            } else {
                 $getAppointmentsQuery = "SELECT a_type,a_date,a_hour FROM Appointments WHERE a_type=$a_type AND a_date=$a_date AND a_hour=$a_hour";
                 $appointmentsResults = $conn->query($getAppointmentsQuery);
                  
                if ($appointmentsResults->num_rows == 0) {
                        $insertAppointmentQuery = "INSERT INTO Appointments(a_type, a_date, a_hour, customer_id) VALUES ('".$a_type."','".$a_date."','".$a_hour."','".$customer_id."');";
                        $insertAppointmentResult = $conn->query($insertAppointmentQuery);
                        
                        $getUserEmailQuery = "SELECT email FROM Customers WHERE customer_id=$customer_id";
                        $getUserEmailResult = $conn->query($getUserEmailQuery);
        
                        if ($insertAppointmentResult == TRUE) {
                            // Get the API client and construct the service object.
                            if ($getUserEmailResult == TRUE) {
                                $customerRow = $getUserEmailResult->fetch_assoc();
                                $customerEmail = $customerRow['email'];
                                
                                $client = getClient();
                                $service = new Google_Service_Calendar($client);
                                $event = new Google_Service_Calendar_Event(array(
                                  'summary' => 'Beauty Clinic Project Invitation',
                                  'location' => 'Our Clinic, Tel Aviv-Yafo',
                                  'description' => 'Thanks for scheduling the appointment with us :)',
                                  'start' => array(
                                    'dateTime' => $a_date.'T'.$a_hour.':00',
                                    'timeZone' => 'Israel',
                                  ),
                                  'end' => array(
                                    'dateTime' => $a_date.'T'.$a_hour.':00',
                                    'timeZone' => 'Israel',
                                  ),
                                  'attendees' => array(
                                    array('email' => $customerEmail)
                                  ),
                                  'reminders' => array(
                                    'useDefault' => FALSE,
                                    'overrides' => array(
                                      array('method' => 'email', 'minutes' => 24 * 60),
                                      array('method' => 'popup', 'minutes' => 10),
                                    ),
                                  ),
                                ));
                                
                                $calendarId = 'primary';
                                $event = $service->events->insert($calendarId, $event, ['sendUpdates' => 'all']);
        
                                $allAppointments = $conn->query($getAllAppointmentsQuery);
                                while ($appointmentRow = $allAppointments->fetch_assoc()) {
                                    $allRows[] = $appointmentRow;
                                }
                                
                                $allAppontmentsJson = json_encode($allRows);
                                // forward the appointments details to session storage, so we will can use it in js for disable unavailble meetings
                                echo '<script>sessionStorage.setItem("allAppointments", JSON.stringify('.$allAppontmentsJson.'));</script>';
            
                                echo '<script>alert("Success: the appointment is booked. Check your email '.$customerEmail.' for saving the event on your calendar.")</script>';
                            }
                    } else {
                        echo '<script>alert("Error: we couldn\'t set you an appointment")</script>';
                    }
                     
                } else {
                    echo '<script>alert("Error: this appointment is already booked")</script>';
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
    
    function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        //$client->setPrompt('select_account consent');
    
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }
    
        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));
    
                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
    
                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
    
    
?>

<script>

</script>

<header>
  <div class="wrapper">
    <div class="c-monthyear">
    <div class="c-month">
        <span id="prev" class="prev fa fa-angle-left" aria-hidden="true"></span>
        <div id="c-paginator">
          <span class="c-paginator__month">JANUARY</span>
          <span class="c-paginator__month">FEBRUARY</span>
          <span class="c-paginator__month">MARCH</span>
          <span class="c-paginator__month">APRIL</span>
          <span class="c-paginator__month">MAY</span>
          <span class="c-paginator__month">JUNE</span>
          <span class="c-paginator__month">JULY</span>
          <span class="c-paginator__month">AUGUST</span>
          <span class="c-paginator__month">SEPTEMBER</span>
          <span class="c-paginator__month">OCTOBER</span>
          <span class="c-paginator__month">NOVEMBER</span>
          <span class="c-paginator__month">DECEMBER</span>
        </div>
        <span id="next" class="next fa fa-angle-right" aria-hidden="true"></span>
      </div>
      <span class="c-paginator__year">2020</span>
    </div>
    <div class="">
        <a class="c-add o-btn js-event__add" id="schedule-btn" href="javascript:;" style="display:none">Schedule <span class="fa fa-plus"></span></a>
    </div>
  </div>
</header>
<div class="wrapper">
  <div class="c-calendar">
    <div class="c-cal__container c-calendar__style">
      <script>
      
      // CAHNGE the below variable to the CURRENT YEAR
      year = 2020;

      // first day of the week of the new year
      today = new Date();
      start_day = today.getDay() + 1;
      fill_table("January", 31, "01", 1);
      fill_table("February", 29, "02", 2);
      fill_table("March", 31, "03", 3);
      fill_table("April", 30, "04", 4);
      fill_table("May", 31, "05", 5);
      fill_table("June", 30, "06", 6);
      fill_table("July", 31, "07", 7);
      fill_table("August", 31, "08", 8);
      fill_table("September", 30, "09", 9);
      fill_table("October", 31, "10", 10);
      fill_table("November", 30, "11", 11);
      fill_table("December", 31, "12", 12);
      </script>
    </div>
  </div>

  <div class="c-event__creator c-calendar__style js-event__creator" id=EventWindow>
    <a href="javascript:;" class="o-btn js-event__close">CLOSE<span class="fa fa-close"></span></a>
    <p><br></p>
    <form id="addEvent" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Treatment Type:<select name="a_type">
          <option value="manicure">manicure</option>
          <option value="padicure">padicure</option>
          <option value="face-treatment">face-treatment</option>
          <option value="hair-styling">hair-styling</option>
          <option value="massage">massage</option>
        </select></label>
        <p><label><span>Date:</span><input style="background-color: #bbbbbb;" type="date" id="a_date" name="a_date" readonly></label></p>
        <label>Hour:<select name="a_hour" id="a_hour">
            <option id="09:00:00" value="09:00">09:00</option>
            <option id="10:00:00" value="10:00">10:00</option>
            <option id="11:00:00" value="11:00">11:00</option>
            <option id="12:00:00" value="12:00">12:00</option>
            <option id="13:00:00" value="13:00">13:00</option>
            <option id="14:00:00" value="14:00">14:00</option>
            <option id="15:00:00" value="15:00">15:00</option>
            <option id="16:00:00" value="16:00">16:00</option>
            <option id="17:00:00" value="17:00">17:00</option>
            <option id="18:00:00" value="18:00">18:00</option>
        </select></label>
        <p><button type="submit">SAVE</button> </span></p></div>
    </form>
    <br>
  </div>
  
<?php
    $conn->close();
?>


</div>
</main>

</body>
</html>