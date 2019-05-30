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
    
    // Validate incoming JSON payload - Minimum required data for adding new contact
    // No information needed other than AccountID from Cookie
    
    // Create database connection
    $conn = new mysqli("localhost", "copahost_dbuser", "7Tt#OUqiB4uJ", "copahost_cop4331");
	if ($conn->connect_error) 
	{
		exitWithError( $conn->connect_error );
	} 

    // Fetch all rows associated with AccountID
    $sql = "select * from Contacts where AccountID = " . "'" . $accountID . "'";
    $result = $conn->query($sql);
    
    // Initialize array to hold multiple rows
    $dbdata = array();
    
    // Fetch into associative array
    if ( $result->num_rows > 0 )
    {
        while ( $row = $result->fetch_assoc())
        {
            $dbdata[] = $row;
        }
        sendResultInfoAsJson( json_encode($dbdata) );     
    }
    else 
    {
        exitWithError("No Records Found");
    }
     
    // Functions used by script
	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}    
    
    function exitWithError( $err )
	{
		$retValue = '{"error" : "' . $err . '"}';
		sendResultInfoAsJson( $retValue );
        exit();
	}   
?>