<?php

class Devshark_Postcodelookup_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
		
		$account = Mage::getStoreConfig('postcodelookup/account/accountname'); // Insert your account name here
		$password = Mage::getStoreConfig('postcodelookup/account/accountpassword'); // Insert your password here
		
		$URL = "http://ws1.postcodesoftware.co.uk/lookup.asmx/getAddress?account=" . $account . "&password=" . $password . "&postcode=" . $this->getRequest()->getParam('postcode');
			
		$xml = simplexml_load_file(str_replace(' ','', $URL)); // Removes unnecessary spaces
		
		if ($xml->ErrorNumber <> 0) // If an error has occured show message
		{
			print "<span style='color:red;'>" . $xml->ErrorMessage . "</span>";
		}
		else
		{
			
			if ($xml->Address2 != "")
			{
				if ($xml->Address3 != "")
				{
					if ($xml->Address4 != "")
						{ $AddressLine1 = $xml->Address1 . ", " . $xml->Address2; $AddressLine2 = $xml->Address3 . ", " . $xml->Address4; }	
					else
						{ $AddressLine1 = $xml->Address1; $AddressLine2 = $xml->Address2 . ", " . $xml->Address3; }
				}
				else
				{ $AddressLine1 = $xml->Address1; $AddressLine2 = $xml->Address2; }
			}
			else
			{
				$AddressLine1 = $xml->Address1;
			}

			$chunks = spliti (";", $xml->PremiseData); // Splits up premise data
			print "<select class=\"validate-select\" id='address_dropdown' onChange=\"sendText('$AddressLine2','$xml->Town','$xml->County','$xml->Postcode');\" style=\"width:300px\">\n<option> [ Please Select ] </option>";
			foreach ($chunks as $v) // Adds premises to combo box
			{
				if ($v <> "")
				{
					list($organisation, $building , $number) = split('[|]', $v); // Splits premises into organisation, building and number
					echo "<option value='$organisation'>";
					if ($organisation <> "")echo $organisation . ", ";
					if ($building <> "")echo  str_replace("/",", ",$building) . ", ";
					if ($number <> "")echo $number . " ";
					print $AddressLine1;
					print "</option>\n";		
				}
			}
			print "</select>";
		}		
    }
}
