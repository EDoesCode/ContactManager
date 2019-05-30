<?php
    // Continue an existing session
    session_start();
    if ( $_SESSION["AccountID"] == "" || $_SESSION["AccountID"] < 1 )
    {
        exitWithError( "Authorization required" );
    }
    else
    {
        $accountID = $_SESSION["AccountID"];
    }  
    
    // Capture incoming JSON payload
    $inData = json_decode(file_get_contents('php://input'), true);
    $contactID = $inData["ContactID"];
    $firstName = $inData["FirstName"];
    $lastName = $inData["LastName"];
    $address1 = $inData["Address1"];
    $address2 = $inData["Address2"];
    $city = $inData["City"];
    $state = $inData["State"];
    $zip = $inData["Zip"];
    $email = $inData["Email"];
    $phone = $inData["Phone"];
    
    // Validate incoming JSON payload - Minimum required data for adding new contact
    if ( $contactID==null )
    {
       exitWithError( "Missing required fields" );
    }
    
    if ($firstName==null && $lastName==null && $address1==null && $address2==null && $city==null && $state==null && $zip==null && $email==null && $phone==null )
    {
        exitWithError( "At least one field must be updated" );
    }

    // Create database connection
    $conn = new mysqli("localhost", "copahost_dbuser", "7Tt#OUqiB4uJ", "copahost_cop4331");
	if ($conn->connect_error) 
	{
		exitWithError( $conn->connect_error );
	} 

    // Update data in database - Only requires ContactId and one other field
    $sql = "update Contacts set ";
    if ($firstName !== null) {$sql .= "FirstName = " . "'" . $firstName . "', "; }
    if ($lastName !== null) {$sql .= "LastName = " . "'" . $lastName . "', "; }
    if ($address1 !== null) {$sql .= "Address1 = " . "'" . $address1 . "', "; }
    if ($address2 !== null) {$sql .= "Address2 = " . "'" . $address2 . "', "; }
    if ($city !== null) {$sql .= "City = " . "'" . $city . "', "; }
    if ($state !== null) {$sql .= "State = " . "'" . $state . "', "; }
    if ($zip !== null) {$sql .= "Zip = " . "'" . $zip . "', "; }
    if ($phone !== null) {$sql .= "Phone = " . "'" . $phone . "', "; }
    if ($email !== null) {$sql .= "Email = " . "'" . $email . "', "; }
    $sql .= "ContactID = " . "'" . $contactID . "' ";
    $sql .= " where ContactID = " . "'" . $contactID . "'"; 
    
	if( $result = $conn->query($sql) != TRUE )
	{
        exitWithError( $conn->error );
	}
    
    // Default exit with no error status set
    $conn->close(); 
    exitWithError("");

    // Functions used in script
    function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
    function exitWithError( $err )
	{
		$retValue = '{"error" :"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
        exit();
	}

?>