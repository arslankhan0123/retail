<?php
$conn = new mysqli('localhost', 'root', '', 'retail');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check db_deliverynote
$result = $conn->query("SHOW COLUMNS FROM `db_deliverynote` LIKE 'salesman_id'");
if($result->num_rows == 0) {
    $conn->query("ALTER TABLE `db_deliverynote` ADD `salesman_id` INT(11) NULL DEFAULT NULL AFTER `customer_id`;");
    echo "Added salesman_id to db_deliverynote\n";
} else {
    echo "salesman_id already exists in db_deliverynote\n";
}

// Check db_salesreturn
$result = $conn->query("SHOW COLUMNS FROM `db_salesreturn` LIKE 'salesman_id'");
if($result->num_rows == 0) {
    $conn->query("ALTER TABLE `db_salesreturn` ADD `salesman_id` INT(11) NULL DEFAULT NULL AFTER `customer_id`;");
    echo "Added salesman_id to db_salesreturn\n";
} else {
    echo "salesman_id already exists in db_salesreturn\n";
}

$conn->close();
?>
