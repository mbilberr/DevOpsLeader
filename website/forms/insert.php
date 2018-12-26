<?php

include_once("/kunden/homepages/22/d716419518/htdocs/config/passwords.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO visitor (vname, company) VALUES (:vname, :company)");
    $stmt->bindParam(':vname', $vname);
    $stmt->bindParam(':company', $company);
    
    // insert a row
    $vname   = $_POST["vname"];
    $company = $_POST["company"];
    $stmt->execute();
    echo "New records created successfully\nRedirecting in 5 seconds...";
    sleep(5);
    include ('index.php');
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
