<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Review Search Form | ratemyUSCHousing</title>
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
			<h1 class="col-12 mb-5 text-center">Search for Reviews</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row col-12 mb-4">
			<div class="col-6">
				<img src="img/search_tip.png" alt="Person researching reviews" class="img-fluid">
			</div>
			<div class="col-6">
				<h2 class="text-center mb-2">Tips for searching Reviews</h2>
				<ul>
					<li>
						Rank your preferences and list your deal-breakers.
					</li>
					<li>
						Look for specific details within reviews to ensure they are credible.
					</li>
					<li>
						See if you can find patterns on certain properties or landlords, they are more likely to be accurate.
					</li>
					<li>
						Consider looking for details that landlords try to hide to new tenants. One example is whether or not they take action against tenants breaking
						leasing policies such as smoking.
					</li>
					<li>
						Consider your needs for daily life such as the amount of difficulty to find street parking in the area of your potential new home.
					</li>
				</ul>
			</div>
		</div>
		<form action="search_results.php" method="GET">

			<div class="form-group row">
				<label for="location-id" class="col-sm-1 col-form-label text-sm-right">Address:</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="location-id" name="location">
				</div>
				<label for="provider-id" class="col-sm-1 col-form-label text-sm-right">Landlord:</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="provider-id" name="provider">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="rating-id" class="col-sm-1 col-form-label text-sm-right">Rating:</label>
				<div class="col-sm-2">
					<input type="number" min="0" max="5" class="form-control" id="rating-id" name="rating">
				</div>

				<label for="release_date_from-id" class="col-sm-3 col-form-label text-sm-right ">Date Range:</label>
				<div class="col-sm-2">
					<input type="date" class="form-control" name="release_date_from" id="release_date_from-id">
				</div>
				<label for="release_date_to-id" class="col-sm-0 col-form-label text-sm-right ">to</label>
				<div class="col-sm-2">
					<input type="date" class="form-control" name="release_date_to" id="release_date_to-id">
				</div>
			</div> <!-- .form-group -->

	

			<div class="form-group row mt-5">
				<!-- <div class="col-sm-3"></div> -->
				<div class="col-sm-12 text-center">
					<button type="submit" class="btn btn-primary btn-lg">Search</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>