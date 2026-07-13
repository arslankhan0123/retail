<?php
$dir = "application/views/delivery_note/";
$files = glob($dir . "*.php");
foreach($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace("site_url('deliverynote/", "site_url('Delivery_note/", $content);
    $content = str_replace('site_url("deliverynote/', 'site_url("Delivery_note/', $content);
    $content = str_replace("base_url('deliverynote/", "base_url('Delivery_note/", $content);
    $content = str_replace('base_url("deliverynote/', 'base_url("Delivery_note/', $content);
    $content = str_replace("Deliverynote/update", "Delivery_note/update", $content);
    $content = str_replace("deliverynote/update", "Delivery_note/update", $content);
    $content = str_replace("Deliverynote/delete", "Delivery_note/delete", $content);
    $content = str_replace("deliverynote/delete", "Delivery_note/delete", $content);
    file_put_contents($file, $content);
}
echo "Done views";
?>
