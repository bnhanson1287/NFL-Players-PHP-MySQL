<?php 

include ("includes/header.php");

 ?>
<h1>Search</h1>
       
    <!-- On your own
	Create a search form.
	Create a link to search in your header


     -->

<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

		<div class="form-group">
			<label for="searchterm">Search Term:</label>
			<input type="text" name="searchterm" class="form-control">	
		</div>
			
		<div class="form-group">
			<label for="submit">&nbsp;</label>
			<input type="submit" name="submit" class="btn btn-info" value="Submit">
		</div>

</form>
      
<?php 

if(isset($_POST['submit'])){

	$searchterm = trim($_POST['searchterm']);
	if($searchterm != ""){
		echo "<p>searching for <b>\"$searchterm\"</b> ... </p>" ;


	// this time, we'll save our actual SQL query in a variable
	
		$sql = "SELECT * FROM nfl_players WHERE 
		player_name LIKE '$searchterm'
		OR player_description LIKE '%$searchterm%'";	

		//$result = mysqli_query($con,"SELECT * FROM characters") or die(mysqli_error($con));
		$result = mysqli_query($con,$sql) or die(mysqli_error($con));

		// let's have a conditional in case there are no results from this query

		if(mysqli_num_rows($result) > 0){

			while($row = mysqli_fetch_array($result)){
	
				$pid =$row['p_id'];
				$name = $row['player_name'];
				$image = $row['player_image'];
				$description = $row['player_description'];
				echo "\n<div class=\"col-lg-12 player-box\">";
				echo "\n\t<a href=\"display.php?pid=$pid\"><h3>".$name."</h3></a>";
				echo "\n\t<a href=\"display.php?pid=$pid\"><img src=\"images/thumbs140/$image\"/></a>";
				echo "\n\t<p>" . $description . "</p>";
				echo "\n</div>";

			}




		}else{
			echo "\n\t\t<div class=\"alert alert-warning\">No Results</div>\n";
		}



	}

}



 ?>



 <?php 

include ("includes/footer.php");

 ?>