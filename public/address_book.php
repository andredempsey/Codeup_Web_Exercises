<?
$filename = 'address_book.csv';
$addressBook =[];
$errorMessage='';

$addressBook = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
];
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
		$addressBook[]=addAddress($filename, $_POST);
		$_POST=[];
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
	<table border =1">
		    <tr>
		        <th>Name</th>
		        <th>Street</th>
		        <th>City</th>
		        <th>State</th>
				<th>Zip Code</th>
				<th>Phone</th>
		    </tr>
		    <?foreach ($addressBook as $entry => $address): ?>	
		    <tr>
		    	<? if (empty($address)) :?>
		    			<?continue;?>
		    	<?endif;?>
				<? foreach ($address as $element=>$item): ?>
		        <td><?=$item;?></td>
				 <?endforeach; ?>
 		    </tr>
		    <? endforeach; ?>
	</table>
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