<?php
$conn = new mysqli('localhost', 'root', '', 'retail');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT a.id, a.deliverynote_date, a.expire_date, a.deliverynote_code, a.reference_no, b.customer_name, a.grand_total, a.created_by, a.store_id, a.sales_status FROM db_deliverynote a LEFT JOIN db_customers b ON b.id=a.customer_id";

if ($conn->query($sql) === TRUE) {
  echo "Query successful\n";
} else {
  echo "Error: " . $conn->error . "\n";
}
?>
