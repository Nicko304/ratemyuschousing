<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Write a Review | ratemyUSCHousing</title>
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
			<h1 class="col-12 mb-5 text-center">Write Your Own Review</h1>
			<?php if( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) : ?> <!-- User IS NOT logged in -->
				<h2 class="col-12 mb-5 text-center text-danger">Warning: You are not logged in so submission will be denied. Please log in.</h2>
			<?php endif; ?>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row col-12 mb-4">
			<div class="col-6">
				<img src="img/review_form_write.jpg" alt="Person rating their experience" class="img-fluid">
			</div>
			<div class="col-6">
				<h2 class="text-center mb-2">Guidelines for Reviews</h2>
				<ul>
					<li>
						Try to concisely list the positive and negative experiences that affected you the most.
					</li>
					<li>
						Mention specific or vivid details to establish better credibility.
					</li>
					<li>
						If you can, it is great to mention anything you did not expect when moving in.
					</li>
					<li>
						Think about what you would have liked to known before moving into the location, that information can be invaluable to many others.
					</li>
					<li>
						Thank you for spending your time helping other Trojans. Fight on!
					</li>
				</ul>
			</div>
		</div>
		<form action="review_confirmation.php" method="POST">

			<div class="form-group row">
				<label for="location-id" class="col-sm-2 col-form-label text-sm-right">Location (address): <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="location-id" name="location">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="provider-id" class="col-sm-2 col-form-label text-sm-right">Provider (landlord): <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="provider-id" name="provider">
				</div>
			</div>
			<div class="form-group row">
				<label for="rating-id" class="col-sm-2 col-form-label text-sm-right">Rating: <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="number" min="0" max="5" class="form-control" id="rating-id" name="rating">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="comment-id" class="col-sm-2 col-form-label text-sm-right">Comment:</label>
				<div class="col-sm-10">
					<textarea rows="3" cols="5" class="form-control" id="comment-id" name="comment" placeholder="Type your reasoning here if applicable."></textarea>
					<div id="counter" class="text-right">0 / 300</div>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-sm-right">Email me my review:</label>
				<div class="col-sm-10">
					<div class="form-check form-check-inline">
						<label class="form-check-label my-1">
							<input class="form-check-input mr-2" type="radio" name="email_bool" id="inlineCheckbox1" value="yes">Yes
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label my-1">
							<input class="form-check-input mr-2" type="radio" name="email_bool" id="inlineCheckbox2" value="no" checked>No
						</label>
					</div>
				</div>
			</div> <!-- .form-group -->


			<div class="form-group row mt-5">
				<div class="col-sm-12 text-center">
					<button type="submit" class="btn btn-primary btn-lg">Submit Review</button>
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