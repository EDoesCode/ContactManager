<?php
    // Start a session
    session_start();
    $_SESSION["AccountID"] = 0;
    
    // Capture incoming JSON payload
    $inData = json_decode(file_get_contents('php://input'), true);
    $firstName = $inData["FirstName"];
    $lastName = $inData["LastName"];
    $accountName = $inData["AccountName"];
    $password = $inData["Password"];
    
    // Validate incoming JSON payload
    if ($firstName==null || $lastName==null || $accountName==null || $password==null )
    {
       exitWithError( "Missing required fields" );
    }
    
    // Create database connection
    $conn = new mysqli("localhost", "copahost_dbuser", "7Tt#OUqiB4uJ", "copahost_cop4331");
	if ($conn->connect_error) 
	{
		exitWithError( $conn->connect_error );
	} 
	
    // Insert data into database
    $sql = "insert into Accounts (AccountName,FirstName,LastName,Password) VALUES ("
            . "'" . $accountName . "',"
            . "'" . $firstName . "',"
            . "'" . $lastName . "',"
            . "'" . $password . "')"; 
	if( $result = $conn->query($sql) != TRUE )
	{
        // Duplicate AccountName will fail
        exitWithError( $conn->error );
	}
    
    // Determine auto assigned AccountID and set state for it
    // AccountName is Unique DB field only 0 or 1 row can exist
    $sql = "select AccountID from Accounts where AccountName = '" . $accountName . "'";
    $result = $conn->query($sql);
    if ( $result->num_rows > 0 )
    {
        $row = $result->fetch_assoc();
        $_SESSION["AccountID"] = $row["AccountID"];
    }
    else 
    {
        exitWithError("Unable to retrieve AccountID.");
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