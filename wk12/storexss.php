<?php
// Stored XSS Demo
// Reads content from storedxss.txt and outputs it directly WITHOUT sanitizing.
// This intentionally renders any HTML/JS stored in the file.

$filename = "storedxss.txt";

if (file_exists($filename)) {
    $contents = file_get_contents($filename);
    // Directly echo without sanitization — intentionally vulnerable for demo
    echo $contents;
} else {
    echo "Error: storedxss.txt not found.";
}
?>
