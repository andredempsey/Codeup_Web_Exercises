<?
$filename = 'address_book.csv';
$addressBook =[];
$errorMessage='';
function addAddress($filename, $addressBook)
{
	$handle = fopen($filename, 'w');
	foreach ($addressBook as $key=>$entry) 
	{
		$addressBook[$key]=htmlspecialchars(strip_tags($entry));
	}
	fputcsv($handle, $addressBook);
	fclose($handle);
	return $addressBook;
}
function checkFields($addressEntries, &$errorMessage)
{
	$missingValues=false;
	foreach ($addressEntries as $key=>$entry) 
	{
		if (empty($entry)&&$key!='Phone')
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
		$addressBook=addAddress($filename, $_POST);
	}
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
	<table>
		    <tr>
		        <th>Name</th>
		        <th>Street</th>
		        <th>City</th>
		        <th>State</th>
				<th>Zip Code</th>
				<th>Phone</th>
		    </tr>
		    <tr>
				<? foreach ($addressBook as $element=>$item) :?>
		        <td><?=$item;?></td>
				 <?endforeach; ?>
 		    </tr>
	</table>
<hr>
	<form method="POST">
		<p>
            <label for="Name">Name:</label>
            <input id="Name" name="Name" type="text" placeholder="Enter Name">
            <label for="Address">Street Address:</label>
            <input  id="Address" name="Street Address" type="text" placeholder="Enter Street Address">
            <label for="addressCity">City:</label>
            <input  id="addressCity" name="City" type="text" placeholder="Enter City">
            <label for="addressState">State:</label>
            <input  id="addressState" name="State" type="text" placeholder="Enter State">
            <label for="addressZip">Zip Code:</label>
            <input  id="addressZip" name="Zip" type="text" placeholder="Enter Zip Code">
            <label for="addressPhone">Phone Number:</label>
            <input  id="addressPhone" name="Phone" type="text" placeholder="Enter Phone Number">
		</p>
	<input type="submit" value="Add Address">
	</form>
	<?= $errorMessage;?>
</body>
</html>