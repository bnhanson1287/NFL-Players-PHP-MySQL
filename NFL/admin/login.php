<?php 
include("/home/bhanson11/data/data.php");
	//echo "$username_good, $pws_enc, $username_philr, $ppws_enc ";
	
	if(isset($_POST['mysubmit']))
	{
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if(($username == $username_good) && (password_verify($password, $pws_enc)))
		{
		
			session_start();
			$_SESSION['nflplayersession'] = session_id();

			if(isset($_GET['redirect']))
			{
				header('Location: '.$_GET['redirect']);
			}
			else
			{
				header('Location:player-edit.php');
			}
		}
		else 
		{
			if($username != "" && $password !="")
			{
				$msg = "Incorrect login";
			}
			else
			{
				$msg = "Please enter a username and password";
			}
		}
	}
?>
<?php

include ("../includes/header.php");
?>


<style type="text/css">
	.message-login
	{
		margin-top: 20px;
	}
</style>

<div class="login-form">

	<h1>Please Login</h1>

	<form name="myform" class="team-form" method="post" action="#">

	  <div class="form-group">
	    <label for="username">Username:</label>
	    <input type="text" class="form-control" name="username">
	  </div>

	  <div class="form-group">
	    <label for="password">Password:</label>
	    <input type="password" class="form-control" name="password">
	  </div>

	 

	  <input type="submit" class="btn btn-secondary" name="mysubmit">

	  <?php 
		if($msg)
		{
			echo "\n\t<div class =\"alert alert-danger message-login\">$msg</div>\n";
		}


	 ?>
	</form>
	

</div>
<?php

include ("../includes/footer.php");
?>