<?php
require_once("inventory_class.php");

class BulkLoad {
    // Constructor checks for file types with a POST method, validates them and stores them in uploads folder
    public function __construct($file, $ext) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $allowed = ['csv' => 'text/csv', 'json' => 'application/json', 'xml' => 'text/xml'];
            $maxsize = 5 * 1024 * 1024; // 5MB maximum file size
            $upload_dir = 'uploads/';
            $success_count = 0;
            $error_count = 0;
            $skipped_count = 0;
            $total_files = count($_FILES['files']['name']);

        for ($i = 0; $i < $total_files; $i++) {
            $filename = $_FILES['files']['name'][$i];
            $filetype = $_FILES['files']['type'][$i];
            $filesize = $_FILES['files']['size'][$i];
            $tmp_name = $_FILES['files']['tmp_name'][$i];
            print($filename);

            // Verify file extension
            if (!array_key_exists($ext, $allowed)) {
                $error_count++;
                echo "Invalid file extension.";
                return;
            }

            // Verify file size
            if (filesize($file) > $maxsize) {
                $error_count++;
                echo "File size exceeds limit.";
                return;
            }

           // Verify MIME type
            if (in_array($filetype, $allowed)) {
                $target_file = $upload_dir . basename($filename);

                // Check if file already exists
                if (file_exists($target_file)) {
                    $skipped_count++;
                    continue;
                } else {
                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $success_count++;
                        try {
                            // Process the file here
                            $this->process_file($target_file, $ext);
                        } catch (Exception $e) {
                            $error_count++;
                        }
                    } else {
                        $error_count++;
                    }
                }
            } else {
                $error_count++;
            }
        }

        $message = "Upload Summary: <br> Successfully processed: $success_count <br> Skipped: $skipped_count <br> Errors: $error_count";
        echo $message;
        } else {
            echo "No files were uploaded.";
        }
    }


    //Function that invokes specific file parser functions
    public function process_file($file, $ext) {
        switch ($ext) {
            case 'csv':
                $data = $this->parse_csv($file);
                break;
            case 'json':
                $data = $this->parse_json($file);
                break;
            case 'xml':
                $data = $this->parse_xml($file);
                break;
            default:
                throw new Exception("Unsupported file format.");
               
        }
        
        $inventory = new Inventory();
        foreach ($data as $record) {
            if ($this->validate_record($record, $inventory)) {
                $inventory->upload($data);
            } else {
                // Handling invalid record
                $this->failed_records[] = $record;
                error_log("Invalid record: " . json_encode($record));
            }
        }
    }

    public function validate_record($record, $inventory) {
        // Validate ID, This should add stock to an existing Id and should verify if other records match to do so > TOO COMPLEX ugh :(!!
        // I am just leaving it as filtering out existing ids for the timebeing
        if (!isset($record['Id']) || !preg_match("/^\d{1,3}[A-Za-z]{1,2}$/", $record['Id']) || !$inventory->is_unique_id($record['Id'])) {
            return false;
        }

        // Validate Name
        if (!isset($record['Name']) || !preg_match("/^[A-Za-z0-9\s\W]+$/", $record['Name'])) {
            return false;
        }

        // Validate Brand
        if (!isset($record['Brand']) || !preg_match("/^[A-Za-z0-9\s\W]+$/", $record['Brand'])) {
            return false;
        }

        // Validate Category
        if (!isset($record['Category']) || !preg_match("/^[A-Za-z0-9\s\W]+$/", $record['Category'])) {
            return false;
        }

        // Validate Unit Price
        if (!isset($record['Unit Price']) || !preg_match("/^\d+(\.\d{1,2})?$/", $record['Unit Price'])) {
            return false;
        }

        // Validate Expiry Date (optional: add specific date format validation)
        if (!isset($record['Expiry Date'])) {
            return false;
        }

        // Validate Stock
        if (!isset($record['Stock']) || !preg_match("/^\d+$/", $record['Stock'])) {
            return false;
        }

        return true;
    }

    public function parse_csv($file) {
        $csvData = array_map('str_getcsv', file($file));
        array_walk($csvData, function(&$a) use ($csvData) {
            $a = array_combine($csvData[0], $a);
        });
        array_shift($csvData); // remove column header
        return $csvData;
    }

    public function parse_json($file) {
        $jsonData = file_get_contents($file);
        $data = json_decode($jsonData, true);
        return isset($data['items']) ? $data['items'] : [];
    }

    public function parse_xml($file) {
        $xml = simplexml_load_file($file);
        $json = json_encode($xml);
        return json_decode($json, true)['items'];
    }
    // Not using this
    public function getErrors() {
        return $this->errors;
    }
}
?>
