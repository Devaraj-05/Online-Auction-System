<?php
	include './header.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require './vendor/phpmailer/phpmailer/src/Exception.php';
	require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require './vendor/phpmailer/phpmailer/src/SMTP.php';

	require_once './src/Database.php';
    require_once './src/Session.php';
    require './src/mailer.php';
	$db = Database::getInstance();

	$err = '';
	$msg = '';

	$mail = new PHPMailer; 

	if(isset($_POST['login'])){
		$email = $_POST['email'];
		
		if(strlen($email) < 1){

			$err = "Please enter email";
		} else {
			$sql = "SELECT * FROM users WHERE email = '$email'";
			$res = $db->query($sql);

			if($res->num_rows > 0){
				$user = $res->fetch_object();
                $rand = mt_rand(00000000, 99999999);
                $msg = "Your new password for Secure Online Auction Sysem : ". $rand;
                //echo $msg;
                if(mailer($mail, $email, $msg)){
					$msg1 = "We have sent a new password to your email, Please check";
					$new_pass = password_hash($rand, PASSWORD_DEFAULT);
					$sql = "UPDATE users set password = '$new_pass', last_password = '$user->password'";
					//echo $sql;die;
					$db->query($sql);
                } else{
                    $err = "Unable to sent password, Please try again later";
                }
			} else{
				$err = "User not found";
			}
		}	
	}
?>
<div class="container-fluid">
	<div class="row no-gutter">
		<div class="col-md-4 col-lg-4 offset-lg-4 mt-5">
			<div class="card">
				<div class="card-body">
					<div id="msg">
						<?php if(strlen($msg1) > 1):?>
						<div class="alert alert-success mt-3 text-center"><strong>Success! </strong><?php echo $msg?>
						</div>
						<?php endif?>
						<?php if(strlen($err) > 1):?>
						<div class="alert alert-danger mt-3 text-center"><strong>Failed! </strong><?php echo $err?>
						</div>
						<?php endif?>
					</div>
					<h3 class="card-title text-center my-3"></h3>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
						<div class="form-group">
							<label class="font-weight-bold">Email</label>
							<input type="text" name="email" class="form-control" placeholder="Enter email">
						</div>
						<button class="btn btn-lg btn-primary btn-block btn-login my-2" name="login"
							type="submit">Send password</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include './footer.php';
?>
