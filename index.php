<?php
	// 1. Create the database connection.
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "root";
	$dbname = "clericaljobs";
	$connection = mysqli_connect($dbhost,$dbuser, $dbpass, $dbname);
	
	// Test if connection occurred
	if(mysqli_connect_errno()) {
		die("Database Connection Failed: " .
			mysqli_connect_error() .
			" (" . mysqli_connect_errno() . ")"
	 	);
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>JOB Portal</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
	<div class="meta">
		<div class="metalinks">
			<a href=""><img src="images/meta1.gif" alt="" width="15" height="14" /></a>
			<a href="#"><img src="images/meta2.gif" alt="" width="17" height="14" /></a>
			<a href="#"><img src="images/meta3.gif" alt="" width="17" height="14" /></a>
			<a href="#"><img src="images/meta4.gif" alt="" width="15" height="14" /></a>
		</div>
		<p>Recruiters: <a href="#">Log in</a> or <a href="#">Find out more</a></p>																																															
	</div>
	<div id="header">
		<a href="index.html" class="logo"><img src="images/logo.jpg" alt="setalpm" width="149" height="28" /></a>                                                                                                                                                                                                                                       <div class="inner_copy"><a href="http://www.webbuildersguide.com/">http://www.webbuildersguide.com/</a></div>
		<span class="slogan">Your Key to Success</span>
		<ul id="menu">
			<li><a href="#">Home</a></li>
			<li><a href="clerical-jobs-by-location.php">Find Clerical Jobs By Location</a></li>
			<li><a href="#">Find Clerical Jobs By Position</a></li>
		</ul>
		<img src="images/bigpicture.jpg" alt="" width="892" height="303" />
	</div>
	<div id="content">
		<div class="search">
			<form action="listings.php" method="post">
				<img src="images/title.gif" alt="" width="90" height="30" />
				
				<?php
					$getJobs = "SELECT * FROM titles";
					$getJobsResult = mysqli_query($connection, $getJobs);

					if(!$getJobsResult) {
						die("Database query failed. ");	
					}
								
					while($row = mysqli_fetch_ASSOC($getJobsResult)) {
						$options = $options . "<option value=\"" . $row["Title"] . "\">" . $row["Title"] . "</option>";
						}	
								
					$menu="<select class=\"second input\" name='jobTitle' id='jobTitle'>" . $options . "</select>";

					echo $menu;
				?>
				
				<input type="text" class="first input" name="zipcode" value="Enter Zipcode" />
				
				<input type="submit" name="submit"  class="button" value="Search" /> 
			</form>
		</div>
		<div id="blocks">																																																																																																																													
			<div class="block">
				<img src="images/title1.gif" alt="" width="214" height="29" /><br />
				<img src="images/map.jpg" alt="" width="214" height="160" /><br />
				<a href="#" class="more"><img src="images/morey.jpg" alt="" width="105" height="27" /></a>
			</div>
			<div class="block">
				<img src="images/title2.gif" alt="" width="214" height="29" /><br />
				<p class="red_text">Maecenas hendrerit, massa ac laoreet iaculipede mnisl ullamcorper- massa, cosectetuer feipsum eget pede. Proin nunc. Donec nonummy, tellus er sodales enim, in tincidun- mauris in odio. Massa ac laoreet iaculipede nisl ullamcorpermassa, ac consectetuer feipsum eget pede.  Proin nunc. Donec massa.</p>
				<a href="#" class="more"><img src="images/morer.jpg" alt="" width="105" height="27" /></a>
			</div>
			<div class="block">
				<img src="images/title3.gif" alt="" width="214" height="29" /><br />
				<ul id="list">
					<li><a href="#">Maecenas hendrerit</a></li>
					<li><a href="#">Massa ac laoreet iaculipede</a></li>
					<li><a href="#">Convallis nonummy tellus</a></li>
					<li><a href="#">In tincidunt mauris</a></li>
					<li><a href="#">Maecenas hendrerit</a></li>
					<li><a href="#">Consectetuer feipsum eget</a></li>
				</ul>
				<a href="#" class="more"><img src="images/moreg.jpg" alt="" width="106" height="27" /></a>
			</div>
			<div class="block">
				<img src="images/title4.gif" alt="" width="214" height="29" /><br />
				<p class="gray_text">Maecenas hendrerit, massa ac laoreet iaculipede mnisl ullamcorper- massa, cosectetuer feipsum eget pede. Proin nunc. Donec nonummy, tellus er sodales enim, in tincidun- mauris in odio. </p>
				<form action="#">
					<input type="text" class="signup input" value="Your E-mail Address" />
					<a href="#" class="submit"><img src="images/submit.jpg" alt="" width="69" height="25" /></a>
				</form>
			</div>
		</div>
		<div id="info">
			<div>
				<img src="images/title5.gif" alt="" width="160" height="26" />
				<ul>
					<?php
						// 2. Perform database query
						$query = "SELECT * FROM titles";
						$result = mysqli_query($connection, $query);
						// Test if there was a query error
						//echo $query;
						
						if(!$result) {
							die("Database query failed. ");	
						}
						
						// 3. Use returned data (if any)
						while($row = mysqli_fetch_ASSOC($result)) {
							// Output data from each row
							echo "<li><a href=\"http://www.clericaljobs.us.com/jobs-by-position.php?ID=" . $row["ID"] . "\">" . $row["Title"] . " jobs</a></li>";	
						}
						
						
					?>
					
					
				</ul>
			</div>
			<div>
				<img src="images/title6.gif" alt="" width="160" height="26" />
				<ul>
					<li><a href="#">Maecenas hendrerit</a></li>
					<li><a href="#">Massa ac laoreet iaculipede</a></li>
					<li><a href="#">Convallis nonummy tellus</a></li>
					<li><a href="#">In tincidunt mauris</a></li>
					<li><a href="#">Maecenas hendrerit</a></li>
					<li><a href="#">Convallis nonummy tellus</a></li>
					<li><a href="#">In tincidunt mauris</a></li>
				</ul>
			</div>
			<div>
				<img src="images/title7.gif" alt="" width="160" height="26" />
				<ul>
					<li><a href="#">Maecenas hendrerit</a></li>
					<li><a href="#">Massa ac laoreet iaculipede</a></li>
					<li><a href="#">Convallis nonummy tellus</a></li>
					<li><a href="#">In tincidunt mauris</a></li>
					<li><a href="#">Maecenas hendrerit</a></li>
					<li><a href="#">Convallis nonummy tellus</a></li>
					<li><a href="#">In tincidunt mauris</a></li>
				</ul>
			</div>
			<div>
				<img src="images/title8.gif" alt="" width="160" height="26" />
				<ul>
					<li><a href="#">Maecenas hendrerit</a></li>
					<li><a href="#">Massa ac laoreet iaculipede</a></li>
					<li><a href="#">Convallis nonummy tellus</a></li>
					<li><a href="#">In tincidunt mauris</a></li>
					<li><a href="#">Maecenas hendrerit</a></li>
					<li><a href="#">Convallis nonummy tellus</a></li>
					<li><a href="#">In tincidunt mauris</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="footer">
		Copyright &copy;. All rights reserved. Design by <a href="http://www.bestfreetemplates.info" target="_blank" title="Free CSS templates">BFT</a> 																																																						 
	</div>
</body>
</html>

<?php
  // 5. Close connection
  mysqli_close($connection);
	
?>
