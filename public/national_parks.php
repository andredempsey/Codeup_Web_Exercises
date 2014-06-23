<?php


// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', 'andre', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$query = "SELECT * FROM national_parks";

$stmt = $dbc->query($query);
$parks = $stmt->fetchAll(PDO::FETCH_NUM);
$results = $stmt->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>National Parks</title>
</head>
<body>
	<p>Total number of results: <?=$results?></p>
	<table border =1">
	    <tr>
	        <th>id</th>
	        <th>Name</th>
	        <th>Location</th>
	        <th>Date</th>
	        <th>Acres</th>
	    </tr>
	<?foreach ($parks as $park) :?>
		<tr>
		<?foreach ($park as $attrib =>$value) :?>
			<td><?=$value;?></td>
		<?endforeach;?>
		</tr>
	<?endforeach;?>
	</table>
</body>
</html>