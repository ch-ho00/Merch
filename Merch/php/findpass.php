<?php
	session_start();
	require_once("class.user.php");
	$login = new USER();

	if($login->is_loggedin()!="")
	{
		$login->redirect('Buypage_loggedin.php');
	}

	if(isset($_POST['submit_email']))
	{
		$umail = strip_tags($_POST['txt_uname_email']);

		if($login->checkEmail($umail))
		{
      $salt = "128f12f9294@$1224vnd";
      $password = hash('sha512', $salt.$umail);
      $pwurl = "www.merch.com/findpass.php?q=".$password;
      $mailbody = "Dear user,\n\nredirect to the following url you will be able to change your password.";
      mail($umail,"www.merch.com - Password Reset", $mailbody);
			$display = "change url sent to the registered email";
		}
		else
		{
			$display = "<b>User Email does not exist !</b>";
		}
	}
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <link rel="stylesheet" type="text/css" href="../css/log_in.css">
		<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
	<title>Change Password</title>
	</head>
	<body>

	<div class="tm-container">
	  <div class="box">
	    <div class="boxbody">
					<div class="Logo">
						<div id="merchText">
							<a href="">Merch</a>
						</div>
					</div>
		        <form  method="post" action="findpass.php">
		              <?php
		      			if(isset($display))
		      			{
		      				      ?>
		                         <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $display; ?>
		                      <?php
		      			}
		      		    ?>
		            <div class="ID">
									<label id="usernameLabel">
											Email
									<label>
		              <input id="username" type="text" name="txt_uname_email" placeholder="Registered Email" required />
		            </div>
		            <div class="DONE">
		              <input id="submitButton" value="Send change email url" type="submit" name="submit_email" class="button">
		            </div>
		        </form>
						<div class="SIGNUP">
							<a href="sign_in.php" id="signupButton">Sign Up</a>
						</div>

						<div class="signin">
							<a href="log_in.php">Log in</a>
						</div>

	      </div><!--boxbody-->
	    </div><!--box-->
	</div><!--tm-container-->
	</body>
</html>
