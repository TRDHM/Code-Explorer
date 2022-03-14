<?php
  $conn = new mysqli("localhost", "root", "RbexTSE2zqdSL9", "Code Explorer");

?>
<html>
<head>
  <link rel="stylesheet" href="page2.css">
</head>
<body>

	<h1>Enter data for new map location</h1>
<div id='wrapper'>
	<form method="post" action".">
		<h2> Name: </h2> <br>
		<input type="text" name="name" required><br>		

		<h2> Address: </h2> <br>
		<input type="text" name="location" required><br>
		<input type="submit" name = "Submit" value="Submit">
</form>

<?php
$Password = 'Mercer#1';
if(isset($_POST['Submit'])){
	$address = $_POST['location'];
	$name = $_POST['name'];
	$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key=AIzaSyAn5EKHaL8Jn_ImbLo0D81jeaTqjMupy7w');
	$output = json_decode($geocode, true);
	print_r($output);
//	if (isset($output['status']) && ($output['status'] == 'OK')){
	$lat = $output['results'][0]['geometry']['location']['lng'];
	$lon = $output['results'][0]['geometry']['location']['lng'];


	$sql = "INSERT INTO School (Name, TotalScore, lat, lon)
	VALUES ('$name','0','$lat', '$lon')";

	if($conn->query($sql) === TRUE){
		//header("Location: index.php");
	}
//	else {
//		echo $conn->error;
//	}
 // }

  else {
	  echo "Something Wrong With That Address, Sorry";
	
  }
	

}
?>


<a href="index.php"><h2>Click Here To Go Back To The Map</a>
</div>
</body>
</html>
