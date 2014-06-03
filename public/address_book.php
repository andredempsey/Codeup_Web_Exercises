<?
$filename = 'address_book.csv';
$errorMessage='';
$addressBook=[];
$addressBook=getAddress($filename, $addressBook);
function getAddress($filename, $addressBook)
{
	$handle = fopen($filename, 'r');
	while(!feof($handle)) 
	{
		$row=fgetcsv($handle);  	
		if (is_array($row)) 
		{
			$addressBook[] = $row;
		}
	}
	fclose($handle);
	return $addressBook;
	}

function removeTags($addedEntry)
{
	foreach ($addedEntry as $key=>$entry) 
	{
		$addedEntry[$key]=htmlspecialchars(strip_tags($entry));
	}
	return $addedEntry;
}
function addAddress($filename, $addressBook)
{
	$handle = fopen($filename, 'w');
	foreach ($addressBook as $key=>$entry) 
	{
		fputcsv($handle, $entry);
	}
	fclose($handle);
	return $addressBook;
}

function checkFields($addressEntries, &$errorMessage)
{
	$missingValues=false;
	foreach ($addressEntries as $key=>$entry) 
	{
		if (empty($entry) && $key!='Phone')
		{
			$errorMessage .= "Please enter a value for the $key field.\n<br>";
			$missingValues = true;
		}		
	}
	return $missingValues;
}
if (!empty($_POST)) 
{
	if (!checkFields($_POST,$errorMessage)) 
	{
		$cleanInput = removeTags($_POST);
		array_push($addressBook,$cleanInput);
		$addressBook = addAddress($filename, $addressBook);
		$_POST=[];
	}
}
if (isset($_GET['delete']) && $_GET['delete']!="")
{
	unset($addressBook[$_GET['delete']]);
	$addressBook=addAddress($filename, $addressBook);
	header('Location: /address_book.php');
	exit;
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Address Book</title>
</head>
<body>
	<h1>Address Book</h1>
	<hr>
	<form method="GET" action="address_book.php">
	<table border =1">
		    <tr>
		        <th>Action</th>
		        <th>Name</th>
		        <th>Street</th>
		        <th>City</th>
		        <th>State</th>
				<th>Zip Code</th>
				<th>Phone</th>
		    </tr>
		    <?foreach ($addressBook as $entry => $address): ?>	
		    <tr>
				<td><button id='delete' name = 'delete' value = <?=$entry?>>Delete</button></td>
				<? foreach ($address as $element=>$item): ?>
		        <td><?=$item;?></td>
				 <?endforeach; ?>
 		    </tr>
		    <? endforeach; ?>
	</table>
	</form>
<hr>
	<form method="POST">
		<p>
            <label for="Name">Name:</label>
            <input id="Name" name="Name" type="text" value=<?=(!empty($_POST) && $_POST['Name']!='')?$_POST['Name']:'' ?> >
            <label for="Address">Street Address:</label>
            <input  id="Address" name="Street" type="text" value=<?=(!empty($_POST) && $_POST['Street']!='')?$_POST['Street']:'' ?> >
            <label for="addressCity">City:</label>
            <input  id="addressCity" name="City" type="text" value=<?=(!empty($_POST) && $_POST['City']!='')?$_POST['City']:'' ?> >
            <label for="addressState">State:</label>
            <input  id="addressState" name="State" type="text" value=<?=(!empty($_POST) && $_POST['State']!='')?$_POST['State']:'' ?> >
            <label for="addressZip">Zip Code:</label>
            <input  id="addressZip" name="Zip" type="text" value=<?=(!empty($_POST) && $_POST['Zip']!='')?$_POST['Zip']:'' ?> >
            <label for="addressPhone">Phone Number:</label>
            <input  id="addressPhone" name="Phone" type="text" placeholder="Optional">
		</p>
	<input type="submit" value="Add Address">
	</form>
	<font color="DC143C"><?= $errorMessage;?></font>
</body>
</html>