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
    
    // Validate incoming JSON payload - Minimum required data for adding new contact
    if ( $contactID==null )
    {
       exitWithError( "Missing required fields" );
    }

    // Create database connection
    $conn = new mysqli("localhost", "copahost_dbuser", "7Tt#OUqiB4uJ", "copahost_cop4331");
	if ($conn->connect_error) 
	{
		exitWithError( $conn->connect_error );
	} 

    // Delete data from database
    $sql = "delete from Contacts where "
            . "AccountID = '" . $accountID . "' and "
            . "ContactID = '" . $contactID . "'";
            
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