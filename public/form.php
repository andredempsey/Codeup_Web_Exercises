<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My First HTML Form</title>
</head>
<body>
	<?php
	var_dump($_GET);
	var_dump($_POST);
	?>
	<form method="POST" action="/form.php">
    <p>
        <label for="username">Username</label>
        <input id="username" name="username" type="text" placeholder="username">
        <!-- alternative formatting -->
        <!-- <label>Username: <input name="username" type ="text"></label> -->
    </p>
    <p>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="password">
    </p>
    <p>
        <!-- <input type="submit" name="submitbutton" value = "Login"> -->
        <button type = "Submit">Login</button>
    </p>
</form>	
</body>
</html>