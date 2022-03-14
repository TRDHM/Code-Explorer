<?php
session_start();
if(isset($_GET["action"])){
	if($_GET["action"]){
		session_unset();
		session_destroy();
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384=TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKIxXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="main.css">	
	<title>Code Explorer</title>
	<h1>Welcome To Code Explorer</h1>
</head>

<body>
<header>
	<div class='navbar'>
		<a href='index.php' class='navLink'>Home</a>
<?php
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
?>
		<div class='dropdown'>
			<button class='dropbtn'><?= $_SESSION['username'] ?>
			<i class='fa fa-caret-down'></i>
			</button>
<?php
			if($_SESSION['acctType']=='Student'){
?>
			<div class='dropdown-content'>
				<a href='studentpage.php' class='navLink'>Profile</a>
				<a href='index.php?action=logout' class='navLink'>Logout</a>
<?php
			}
			if($_SESSION['acctType']=='Teacher'){
?>
				<a href='teacherpage.php' class='navLink'>Profile</a>
				<a href='index.php?action=logout' class='navLink'>Logout</a>
			</div>
		</div>
<?php
			}
	}
	else{
?>
		<a href='login.php' class='navLink'>Login</a>
		<a href='register.php' class='navLink'>Create Account</a>
<?php
	}
?>
	
	</div>
</header>
<div id="googleMap" style="width:100%;height:400px;"></div>
<script>
      function newMap() {
            var mapProp = {
              center: new google.maps.LatLng(32.828361, -83.6499611),
              zoom: 7,
              };
              var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
	<?php
		    $conn = new mysqli("localhost", "root", "RbexTSE2zqdSL9", "Code Explorer");
                    $query = $conn->query("SELECT * FROM School");
                    if($query) {
                          while($row = $query->fetch_assoc()){
                                echo "var point".$row['ID']." = new google.maps.Marker({position: new google.maps.LatLng(".$row['lat'].",".$row['lon'].")});\n";
                                echo "point".$row['ID'].".setMap(map);\n";
                                echo "var info".$row['ID']." = new google.maps.InfoWindow({content: '".htmlentities($row['Name'],ENT_QUOTES).": ".$row['TotalScore']."'});\n";
                                echo "point".$row['ID'].".addListener('click', function() { info".$row['ID'].".open(map,point".$row['ID'].");});\n";
                                                                              }
                                                                          }
?>
      }
</script>
		    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAn5EKHaL8Jn_ImbLo0D81jeaTqjMupy7w&callback=newMap"></script>
<a href="addSchool.php">Don't See Your School? Add It!</a><br>
<a href="login.php">Login</a><br>
<a href='register.php'>Create An Account</a>
<div id="scoreboard">
<h2>Current Leading Schools</h2>
	<ul>	
<?php
	$query2 = $conn->query("SELECT * FROM School ORDER BY TotalScore Desc");
	while($row = $query2->fetch_assoc()){
		$school = $row['Name'];
		$totalScore = $row['TotalScore']; 
?>
	<li><?= $school ?>: <?= $totalScore?></li>

<?php
	}
?>
	</ul>
</div>



</body>
</html>
