var type, txtPostcode, txtCompany, txtStreet1, txtStreet2, txtCity, txtRegion, txtResult;

function sendText(addressline2, town, county, postcode)
	{	
		var company = $('address_dropdown').value;
		var addressline1 =$('address_dropdown').options[$('address_dropdown').selectedIndex].text;
		 
		if (company != "")
		{
			addressline1 = addressline1.replace(company + ', ','');
			$(txtCompany).value = company;			
		}
		if (addressline2 != "")
		{
			$(txtStreet2).value = addressline2;			
		}
		$(txtPostcode).value = postcode;
		$(txtStreet1).value = addressline1;
		$(txtCity).value = town;
		$(txtRegion).value = county;
		$(txtResult).innerHTML = "";
	}
	
	function LookupPostcode(type,url)
	{
		if (type == 'billing')
		{
			txtPostcode = 'billing:postcode';
			txtCompany = 'billing:company';
			txtStreet1 = 'billing:street1';
			txtStreet2 = 'billing:street2';
			txtCity = 'billing:city';
			txtRegion = 'billing:region';
			txtResult = 'billing:result';
			spnLoading = 'billing:loading';
		}
		if (type == 'shipping')
		{
			txtPostcode = 'shipping:postcode';
			txtCompany = 'shipping:company';
			txtStreet1 = 'shipping:street1';
			txtStreet2 = 'shipping:street2';
			txtCity = 'shipping:city';
			txtRegion = 'shipping:region';
			txtResult = 'shipping:result';
			spnLoading = 'shipping:loading';
		}
		if (type == 'edit')
		{
			txtPostcode = 'zip';
			txtCompany = 'company';
			txtStreet1 = 'street_1';
			txtStreet2 = 'street_2';
			txtCity = 'city';
			txtRegion = 'region';
			txtResult = 'result';
			spnLoading = 'loading';
		}
		//onLoading: function(){ $('ajax_loading').show() }, onLoaded: function(){ $('ajax_loading').hide() }
		new Ajax.Updater({success: txtResult},url,{method: 'post', parameters: 'postcode=' + $F(txtPostcode), onFailure: txtResult, onLoading: function(){ $(spnLoading).show() }, onLoaded: function(){ $(spnLoading).hide() }});
		//$('ajax_loading').hide();
	}