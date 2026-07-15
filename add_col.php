<?php
$conn = new mysqli('localhost', 'root', '', 'retail');
$result = $conn->query("SHOW COLUMNS FROM db_salesman LIKE 'tot_advance'");
if($result->num_rows == 0) {
    $conn->query("ALTER TABLE db_salesman ADD tot_advance double NOT NULL DEFAULT '0'");
    echo "Added tot_advance column";
} else {
    echo "Column exists";
}
?>
