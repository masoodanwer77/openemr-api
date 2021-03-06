<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require('classes.php');

$xml_string = "";
$xml_string = "<prescription>";

$token = $_POST['token'];
//	$patientId = $_POST['patientId'];

$id = $_POST['id'];


if ($userId = validateToken($token)) {
    $user = getUsername($userId);

    $strQuery = "DELETE FROM `prescriptions` WHERE id = {$id}";
    $result = $db->query($strQuery);

    if ($result) {
        newEvent($event = 'patient-record-update', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);

        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>The Patient prescription has been deleted</reason>";
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</prescription>";
echo $xml_string;
?>