<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register | ratemyUSCHousing</title>
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
                <h1 class="col-12 mb-5 text-center">Register An Account</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">

            <form action="register_confirmation.php" method="POST">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-12 text-center">
                        <!-- Display errors here. -->
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
						<small id="username-error" class="invalid-feedback">Username is required.</small>
                    </div>
                </div> <!-- .form-group -->
                <div class="form-group row">
                    <label for="email-id" class="col-sm-2 col-form-label text-sm-right">Email: <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control bg-dark text-white" id="email-id" name="email">
						<small id="email-error" class="invalid-feedback">Email is required.</small>
                    </div>
                </div> <!-- .form-group -->
				<div class="form-group row">
					<label for="password-id" class="col-sm-2 col-form-label text-sm-right">Password: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="password" class="form-control bg-dark text-white" id="password-id" name="password">
						<small id="password-error" class="invalid-feedback">Password is required.</small>
					</div>
				</div> <!-- .form-group -->
                <div class="form-group row mt-5">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg mr-5">Register</button>
                        <a href="login.php" role="button" class="btn btn-light btn-lg">Already have an account</a>
                    </div>
                </div> <!-- .form-group -->
            </form>

        </div> <!-- .container -->
    </div>
    <div id="img-div">
        <img id="banner-image" src="img/login_bg.jpg" alt="Decorational building background">
        <div class="dimmer"></div>
    </div>

	<script>
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#username-id').value.trim().length == 0 ) {
				document.querySelector('#username-id').classList.add('is-invalid');
			} else {
				document.querySelector('#username-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#email-id').value.trim().length == 0 ) {
				document.querySelector('#email-id').classList.add('is-invalid');
			} else {
				document.querySelector('#email-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#password-id').value.trim().length == 0 ) {
				document.querySelector('#password-id').classList.add('is-invalid');
			} else {
				document.querySelector('#password-id').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>
</body>
</html>