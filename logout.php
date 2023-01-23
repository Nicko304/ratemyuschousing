<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logout | ratemyUSCHousing</title>
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
			<h1 class="col-12 text-center">Logout Confirmation</h1>
			<p class="col-12 text-center mt-4">You have successfully logged out.</p>
		</div> <!-- .row -->
		<div class="container">
			<div class="form-group row mt-5">
				<div class="col-sm-12 text-center">
					<a href="home.php" role="button" class="btn btn-primary btn-lg mr-5">Home</a>
					<a href="login.php" role="button" class="btn btn-secondary btn-lg">Login</a>
				</div>
			</div> <!-- .form-group -->
		</div> <!-- .container -->
	</div> <!-- .container -->

</body>
</html>