<?php
$conn = new mysqli('localhost', 'root', '', 'retail');
$res = $conn->query("SHOW COLUMNS FROM db_sales LIKE 'deliverynote_id'");
if($res->num_rows > 0) echo 'Exists'; else echo 'Not Exists';
?>
