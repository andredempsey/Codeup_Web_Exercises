<?php

// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', 'andre', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$numRecords = 4;
$offsetValue = 0;
$pageNumber= 1;

if (isset($_GET['Page']))
{
	if (isset($_GET['Nav']))
	{
		if ($_GET['Nav'] == 'Next')
		{	
			$pageNumber = $_GET['Page'] + 1;
			$offsetValue = $numRecords * $pageNumber - $numRecords;
		}
		else
		{
			$pageNumber = ($_GET['Page']>1)?$_GET['Page'] - 1:1;
			$offsetValue = $numRecords * $pageNumber - $numRecords;
		}
	}
	else
	{
		$pageNumber = $_GET['Page'];
		$offsetValue = $numRecords * $pageNumber - $numRecords;
	}
}

$query = "SELECT * FROM national_parks LIMIT :numRecs OFFSET :offsetVal";

$stmt = $dbc->prepare($query);

$stmt->bindValue(':numRecs', $numRecords, PDO::PARAM_INT);
$stmt->bindValue(':offsetVal', $offsetValue, PDO::PARAM_INT);
$stmt->execute();

$parks = $stmt->fetchAll(PDO::FETCH_NUM);

$results = $stmt->rowCount();
$totalPages = ($dbc->query('SELECT * FROM national_parks')->rowCount()/$numRecords);

if ($results == 0) 
{
	$pageNumber = $_GET['Page'];
	$offsetValue = $numRecords * $pageNumber - $numRecords;
	$query = "SELECT * FROM national_parks LIMIT :numRecs OFFSET :offsetVal";
	$stmt = $dbc->prepare($query);
	$stmt->bindValue(':numRecs', $numRecords, PDO::PARAM_INT);
	$stmt->bindValue(':offsetVal', $offsetValue, PDO::PARAM_INT);
	$stmt->execute();
	$parks = $stmt->fetchAll(PDO::FETCH_NUM);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>National Parks</title>
	<link href="/css/bootstrap.css" rel="stylesheet">
</head>
<body>
	<h1 style="text-align: center">National Parks</h1>
	<div class = "container">
		<table class = "table table-striped" border = "1">
	    <tr>
	        <th>id</th>
	        <th>Name</th>
	        <th>Location</th>
	        <th>Date Established</th>
	        <th>Size (Acres)</th>
	        <th>Description</th>
	    </tr>
		<?foreach ($parks as $park) :?>
		<tr>
			<?foreach ($park as $attrib =>$value) :?>
				<td><?=$value;?></td>
			<?endforeach;?>
		</tr>
		<?endforeach;?>
	</table>
	<form method="GET" action="/national_parks.php">
		<div style ="text-align: center"><ul class="pagination">
		  <li><a href="national_parks.php?Nav=Prev&Page=<?=$pageNumber?>">&laquo;</a></li>
		  	<?for ($i = 1; $i <= ceil($totalPages); $i++) : ?>
		  	<li><a href="national_parks.php?Page=<?=$i?>"><?=$i?></a></li>
			<?endfor;?>
		  <li><a href="national_parks.php?Nav=Next&Page=<?=$pageNumber?>">&raquo;</a></li>
		</ul>
		</div>
	</form>
	<p style="text-align: center">You are viewing <?=$results?> of <?=$totalPages*$numRecords?> total results.</p>
	</div>
</body>
</html>