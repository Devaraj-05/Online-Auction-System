<?php
include './header.php';
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == false) {
	header('Location: ./index.php');
	exit();
}
require_once './src/Database.php';
require_once './src/Session.php';
$db = Database::getInstance();

$err = '';
$msg = '';
$user = Session::get('user');
if (isset($_POST['submit'])) {
	$currPassword = $_POST['cur_password'];
	$newPassword = $_POST['new_password'];
	$confPassword = $_POST['conf_password'];
	if(strlen($newPassword) < 8){
		$err = "Password  must be 8 character";
	} else if($newPassword != $confPassword){
		$err = "Password does not match";
	} elseif(!password_verify($currPassword, $user->password)){
		$err = "Wrong current password";
	} else {
		$hash = password_hash($newPassword, PASSWORD_DEFAULT);
		$sql = "UPDATE users SET password = '$hash' WHERE id = '$user->id'";
		if(!$db->query($sql)){
			$err = "Failed to change password";
		} else {
			$msg = "Your password updated";
		}
	}
}
?>
<div class="container-fluid">
	<div class="row no-gutter">
		<div class="d-none d-md-flex col-md-4 col-lg-6 bg-image">
		</div>
		<div class="col-md-8 col-lg-6" style="background:whitesmoke">
			<div class="login align-items-center d-flex">
				<div class="col-md-9 col-lg-8 mx-auto">
					<div id="msg">
						<?php if (strlen($err) > 1) : ?>
							<div class="alert alert-danger mt-3 text-center"><strong>Failed! </strong><?php echo $err ?></div>
						<?php endif ?>
						<?php if (strlen($msg) > 1) : ?>
							<div class="alert alert-success mt-3 text-center"><strong>Success! </strong><?php echo $msg ?></div>
						<?php endif ?>
					</div>
					<h3 class="mb-4 text-center font-weight-bold">Change password</h3>
					<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return validateLoginForm()">
						<div class="form-group">
							<label class="font-weight-bold">Current password</label>
							<input type="password" id="cur_password" name="cur_password" class="form-control">
						</div>
						<div class="form-group">
							<label class="font-weight-bold">New password</label>
							<input type="password" id="new_password" name="new_password" class="form-control">
						</div>
						<div class="form-group">
							<label class="font-weight-bold">Confirm password</label>
							<input type="password" id="conf_password" name="conf_password" class="form-control">
						</div>
						<div>

							<button class="btn btn-lg btn-primary btn-block btn-login my-2" name="submit" type="submit">Change</button>

					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	include './footer.php';
	?>
