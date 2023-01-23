<?php

	require 'config/config.php';

	if ( !isset($_POST['email']) || trim($_POST['email'] == '')
		|| !isset($_POST['username']) || trim($_POST['username'] == '')
		|| !isset($_POST['password']) || trim($_POST['password'] == '') ) {
		$error = "Please fill out all required fields.";
	} else {
		// All required fiels present.

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$email = $mysqli->escape_string($_POST['email']);
		$username = $mysqli->escape_string($_POST['username']);
		$password = $mysqli->escape_string($_POST['password']);

		$password = hash('sha256', $password);


		$sql_registered = "SELECT *
							FROM users
							WHERE email = '$email' 
							OR username = '$username';";

		$results_registered = $mysqli->query($sql_registered);

		if ( $results_registered == false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		if ($results_registered->num_rows > 0) {
			$error = "Username or email already registered, please login or try again.";
		} else {
			$sql = "INSERT INTO users (username, email, password)
				VALUES ('$username', '$email', '$password');";

			$results = $mysqli->query($sql);

			if ( $results == false ) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}
		}

		$mysqli->close();
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration Confirmation | ratemyUSCHousing</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="config/nav.css">
	<style>
		body {
			margin: 0;
			/* padding-top: 100px; */
		}

        /* Home page banner implementation */
        .banner-txt {
            width: 60%;
            height: 50%;
            padding: 1% 2%;
            position: absolute;
            left: 19%;
            top: 15%;
            color: white;
            /* background: rgba(0, 0, 0, 0.6); */
            background: #616161;
            border-radius: 5px;
            z-index: 9;
        }

        #banner-image {
            width: 100%;
            height: auto;
            max-height: calc(100vh);
            display: block;
            margin: 0 auto;
            padding: 0;
            object-fit: cover;
            z-index: 1;
            /*
            height: calc(100vh - 100px);
            object-fit: cover;
            */
        }

        .dimmer {
			position: absolute;
			top: 0px;
			bottom: 0px;
			left: 0px;
			right: 0px;
			text-align: center;
			margin: 0;
			padding-top: 100px;

			background-color: rgba(0, 0, 0, 0.6);
            z-index: 5;
        }
        /* End of home page banner implementation */

	</style>
</head>
<body>
	<?php include 'config/nav.php'; ?>
    <div class="banner-txt">
        <div class="container">
            <div class="row">
                <h1 class="col-12 mb-5 text-center">Registration Confirmation</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">

            <form action="register_confirmation.php" method="POST">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-12 text-center">
                        <!-- Display errors here. -->
						<?php if ( isset($error) && trim($error) != '' ) : ?>
							<div class="text-danger"><?php echo $error; ?></div>
						<?php else : ?>
							<div class="text-success"><?php echo $username; ?> was successfully registered. Please Login to your account</div>
						<?php endif; ?>
                    </div>
                </div> <!-- .row -->
                <div class="form-group row mt-5">
                    <div class="col-sm-12 text-center">
						<a href="login.php" role="button" class="btn btn-primary btn-lg mr-5">Login</a>
                        <a href="register_form.php" role="button" class="btn btn-light btn-lg">Back</a>
                    </div>
                </div> <!-- .form-group -->
            </form>

        </div> <!-- .container -->
	</div> <!-- .banner-txt -->
    <div id="img-div">
        <img id="banner-image" src="img/login_bg.jpg" alt="Decorational building background">
        <div class="dimmer"></div>
    </div>
</body>
</html>