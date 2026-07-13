<?php
$src_dir = "theme/js/quotation/";
$dest_dir = "theme/js/deliverynote/";

if(!is_dir($dest_dir)) {
    mkdir($dest_dir, 0755, true);
}

$src_file = $src_dir . "quotation.js";
$dest_file = $dest_dir . "deliverynote.js";

$content = file_get_contents($src_file);

// Replace the URL routes first to ensure they use the correct case
$content = str_replace("quotation/add", "Delivery_note/add", $content);
$content = str_replace("quotation/update", "Delivery_note/update", $content);
$content = str_replace("quotation/delete", "Delivery_note/delete", $content);
$content = str_replace("quotation/ajax_list", "Delivery_note/ajax_list", $content);

// Standard replacements
$content = str_replace("quotation", "deliverynote", $content);
$content = str_replace("Quotation", "Delivery Note", $content);
$content = str_replace("QUOTATION", "DELIVERY NOTE", $content);

// The controller is Delivery_note, so URLs must use Delivery_note
$content = str_replace("deliverynote/get_items_info", "Delivery_note/get_items_info", $content);
$content = str_replace("deliverynote/return_row_with_data", "Delivery_note/return_row_with_data", $content);
$content = str_replace("deliverynote/deliverynote_save_and_update", "Delivery_note/deliverynote_save_and_update", $content);

file_put_contents($dest_file, $content);

echo "JS duplicated and replaced";
?>
