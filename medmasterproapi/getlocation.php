<?php 
	header ("Content-Type:text/xml"); 
	$ignoreAuth = true;
	require 'classes.php';
	
	$xml_string = "";
	$xml_string = "<locations>";
	
	$token = $_POST['token'];
	$facilityId = $_POST['facility_id'];
	
	//$token = 'fe15082d987f3fd5960a712c54494a68';
	//$facilityId=4;
	
	if ($userId = validateToken($token)) {		
		$strQuery = "SELECT id, name FROM facility WHERE primary_business_entity=".$facilityId;
		$result = $db->get_results($strQuery);
	
		if($result) {
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Locations Records has been fetched</reason>";
		
			for($i=0; $i<count($result); $i++) {
				$xml_string .= "<location>\n";
				
				foreach($result[$i] as $fieldName => $fieldValue) {
					$rowValue = xmlsafestring($fieldValue);
					$xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
				}
				
				$xml_string .= "</location>\n";
			}
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}	
	} else {
		$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</locations>";	
	echo $xml_string;
?>