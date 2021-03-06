<?php

header("Content-Type:text/xml");

$ignoreAuth = true;
require('classes.php');

$xml_string = "";
$xml_string .= "<PrescriptionList>\n";

$token = $_POST['token'];
//	$data = $_POST['data'];
$patientId = $_POST['patientID'];
$visit_id = isset($_POST['visit_id']) && !empty($_POST['visit_id']) ? $_POST['visit_id'] : '';

/* $token = 'a9b450867020dc6bb08f3c94f9f3efe9';
  $patientId = 1;
  $data = 'nv2aMcunGlAg';
 */

if ($userId = validateToken($token)) { 
    $user_data = getUserData($userId);
    $user = $user_data['user'];
    $emr = $user_data['emr'];
    $username = $user_data['username'];
    $password = $user_data['password'];
	
switch ($emr) {
    case 'openemr':
			
    $strQuery = "SELECT p.*,u.id AS provider_id,u.fname AS provider_fname,u.lname AS provider_lname,u.mname AS provider_mname 
                            FROM prescriptions as p
                            LEFT JOIN `users` as u ON u.id = p.provider_id
                            WHERE patient_id =" . $patientId;

    if ($visit_id) {
        $strQuery .= " AND encounter = " . $visit_id;
    }
    $result = $db->get_results($strQuery);

    if ($result) {
        $xml_string .= "<status>0</status>\n";
        $xml_string .= "<reason>The Patient Employer Record has been fetched</reason>\n";
        $data = "";
        for ($i = 0; $i < count($result); $i++) {
            $data .= "<prescription>\n";

            foreach ($result[$i] as $fieldName => $fieldValue) {
                $rowValue = xmlsafestring($fieldValue);
                $data .= "<$fieldName>$rowValue</$fieldName>\n";
            }

            $data .= "</prescription>\n";
        }
        $xml_string .= "<data>" . $data . "</data>";
    } else {
        $xml_string .= "<status>-1</status>\n";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>\n";
    }
	break;
	case 'greenway':
		include 'greenway/PatientMedicationGet.php';
	break;
}// end switch

//		} else {
//			$xml_string .= "<status>-3</status>";	
//			$xml_string .= "<reason>Invalid Secret Key</reason>";	
//		}	
} else {
    $xml_string .= "<status>-2</status>\n";
    $xml_string .= "<reason>Invalid Token</reason>\n";
}

$xml_string .= "</PrescriptionList>\n";
echo $xml_string;
?>