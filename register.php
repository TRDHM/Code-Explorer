<?php
require_once "config.php";
$username = $password = $confirm_password = "";
$username_error = $password_error = $confirm_password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	//validate username
	if(empty(trim($_POST["username"]))){
		$username_error = "Please enter a username";
	}
	else{
		$sql = "SELECT id FROM User WHERE NAME = :username";

		if($stmt = $pdo->prepare($sql)){

			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

			$param_username = trim($_POST["username"]);

			if($stmt->execute()){
				if($stmt->rowCount() == 1){
					$username_err = "This username is already taken";
				} else{
					$username = trim($_POST["username"]);
				}
			}else{
				echo "Something went wrong. Please try again later";
			}

			unset($stmt);

		}

	}

	//Validate password
	if(empty(trim($_POST["password"]))){

		$password_error = "Please enter a password";
	}elseif(strlen(trim($_POST["password"])) < 8){
		$password_error = "Password must have at least 8 characters";
	}else {
		$password = trim($_POST["password"]);
	}

	if(empty(trim($_POST["confirm_password"]))){
		$confirm_password_err = "Please confirm password";

	}else{
		$confirm_password = trim($_POST["confirm_password"]);
		if(empty($password_error) && ($password != $confirm_password)){
			$confirm_password_err = "Passwords do not match";
		}
	}

	if(empty($username_err) && empty($password_err) && empty($confirm_password_error)){
		$con = new mysqli('localhost', 'root', 'RbexTSE2zqdSL9', 'Code Explorer');

		if($_POST['role'] == "Student"){
			$makeNewTable = "CREATE TABLE ".$_POST['username']."scoreTrack (
					CNum INT(5) AUTO_INCREMENT PRIMARY KEY,
					Value INT(4), 
					CName VARCHAR(30))";

			if(!mysqli_query($con, $makeNewTable)){
				echo $con->error();
			}

		}


		$param_password = password_hash($password, PASSWORD_DEFAULT);	//hash password
		$sql = "INSERT INTO User (Name, Password, School, FirstName, LastName, Role) VALUES ('$_POST[username]','$param_password','$_POST[school]','$_POST[firstName]','$_POST[lastName]','$_POST[role]')";
		//$sql2 = "INSERT INTO scoreTrack (Name) VALUES ('$_POST[username]')";
			if(!$con->query($sql)=== TRUE){
				echo "Something went wrong, try again later";
				die(mysql_error());
			}else{
				$con->query(sql2);
				header("location: login.php");
			}
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Teacher Sign Up</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
 <style type="text/css">
	body{ font: 14px sans-serif;}
	.wrapper{ width: 350px; padding: 20px;}
 </style>
</head>
<body>
	<div class="wrapper">
	<h2>Sign Up</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
		<label>Username</label>
		<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
			<span class="help-block"><?php echo $username_error; ?></span>
		</div>
	
		<div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
		<label>Password (Make sure it is more than 8 characters)</label>
		<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
			<span class="help-block"><?php echo $password_error;?></span>
		</div>

		<div class="form-group <?php echo (!empty($confirm_password_error)) ? 'has-error' : ''; ?>">
		<label>Confirm Password</label>
		<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
			<span class="help-block"><?php echo $confirm_password_error; ?></span>
		</div>


		<div class="form-group">
		<label>First Name</label>
		<input type="text" name="firstName" class="form-control">
			<span class="help-block"><?php echo $confirm_password_error; ?></span>
		</div>
		<div class="form-group">
		<label>Last Name</label>
		<input type="text" name="lastName" class="form-control">
			<span class="help-block"><?php echo $confirm_password_error; ?></span>
		</div>

		<div class="form-group">
		<label>Account Type</label>
		<select name="role" class="form-control" value="<?php echo $confirm_password; ?>">
			<option value="Teacher">Teacher</option>
			<option value="Student">Student</option>
		</select>
		</div>

		<div class="form-group">
		<label>School</label>
		<select name="school" class="form-control" id="school">
			<?php
				$getSchools = new mysqli ('localhost', 'root', 'RbexTSE2zqdSL9', 'Code Explorer');
				$schoolQuery = "SELECT * FROM School";
				$schoolNames = $getSchools->query ($schoolQuery);
				while ($row = $schoolNames->fetch_assoc()){
					echo "<option value='".$row['Name']."'>".$row['Name']."</option>";
				}
				echo "</select>";
			?>
		</div>

		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Submit">
			<input type="reset" class="btn btn-default" value="Reset">
		</div>
		<p>Already have an account? <a href="login.php">Login Here</a>.</p>
		</form>
		</div>
</body>
</html>
