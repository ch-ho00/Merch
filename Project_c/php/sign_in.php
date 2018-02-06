

<?php
session_start();
require_once('class.user.php');
$user = new USER();

if($user->is_loggedin()!="")
{
	$user->redirect('Buypage_loggedin.php');
}

if(isset($_POST['btn-signup']))
{
	$uname = strip_tags($_POST['txt_uname']);
	$umail = strip_tags($_POST['txt_umail']);
	$upass = strip_tags($_POST['txt_upass']);
  $phone_num = strip_tags($_POST['txt_phone_num']);

	if($uname=="")	{
		$error[] = "<b><font color='red'>provide username !</font></b>";
	}
	else if($umail=="")	{
		$error[] = "<b><font color='red'>provide email id !";
	}
	else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = "<b><font color='red'>Please enter a valid email address !</font></b>";
	}
	else if($upass=="")	{
		$error[] = "<b><font color='red'>provide password !</font></b>";
	}
	else if(strlen($upass) < 6){
		$error[] = "<b><font color='red'>Password must be atleast 6 characters</font></b>";
	}
	else if(strlen($phone_num) < 7){
		$error[] = "<b><font color='red'>Phone number must be atleast 8 characters</font></b>";
	}
	else if(strlen($phone_num) >13){
		$error[] = "<b><font color='red'>Phone number must be less than 12 characters</font></b>";
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT user_name, email FROM users WHERE user_name=:uname OR email=:umail");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			if($row['user_name']==$uname) {
				$error[] = "<b><font color='red'>sorry username already taken !</font></b>";
			}
			else if($row['email']==$umail) {
				$error[] = "<b><font color='red'>sorry email id already taken !</font></b>";
			}
			else
			{
				if($user->register($uname,$umail,$upass,$phone_num)){
					$user->redirect('Buypage_loggedin.php?joined');
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PDO : Sign up</title>
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

<div id="main">


        <form method="post" >
            <h1>Sign up.</h1>
            <?php
			if(isset($error))
			{
			 	foreach($error as $error)
			 	{
					 ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
				}
			}
			else if(isset($_GET['joined']))
			{
				 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
			}
			?>

            <input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
              <input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $umail;}?>" />
            	<input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
							<input type="text" class="form-control" name="txt_phone_num" placeholder="Enter phonenum" value="<?php if(isset($error)){echo $uname;}?>" />
							<input value="SIGN UP" type="submit" class="button" name="btn-signup">


            <p>have an account ! <a href="log_in.php">Sign In</a></p>
        </form>


</div>

</body>
</html>
