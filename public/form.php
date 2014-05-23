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
    <h2 id="login">User Login</h2>
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
    <hr>
    <h2>Compose an Email</h2>
    <form method="POST">
        <p>
            <label for="recipient">To:</label>
            <input id="recipient" name="recipient" type="email" placeholder="Enter Recipient Email">
        </p>
        <p>
            <label for="sender">From:</label>
            <input  id="sender" name="sender" type="text" placeholder="Enter Sender Email">
        </p>
        <p>
            <label for="subject">Subject:</label>
            <input id="subject" name="subject" type="text" placeholder="Message Subject">
        </p>
        <p>
            <label for="body">Message</label>
            <textarea id="body" name="body" cols="60" rows="15" placeholder = "Enter message here"></textarea>
        <p>
            <input type="submit" name="submit" value="Send">
        </p>

        </p>
    </form>
</body>
</html>