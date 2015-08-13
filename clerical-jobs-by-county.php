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
	
	$state = "California";
	
	$stateQuery = "SELECT State FROM states WHERE Abbreviation ='" . $_GET["state"] . "'";
	//echo $query;
	$stateResult = mysqli_query($connection, $stateQuery);
	
	while($stateRow = mysqli_fetch_ASSOC($stateResult)) {
		$state = $stateRow["State"];
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
		
		<div >
			
			<?php
				$jobTitle = "Clerical";
				
				
			   // echo $jobTitle;
			   // echo $zipcode;
			   
			   $url = "http://api.indeed.com/ads/apisearch?publisher=8134512135661512&q=";
			   $parameters = rawurlencode($jobTitle) . 
					  "&l=" . $state . "&sort=&radius=&st=&jt=&start=&limit=&fromage=&filter=" .
					  "&latlong=1&co=us&chnl=clericaljobs&userip=" .
					  $_SERVER["REMOTE_ADDR"] . "&useragent=" .
					  rawurlencode($_SERVER['HTTP_USER_AGENT']) . "&v=2";
					  
			   $finalURL = $url . $parameters;
			   
			   // echo $finalURL;
			   echo "<br /><br />";
					  
			   $xml=simplexml_load_file($finalURL) or die("Error: Cannot create object");
			   
			   foreach ($xml->results->result as $result){
			   		
				    echo "<div class=\"job_listing_block\" style=\" height:200px; border:1px solid black; width:49%; position: relative;\">";
			   		echo "<br /><b style=\"font-size:18px;\">" . $result->jobtitle . "</b><br />";
					echo "<p><b>Company: </b>" . $result->company . ", " . $result->formattedLocation . "<p>";
					echo "<p><b>Posted:</b> " . $result->formattedRelativeTime . "</p>";
					echo "<p><br /><br /><i style=\"font-size:14px;\">" . $result->snippet . "</i></p>";
					
					echo "<div style=\"position: absolute; right:0; bottom:0;><a href=\"" . $result->url . "\"><img src=\"images/Apply-Button.jpg\" alt=\"\" style=\"float:right; margin:0px 10px 10px 0px;\" /></a></div>";
					echo "</div>";
					
			   
			   }
			   // print_r($xml);
			?>
			
		</div>
		
		<div class="listingBlock">
			<p><h2><br />The latest Clerical jobs in <?php echo $state ?> State.</h2></p>
			<p><br />The most recent Clerical jobs in <?php echo $state ?> State are listed to the right.  </p>
			<p><br />Clerical jobs are available all across <?php echo $state ?> in a range or different sized organizations.  From startup to Blue Chip, Government to Charities and more.  to make your clerical job search faster and easier, all open positions are listed by county and job. Simply navigate to the county in <?php echo $state ?> where you want to work and then click on your speciality.</p>
			<p><br />
				<?php
					// 2. Perform database query
					$query = "SELECT DISTINCT county FROM citycountystate WHERE state ='" . $_GET["state"] . "' ORDER BY county";
					//echo $query;
					$result = mysqli_query($connection, $query);
					// Test if there was a query error
					//echo $query;
					
					if(!$result) {
						die("Database query failed. ");	
					}
					
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_ASSOC($result)) {
					
							
							echo "<div class=\"job_page_container\" style=\"font-size:16px; height:30px; width:50%;\"><a href=\"clerical-jobs-by-county.php?state=". $row["county"]. "\">" . $row["county"] . "</a></div>";
					}	
				?>			
			</p>
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