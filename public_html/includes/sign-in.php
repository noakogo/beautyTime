
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="/CSS/login.css" rel="stylesheet" id="bootstrap-css">
<link href="/CSS/Payment.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/JS/common.js"></script>

<?php
    require_once "db-connection.php";
    session_start();

    $message = $email = $password = "";    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
          
    if (empty($email) || empty($password)) {
        $message = "<div class='alert alert-danger'>Both Fields are required</div>";
    } else {
            $sql = "SELECT customer_id, first_name FROM Customers WHERE email = '$email' AND password = '$password'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                while($row = $result->fetch_assoc()) {
                    $name = $row["first_name"];
                    $_SESSION["ID"] = $row["customer_id"];
                    setcookie("ID", $row["customer_id"], time()+3600);
                    echo '<script>
                        sessionStorage.setItem("isLoggedIn", true);
                        sessionStorage.setItem("first_name","'.$name.'");
                        window.location = "/";
                    </script>';
                } 
            }
            else {
                $message = '<div class="alert alert-danger">Your Login Name or Password is invalid</div>';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="/CSS/login.css">
</head>
<header>
     <div id="common"></div>
</header>
<body>
   
<div class="container">
		<section class="credit-card">
		 <div class="container">
		  
			<div class="card-holder">
			  <div class="card-box bg-news">
		       <div class="row">
				<div class="col-lg-6">
			<div class="card-header">
				<h3>Sign In</h3>
			</div>
			<div class="card-body">
			    <span><?php echo $message; ?></span>
				<form method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" name="email" id="email" class="form-control" placeholder="user email" />
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
                        <input type="password" name="password" id="password" class="form-control" placeholder="password"/>
					</div>
					<div class="form-group">
					    <input type="submit" value="Login" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Don't have an account?<a href="sign-up.php">Sign Up</a>
				</div>
			</div>
		</div>
	</div>
</div>
</div><!--/col-lg-6 --> 
</div><!--/row -->
</section><!--/card-box -->
</div><!--/card-holder -->
</body>
</html>