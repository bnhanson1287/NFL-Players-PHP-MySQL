<?php  
session_start();
	if(isset($_SESSION['nflplayersession']))
	{

	}
	else 
	{
		header("Location:login.php?redirect=player-edit.php"); 
	}

	include("../includes/header.php");

	$pid = $_GET['pid'];



	if(!isset($pid))
	{
		$result = mysqli_query($con, "SELECT p_id FROM nfl_players LIMIT 1");
		{
			while($row = mysqli_fetch_array($result))
			{
				$pid = $row['p_id']; 
			}
		}
	}
	// Get player photo
	$result = mysqli_query($con, "SELECT player_image FROM nfl_players WHERE p_id = $pid");
	while($row = mysqli_fetch_array($result))
	{
		$fileName = $row['player_image'];

		$image = "<img src=\"../images/display350/$fileName\">";
	}

	
	// UPDATE
	if(isset($_POST['my-submit']))
	{
		$name = trim($_POST['name']);
		$birthday = $_POST['birthday'];
		$draft = $_POST['draft'];
		$position = $_POST['position'];
		$side = $_POST['off-def'];
		$proBowl = $_POST['pro-bowl'];
		$active = $_POST['active'];
		$description = $_POST['description'];
		$superBowls = $_POST['super-bowl'];
		 
		$valid = 1;
		$msgPre = "<div class=\"alert alert-success\">";
		$msgPost = "</div>\n";
		$msgPreError = "<div class=\"alert alert-info\">";

		// Name Val
		if((strlen($name) < 1 )|| (strlen($name) > 50 ))
		{
			$valid = 0;
			$valNameMsg = "Player Name must be between 1 and 50 characters";
		}
		//years active
		if($active == null)
		{
			$valid = 0;
			$valActiveMsg = "Please input years active.";
		}

		// birthday val
		if($birthday == null)
		{
			$valid = 0;
			$valBDayMsg = "You must input the players birthday.";
		}
		//draft val
		if($draft == null)
		{
			$valid = 0;
			$valDraftMsg = "You must input the players draft year.";
		}
		// side val
		if($side == null)
		{
			$valid = 0;
			$valSideMsg = "Was this an Offensive or Defensive player?";
		}
		// position val
		if($position == null)
		{
			$valid = 0;
			$valPositionMsg = "You must select a position.";
		}

		//Description Val
		if(strlen($description) < 20 || strlen($description) > 800)
		{
			$valid = 0;
			$valDescriptionMsg = "Description must be between 20 & 800 characters.";
		} 

		// SUCCESS
		if($valid == 1)
		{
			$msgSuccess = "You have successfully updated ".$name.".";
			mysqli_query($con,"UPDATE nfl_players SET player_name = '$name',  date_of_birth = '$birthday', draft_year = '$draft', num_sb_champs = '$superBowls', offense_defense = '$side', player_description = '$description', position = '$position', pro_bowler = '$proBowl', years_active = '$active' WHERE p_id = $pid")or die(mysqli_error($con));
		}
	}



	//prepop
	$result = mysqli_query($con, "SELECT * FROM nfl_players WHERE p_id = $pid")or die(mysqli_error($con));
	while($row = mysqli_fetch_array($result))
	{
		$name = $row['player_name'];
		$birthday = $row['date_of_birth'];
		$draft = $row['draft_year'];
		$position = $row['position'];
		$side = $row['offense_defense'];
		$proBowl = $row['pro_bowler'];
		$active = $row['years_active'];
		$description = $row['player_description'];
		$superBowls = $row['num_sb_champs'];
	}

?>

