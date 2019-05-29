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
    if ( $lastName==null )
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
    $sql = "insert into Contacts (FirstName,LastName,Address1,Address2,City,State,Zip,Email,Phone,AccountID) VALUES ("
            . "'" . $firstName . "',"
            . "'" . $lastName . "',"
            . "'" . $address1 . "',"
            . "'" . $address2 . "',"
            . "'" . $city . "',"
            . "'" . $state . "',"
            . "'" . $zip . "',"
            . "'" . $email . "',"
            . "'" . $phone . "',"
            . "'" . $accountID . "')"; 
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