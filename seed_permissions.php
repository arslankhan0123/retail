<?php
$conn = new mysqli('localhost', 'root', '', 'retail');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Find roles that have quotation_view
$result = $conn->query("SELECT DISTINCT role_id, store_id FROM db_permissions WHERE permissions='quotation_view'");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $role_id = $row["role_id"];
        $store_id = $row["store_id"];
        
        $perms = ['deliverynote_add', 'deliverynote_edit', 'deliverynote_delete', 'deliverynote_view'];
        foreach($perms as $p) {
            // check if exists
            $check = $conn->query("SELECT * FROM db_permissions WHERE role_id='$role_id' AND store_id='$store_id' AND permissions='$p'");
            if($check->num_rows == 0) {
                $conn->query("INSERT INTO db_permissions (role_id, permissions, store_id) VALUES ('$role_id', '$p', '$store_id')");
            }
        }
    }
}
echo "Permissions seeded!";
?>
