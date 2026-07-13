<?php
$dirs = glob("application/language/*", GLOB_ONLYDIR);
foreach($dirs as $dir) {
    $files = glob($dir . "/*_lang.php");
    foreach($files as $file) {
        $content = file_get_contents($file);
        if (strpos($content, "'deliverynote'") === false) {
            preg_match_all("/\\\$lang\['(quotation.*?)'\s*\]\s*=\s*(['\"].*?['\"]);/i", $content, $matches);
            if (!empty($matches[0])) {
                $new_lines = "\n// Delivery Note Language Keys\n";
                foreach($matches[1] as $idx => $key) {
                    $new_key = str_replace("quotation", "deliverynote", $key);
                    $new_val = str_replace("Quotation", "Delivery Note", $matches[2][$idx]);
                    $new_val = str_replace("quotation", "delivery note", $new_val);
                    $new_lines .= "\$lang['" . $new_key . "'] = " . $new_val . ";\n";
                }
                
                if (strpos($content, "'show_all_users_quotations'") !== false) {
                    preg_match("/\\\$lang\['show_all_users_quotations'\s*\]\s*=\s*(['\"].*?['\"]);/i", $content, $m);
                    if (!empty($m)) {
                        $new_val = str_replace("Quotations", "Delivery Notes", $m[1]);
                        $new_lines .= "\$lang['show_all_users_deliverynotes'] = " . $new_val . ";\n";
                    }
                }
                
                if (strpos($content, "?>") !== false) {
                    $content = str_replace("?>", $new_lines . "\n?>", $content);
                } else {
                    $content .= $new_lines;
                }
                file_put_contents($file, $content);
            }
        }
    }
}
echo "Language keys appended";
?>
