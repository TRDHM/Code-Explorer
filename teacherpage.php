<?php
session_start();
$u = $_SESSION['username'];

$con = new mysqli ("localhost", "root", "RbexTSE2zqdSL9", "Code Explorer");
$q2 = "SELECT ID FROM User WHERE Name='$u'";
if ($result = mysqli_query($con,$q2)){
	$getRow = mysqli_fetch_row($result);
	echo "Your Teacher ID (Have students enter this on their page):	";
	$tID = $getRow[0];
	echo $tID;	
}

?>

<html>
<head>
<link rel='stylesheet' href='main.css'>

</head>

<body>
<div>
<?php
echo "<h1>Welcome ".$_SESSION['username']."</h1><br><br>";
echo "<h3>Your Students</h3>";

$query = $con -> query ("SELECT * FROM User WHERE TeacherID=".$tID."");
if($query) {
	while($row = $query->fetch_assoc()){
		echo "Name: ".$row['FirstName']." ".$row['LastName']."<br> Score: ".$row['Score']."<br><br>";
	}
}

if(isset($_GET["action"])){

	if($_GET["action"]){
		session_unset();
		session_destroy();
		header("location: index.php");
	}
}	


?>
<a href='teacherpage.php?action=logout'>Logout</a>
<a href='index.php'>Home</a>

</div>
</body>
</html>
