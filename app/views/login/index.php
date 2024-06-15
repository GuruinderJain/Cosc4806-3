<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container">
		<div class="page-header" id="banner">
				<div class="row">
						<div class="col-lg-12">
								<h1>Log in</h1>
						</div>
				</div>
		</div>

<?php
if (isset($_SESSION['account_created']) && $_SESSION['account_created'] == 1) {
		echo "Account created! Please log in.";
}


unset($_SESSION['account_created']);
?>

<br>
	<br>
<div class="row">
		<div class="col-sm-auto">
		<form action="/login/verify" method="post" >
		<fieldset>
			<div class="form-group">
				<label for="username">Username</label>
				<input required type="text" class="form-control" name="username">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input required type="password" class="form-control" name="password">
			</div>
			<?php
				if (isset($_SESSION['username_exists'])) {
					echo "Username does not exist";
					unset($_SESSION['username_exists']);
				}
				if (isset($_SESSION['failedAuth'])) { 
					echo "Password is incorrect";
				}
			?>
			<br>
			<button type="submit" class="btn btn-primary">Login</button>
		</fieldset>
		</form> 
	</div>
</div>

		<a href="/create">Don't have an account? Sign up now.</a>

					<?php
						if (isset($_SESSION['locked']) && !(time() > $_SESSION['lock_end'])) { ?>
							<br>
							<br>
							<div class="alert alert-danger" role="alert">
									You have been locked out for 60 seconds. Please refresh the page and try again later.
							</div>
						<?php }
						else {
							unset($_SESSION['locked']);
						}
?>
<br>

<?php require_once 'app/views/templates/footer.php' ?>