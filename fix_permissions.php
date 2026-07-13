<?php
$files = ['application/controllers/Delivery_note.php', 'application/models/Delivery_note_model.php'];
foreach($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace("permission_check('Delivery_note_view')", "permission_check('quotation_view')", $content);
    $content = str_replace("permission_check('Delivery_note_add')", "permission_check('quotation_add')", $content);
    $content = str_replace("permission_check('Delivery_note_edit')", "permission_check('quotation_edit')", $content);
    $content = str_replace("permission_check('Delivery_note_delete')", "permission_check('quotation_delete')", $content);
    
    $content = str_replace("permission_check_with_msg('Delivery_note_view')", "permission_check_with_msg('quotation_view')", $content);
    $content = str_replace("permission_check_with_msg('Delivery_note_add')", "permission_check_with_msg('quotation_add')", $content);
    $content = str_replace("permission_check_with_msg('Delivery_note_edit')", "permission_check_with_msg('quotation_edit')", $content);
    $content = str_replace("permission_check_with_msg('Delivery_note_delete')", "permission_check_with_msg('quotation_delete')", $content);
    
    $content = str_replace("permissions('Delivery_note_view')", "permissions('quotation_view')", $content);
    $content = str_replace("permissions('Delivery_note_add')", "permissions('quotation_add')", $content);
    $content = str_replace("permissions('Delivery_note_edit')", "permissions('quotation_edit')", $content);
    $content = str_replace("permissions('Delivery_note_delete')", "permissions('quotation_delete')", $content);
    file_put_contents($file, $content);
}
echo "Done";
?>