<div class="container">
	<h2>Edit Player</h2>
		<div class="row">
			<div class="col-lg-4 col-sm-1">
				<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>">
					<?php 
						if($msgSuccess)
						{
							echo $msgPre . $msgSuccess . $msgPost;
						}
					?>  
					<div class="form-group">
	 					<label for="name">Name:</label>
		 					<input type="text" name="name" class="form-control" value="<?php if($name){echo "$name";} ?>">
		 					<?php if($valNameMsg){echo $msgPreError. $valNameMsg. $msgPost;} ?>
	 				</div>
	 				<div class="form-group">
	 					<label for="birthday">DOB:</label>
		 					<input type="date" name="birthday" class="form-control" value="<?php if($birthday){echo "$birthday";} ?>">
		 					<?php if($valBDayMsg){echo $msgPreError. $valBDayMsg. $msgPost;} ?>
	 				</div>
	 				<div class="form-group">
	 					<label for="draft">Draft Year:</label>
		 					<input type="text" name="draft" class="form-control" value="<?php if($draft){echo "$draft";} ?>">
		 					<?php if($valDraftMsg){echo $msgPreError. $valDraftMsg. $msgPost;} ?>
	 				</div>
	 				<div class="form-group">
	 				<label for="position">Position:</label>
					<select name="position" class="form-control">
						<option value="">
							Select a position
						</option>
						<option value="QB" <?php if(isset ($position) && $position == "QB") {echo "selected";} ?>>
							Quarterback
						</option>
						<option value="RB" <?php if(isset ($position) && $position == "RB") {echo "selected";} ?> >
							Running Back
						</option>
						<option value="WR" <?php if(isset ($position) && $position == "WR") {echo "selected";} ?>>
							Wide Receiver
						</option>
						<option value="TE" <?php if(isset ($position) && $position == "TE") {echo "selected";} ?>>
							Tight-End
						</option>
						<option value="OT" <?php if(isset ($position) && $position == "OT") {echo "selected";} ?>>
							Offensive Tackle
						</option>
						<option value="OG" <?php if(isset ($position) && $position == "OG") {echo "selected";} ?>>
							Guard
						</option>
						<option value="OC" <?php if(isset ($position) && $position == "OC") {echo "selected";} ?>>
							Center
						</option>
						<option value="DE" <?php if(isset ($position) && $position == "DE") {echo "selected";} ?>>
							Defensive End
						</option >
						<option value="DT" <?php if(isset ($position) && $position == "DT") {echo "selected";} ?>>
							Defensive Tackle
						</option>
						<option value="LB" <?php if(isset ($position) && $position == "LB") {echo "selected";} ?>>
							Linebacker
						</option>
						<option value="CB" <?php if(isset ($position) && $position == "CB") {echo "selected";} ?>>
							Corner Back
						</option>
						<option value="S" <?php if(isset ($position) && $position == "S") {echo "selected";} ?>>
							Safety
						</option>
					</select>
					<?php 
						if($valPositionMsg){echo $msgPreError . $valPositionMsg . $msgPost;}
					 ?>
					</div>
					<div class="form-group">
	 					<label for="off-def">Side of the Ball:</label>
						<div class="form-check form-check-inline">
			            	<input class="form-check-input" type="radio" name="off-def" value="offense" <?php if(isset ($side) && $side == "offense") {echo "checked";} ?>>
			            	<label class="form-check-label" for="off-def">Offense</label>
				        </div>
				        <div class="form-check form-check-inline">
			            	<input class="form-check-input" type="radio" name="off-def" value="defense" <?php if(isset ($side) && $side == "defense") {echo "checked";} ?>>
			            	<label class="form-check-label" for="off-def">Defense</label>
				        </div>
				        <?php 
							if($valSideMsg){echo $msgPreError . $valSideMsg . $msgPost;}
						 ?>
						 <div class="form-check form-check-inline">
			    			<label class="form-check-label" for="pro-bowl">Pro Bowler:&nbsp;</label>
			            	<input class="form-check-input" type="checkbox" name="pro-bowl" value="1" <?php if(isset ($proBowl)) {echo "checked";} ?>>
				        </div>
	 				</div>
	 				<div class="form-group">
	 					<label for="description">Description:</label>
	 					<textarea name="description" class="form-control"><?php if($description){echo "$description";} ?></textarea>
	 					<?php if($valDescriptionMsg){echo $msgPreError. $valDescriptionMsg. $msgPost;} ?>
	 				</div>
	 				<div class="form-group">
	 					<label for="active">Years Active: </label>
						<input type="text" name="active" class="form-control" value="<?php if($active) {echo "$active";}?>">
						<?php 
								if($valActiveMsg){echo $msgPreError . $valActiveMsg . $msgPost;}
						?>
	 				</div>
	 				<div class="form-group">
	 					<label for="super-bowl">Number of Super Bowls: </label>
						<input type="text" name="super-bowl" class="form-control" value="<?php if($superBowls) {echo "$superBowls";}?>">
	 				</div>
	 				<div class="form-group buttons">
 					<input type="submit" name="my-submit" class="btn btn-info" value="Update">
 					<a href="delete.php?pid=<?php echo "$pid";?> "class="btn btn-danger" onclick="return confirm('Are you sure you want to delete <?php echo "$name";?>?')">Delete</a>
 				</div>
				</form>
			</div>
			<div class="col-lg-4 col-sm-1">
				<h3>Player Picture</h3>
				<p>&nbsp;</p>
	 			<?php echo $image; ?>
	 		</div>
	 		<div class="col-lg-4 col-sm-1">
	 			<h3>Select a Player to Edit</h3>
	 			<?php $result = mysqli_query($con, "SELECT * FROM nfl_players") ?>
				<?php while($row = mysqli_fetch_array($result)) 
				{
					$name = $row['player_name'];
					$image = $row['player_image'];
					$id = $row['p_id'];
					echo "<div class=\"thumb\">";
					echo "<a href=\"player-edit.php?pid=$id\"><img src=\"../images/thumbs50/$image\"/></a><br>";
					echo "<a href=\"player-edit.php?pid=$pid\">$name</a>";
					echo "</div>";
				}
				?>
	 		</div>
		</div>	
</div>
 <?php 
	include("../includes/footer.php");
  ?>