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

<script type="text/javascript"
src="http://gdc.indeed.com/ads/apiresults.js"></script>


</head>

<body>
	
	
	
	<div class="meta">
		<div class="metalinks">
			<a href="#"><img src="images/meta1.gif" alt="" width="15" height="14" /></a>
			<a href="#"><img src="images/meta2.gif" alt="" width="17" height="14" /></a>
			<a href="#"><img src="images/meta3.gif" alt="" width="17" height="14" /></a>
			<a href="#"><img src="images/meta4.gif" alt="" width="15" height="14" /></a>
		</div>
		<p>Recruiters: <a href="#">Log in</a> or <a href="#">Find out more</a></p>																																															
	</div>
	<div id="innerheader">
		<a href="index.html" class="logo"><img src="images/logo.jpg" alt="setalpm" width="149" height="28" /></a>                                                                                                                                                                                                                                       <div class="inner_copy"><a href="http://www.webbuildersguide.com/">http://www.webbuildersguide.com/</a></div>
		<span class="slogan">Your Key to Success</span>
		<ul id="menu">
			<li><a href="#">Home</a></li>
			<li><a href="#">Employer</a></li>
			<li><a href="#">Our Career</a></li>
			<li><a href="#">About Us</a></li>
			<li><a href="#">Help</a></li>
			<li class="last"><a href="#">Register</a></li>
		</ul>
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
		<div class="listingBlock">
			<p><h2><br />Search results for <?php echo $_POST["jobTitle"]?> positions in or near <?php echo $_POST["zipcode"]?> Zipcode</h2></p>
			<p><br />Thank you for using our site today to search for <?php echo $_POST["jobTitle"]?> jobs.  The results of the search can be seen on the right.  Just click the link to find out more and apply!</p>
			<p><br />If there is nothing suitable then we have thousands of other opportunities that could be of interest, use the links below to seach for other types of jobs in the same local area.</p>
			<p><br />
				<?php
					// 2. Perform database query
					$query = "SELECT * FROM states";
					$result = mysqli_query($connection, $query);
					// Test if there was a query error
					//echo $query;
					
					if(!$result) {
						die("Database query failed. ");	
					}
					
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_ASSOC($result)) {
						// Output data from each row
						//echo "<p style=\"font-size:16px;\"><a href=\"http://www.clericaljobs.us.com/jobs-by-position.php?ID=" . $row["ID"] . "\">" .
							// $row["Title"] . 
							// " jobs near " . 
							// $_POST["zipcode"] .
							// "</a></p>";	
							
							echo "<a href=\"clerical-jobs-by-county.php?state=". $row["Abbreviation"]. "\">" . $row["State"] . " (". $row["Abbreviation"] . ")</a>" . "        ";
					}
					
					
				?>
			
			</p>
		</div>
		<div class="listingBlock">
			
			<?php
				$jobTitle = $_POST["jobTitle"];
				$zipcode = $_POST["zipcode"];
				
			   // echo $jobTitle;
			   // echo $zipcode;
			   
			   $url = "http://api.indeed.com/ads/apisearch?publisher=8134512135661512&q=";
			   $parameters = rawurlencode($jobTitle) . 
					  "&l=" . $zipcode . "&sort=&radius=&st=&jt=&start=&limit=&fromage=&filter=" .
					  "&latlong=1&co=us&chnl=clericaljobs&userip=" .
					  $_SERVER["REMOTE_ADDR"] . "&useragent=" .
					  rawurlencode($_SERVER['HTTP_USER_AGENT']) . "&v=2";
					  
			   $finalURL = $url . $parameters;
			   
			   // echo $finalURL;
			   echo "<br /><br />";
					  
			   $xml=simplexml_load_file($finalURL) or die("Error: Cannot create object");
			   
			   foreach ($xml->results->result as $result){
			   
			   		echo "<b style=\"font-size:18px;\">" . $result->jobtitle . "</b><br />";
					echo "<b>Company: </b>" . $result->company . ", " . $result->formattedLocation . "<br />";
					echo "<b>Posted:</b> " . $result->formattedRelativeTime . "<br /><br />";
					echo "<i style=\"font-size:12px;\">" . $result->snippet . "</i><br /><br />";
					echo "<p style=\"text-align:right; font-size:16px;\"><a href=\"" . $result->url . "\"><img src=\"images/Apply-Button.jpg\" alt=\"\" width=\"105\" height=\"27\" /></a></p>";
					echo "<br /><hr><br />";
			   
			   }
			   // print_r($xml);
			?>
			
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