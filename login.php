<?php
$con = new mysqli('localhost', 'root', 'RbexTSE2zqdSL9', 'Code Explorer');
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	if($_SESSION["acctType"] == "Teacher"){
		header("location: teacherpage.php");
	}
	else if($_SESSION["acctType"] == "Student"){
		header("location: studentpage.php");
	}
}

require_once "config.php";

$username  = $password = "";
$username_error = $password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST["username"]))){
		$username_error = "Please enter username";
	}else {
		$username = trim($_POST["username"]);
	}

	if(empty(trim($_POST["password"]))){
		$password_error = "Please enter your password";
	}else {
		$password = trim($_POST["password"]);
	}

	if(empty($username_error) && empty($password_error)){
		$sql = "SELECT * FROM User WHERE Name = :username";

		if($stmt = $pdo->prepare($sql)){
			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
			$param_username = trim($_POST["username"]);

			if($stmt->execute()){
				if($row = $stmt->fetch()){
					if($stmt->rowCount() == 1){
						$username = $row["Name"];
						$school = $row["School"];
						$retrievedPassword = $row["Password"];
						$acctType = $row["Role"];
						$_SESSION["tID"] = $row["ID"];

						if(password_verify($password, $retrievedPassword)){

							$_SESSION["loggedin"] = true;
							$_SESSION["username"] = $username;
							$_SESSION["acctType"] = $acctType;
							$_SESSION["school"] = $school;
							

							echo $acctType;

							if($acctType == "Teacher"){
								header("location: teacherpage.php");
							}

							if ($acctType == "Student"){
								header("location: studentpage.php");
							}
						}else{
							$password_err = "The password you entered was incorrect";
						}
					}
					else {
						echo "Oops! wrong username";
					}	
				

				}
			}
	

		}
	}
		unset($pdo);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<style type="text/css">
		body{ font: 14px sans-serif; }
		.wrapper{ width: 350px; padding 20px;}
	</style>
</head>
<body>
	<div class="wrapper">
	<h2>Login</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : '';?>">
		<label>Username</label>
		<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
		<span class="help-block"><?php echo $username_error;?></span>
	</div>

	<div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
		<label>Password</label>
		<input type="password" name="password" class="form-control">
		<span class="help-block"><?php echo $password_error;?></span>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Login">
	</div>
	<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
	</form>
</div>
</body>
</html>
