<?php
    // Start a session
    session_start();
    $_SESSION["AccountID"] = 0;
    
    // Capture incoming JSON payload
    $inData = json_decode(file_get_contents('php://input'), true);
    $accountName = $inData["AccountName"];
    $password = $inData["Password"];
    
    // Validate incoming JSON payload
    if ($accountName==null || $password==null )
    {
       exitWithError( "Missing required fields" );
    }
    
    // Create database connection
    $conn = new mysqli("localhost", "copahost_dbuser", "7Tt#OUqiB4uJ", "copahost_cop4331");
	if ($conn->connect_error) 
	{
		exitWithError( $conn->connect_error );
	} 
	    
    // Validate AccountName and Password
    // AccountName is Unique DB field only 0 or 1 row can exist
    $sql = "select AccountID from Accounts where "
            . "AccountName = '" . $accountName . "' "
            . "and Password = '" . $password . "'";
    $result = $conn->query($sql);
    if ( $result->num_rows > 0 )
    {
        $row = $result->fetch_assoc();
        $_SESSION["AccountID"] = $row["AccountID"];
        
        //Update LastLoginDate
        $sql = "update Accounts set LastLoginDate = CURRENT_TIMESTAMP where "
               . "AccountID = '" . $_SESSION["AccountID"] . "'";
        $result = $conn->query($sql);
    }
    else 
    {
        exitWithError("Invalid user name or password");
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