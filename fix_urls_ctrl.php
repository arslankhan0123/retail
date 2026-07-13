<?php
$file = "application/controllers/Delivery_note.php";
$content = file_get_contents($file);
$content = str_replace("base_url().'deliverynote/", "base_url().'Delivery_note/", $content);
$content = str_replace('base_url()."deliverynote/', 'base_url()."Delivery_note/', $content);
file_put_contents($file, $content);
echo "Done controller";
?>
