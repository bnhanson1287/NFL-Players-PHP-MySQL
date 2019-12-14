<?php 

include ("includes/header.php");
$pid = $_GET['pid'];
 $back = "<p><b><a href=\"". $_SERVER['HTTP_REFERER']. "\">Back</a></b></p>";
 ?>



 <?php $result = mysqli_query($con, "SELECT * FROM nfl_players WHERE p_id = '$pid'") ?>
 <div class="container">	
 	<?php echo $back; ?>
 	<div class="row">	
 		<?php while($row = mysqli_fetch_array($result)): ?>
 			<div class="col-sm">
 				<img src="images/display/<?php echo $row['player_image']; ?>">
 			</div>
 			<div class="col-sm">	
 				<h2><?php echo $row['player_name'] ?></h2>
 				<b>Years Active:</b><br>
 				<i><?php echo $row['years_active'] ?></i><br><br>
 				<b>Date of Birth:</b>
 				<p><?php echo $row['date_of_birth'] ?></p>
 				<b>Draft Year: </b>
 				<p><?php echo $row['draft_year'] ?></p>
 				<b>Position: </b>
 				<p><?php echo $row['position'] ?></p>
 				<?php if($row['num_sb_champs'] != 0): ?>
					<b>Super Bowl Wins: </b><br>
					<?php 
							$times = $row['num_sb_champs'];

							for($i = 0; $i < $times; $i++)
							{
								echo "<img class=\"sb-pic\" src=\"images/site-picks/lombardi.png\" alt=\"$times\"/>";
							}
					 ?>

 					<!---<p><?php echo $row['num_sb_champs'] ?></p>-->
 				<?php endif ?>
 				<br><b>Pro Bowler: </b>
 				<?php if($row['pro_bowler'] == 1): ?>
 					<p>Yes</p>
 				<?php else : ?>
 					<p>No</p>
 				<?php endif ?>
 				<b>Player Description: </b>
 				<p><?php echo nl2br($row['player_description']) ?></p>
		 		<?php 	endwhile ?>
		 		<h3>Teams Played for:</h3>
		 		<?php $logoResult = mysqli_query($con, "SELECT logo, nfl_teams.t_id from nfl_teams inner join nfl_roster on nfl_roster.t_id = nfl_teams.t_id WHERE nfl_roster.p_id = '$pid'")?>
		 		<?php while($row = mysqli_fetch_array($logoResult))
					{
						$logo = $row['logo'];
						$id = $row['t_id'];

						echo "<div class=\"thumb\">";
						echo "<a href=\"teams.php?tid=$id\"><img src=\"images/thumbs50/$logo\"/></a><br>";
						echo "</div>";
		 			}
		 		?>
 		</div>
	</div>
	<div class="form-group">
		
	</div>
</div>
 <?php 
	include("includes/footer.php")
 ?>
