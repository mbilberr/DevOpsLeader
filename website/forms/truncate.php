<?php

include_once("/kunden/homepages/22/d716419518/htdocs/config/passwords.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // prepare sql and bind parameters
    $stmt = $conn->prepare("truncate table visitor");
    $stmt->execute();
    echo "Table has been truncated successfully.\nRedirecting in 5 seconds...";
    sleep(5);
    include ('index.php');
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
