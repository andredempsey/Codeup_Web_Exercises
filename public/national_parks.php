<?php

// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', 'andre', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$errorMessage='';
$numRecords = 4;
$offsetValue = 0;
$pageNumber= 1;
class InvalidInputException extends Exception {}

//checks if field is blank and updates error message
function checkFields($parkEntries, &$errorMessage)
{
	$missingValues=false;
	foreach ($parkEntries as $key=>$entry) 
	{
		if (empty($entry) && $key != 'Description')
		{
			$errorMessage .= "Please enter a value for the $key field.\n<br>";
			$missingValues = true;
		}		
	}
	return $missingValues;
}
//checks if field has space and throws error
function inputValidation($inputValue, $key)
{

	if (trim($inputValue) == '')
	{
		throw new InvalidInputException($key . ' input cannot be null.');
	}
	else
	{
		return trim($inputValue);
	}
}
//if park was submitted, insert into database using prepare statements
if (!empty($_POST)) 
{
	if (!checkFields($_POST,$errorMessage)) 
	{
		try {
			$stmt = $dbc->prepare('INSERT INTO national_parks (name, location, date_established, area_in_acres, description) VALUES (:name, :location, :date_est, :acres, :desc)');
		    $stmt->bindValue(':name', inputValidation($_POST['Name'],'name'), PDO::PARAM_STR);
		    $stmt->bindValue(':location', inputValidation($_POST['Location'],'location'),  PDO::PARAM_STR);
		    $stmt->bindValue(':date_est', inputValidation($_POST['DateEst'], 'date_est'), PDO::PARAM_STR);
		    $stmt->bindValue(':acres', inputValidation($_POST['Size'], 'acres'), PDO::PARAM_STR);
		    $stmt->bindValue(':desc',  $_POST['Description'],  PDO::PARAM_STR);
		    $stmt->execute();
		 	$errorMessage = "Inserted ID: " . $dbc->lastInsertId();
			$_POST=[];
			
		} 
		catch (Exception $e) 
		{
			$errorMessage=$e->getMessage();
		}
	}
}

//if page was changed, update data set using prepare statements and SQL SELECT query
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

//determine count of records returned
$results = $stmt->rowCount();
//determine total pages for entire data set
$totalPages = ($dbc->query('SELECT * FROM national_parks')->rowCount()/$numRecords);

//if no results from query, do not move to next page
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
	<p style="text-align: center">Page <?=$pageNumber?> of <?=ceil($totalPages)?> pages.</p>
	<p style="text-align: center">You are viewing <?=$results?> of <?=$totalPages*$numRecords?> total results.</p>
	</div>
	<p style="text-align: center"><font color="DC143C"><?= (is_null($errorMessage))?"":$errorMessage; ?></font></p>
	<hr>
	<div class = "container">
		<form method="POST" action="/national_parks.php">
			<p>
	            <label for="Name">Park Name:</label>
	            <input id="Name" name="Name" type="text" value=<?=(!empty($_POST) && $_POST['Name']!='')?$_POST['Name']:'' ?> >
	            <label for="Location">Park Location:</label>
	            <input  id="Location" name="Location" type="text" value=<?=(!empty($_POST) && $_POST['Location']!='')?$_POST['Location']:'' ?> >
	            <label for="DateEst">Date Established:</label>
	            <input  id="DateEst" name="DateEst" type="text" value=<?=(!empty($_POST) && $_POST['DateEst']!='')?$_POST['DateEst']:'' ?> >
	            <label for="Size">Size (Acres):</label>
	            <input  id="Size" name="Size" type="text" value=<?=(!empty($_POST) && $_POST['Size']!='')?$_POST['Size']:'' ?> >
	            <div><label for="Description">Description:</label>
		            <input  id="Description" name="Description" type="text" placeholder="Optional">
	            </div>
			</p>
		<input type="submit" value="Add Park">
		</form>
	</div>
</body>
</html>