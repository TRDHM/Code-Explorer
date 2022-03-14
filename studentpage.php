<?php
$con = new mysqli ("localhost", "root", "RbexTSE2zqdSL9", "Code Explorer");
$query = $con ->query ("SELECT * FROM scoreTrack");
$q2 = $con->query("SELECT * FROM scoreTrack");
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="main.css">

</head>

<body>
<header>
<a href='index.php'>Home</a>
</header

<div>
<?php
$uname = $_SESSION["username"];
$school =  $_SESSION["school"];
?>
	<h1>Welcome <?= $uname ?> from <?= $school ?></h1><br><br>
	<a href='index.php?action=logout'>Logout</a>
</div>
<div id='Challenges'>
	<h2>Challenges</h2>
	<form method='post' action=''>
	<input type='submit' value='Complete Selected' name='but_comp'>
	<table id="allChallenges" style="width:50%; float: left;">
	<tr>
		<th>Challenge</th>
		<th>Value</th>
		<th>Completed</th>
	</tr>
<?php
$newScore = 0;
if($query){

	while($row = $query->fetch_assoc()){
		$chalNum = $row['CNum'];
		$url = $row['URL'];
		$chalName = $row['CName'];
		$value = $row['Value']
?>
	<tr id='tr_<?= $chalNum ?>'>
		<td><a href='<?= $url ?>'><?= $chalName ?></a></td>
		<td><?= $value ?></td>
		<td><input type='checkbox' name='comp[]' value='<?= $chalNum ?>'></td>
	</tr>
<?php	
	}	
}
?>
	</table>
	</form>
<?php
if(isset($_POST['but_comp'])){
	if(isset($_POST['comp'])){
		foreach($_POST['comp'] as $compid){
			$getChallenge = "SELECT * FROM scoreTrack WHERE CNum = $compid";
			$result = mysqli_query($con,$getChallenge);
				while($row2 = mysqli_fetch_array($result)){
					$cname = $row2['CName'];
					$cvalue = $row2['Value'];
				}
			$completeChallenge = "INSERT INTO ".$uname."scoreTrack (Value, CName) VALUES ('$cvalue','$cname')";
			mysqli_query($con,$completeChallenge);
		}
	}
	$_POST = array();
	echo "<meta http-equiv='refresh' content=0>";
}

?>
<table id='completedChallenges' style="width:50%; float: left;">
	<tr>
		<th>Challenge</th>
		<th>Value</th>
	</tr>
<?php
$query2 = "SELECT * FROM ".$uname."scoreTrack";
$result2 = mysqli_query($con,$query2);
$totalValue = 0;
while($row3 = mysqli_fetch_array($result2)){
	$completedNum = $row3['CNum'];
	$completedChallenge = $row3['CName'];
	$completedValue = $row3['Value'];
	$totalValue = $totalValue + $completedValue;
?>
	<tr id='comp_<?= $completedNum ?>'>
		<td><?= $completedChallenge ?></td>
		<td><?= $completedValue ?></td>
	</tr>
<?php
}
$query3 = "UPDATE `User` SET Score = $totalValue WHERE Name = '$uname'";
mysqli_query($con,$query3);
?>
	<tr id='totalValue'>
		<td>Total</td>
		<td><?= $totalValue ?></td>
	</tr>
</table>
</div>
<div>
<h2>Enter Teacher ID Here (if required for class)</h2>
<form method = 'post' action=''>
<input type="text" name="updateTeacher">
<input type="submit" value="Submit" name="submit2">
</form>



<?php
if(isset($_POST['submit2'])){
		$TID = $_POST['updateTeacher'];
		$updateTID = "UPDATE `User` SET TeacherID = '$TID' WHERE Name = '$uname'";
		mysqli_query($con, $updateTID);
}

if(isset($_GET["action"])){

	if($_GET["action"]){
		session_unset();
		session_destroy();
	}
}	
?>
</div>

</body>
</html>

