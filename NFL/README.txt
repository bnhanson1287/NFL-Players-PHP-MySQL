Setup of the Basic Application Template
------------------------------------------

The following steps must be completed in order to start using this template to create an application lab for DMIT2025.

includes/mysql_connect.php: This is a basic configuration file for DB connection and other important setup features.
 - $con = mysqli_connect("localhost", "username","password","db_name"); // This must be changed to your DB credentials.

 - define("BASE_URL", "http://username.dmitstudent.ca/dmit2025/characters/"); // This must be set to the root path to your application with the trailing slash included. Its best to change the name of the folder from "basic-app-template" to the name of the app (example: "characters") first.

If your project is then moved to another server, these settings are changed,and everything should still work. The DB must be migrated as well.


includes/header.php: links to pages - In order to be able to link to any page from any page using the same included file (header, footer), we use absolute URLs instead of relative URLs. Since we defined the constant BASE_URL above, we then use that in all our links.

Any of the sample links in the header must be changed to your pages. Additional links can be added. 
	<li><a href="<?php echo BASE_URL ?>anotherpage.php">Another Page</a></li>