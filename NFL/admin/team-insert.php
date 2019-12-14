<?php
session_start();
	if(isset($_SESSION['nflplayersession']))
	{

	}
	else 
	{
		header("Location:login.php?redirect=team-insert.php"); 
	}
	include("../includes/header.php");
	include("../includes/_functions.php");


	$uniqueId = uniqid().".jpg";
	if(isset($_POST['submit']))
	{
		$team = $_POST['team'];
		$fileName = $uniqueId;
		$description = strip_tags(trim($_POST['description']));

		$valid = 1;
		$msgPre = "<div class=\"alert alert-success\">";
		$msgPost = "</div>\n";
		$msgPreError = "<div class=\"alert alert-info\">";

		// Name Val
		if((strlen($team) < 1 )|| (strlen($team) > 50 ) )
		{
			$valid = 0;
			$valTeamMsg = "Team Name must be between 1 and 50 characters";
		}
		//Description Val
		if(strlen($description) < 20 || strlen($description) > 800)
		{
			$valid = 0;
			$valDescriptionMsg = "Description must be between 20 & 800 characters.";
		} 

		// image validation
		if($_FILES['myfile']['type'] != "image/jpeg")
		{
			$valid =0;
			$valMessage .= "Please upload JPG image.";	
		}
		if($_FILES['myfile']['size'] > (10 * 1024 * 1024))
		{
			$valid = 0;
			$valMessage .= "File is too large.";
		}

		if($valid == 1)
		{
			$msgSuccess = "You have successfully added the ".$team;

			if(move_uploaded_file($_FILES['myfile']['tmp_name'], "../images/originals/".$uniqueId))
				{


					correctImageOrientation("../images/originals/".$uniqueId);
					$thisFile = "../images/originals/".$uniqueId;
					
					createSquareImageCopy($thisFile, "../images/thumbs50/", 50);

					createSquareImageCopy($thisFile, "../images/thumbs140/", 140);

					createImageCopy($thisFile, "../images/display350/", 350);

					//DB

					mysqli_query($con,"INSERT INTO nfl_teams (team_name,team_description,logo) VALUES ('$team','$description', '$fileName')")or die(mysqli_error($con));
				}
				else
				{
					echo "<h3>Error</h3>";
				}

				
		}

	}
?>
<h2>Add a Team</h2>
<form id="myform" name="myform" class="team-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
	<?php 
		if($msgSuccess)
		{
			echo $msgPre . $msgSuccess . $msgPost;
		}
	?> 
		<div class="form-group">
			<label for="team">Team Name:</label>
			<input type="text" name="team" class="form-control" value="<?php if($team){echo "$team";}?>">
			<?php 
				if($valTeamMsg){echo $msgPreError . $valTeamMsg . $msgPost;}
			 ?>
		</div>
		<div class="form-group">
			<label for="myfile">Logo Upload:</label>
			<input type="file" name="myfile" class="form-control" value="<?php if($fileName){echo "$fileName";}?>">
			<?php 
				if($valMessage){echo $msgPreError . $valMessage . $msgPost;}
			 ?>
		</div>
		<div class="form-group">
			<label for="description">Team Description</label>
			<textarea name="description" class="form-control"><?php if($description){echo "$description";}?></textarea>
			<?php 
				if($valDescriptionMsg){echo $msgPreError . $valDescriptionMsg . $msgPost;}
			 ?>
		</div>
		<div class="form-group">
			<label for="submit">&nbsp;</label>
			<input type="submit" name="submit" class="btn btn-info" value="Submit">
		</div>



</form>
<?php
	include("../includes/footer.php");
?>