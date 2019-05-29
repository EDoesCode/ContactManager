<?php

    $servername = "localhost";
    $username = "copahost_dbuser";
    $password = "7Tt#OUqiB4uJ";
    $dbname = "copahost_cop4331";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT AccountID, AccountName, FirstName, LastName, Password, LastLoginDate, CreateDate FROM Accounts";
    $result = $conn->query($sql);

    echo "<h1>Table: Accounts</h1>";
    
    if ($result->num_rows > 0) {
        echo file_get_contents("tablestyle.txt");
        echo "<table>" 
           . "<tr>"
           . "<th>AccountID</th>"
           . "<th>AccountName</th>"
           . "<th>FirstName</th>"
           . "<th>LastName</th>"
           . "<th>Password</th>"
           . "<th>LastLoginDate</th>"
           . "<th>CreateDate</th>"
           . "</tr>";
        
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>" 
               . "<td>" . $row["AccountID"] . "</td>"
               . "<td>" . $row["AccountName"] . "</td>" 
               . "<td>" . $row["FirstName"] . "</td>"
               . "<td>" . $row["LastName"] . "</td>"
               . "<td>" . $row["Password"] . "</td>"
               . "<td>" . $row["LastLoginDate"] . "</td>"
               . "<td>" . $row["CreateDate"] . "</td>"
               . "</tr>";
        }
        echo "</table>";
    } else {
        echo "No rows found";
    }

    $sql = "SELECT ContactID, FirstName, LastName, Address1, Address2, City, State, Zip, Email, Phone, AccountID FROM Contacts";
    $result = $conn->query($sql);

    echo "<h1>Table: Contacts</h1>";
    
    if ($result->num_rows > 0) {
        echo file_get_contents("tablestyle.txt");
        echo "<table>" 
           . "<tr>"
           . "<th>ContactID</th>"
           . "<th>FirstName</th>"
           . "<th>LastName</th>"
           . "<th>Address1</th>"
           . "<th>Address2</th>"
           . "<th>City</th>"
           . "<th>State</th>"
           . "<th>Zip</th>"
           . "<th>Email</th>"
           . "<th>Phone</th>"
           . "<th>AccountID</th>"
           . "</tr>";
        
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>" 
               . "<td>" . $row["ContactID"] . "</td>"
               . "<td>" . $row["FirstName"] . "</td>" 
               . "<td>" . $row["LastName"] . "</td>"
               . "<td>" . $row["Address1"] . "</td>"
               . "<td>" . $row["Address2"] . "</td>"
               . "<td>" . $row["City"] . "</td>"
               . "<td>" . $row["State"] . "</td>"
               . "<td>" . $row["Zip"] . "</td>"
               . "<td>" . $row["Email"] . "</td>"
               . "<td>" . $row["Phone"] . "</td>"
               . "<td>" . $row["AccountID"] . "</td>"
               . "</tr>";
        }
        echo "</table>";
    } else {
        echo "No rows found";
    }
    
    
    $conn->close();
?>
