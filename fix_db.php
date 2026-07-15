<?php
$mysqli = new mysqli("localhost", "root", "", "retail");
$mysqli->query("ALTER TABLE db_store ADD COLUMN qr_image varchar(255) DEFAULT NULL;");
echo $mysqli->error;
echo "Done";
