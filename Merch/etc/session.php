<?php

	session_start();

<<<<<<< HEAD
	require_once '../4. MakeAccount/class.user.php';
=======
	require_once ('../php/class.user.php');
>>>>>>> 106bf21f73ecb50ae742d502723e06ed955c163d
	$session = new USER();

	// if user session is not active(not loggedin) this page will help 'home.php and profile.php' to redirect to login page
	// put this file within secured pages that users (users can't access without login)

	if(!$session->is_loggedin())
	{
		// session no set redirects to login page
		$session->redirect('denied.php');
	}
