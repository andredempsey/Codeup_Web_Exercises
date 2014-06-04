<?
class AddressDataStore 
{
    public $filename = '';

    public function __construct($fname)
    {
    	$this->filename=$fname;
    }
    public function readAddressBook()
    {
    	$addressBook=[];
        // Code to read file $this->filename
    	$handle = fopen($this->filename, 'r');
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

    public function writeAddressBook($addressBook) 
    {
        // Code to write $addresses_array to file $this->filename
		if (is_writable($this->filename)) 
		{	
			$handle = fopen($this->filename, 'w');
			foreach ($addressBook as $key=>$entry) 
			{
				fputcsv($handle, $entry);
			}
			fclose($handle);
		}
		return $addressBook;
    }
}
?>