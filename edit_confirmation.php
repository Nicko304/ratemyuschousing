<?php
	require "config/config.php";
    // Get date of submission
    date_default_timezone_set('America/Los_Angeles');
    $date = date('Y-m-d');

	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
		// User IS NOT logged in
		$error = "Please log in to this website before editing a review.";
	}
	else if(!isset($_POST['location']) || trim($_POST['location']) == '' // If title is NULL or empty after trimming
        || !isset($_POST['provider']) || trim($_POST['provider']) == ''
        || !isset($_POST['rating']) || trim($_POST['rating']) == ''
        || !isset($_POST['id']) || trim($_POST['id']) == ''){
		$error = "Please fill out all required fields before editing a review.";
	}
    else if( isset($_POST['comment']) && strlen(trim($_POST['comment'])) > 300 ){ // Validate character limit for comment
		$error = "Please follow the comment character limit before submitting an edited review.";
	}
	else{ // If inputs are valid, perform db operations


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
        $id = $_POST['id'];
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

		$location_element = $result_location2->fetch_assoc();
		$provider_element = $result_provider2->fetch_assoc();
		$location_id = $location_element['id'];
		$provider_id = $provider_element['id'];

        $sql = "UPDATE reviews
            SET comment = $comment,
            rating = $rating,
            release_date = '$date',
            location_id= $location_id,
            provider_id = $provider_id
            WHERE id = $id;";

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



		// 3. Close the DB
		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Review Confirmation | ratemyUSCHousing</title>
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
			<h1 class="col-12 text-center">Review Edit Confirmation</h1>
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
						<p>Your edited review of <span class="font-italic"><?php echo $_POST['location']; ?></span> was successfully submitted.</p>
					</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="form-group row mt-5">
			<div class="col-sm-12 text-center">
				<a href="search_form.php" role="button" class="btn btn-primary btn-lg mr-5">Search For Reviews</a>
				<a href="review_form.php" role="button" class="btn btn-secondary btn-lg">Write a New Review</a>
			</div>
		</div> <!-- .form-group -->
	</div> <!-- .container -->
</body>
</html>