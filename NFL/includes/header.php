<?php
include("mysql_connect.php");// here we include the connection script; since this file(header.php) is included at the top of every page we make, the connection will then also be included. Also, config options like BASE_URL are also available to us.

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   
    <!--  This CONSTANT is defined in your mysql_connect.php file. -->
    <title><?php echo APP_NAME; ?></title>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<!-- Google Icons: https://material.io/tools/icons/
  also, check out Font Awesome or Glyphicons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


 <!-- Your Custom styles for this project -->
 <!--  Note how we can use BASE_URL constant to resolve all links no matter where the file resides. -->
<link href="<?php echo BASE_URL ?>css/styles.css" rel="stylesheet">
<!-- Themes from https://bootswatch.com/ : Use the Themes dropdown to select a theme you like; copy/paste the bootstrap.css. Here, we have named the downloaded theme as a new file and can overwrite the default.  -->
<link href="<?php echo BASE_URL ?>css/bootstrap-cerulean.css" rel="stylesheet">

</head>

  <body>

    
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4 fixed-top">
      <a class="navbar-brand" href="<?php echo BASE_URL ?>index.php"><i class="material-icons" style="font-size:36px">home</i></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
         
          <li class="nav-item">
            <!-- This is a placeholder link. You will need to change this to link to your files. -->
            <a class="nav-link" href="<?php echo BASE_URL ?>teams.php">Teams</a>
          </li>
          <li class="nav-item">
             <a class="nav-link" href="<?php echo BASE_URL ?>players.php">Players</a>
          </li>
           <li class="nav-item">
             <a class="nav-link" href="<?php echo BASE_URL ?>search.php">Search</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
            <div class="dropdown-menu">
                <div class="dropdown-submenu" aria-labelledby="dropdown01">
              <a class="dropdown-item dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Player</a>
              <div class="dropdown-menu"> 
                  <a class="dropdown-item" href="<?php echo BASE_URL ?>admin/player-insert.php">Insert Player</a>
                  <a class="dropdown-item" href="<?php echo BASE_URL ?>admin/player-edit.php">Edit Player</a>
              </div>
                </div>
                <div class="dropdown-submenu" aria-labelledby="dropdown01">
                <a class="dropdown-item dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Team</a>
                <div class="dropdown-menu"> 
                    <a class="dropdown-item" href="<?php echo BASE_URL ?>admin/team-insert.php">Insert Team</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL ?>admin/team-edit.php">Edit Team</a>
                </div> 
                </div>
            </div>
          </li>
        </ul>
        <a href="<?php echo BASE_URL ?>admin/logout.php" class="btn btn-danger"><i class="glyphicon glyphicon-log-out"></i>Logout</a>
      </div>
    </nav>

    <main role="main" class="container">



    

      

    




