<?php
	require "config/config.php";
    // Get date of submission
    date_default_timezone_set('America/Los_Angeles');
    $date = date('Y-m-d');

	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
		// User IS NOT logged in
		$error = "Please log in to this website before submitting a review.";
	}
	else if(!isset($_POST['location']) || trim($_POST['location']) == '' // If required inputs are NULL or empty after trimming
        || !isset($_POST['provider']) || trim($_POST['provider']) == ''
        || !isset($_POST['rating']) || trim($_POST['rating']) == ''){
		$error = "Please fill out all required fields before submitting a review.";
	}
	else if( isset($_POST['comment']) && strlen(trim($_POST['comment'])) > 300 ){ // Validate character limit for comment
		$error = "Please follow the comment character limit before submitting a review.";
	}
	else{ // If required inputs are valid, perform db operations


        // 1. Establish MySQL Connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
        // Check for MySQL Connection Errors
        if($mysqli->connect_errno){
            echo $mysqli->connect_error;
            exit();
        }

		// Prevent garbage characters from inputs
		$mysqli->set_charset('utf8');

		// Get required field(s) already checked
		$location = "'". $mysqli->escape_string(trim($_POST['location'])) . "'"; // Note: '___' must match the name of the input in add_form.php
        $provider = "'". $mysqli->escape_string(trim($_POST['provider'])) . "'";

        $rating = $_POST['rating'];
        // $accurate_count = 0; // Always starts at 0 since users make it go up

		// Get optional field(s) (either set to user input or NULL)
		if( isset($_POST['comment']) && trim($_POST['comment']) != '') {
			$comment = "'". $mysqli->escape_string(trim($_POST['comment'])) . "'";
		} 
		else{
			$comment = "NULL";
		}

		$sql_location = "SELECT *
						FROM locations
						WHERE address = $location;";
		$sql_provider = "SELECT *
						FROM providers
						WHERE name = $provider;";
		
		$result_location = $mysqli->query($sql_location); // Execute the thunderbolt
		if($result_location->num_rows == 0){
			$sql_location = "INSERT INTO locations (address)
							VALUES ($location);";
			$result_location = $mysqli->query($sql_location); // Execute the thunderbolt
			if(!$result_location){
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}
		}
		$result_provider = $mysqli->query($sql_provider); // Execute the thunderbolt
		if($result_provider->num_rows == 0){
			$sql_provider = "INSERT INTO providers (name)
							VALUES ($provider);";
			$result_provider = $mysqli->query($sql_provider); // Execute the thunderbolt
			if(!$result_provider){
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}
		}

		// Now retrieve ID's of location and provider (it's a little redundant but needed)
		$sql_location = "SELECT *
						FROM locations
						WHERE address = $location;";
		$sql_provider = "SELECT *
						FROM providers
						WHERE name = $provider;";
		$result_location2 = $mysqli->query($sql_location); // Execute the thunderbolt
		if(!$result_location2){
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}
		$result_provider2 = $mysqli->query($sql_provider); // Execute the thunderbolt
		if(!$result_provider2){
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		// Retrieve email ID
		$username = "'" . trim($_SESSION['username']) . "'"; // Ex: 'naschuma@usc.edu'
		$sql_username = "SELECT *
					FROM users
					WHERE username = $username;";
		$result_username = $mysqli->query($sql_username); // Execute the thunderbolt
		if(!$result_username){
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$location_element = $result_location2->fetch_assoc();
		$provider_element = $result_provider2->fetch_assoc();
		$username_element = $result_username->fetch_assoc();
		$location_id = $location_element['id'];
		$provider_id = $provider_element['id'];
		$username_id = $username_element['id'];
		$email = $username_element['email'];
		// $username = "'" . trim($_SESSION['username']) . "'"; // Ex: 'naschuma@usc.edu'

		$sql = "INSERT INTO reviews (comment, rating, release_date, user_id, location_id, provider_id)
				VALUES ($comment, $rating, '$date', $username_id, $location_id, $provider_id);";

		// var_dump($sql); // Set contents of the sql query before it's executed

		$result = $mysqli->query($sql); // Execute the thunderbolt

		if(!$result){
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		// echo "<pre>";
		// echo $sql;
		// echo "</pre>";


		if(isset($_POST['email_bool']) && $_POST['email_bool'] == 'yes'){ // Check value of the email (input) to see if user wants to be emailed
			// Email user
			$destination = $email; // Ex: 'naschuma@usc.edu'
			$subject = 'Your Latest Review!';
			$message = '<h1>Your Review</h1>
						<p>Thanks for submitting a review! Every review counts in helping us grow and expand our reach to help more students.</p>
						<p>We hope that you submit more reviews in the near future and find our tools useful in your college housing search.</p>
						<p>If you ever wish to update your review or delete it. Just search for the address and company you submitted on our search engine.</p>
						<p>Here is what you wrote in case you ever forget:</p>
						<h2>Location (address):</h2>
						<p>' . $location . '</p>
						<h2>Provider (landlord):</h2>
						<p>' . $provider . '</p>
						<h2>Rating:</h2>
						<p>' . $rating . '</p>
						<h2>Comment:</h2>
						<p>' . $comment . '</p>';
			$header = [
				"content-type" => "text/html",
				"from" => "ratemyUSCHousing@usc.edu",
				"reply-to" => "no-reply@usc.edu"
			];

			mail($destination, $subject, $message, $header); // Execute mail to the user
			
			// Might have to use cPanel as it doesn't work on laptop and PC's sometimes
			// if ( mail($destination, $subject, $message, $header) ) {
			// 	echo 'Success';
			// } else {
			// 	echo 'Error';
			// }
		}



		// 3. Close the DB
		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Review Confirmation | ratemyUSCHousing</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="config/nav.css">
    <style>
        body {
            margin: 0;
            padding-top: 100px;
        }
    </style>
</head>
<body>
    <?php include 'config/nav.php'; ?>
	<div class="container">
		<div class="row">
			<h1 class="col-12 text-center">Review Confirmation</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if(isset($error) && !empty($error)): ?>
					<div class="text-danger font-italic text-center">
						<?php echo $error; ?>
					</div>
				<?php else: ?>
					<div class="text-success text-center">
						<p>Your review of <span class="font-italic"><?php echo $_POST['location']; ?></span> was successfully submitted.</p>
                        <?php if( isset($_POST['email']) && $_POST['email'] == 'yes'  ): ?>
                            <p>We'll email you the review shortly for your personal records.</p>
                        <?php endif; ?>
					</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="form-group row mt-5">
			<div class="col-sm-12 text-center">
				<a href="search_form.php" role="button" class="btn btn-primary btn-lg mr-5">Search For Reviews</a>
				<a href="review_form.php" role="button" class="btn btn-secondary btn-lg">Go Back</a>
			</div>
		</div> <!-- .form-group -->
	</div> <!-- .container -->
</body>
</html>