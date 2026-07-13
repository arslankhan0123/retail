<?php
$dir = "application/views/delivery_note/";
$files = glob($dir . "*.php");
foreach($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace("deliverynote/add", "Delivery_note/add", $content);
    $content = str_replace("deliverynote/print", "Delivery_note/print", $content);
    $content = str_replace("deliverynote/delete", "Delivery_note/delete", $content);
    $content = str_replace("deliverynote/pdf", "Delivery_note/pdf", $content);
    file_put_contents($file, $content);
}
echo "Done views wider";
?>
