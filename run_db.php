<?php
$conn = new mysqli('localhost', 'root', '', 'retail');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "CREATE TABLE IF NOT EXISTS `db_deliverynote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create deliverynote Code',
  `deliverynote_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `deliverynote_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `deliverynote_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL,
  `round_off` double(20,4) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `deliverynote_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'deliverynote return raised',
  `customer_previous_due` double(20,4) DEFAULT NULL,
  `customer_total_due` double(20,4) DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($conn->query($sql1) === TRUE) {
  echo "Table db_deliverynote created successfully\n";
} else {
  echo "Error creating table: " . $conn->error . "\n";
}

$sql2 = "CREATE TABLE IF NOT EXISTS `db_deliverynoteitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `deliverynote_id` int(11) DEFAULT NULL,
  `deliverynote_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `deliverynote_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `seller_points` double(20,4) DEFAULT 0.0000,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($conn->query($sql2) === TRUE) {
  echo "Table db_deliverynoteitems created successfully\n";
} else {
  echo "Error creating table: " . $conn->error . "\n";
}

$conn->close();
?>
