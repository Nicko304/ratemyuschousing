<?php
	require "config/config.php";

	if( (!isset($_SESSION['logged_in']) || !isset($_GET['username']) || $_SESSION['logged_in'] == false ||  $_SESSION['username'] != $_GET['username']) && (!isset($_SESSION['username']) || $_SESSION['username'] != 'ADMIN') ){
		$error = "Please log into the correct account to delete this review.";
	}
	else if( !isset($_GET['id']) || trim($_GET['id']) == ''
	|| !isset($_GET['address']) || trim($_GET['address']) == ''){
		$error = "Invalid Review ID or Address.";
	}
	else{
		// DB Connection.
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$id = $_GET['id'];
		$address = $_GET['address'];

		$sql = "DELETE
				FROM reviews
				WHERE id = $id;";

		$results = $mysqli->query($sql);

		if ( !$results ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$mysqli->close();
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Deleted A Review | ratemyUSCHousing</title>
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
			<h1 class="col-12 text-center">Delete Confirmation</h1>
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
						<p>Your review of <span class="font-italic"><?php echo $address; ?></span> was successfully deleted.</p>
					</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="form-group row mt-5">
			<div class="col-sm-12 text-center">
				<a href="review_form.php" role="button" class="btn btn-primary btn-lg mr-5">Write A New Review</a>
				<?php if(isset($error) && !empty($error)): ?>
					<a href="login.php" role="button" class="btn btn-secondary btn-lg">Login</a>
				<?php else: ?>
					<a href="search_form.php" role="button" class="btn btn-secondary btn-lg">Go To Search Form</a>
				<?php endif; ?>
			</div>
		</div> <!-- .form-group -->
	</div> <!-- .container -->
</body>
</html>