<?php
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('location:../client/index.php');	
    } 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<div class="container">
		<h1>PASI</h1>
		<form method="POST" action="../client/server.php">
			<input type="text" name="userN" placeholder="Username" required>
			<input type="password" name="userP" placeholder="Password" required>
			<input type="submit" value="Login">
		</form>
		<p class="error-message"><?php echo isset( $_SESSION['login_error']) ?  $_SESSION['login_error'] : ''; ?></p>
		<p class="create-account">Don't have an account? <a href="#">Create one</a></p>
	</div>
	
</body>
</html>
