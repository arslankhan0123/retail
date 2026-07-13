<?php
// Fix Sales.php controller
$file = 'application/controllers/Sales.php';
$content = file_get_contents($file);
if (strpos($content, 'public function deliverynote(') === false) {
    // Extract quotation method
    preg_match("/public function quotation\(.*?\{.*?\n\t\}/s", $content, $matches);
    if (!empty($matches[0])) {
        $new_method = str_replace('quotation', 'deliverynote', $matches[0]);
        $new_method = str_replace('Quotation', 'Delivery Note', $new_method);
        $new_method = str_replace('db_deliverynote', 'db_deliverynote', $new_method); // Just in case
        $content = str_replace($matches[0], $matches[0] . "\n\n\t" . $new_method, $content);
    }
    
    // Extract return_quotation_list method
    preg_match("/public function return_quotation_list\(.*?\{.*?\n\t\}/s", $content, $matches2);
    if (!empty($matches2[0])) {
        $new_method = str_replace('quotation', 'deliverynote', $matches2[0]);
        $content = str_replace($matches2[0], $matches2[0] . "\n\n\t" . $new_method, $content);
    }
    file_put_contents($file, $content);
}

// Fix Sales_model.php model
$file = 'application/models/Sales_model.php';
$content = file_get_contents($file);
if (strpos($content, 'public function return_deliverynote_list(') === false) {
    // Extract return_quotation_list method
    preg_match("/public function return_quotation_list\(.*?return_row_with_data\(.*?;\n\t\}/s", $content, $matches);
    if (!empty($matches[0])) {
        $new_method = str_replace('quotation', 'deliverynote', $matches[0]);
        $content = str_replace($matches[0], $matches[0] . "\n\n\t" . $new_method, $content);
        file_put_contents($file, $content);
    }
}
echo "Sales methods added";
?>
