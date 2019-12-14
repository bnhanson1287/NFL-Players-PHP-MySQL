<?php
	session_start();
	if(isset($_SESSION['nflplayersession']))
	{

	}
	else 
	{
		header("Location:login.php?redirect=team-edit.php"); 
	}
	include("../includes/header.php");


	$tid = $_GET['tid'];

	if(!isset($tid))
	{
		$result = mysqli_query($con, "SELECT t_id FROM nfl_teams LIMIT 1");
		{
			while($row = mysqli_fetch_array($result))
			{
				$tid = $row['t_id']; 
			}
		}
	}
	$result = mysqli_query($con, "SELECT logo FROM nfl_teams WHERE t_id = $tid");
	while($row = mysqli_fetch_array($result))
	{
		$fileName = $row['logo'];

		$image = "<img src=\"../images/display350/$fileName\">";
	}


	// UPDATE CODE
	if(isset($_POST['submit']))
	{
		$team = $_POST['team'];
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
		if($valid == 1)
		{
			$msgSuccess = "You have successfully added the ".$team;


			mysqli_query($con,"UPDATE nfl_teams SET team_name = '$team',team_description = '$description' WHERE t_id = $tid")or die(mysqli_error($con));
		}
	}

	//PP Fields
	$result = mysqli_query($con, "SELECT * FROM nfl_teams WHERE t_id = $tid")or die(mysqli_error($con));
	while($row = mysqli_fetch_array($result))
	{
		$team = $row['team_name'];
		$description = $row['team_description'];
	}

?>
<div>
	<h2>Edit a Team</h2>
	<div class="row">
		<div class="col-lg-4 col-sm-1">
			<form id="myform" name="myform" class="team-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
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
						<label for="description">Team Description</label>
						<textarea name="description" class="form-control"><?php if($description){echo "$description";}?></textarea>
						<?php 
							if($valDescriptionMsg){echo $msgPreError . $valDescriptionMsg . $msgPost;}
						 ?>
					</div>
					<div class="form-group">
						<label for="submit">&nbsp;</label>
						<input type="submit" name="submit" class="btn btn-info" value="Update">
					</div>
			</form>
		</div>
		<div class="col-lg-4 col-sm-1">
			<h3>Team Logo</h3>
	 		<?php echo $image; ?>
	 	</div>
	 	<div class="col-lg-4 col-sm-1">
	 		<h3>Select a Team to Edit</h3>
	 			<?php $result = mysqli_query($con, "SELECT * FROM nfl_teams") ?>
				<?php while($row = mysqli_fetch_array($result)) 
				{
					$name = $row['team_name'];
					$image = $row['logo'];
					$id = $row['t_id'];
					echo "<div class=\"thumb\">";
					echo "<a href=\"team-edit.php?tid=$id\"><img src=\"../images/thumbs50/$image\"/></a><br>";
					echo "<a href=\"team-edit.php?tid=$id\">$name</a>";
					echo "</div>";
				}
				?>
	 	</div>
	</div>
</div>


<?php 
	include("../includes/footer.php");
 ?>