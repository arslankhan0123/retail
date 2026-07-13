<?php
$conn = new mysqli('localhost', 'root', '', 'retail');
$res = $conn->query("ALTER TABLE db_sales ADD COLUMN deliverynote_id int(11) DEFAULT NULL AFTER quotation_id");
if($res) echo "Column added"; else echo $conn->error;
?>
