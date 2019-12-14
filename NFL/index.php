<?php

include ("includes/header.php");

$result = mysqli_query($con, "SELECT * FROM nfl_players ORDER BY RAND() LIMIT 2") or die (mysql_error());

$displayby = $_GET['displayby'];
$displayvalue = $_GET['displayvalue'];

if(isset($displayby) && isset($displayvalue)) 
{

  $result = mysqli_query($con,"SELECT * FROM nfl_players WHERE $displayby LIKE '$displayvalue'  ORDER BY RAND() LIMIT 2 ") or die (mysql_error());
  
}
if($displayby == "num_sb_champs")
{
  $min = $_GET['min'];
  $max = $_GET['max'];
  $result =  mysqli_query($con,"SELECT * FROM nfl_players WHERE num_sb_champs BETWEEN $min AND $max  ORDER BY RAND() LIMIT 2") or die (mysql_error());
}
if($displayby == "draft_year")
{
  $result =  mysqli_query($con,"SELECT * FROM nfl_players WHERE draft_year < '$displayvalue'  ORDER BY RAND() LIMIT 2") or die (mysql_error());
}


?>

  	<div class="jumbotron clearfix">
        <h1><?php echo APP_NAME ?></h1>
        <p>
          This site uses PHP/MySQL to display my favourite NFL players of all-time. The site uses a relational database to link up the players and the teams they have played for. The homepage features 2 players and a brief description of those players. Those random players can be filtered to random players within a category.
        </p>
        <p>
          The sites player page features a gallery of all the players on the list. The players can be filtered by several different attributes such as: if they were an offensive player or a defensive player, their position, the number of Super Bowls they have won, and if they are still active in the NFL today.
        </p>
        <p>
          The site features a display page for each player and each team in the database. The player display page has all of the gathered information on the player displayed. The user can also see all of the teams that player has played for and each team logo is hyperlinked to the teams information page.
        </p>
        <p>
          The team information page features the team logo, a brief description of the team, and all of the players in the database that have played for the team.
        </p>
        <p>
          The admin section on this site allows me as the site administrator to perform CRUD operations on the teams and players. 
        </p>
  	</div>

<div class="container">
   <h2>Featured Players</h2>
   <div class="col-lg-2 col-md-4 col-sm-1" id="rightcol">
          <a class="btn btn-secondary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <p>Filters</p>
          </a>
        <div class="collapse" id="collapseExample">
          <a href="index.php?displayby=offense_defense&displayvalue=offense">Offense</a><br />
          <a href="index.php?displayby=offense_defense&displayvalue=defense">Defense</a><br />
          <br><a href="index.php?displayby=years_active&displayvalue=%Present">Active</a><br />
          <br><a href="index.php?displayby=draft_year&displayvalue=2000">Old School Players</a><br />
          <p>Super Bowls Won</p>
          <a href="index.php?displayby=num_sb_champs&min=0&max=1"> 0-1</a><br />
          <a href="index.php?displayby=num_sb_champs&min=2&max=6">2-6</a><br />
          <p>Players by Position</p>
          <?php 
            $positionResults =  mysqli_query($con, "SELECT position from nfl_players GROUP BY position");
            while($row = mysqli_fetch_array($positionResults))
            {
              $position = $row['position'];

              echo "<a href=\"index.php?displayby=position&displayvalue=$position\">".$position."</a><br>";
            }


           ?>
        </div>
      </div>
		<div class="row ">
      <div class="col-lg-10 col-md-12 col-sm-12">
        <?php while($row = mysqli_fetch_array($result)):?>
          <div class="col-lg-12 player-box">
            <div class="row ">
              <div class="col-lg-4 col-sm-12">
                <a href="display.php?pid=<?php echo $row['p_id']; ?>"><h3><?php echo $row['player_name'];?></h3
                <a href="display.php?pid=<?php echo $row['p_id']; ?>"><img src="images/thumbs140/<?php echo  $row['player_image']; ?>"></a>
              </div>
              <div class="description-box col-lg-8 col-sm-12">
                <p>
                  <?php echo $row['player_description'];?>
                </p>
              </div>
          </div>
        </div>
        <?php endwhile ?>
      </div>
    </div>
</div>


<?php

include ("includes/footer.php");
?>