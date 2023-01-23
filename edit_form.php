<?php
    require 'config/config.php';

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$error = "Invalid URL";
	}
	else{

        // 1. Establish MySQL Connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
        // Check for MySQL Connection Errors
        if($mysqli->connect_errno){
            echo $mysqli->connect_error;
            exit();
        }

		// Prevent garbage characters from inputs
		$mysqli->set_charset('utf8');


		// Perform SQL Queries to retrieve Review Info:
		$id = $_GET['id'];

		$sql = "SELECT reviews.id AS id, comment, rating, release_date, users.username AS username, locations.address AS address, providers.name AS provider
                FROM reviews
                LEFT JOIN locations
                    ON reviews.location_id = locations.id
                LEFT JOIN providers
                    ON reviews.provider_id = providers.id
                LEFT JOIN users
                    ON reviews.user_id = users.id
                WHERE reviews.id = $id;";

		$results = $mysqli->query($sql); // lightning bolt
		if($results == false){
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$row_review = $results->fetch_assoc(); // Should only have 1 result from id


		// Close DB Connection
		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Review | ratemyUSCHousing</title>
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
			<h1 class="col-12 mb-5 text-center">Edit Your Review</h1>
			<?php if( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) : ?> <!-- User IS NOT logged in -->
				<h2 class="col-12 mb-5 text-center text-danger">Warning: You are not logged in so submission will be denied. Please log in.</h2>
			<?php endif; ?>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<form action="edit_confirmation.php" method="POST">

			<input type="hidden" name="id" value="<?php echo $id; ?>">

			<div class="form-group row">
				<label for="location-id" class="col-sm-2 col-form-label text-sm-right">Location (address): <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="location-id" name="location" value="<?php echo $row_review['address'];?>">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="provider-id" class="col-sm-2 col-form-label text-sm-right">Provider (landlord): <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="provider-id" name="provider" value="<?php echo $row_review['provider'];?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="rating-id" class="col-sm-2 col-form-label text-sm-right">Rating: <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="number" min="0" max="5" class="form-control" id="rating-id" name="rating" value="<?php echo $row_review['rating'];?>">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="comment-id" class="col-sm-2 col-form-label text-sm-right">Comment:</label>
				<div class="col-sm-10">
					<textarea rows="3" cols="5" class="form-control" id="comment-id" name="comment" placeholder="Type your reasoning here if applicable."><?php echo $row_review['comment'];?></textarea>
					<div id="counter" class="text-right"></div>
				</div>
			</div> <!-- .form-group -->


			<div class="form-group row mt-5">
				<div class="col-sm-12 text-center">
					<button type="submit" class="btn btn-primary btn-lg">Submit Your Edit</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->

	<script>
		document.querySelector("#comment-id").oninput = function() { // Comment counter
			document.querySelector("#counter").innerHTML = document.querySelector("#comment-id").value.trim().length + " / 300";
			const comment = document.querySelector("#comment-id").value.trim();
			if(comment.length <= 300){
				document.querySelector("#counter").style.color = "";
			}
			else if(comment.length > 300){ // Check for comment length
				document.querySelector("#counter").style.color = "red";
			}
		}

	</script>
</body>
</html>