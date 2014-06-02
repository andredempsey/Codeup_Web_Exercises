<?

//sample data
$address_book = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
];

$handle = fopen('address_book.csv', 'w');

foreach ($address_book as $fields) {
    fputcsv($handle, $fields);
}

fclose($handle);
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
		    </tr>
			<? foreach ($address_book as $key=>$address) :?>
		    <tr>
				<? foreach ($address as $element=>$item) :?>
		        <td><?=$item;?></td>
				 <?endforeach; ?>
 		    </tr>
			<?endforeach; ?>
	</table>
<hr>
	<form method="POST">
        <p>
            <label for="addressName">Name:</label>
            <input id="addressName" name="addressName" type="text" placeholder="Enter Name">
            <label for="addressAddress">Street Address:</label>
            <input  id="addressAddress" name="addressAddress" type="text" placeholder="Enter Street Address">
            <label for="addressCity">City:</label>
            <input  id="addressCity" name="addressCity" type="text" placeholder="Enter City">
            <label for="addressState">State:</label>
            <input  id="addressState" name="addressState" type="text" placeholder="Enter State">
            <label for="addressZip">Zip Code:</label>
            <input  id="addressZip" name="addressZip" type="text" placeholder="Enter Zip Code">
     
	<input type="submit" value="Add Address">
	</form>
</body>
<? var_dump($_POST); ?>
</html>