<?php
	require "config/config.php";

	// 1. Establish MySQL Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	// Check for MySQL Connection Errors
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}

    // Prevent garbage characters from inputs
    $mysqli->set_charset('utf8');

	// Perform SQL Queries
    $sql = "SELECT reviews.id AS id, comment, rating, release_date, users.username AS username, locations.address AS address, providers.name AS provider
            FROM reviews
            LEFT JOIN locations
                ON reviews.location_id = locations.id
            LEFT JOIN providers
                ON reviews.provider_id = providers.id
            LEFT JOIN users
                ON reviews.user_id = users.id
            WHERE 1 = 1"; // Semicolon for MySQL statement added later

    $input_counter = 0;
	if(isset($_GET['location']) && !empty($_GET['location'])){ // Use name attribute from input on search_form
		$location_name = $mysqli->escape_string($_GET['location']);
		$sql = $sql . " AND locations.address LIKE '%$location_name%'"; // append to WHERE query
		// NOTE: The space before the AND is important so it becomes WHERE 1 = 1 AND ...
        $input_counter++;
	}
    if(isset($_GET['provider']) && !empty($_GET['provider'])){ // Use name attribute from input on search_form
		$provider = $mysqli->escape_string($_GET['provider']);
		$sql = $sql . " AND providers.name LIKE '%$provider%'"; // append to WHERE query
        $input_counter++;
	}
    if(isset($_GET['rating']) && !empty($_GET['rating'])){ // Use name attribute from input on search_form
		$rating = $_GET['rating'];
		$sql = $sql . " AND reviews.rating >= $rating"; // append to WHERE query
        $input_counter++;
	}

    // Date validation/appending
	if( (isset($_GET['release_date_from']) && !empty($_GET['release_date_from'])) && (isset($_GET['release_date_to']) && !empty($_GET['release_date_to'])) ){ // Both date inputs are filled
		$release_date_from = $_GET['release_date_from'];
		$release_date_to = $_GET['release_date_to'];
		$sql = $sql . " AND reviews.release_date BETWEEN '$release_date_from' AND '$release_date_to'"; // append to WHERE query
        $input_counter++;
	}
	else if( isset($_GET['release_date_from']) && !empty($_GET['release_date_from']) ){ // Only date_from input is filled
		$release_date_from = $_GET['release_date_from'];
		$sql = $sql . " AND reviews.release_date >= '$release_date_from'";
        $input_counter++;
	}
	else if( isset($_GET['release_date_to']) && !empty($_GET['release_date_to']) ){ // Only date_to input is filled
		$release_date_to = $_GET['release_date_to'];
		$sql = $sql . " AND reviews.release_date <= '$release_date_to'";
        $input_counter++;
	}

    // If no inputs were entered, get random results:
    if($input_counter == 0){
        $sql = $sql . " ORDER BY RAND()";
    }

	$sql = $sql . ";";
	$results = $mysqli->query($sql); // Equivalent to the lightning bolt


	// Check for errors from the query
	if(!$results){
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}


	// 3. Close the DB
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Review Search Results | ratemyUSCHousing</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="config/nav.css">
    <style>
        body {
            margin: 0;
            padding-top: 100px;
        }

        .review_div {
            width: 75%;
            height: 400px;
            margin: 0 auto;
            padding: 0;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            /* background-color: rgb(226, 226, 225); */
        }

        .review_div_c1 { /* First child for username, date, and  rating */
            width: 30%;
            height: 5rem;
            padding: 0 4px;
            margin-left: 0;
            /* background-color: red; */
        }

        .review_div_c2 { /* Second child for text box/div of location/address, provider/company, and the user's comment*/
            width: 70%;
            padding: 0 8px;
            /* background-color: pink; */
        }

        .rating {
            background-color: lightBlue;
            /* color: #FFF; */
            font-size: 3rem;
            margin: 0 auto;
            width: 4rem;
            /* padding: 0 10px; */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 2rem;
        }

        .content {
            margin: 0 2rem;
        }

        .word-wrap-setting {
            word-wrap: break-word;
        }

    </style>
