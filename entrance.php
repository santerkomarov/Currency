<?php

require 'php/connect.php';
session_start();
$_SESSION['permission'] = "wrong";
if(!$connect) {
	die('Error to connect to DB'. mysqli_connect_error());
} 

$error = "";// errors
$pass = $_POST["pass"];
$user = $_POST["user"];

// Filter
$pass = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$user = filter_var($user, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

if (isset($_POST['pass']) && isset($_POST['user'])) {
	
	if ($pass != "" && $user != "") {
		$result = mysqli_query($connect, "SELECT * FROM `access`");
		$result = mysqli_fetch_all($result);
		foreach ($result as $key => $item) {
			if ($user == $item[1] && $pass == $item[2]) {
			    // set session to open currency.php
				$_SESSION['permission'] = "allowed";
				header("Location: currencies.php");
			} else {
				$error = "Wrong login or password!";
			}
		}
	}
	// check inputs value
	$pass == "" ? $error = "Empty password!" : "";
	$user == "" ? $error = "Empty login!" : "";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>World currencies</title>
	<link rel="icon" type="image/png" href="images/coins.png" />
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	
	<h1>World currencies</h1>
	<h2>&#36; &#163; &#165; &#8355; &#8356; &#128; &#8369; &#8361;</h2>
	<h4> Authorization</h4>
	<form action="entrance.php" class="logs" method="POST">
		<input type="text" placeholder="login" maxlength="40" name="user" />
		<input type="password" placeholder="password" maxlength="40" name="pass"  />
		<button type="submit" name="button">Log in</button>
		<p id="error"><?php echo $error ?></p>
	</form>
	<div class="login-password">
	   <span>login: <b>Boss</b>, password: <b>MainAdmin</b></span>
	</div>
	
</body>
</html>

<?php
