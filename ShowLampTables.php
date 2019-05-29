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

    $sql = "SELECT ID, DateCreated, DateLastLoggedIn, FirstName, LastName, Login, Password FROM Users";
    $result = $conn->query($sql);

    echo "<h1>Table: Users</h1>";
    
    if ($result->num_rows > 0) {
        echo file_get_contents("tablestyle.txt");
        echo "<table>" 
           . "<tr>"
           . "<th>ID</th>"
           . "<th>DateCreated</th>"
           . "<th>DateLastLoggedIn</th>"
           . "<th>FirstName</th>"
           . "<th>LastName</th>"
           . "<th>Login</th>"
           . "<th>Password</th>"
           . "</tr>";
        
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>" 
               . "<td>" . $row["ID"] . "</td>"
               . "<td>" . $row["DateCreated"] . "</td>" 
               . "<td>" . $row["DateLastLoggedIn"] . "</td>"
               . "<td>" . $row["FirstName"] . "</td>"
               . "<td>" . $row["LastName"] . "</td>"
               . "<td>" . $row["Login"] . "</td>"
               . "<td>" . $row["Password"] . "</td>"
               . "</tr>";
        }
        echo "</table>";
    } else {
        echo "No rows found";
    }

    $sql = "SELECT ID, Name, UserID FROM Colors";
    $result = $conn->query($sql);

    echo "<h1>Table: Colors</h1>";
    
    if ($result->num_rows > 0) {
        echo file_get_contents("tablestyle.txt");
        echo "<table>" 
           . "<tr>"
           . "<th>ID</th>"
           . "<th>Name</th>"
           . "<th>UserID</th>"
           . "</tr>";
        
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>" 
               . "<td>" . $row["ID"] . "</td>"
               . "<td>" . $row["Name"] . "</td>" 
               . "<td>" . $row["UserID"] . "</td>"
               . "</tr>";
        }
        echo "</table>";
    } else {
        echo "No rows found";
    }
    
    
    $conn->close();
?>
