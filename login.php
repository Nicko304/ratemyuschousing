<?php
	// session_start();
	require "config/config.php";

	if( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ){
		// User IS logged in.
		header('Location: search_form.php');
	} 
    else{
		// User is NOT logged in.

		if ( isset($_POST['username']) && isset($_POST['password']) ) {
			// The form was submitted.

			$username = $_POST['username'];
			$password = hash('sha256', $_POST['password']);

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if ( $mysqli->connect_errno ) {
				echo $mysqli->connect_error;
				exit();
			}

			$sql = "SELECT *
					FROM users
					WHERE username = '$username'
					AND password = '$password';";

			$results = $mysqli->query($sql);

			if ( $results == false ) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}

			$mysqli->close();

			if ( $results->num_rows == 1 ) {
				// Valid credentials.

				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $_POST['username'];
                

				header('Location: search_form.php');

			} else {
				// Invalid credentials.

				$error = "Invalid credentials. Please try again.";

			}

		}

	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | ratemyUSCHousing</title>
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
                <h1 class="col-12 mb-5 text-center">Login</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">

            <form action="login.php" method="POST">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-12 text-center">
                        <!-- Display errors. -->
                        <?php
                            if ( !empty($error) ) {
                                echo $error;
                            }
                        ?>
                    </div>
                </div> <!-- .row -->

                <div class="form-group row">
                    <label for="username-id" class="col-sm-2 col-form-label text-sm-right">Username: <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control bg-dark text-white" id="username-id" name="username">
                    </div>
                </div> <!-- .form-group -->
                <div class="form-group row">
                    <label for="password-id" class="col-sm-2 col-form-label text-sm-right">Password: <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control bg-dark text-white" id="password-id" name="password">
                    </div>
                </div>
                <div class="form-group row mt-5">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg mr-5">Login</button>
                        <a href="register_form.php" role="button" class="btn btn-light btn-lg">Register</a>
                    </div>
                </div> <!-- .form-group -->
            </form>

        </div> <!-- .container -->
    </div>
    <div id="img-div">
        <img id="banner-image" src="img/login_bg.jpg" alt="Decorational building background">
        <div class="dimmer"></div>
    </div>

</body>
</html>