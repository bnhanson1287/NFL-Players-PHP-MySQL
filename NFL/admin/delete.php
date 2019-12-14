<?php 
	include("../includes/mysql_connect.php");

	$pid = $_GET['pid'];
	//echo $char_id;
	if(!is_numeric($pid))
	{
		exit();
	}
	else
	{
		mysqli_query($con,"DELETE FROM nfl_roster WHERE p_id = '$pid'") or die(mysqli_error($con));
		mysqli_query($con,"DELETE FROM nfl_players WHERE p_id = '$pid'") or die(mysqli_error($con));


		header("Location:player-edit.php");
	}
	


?>