<?php
$dir = "application/views/delivery_note/";
$files = glob($dir . "*.php");
foreach($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace('Quotation', 'Delivery Note', $content);
    $content = str_replace('quotation', 'deliverynote', $content);
    $content = str_replace('QUOTATION', 'DELIVERY NOTE', $content);
    // Also fix URL paths Delivery Note -> delivery_note if any
    $content = str_replace('Delivery Note/update', 'Delivery_note/update', $content);
    file_put_contents($file, $content);
}
echo "Done";
?>
