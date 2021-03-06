<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	require 'classes.php';
	require_once("$srcdir/classes/InsuranceCompany.class.php");
	
	$xml_string = "";
	$xml_string .= "<insurancecompany>";

	$token = $_POST['token'];
	$id = $_POST['id'];				
	$name = $_POST['name'];
	$attn = $_POST['attn'];
	$address_line1 = $_POST['address_line1'];
	$address_line2 = $_POST['address_line1'];
	$phone = $_POST['phone'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$cms_id =$_POST['cms_id'];
	$freeb_type =$_POST['freeb_type'];
	$x12_receiver_id =$_POST['x12_receiver_id'];

/*	$token = 'a9b450867020dc6bb08f3c94f9f3efe9';
	$id = 4;
	$name = 'xyz';
	$attn='47464846';
	$address_line1 = 'Address 33';
	$address_line2 = 'Address 44';
	$city = 'city Updated';
	$state = 'state Updated';
	$zip = 'Zip updated';
	$phone = '1430 143';
	$cms_id ='ddddd';
	$freeb_type ='ddd';
	$x12_receiver_id ='eee';
*/

	if (validateToken($token)) {
		$insuranceCom = new InsuranceCompany($id);
				
		$insuranceCom->set_name($name);
		$insuranceCom->set_attn($attn);
		$insuranceCom->set_address_line1($address_line1);
		$insuranceCom->set_address_line2($address_line1);
		$insuranceCom->set_phone($phone);
		$insuranceCom->set_city($city);
		$insuranceCom->set_state($state);
		$insuranceCom->set_zip($zip);
		$insuranceCom->set_cms_id($cms_id);
		$insuranceCom->set_freeb_type($freeb_type);
		$insuranceCom->set_x12_receiver_id($x12_receiver_id);

		$insuranceCom->persist();
    		
   		$xml_string .= "<status>0</status>\n";
		$xml_string .= "<reason>The Insurance Company hasbeen Updated</reason>\n";
	} else {
    	$xml_string .= "<status>-2</status>";
   		$xml_string .= "<reason>Invalid Token</reason>";
	}

	$xml_string .= "</insurancecompany>";
	echo $xml_string;
?>