</head>
<body>
    <?php include 'config/nav.php'; ?>
	<div class="container">
		<div class="row">
			<h1 class="col-12 text-center">Review Search Results</h1>
            <p class="col-12 text-center">Showing <?php echo $results->num_rows; ?> result(s).</p>
		</div> <!-- .row -->
	</div> <!-- .container -->
    <div class="container mt-3">
        <!-- Testing
        <div class="review_div">
            <div class="review_div_c1">
                <p class="text-center font-weight-bold">Location</p>
                <p class="text-center">3650 McClintock Ave (University of Southern California)</p>
                <p class="text-center font-weight-bold">Provider/Landlord</p>
                <p class="text-center">University of Southern California (USC) Housing</p>
                <p class="text-center font-weight-bold">Rating</p>
                <p class="text-center rating">5</p>
            </div>
            <div class="review_div_c2">
                <div class="header">
                    <p class="font-weight-bold">naschuma</p>
                    <p>12-4-22</p>
                </div>
                <p class="content">Had many bad experiences such as intenet being out for 3 weeks, Tripalink not taking action against illegal smokers (causing fire alarms to go off a lot and the odor of smoke in the hallways and sometimes even the rooms).</p>
                <p class="content mt-5"><span class="font-weight-bold">4</span> users found this to be accurate on the location or provider.</p>
                <a href="delete.php?id=<? // php echo $row['id']; ?>" class="btn btn-outline-danger mt-4 mx-5" onclick="return confirm('Are you sure you want to delete \'<? //php echo $row['address']; ?>\'? Remember that your reviews are invaluable so please reconsider if you have not already.');">
                    Delete
                </a>
                <a href="edit_form.php?id=<? //php echo $row['id']; ?>" class="btn btn-outline-warning mt-4">
                    Edit
                </a>
            </div>
        </div> -->
        <?php while ( $row = $results->fetch_assoc() ) : ?>
            <div class="review_div">
                <div class="review_div_c1">
                    <p class="text-center font-weight-bold">Location</p>
                    <p class="text-center">
                        <?php echo $row['address']; ?>
                    </p>
                    <p class="text-center font-weight-bold">Provider/Landlord</p>
                    <p class="text-center">
                        <?php echo $row['provider']; ?>
                    </p>
                    <p class="text-center font-weight-bold">Rating</p>
                    <p class="text-center rating">
                        <?php echo $row['rating']; ?>
                    </p>
                </div>
                <div class="review_div_c2">
                    <div class="header">
                        <p class="font-weight-bold">
                            <?php echo $row['username']; ?>
                        </p>
                        <p>
                            <?php echo $row['release_date']; ?>
                        </p>
                    </div>
                    <div class="word-wrap-setting">
                        <p class="content">
                            <?php echo $row['comment']; ?>
                        </p>
                    </div>
                    <!-- <p class="content mt-5"> IGNORE: Planned addition for later on personal project
                        <span class="font-weight-bold"><?php echo $row['accurate_count']; ?></span> users found this to be accurate on the location or provider.
                    </p> -->
                    <?php if( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true &&  ($_SESSION['username'] == $row['username'] || $_SESSION['username'] == 'ADMIN') ) : ?>
                        <a href="delete.php?id=<?php echo $row['id']; ?>&address=<?php echo urlencode($row['address']); ?>&username=<?php echo urlencode($row['username']); ?>" class="btn btn-outline-danger mt-4 mx-5" onclick="return confirm('Are you sure you want to delete your review on \'<?php echo urldecode($row['address']); ?>\'? Remember that your reviews are invaluable so please reconsider if you have not already.');">
                            Delete
                        </a>
                        <a href="edit_form.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-warning mt-4">
                            Edit
                        </a>
                    <?php endif; ?>
                </div>
            </div> <!-- .review_div -->
        <?php endwhile; ?>
    </div> <!-- .container -->

</body>
</html>