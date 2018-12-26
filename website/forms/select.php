<?php
try {
    include_once("/kunden/homepages/22/d716419518/htdocs/config/passwords.php");
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
}
catch (PDOException $e) {
    die('Connection error');
}

$tableheader = false;
$query       = "SELECT * FROM `visitor` ORDER BY `id` ASC";
$sth         = $dbh->prepare($query);

if (!$sth->execute()) {
    die('Query error');
}

echo "<table>";

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    if ($tableheader == false) {
        echo '<tr>';
        foreach ($row as $key => $value) {
            echo "<th>{$key}</th>";
        }
        echo '</tr>';
        $tableheader = true;
    }
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>{$value}</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
