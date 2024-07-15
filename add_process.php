<?php
include("public/header.php");
require_once("product_class.php");
require_once 'repository_class.php';
require_once("inventory_class.php");// for unique ID so far

        // Initialize repository
        $repository = new Repository();
        // Creating an inventory object of the InventoryManagement class, to get itemDetails and use its method addItem()
        $inventory = new Inventory();
        $errors = []; # to popullate with validation errors

        // Validate ID, This also validates that the ID is unique, it works yeiii!!!!!
        if (!preg_match("/^\d{1,5}$/", $_POST['Id'])) {
            $errors[] = "Invalid ID format. It should be a number up to five digits.";
        } elseif (!$inventory->is_unique_id($_POST['Id'])) {
            $errors[] = "ID already exists. Please choose a unique ID.";
        }
    
        // Validate Name
        if (!preg_match("/^[A-Za-z0-9\s\W]+$/", $_POST['Name'])) {
            $errors[] = "Invalid item name format.";
        }
    
        // Validate Brand
        if (!preg_match("/^[A-Za-z0-9\s\W]+$/", $_POST['Brand'])) {
            $errors[] = "Invalid item brand format.";
        }
    
        // Validate Category
        if (!preg_match("/^[A-Za-z0-9\s\W]+$/", $_POST['Category'])) {
            $errors[] = "Invalid item category format.";
        }
    
        // Validate Unit Price
        if (!preg_match("/^\d+(\.\d{1,2})?$/", $_POST['UnitPrice'])) {
            $errors[] = "Invalid unit price format.";
        }
    
        // Validate Stock
        if (!preg_match("/^\d+$/", $_POST['Stock'])) {
            $errors[] = "Invalid stock format.";
        }
    
        // Check for errors
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {
            $item_id = $_POST['Id'];
            $item_name = $_POST['Name'];
            $item_brand = $_POST['Brand'];
            $item_category = $_POST['Category'];
            $item_price = floatval($_POST['UnitPrice']);  // Price must be a float
            $item_expiry_date = $_POST['Expiry'];
            $item_stock = intval($_POST['Stock']); // Must be an integer
        }

    

    // Validatting form data, null values cannot be allowed, so an if clause will return false and an error message if any field is left empty
    if (!empty($item_name) && !empty($item_id) && !empty($item_brand) 
    && !empty($item_category) && !empty($item_price) 
    && !empty($item_expiry_date) && !empty($item_stock)) {
    
    //Creating a new Object of the Product Class with the attributes inputted
    $new_prod = new Product($item_id, $item_name, $item_brand, $item_category, $item_price, $item_expiry_date, $item_stock);
    // echo $new_prod->getName();

    // Adding the new product to the Database with a repository function
    $repository->addItem($new_prod);

        echo "The new product: ". $item_name. " has been added to the database.<br><br>". "<button><a href='add_items.php'> Add More Items </a></button>";

    } else {
        echo "All fields are required and in the propper format! <br> Please try again.<br><br>". "<button><a href='add_items.php'> Add New Items </a></button>";
    }



include("public/footer.php");
?>
