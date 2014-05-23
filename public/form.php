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
    <hr>
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
            <textarea id="body" name="body" cols="60" rows="15" placeholder = "Enter message here"></textarea>
        <p>
            <input type="checkbox" name="copy" id="savecopy" value="yes">
            <label for="savecopy">Save copy of message?</label>
        </p>
        <p>
            <input type="submit" name="submit" value="Send">
        </p>
    </form>
    <hr>
    <h2>Multiple Choice Test</h2>
    <form method="POST">
        <p>What is the capital of Texas?</p>
            <label for="q1r1">
                <input type="radio" id="q1r1" name="q1_response" value="Houston">
                Houston
            </label>
            <label for="q1r2">
                <input type="radio" id="q1r2" name="q1_response" value="San Antonio">
                San Antonio
            </label>
            <label for="q1r3">
                <input type="radio" id="q1r3" name="q1_response" value="Dallas">
                Dallas
            </label>
            <label for="q1r4">
                <input type="radio" id="q1r4" name="q1_response" value="Austin">
                Austin
            </label>
        <p>What is the capital of Tennessee?</p>
            <label for="q2r1">
                <input type="radio" id="q2r1" name="q2_response" value="Nashville">
                Nashville
            </label>
            <label for="q2r2">
                <input type="radio" id="q2r2" name="q2_response" value="Memphis">
                Memphis
            </label>
            <label for="q2r3">
                <input type="radio" id="q2r3" name="q2_response" value="Chattanooga">
                Chattanooga
            </label>
            <label for="q2r4">
                <input type="radio" id="q2r4" name="q2_response" value="Knoxville">
                Knoxville
            </label>
        <p>How is the weather today?</p>
            <label for="q3r1">Sunny</label>
            <input type="checkbox" id="q3r1" name="q3_response[]" value="Sunny">
            <label for="q3r2">Rainy</label>
            <input type="checkbox" id="q3r2" name="q3_response[]" value="Rainy">
            <label for="q3r3">Cloudy</label>
            <input type="checkbox" id="q3r3" name="q3_response[]" value="Cloudy">
            <label for="q3r4">Snowy</label>
            <input type="checkbox" id="q3r4" name="q3_response[]" value="Snowy">
        <br>
        <label for="mscontrol">What are your favorite fruits?</label>
        <select name="multiselect[]" id="mscontrol" multiple>
                  <option value="A">Apple</option>
                  <option value="B">Banana</option>
                  <option value="O">Orange</option>
                  <option value="K">Kiwi</option>
              </select>      
        <p>
            <input type="submit" value="Am I right?">
        </p>
    </form>
    <hr>
    <h2>Select Testing</h2>
    <form method="POST">
        <label for="yesno">Do you understand select elements?</label>
        <select name="yesnoquestion" id="yesno">
            <option value="1"selected>Yes</option>
            <option value="0" >No</option>
        </select>
        <p>
            <input type="submit" value="Submit Response">
        </p>
    </form>
</body>
</html>