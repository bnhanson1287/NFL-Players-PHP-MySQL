<?php

include ("includes/header.php");

$result = mysqli_query($con, "SELECT * FROM nfl_players") or die (mysql_error());

$displayby = $_GET['displayby'];
$displayvalue = $_GET['displayvalue'];

if(isset($displayby) && isset($displayvalue)) 
{

  $result = mysqli_query($con,"SELECT * FROM nfl_players WHERE $displayby LIKE '$displayvalue' ") or die (mysql_error());
  
}
if($displayby == "num_sb_champs")
{
  $min = $_GET['min'];
  $max = $_GET['max'];
  $result =  mysqli_query($con,"SELECT * FROM nfl_players WHERE num_sb_champs BETWEEN $min AND $max") or die (mysql_error());
}
if($displayby == "draft_year")
{
  $result =  mysqli_query($con,"SELECT * FROM nfl_players WHERE draft_year < '$displayvalue'") or die (mysql_error());
}


?>
<div class="container">
  <h1>Players</h1>
   <div class="col-lg-2 col-sm-1" id="rightcol">
          <a class="btn btn-secondary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <p>Filters</p>
          </a>
        <div class="collapse" id="collapseExample">
          <a href="players.php">All Players</a><br />
          <a href="players.php?displayby=offense_defense&displayvalue=offense">Offense</a><br />
          <a href="players.php?displayby=offense_defense&displayvalue=defense">Defense</a><br />
          <br><a href="players.php?displayby=years_active&displayvalue=%Present">Active</a><br />
          <br><a href="players.php?displayby=draft_year&displayvalue=2000">Old School Players</a><br />
          <p>Super Bowls Won</p>
          <a href="players.php?displayby=num_sb_champs&min=0&max=1"> 0-1</a><br />
          <a href="players.php?displayby=num_sb_champs&min=2&max=6">2-6</a><br />
          <p>Players by Position</p>
          <?php 
            $positionResults =  mysqli_query($con, "SELECT position from nfl_players GROUP BY position");
            while($row = mysqli_fetch_array($positionResults))
            {
              $position = $row['position'];

              echo "<a href=\"players.php?displayby=position&displayvalue=$position\">".$position."</a><br>";
            }


           ?>
        </div>
      </div>
		<div class="row text-center text-lg-left">
      <div class="col-lg-10">
        <?php while($row = mysqli_fetch_array($result)):?>
          <div class="col-lg-3 col-md-4 col-6 player-grid">
              <div class="title">
                <a href="display.php?pid=<?php echo $row['p_id']; ?>"><?php echo $row['player_name'];?></a>
              </div>
              <div>
                <a href="display.php?pid=<?php echo $row['p_id']; ?>"><img src="images/thumbs140/<?php echo  $row['player_image']; ?>"></a>
              </div>
          </div>
        <?php endwhile ?>
      </div>
    </div>
</div>


<?php

include ("includes/footer.php");
?>