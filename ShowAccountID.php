<?php
    // Start a session
    session_start();
    header('Content-type: application/json');
    echo '{"AccountID" : "' . $_SESSION["AccountID"] . '"}';
?>