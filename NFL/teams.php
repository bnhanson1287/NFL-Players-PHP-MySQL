<?php 
include("includes/header.php");
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
 ?>
<?php $result = mysqli_query($con, "SELECT * FROM nfl_teams WHERE t_id = '$tid'") ?>
<div class="container">
	<h1>Teams</h1>
	<div class="row">	
 		<?php while($row = mysqli_fetch_array($result)): ?>
		<div class="col-lg-6 col-sm-1">
 				<img src="images/display350/<?php echo $row['logo']; ?>">
		</div>
		<div class="col-lg-6 col-sm-1">
			<h2><?php echo $row['team_name'] ?></h2>
				<b>Team Description: </b>
			 	<p><?php echo nl2br($row['team_description']) ?></p>
				<?php 	endwhile ?>
			<h3>Team Players:</h3>
		 		<?php $playerResult = mysqli_query($con, "SELECT player_name, player_image, nfl_players.p_id from nfl_players inner join nfl_roster on nfl_roster.p_id = nfl_players.p_id WHERE nfl_roster.t_id = '$tid'")?>
		 		<?php while($row = mysqli_fetch_array($playerResult))
					{
						$player = $row['player_name'];
						$pic = $row['player_image'];
						$id = $row['p_id'];

						echo "<div class=\"thumb\">";
						echo "<a href=\"display.php?pid=$id\"><img src=\"images/thumbs50/$pic\"/></a><br>";
						echo "<a href=\"display.php?pid=$id\">$player</a>";
						echo "</div>";
		 			}
		 		?>
		</div>
		<div class="col-lg-6 col-sm-1">
			<h3>NFL Teams</h3>
 			<?php $result = mysqli_query($con, "SELECT * FROM nfl_teams") ?>
			<?php while($row = mysqli_fetch_array($result)) 
			{
				$name = $row['team_name'];
				$image = $row['logo'];
				$id = $row['t_id'];
				echo "<div class=\"thumb\">";
				echo "<a href=\"teams.php?tid=$id\"><img src=\"images/thumbs50/$image\"/></a><br>";
				echo "<a href=\"teams.php?tid=$id\">$name</a>";
				echo "</div>";
			}
			?>
		</div>


</div>

 <?php 
include("includes/footer.php");
 ?>