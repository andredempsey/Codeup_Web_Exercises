<?
//include the AddressDataStore class to read and write to/from address book CSV files
require_once('classes/address_data_store.php');
$errorMessage='';
$addressBook=[];
$address = new AddressDataStore('address_book.csv');
$addressBook=$address->read();

function removeTags($addedEntry)
{
	foreach ($addedEntry as $key=>$entry) 
	{
		$addedEntry[$key]=htmlspecialchars((strip_tags($entry)));
	}
	return $addedEntry;
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
		$address->write($addressBook);
		$_POST=[];
	}
}
if (isset($_GET['delete']) && $_GET['delete']!="")
{
	unset($addressBook[$_GET['delete']]);
	$address->write($addressBook);
	header('Location: /address_book.php');
	exit;
}

if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) 
{
    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/codeup.dev/public/uploads/';
    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
	// Check if we saved a file
	if ($_FILES['file1']['type']!='text/csv') //incorrect file type
	{
		$errorMessage = "<p><strong>The file type cannot be processed.  Please try again with a CSV file.</strong></p>";
	} 
	else
	{
		// retrieve uploaded file contents
		$addressUpload = new AddressDataStore($savedFilename);
		$newList = $addressUpload->read();
		$addressBook = array_merge($addressBook,$newList);
		//append file contents to current todo list
		$address->write($addressBook);
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
	<form method="GET" action="/address_book.php">
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
	<form method="POST" action="/address_book.php">
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
	<h3>Upload File</h3>
	<form method="POST" enctype="multipart/form-data" action="/address_book.php">
	    <p>
	        <label for="file1">File to upload: </label>
	        <input type="file" id="file1" name="file1">
	    </p>
	    <p>
	        <input type="submit" value="Upload">
	    </p>
	</form>
	<font color="DC143C"><?= $errorMessage;?></font>
	&copy; Andre 2014
</body>
</html>