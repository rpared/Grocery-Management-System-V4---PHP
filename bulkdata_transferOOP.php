<?php
require_once("bulkLoad_class.php");

if (isset($_FILES['files'])) {
    // Loop through each uploaded file
    foreach ($_FILES['files']['tmp_name'] as $index => $tmpName) {
        // Extract the original name of the file
        $fileName = $_FILES['files']['name'][$index];

        // Extract the file extension
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);

        // Create a new instance of BulkLoad with the file data and extension
        $bulk_transfer = new BulkLoad($tmpName, $ext);
        
        
    }
} else {
    echo "No files uploaded.";
}
?>

