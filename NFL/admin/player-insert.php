<?php
session_start();
	if(isset($_SESSION['nflplayersession']))
	{

	}
	else 
	{
		header("Location:login.php?redirect=player-insert.php"); 
	}
	include("../includes/header.php");
	include("../includes/_functions.php");

	
	//$teamID = array();
	$uniqueId = uniqid().".jpg";
	if(isset($_POST['submit']))
	{
		$name = trim($_POST['name']);
		$birthday = $_POST['dob'];
		$filename = $uniqueId;

		$draft = $_POST['draft'];
		$position = $_POST['position'];
		$side = $_POST['off-def'];
		$proBowl = $_POST['pro-bowl'];
		$active = $_POST['active'];
		$description = strip_tags(trim($_POST['description']));
		$superBowls = $_POST['super-bowl'];
		$teamID = $_POST['team'];

		if($teamID != null)
		{
			$count = count($_POST['team']);
		}
		


		 
		$valid = 1;
		$msgPre = "<div class=\"alert alert-success\">";
		$msgPost = "</div>\n";
		$msgPreError = "<div class=\"alert alert-info\">";

		// Name Val
		if((strlen($name) < 1 )|| (strlen($name) > 50 ) )
		{
			$valid = 0;
			$valNameMsg = "Player Name must be between 1 and 50 characters";
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
		//years active
		if($active == null)
		{
			$valid = 0;
			$valActiveMsg = "Please input years active.";
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
		// count teams val
		if($count == null)
		{
			$val = 0;

			$valCountMsg = "Please select a team.";
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
			$msgSuccess = "You have successfully added a  " .$name;
			if(move_uploaded_file($_FILES['myfile']['tmp_name'], "../images/originals/".$uniqueId))
				{


					correctImageOrientation("../images/originals/".$uniqueId);
					$thisFile = "../images/originals/".$uniqueId;
					
					createSquareImageCopy($thisFile, "../images/thumbs50/", 50);

					createSquareImageCopy($thisFile, "../images/thumbs140/", 140);

					createImageCopy($thisFile, "../images/display350/", 350);

					createImageCopy($thisFile, "../images/display/", 500);


					//DB

					mysqli_query($con,"INSERT INTO nfl_players (player_name, player_image, date_of_birth, draft_year, num_sb_champs, offense_defense, player_description, position, pro_bowler, years_active) VALUES ('$name','$filename', '$birthday', '$draft', '$superBowls', '$side', '$description', '$position', '$proBowl', '$active')")or die(mysqli_error($con));
					$playerID = $con->insert_id;


					for($i = 0; $i < $count; $i++)
					{
						mysqli_query($con,"INSERT INTO nfl_roster (t_id, p_id) VALUES ('$teamID[$i]', '$playerID') ")or die(mysqli_error($con));
					}

					

					$name = "";
					$birthday = "";
					$filename = "";
					$draft = "";
					$position = "";
					$side = "";
					$proBowl = 0;
					$active = "";
					$description = "";
					$superBowls = "";

				}
				else
				{
					echo "<h3>Error</h3>";
				}

				
		}

		
	}
?>
<div class="container py-5">
	    <div class="row">
	    	<div class="col-md-10 mx-auto">
			<h2>Add a Player</h2>
			<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
				<?php 
					if($msgSuccess)
					{
						echo $msgPre . $msgSuccess . $msgPost;
					}
				?> 
					<div class="form-group required row">
						<div class="col-6" >
							<label for="name" class="control-label">Name:</label>
							<input type="text" name="name" class="form-control" value="<?php if($name) {echo "$name";}?>" >
							<?php 
								if($valNameMsg){echo $msgPreError . $valNameMsg . $msgPost;}
							 ?>
						</div>
						<div class="col-6" >
							<label for="dob" class="control-label">Date of Birth:</label>
							<input type="date" name="dob" class="form-control" value="<?php if($birthday) {echo "$birthday";}?>">
							<?php 
								if($valBDayMsg){echo $msgPreError . $valBDayMsg . $msgPost;}
							 ?>
						</div>
					</div>
					<div class="form-group required row ">
						<div class="col-6" >
							<label for="myfile" class="control-label">Image Upload:</label>
							<input type="file" name="myfile" class="form-control" value="<?php if($filename) {echo "$filename";}?>">
							<?php 
								if($valMessage){echo $msgPreError . $valMessage . $msgPost;}
							 ?>
						</div>
						<div class="col-6">
							<label for="draft" class="control-label">Year Drafted:</label>
							<input type="text" name="draft" class="form-control"  value="<?php if($draft) {echo "$draft";}?>">
							<?php 
								if($valDraftMsg){echo $msgPreError . $valDraftMsg . $msgPost;}
							 ?>
						</div>
					</div>
					<div class="form-group required row">
						<div class="col-6">
							<label for="position" class="control-label">Position:</label>
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
						<div class="col-6">
							<label for="super-bowl">Number of Super Bowls: </label>
							<input type="text" name="super-bowl" class="form-control" value="<?php if($superBowls) {echo "$superBowls";}?>">
						</div>
					</div>
					<div class="form-group required row">
						<div class="col-6">
							<label for="off-def" class="control-label">Side of the Ball:</label><br>
							<div class="form-check form-check-inline">
				            	<input class="form-check-input" type="radio" name="off-def" value="offense" <?php if(isset ($side) && $side == "offense") {echo "checked";} ?>>
				            	<label class="form-check-label" for="off-def">Offense</label>
					        </div><br>
					        <div class="form-check form-check-inline">
				            	<input class="form-check-input" type="radio" name="off-def" value="defense" <?php if(isset ($side) && $side == "defense") {echo "checked";} ?>>
				            	<label class="form-check-label" for="off-def">Defense</label>
					        </div><br>
					        <?php 
								if($valSideMsg){echo $msgPreError . $valSideMsg . $msgPost;}
							 ?>
					        <div class="form-check form-check-inline">
				    			<label class="form-check-label" for="pro-bowl">Pro Bowler:&nbsp;</label>
				            	<input class="form-check-input" type="checkbox" name="pro-bowl" value="1" <?php if(isset ($proBowl)  && $proBowl == 1) {echo "checked";} ?>>
					        </div>
				    	</div>
				    	<div class="col-6">
					        <label for="active" class="control-label">Years Active: </label>
							<input type="text" name="active" class="form-control" value="<?php if($active) {echo "$active";}?>">
							<?php 
								if($valActiveMsg){echo $msgPreError . $valActiveMsg . $msgPost;}
							 ?>
				    	</div>
					</div>
					<div class="form-group required row ">
						<label class="control-label" for="team">Teams Played For:&nbsp;&nbsp; </label><br><br>
						<div>
							<?php $team = mysqli_query($con, "SELECT team_name, t_id FROM nfl_teams"); ?>
							<?php while($row = mysqli_fetch_array($team)): ?>
								<label for="team"><?php echo $row['team_name'];  ?>:&nbsp;&nbsp;</label>
								<input type="checkbox" name="team[]" value="<?php echo $row['t_id'] ; ?>" >
							<?php endwhile ?><br>
							<a href="team-insert.php">Add a Team</a>
							<?php 
									if($valCountMsg){echo $msgPreError . $valCountMsg . $msgPost;}
								 ?>
						</div>
					</div>
					<div class="form-group required row">
						<label for="description" class="control-label">Player Description:</label>
						<textarea name="description" class="form-control"><?php if($description) {echo "$description";}?></textarea>
						<?php if($valDescriptionMsg){echo $msgPreError. $valDescriptionMsg. $msgPost;} ?>
					</div>
					<div class="form-group">
						<label for="submit">&nbsp;</label>
						<input type="submit" name="submit" class="btn btn-info" value="Submit">
					</div>
			</form>
		</div>
	</div>
</div>
<?php
	include("../includes/footer.php");
?>