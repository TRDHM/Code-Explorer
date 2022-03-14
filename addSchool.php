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

		<h2> Latitude: </h2> <br>
		<input type="text" name="lat" required><br>

		<h2> Longitude: </h2><br>
		<input type="text" name="lon" required><br>
		<input type="submit" name = "Submit" value="Submit">
</form>

<?php
$Password = 'Mercer#1';
if(isset($_POST['Submit'])){
	
	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
	$name = $_POST['name'];



	$sql = "INSERT INTO School (Name, TotalScore, lat, lon)
	VALUES ('$name','0','$lat', '$lon')";

	if($conn->query($sql) === TRUE){
		header("Location: index.php");
	}
	else {
		echo $conn->error;
	}

	

}
?>


<a href="index.php"><h2>Click Here To Go Back To The Map</a>
</div>
</body>
</html>
