<?php
require_once("product_class.php");
require_once 'repository_class.php';

class Inventory {
    private $repository;
    private $item_details;
    private $item_names;

    public function __construct() {
        // Initialize repository
        $this->repository = new Repository();
        $this->item_details = $this->repository->fetchItems();
        $this->item_names = $this->repository->getItemNames();
    }

    // Function to check if ID is unique
    public function is_unique_id($id) {
        foreach ($this->item_details as $product) {
            if ($product['item_id'] === $id) {  // Assuming 'Id' is the key for item_id in fetchItems() result
                return false;
            }
        }
        return true;
    }

    // Function to populate Dropdown Select elements with options
    public function itemDropDown() {
      $item_droplist = $this->item_names;
      if (empty($item_droplist)) {
          echo '<option value="">No items found</option>'; // Display an error message
      } else {
          foreach ($item_droplist as $item_name) {
              echo "<option value=\"" . htmlspecialchars($item_name) . "\">" . htmlspecialchars($item_name) . "</option>";
          }
      }
    }


    // Function to populate Datalist with options
    public function itemDatalist() {
      $item_datalist = $this->item_details;
      foreach ($item_datalist as $product) {
          echo "<option value='" . htmlspecialchars($product["item_name"]) . "'>";
      }
    }

    //Function to Check for Expired Items

    //   this funtion will run a foreach loop and a if conditional to check if dates are lesser than the current one
    public function expiry_check($item_details) {
      //var_dump($item_details);
      $current_date_obj = new DateTime();  
        // Initialize an empty array to store expired items
      $expired_items = array();
      //$item_details = $this->item_details; //not needed
      foreach ($item_details as $product) {
      // Extracting the actual expiry date and save it to a variable
        $expiry_date = $product['item_expiry_date']; 
    
        // Convert both expiry date and current date to DateTime objects, otherwise nothing works, dont fully understand this ugh!!!
        $expiry_date_obj = new DateTime($expiry_date);
    
        //Populating the expired items array with a conditional
        if ($expiry_date_obj < $current_date_obj) {
          $expired_items[] = $product["item_name"] . " - expired on: " . "<span style='background-color: pink;'>".$product['item_expiry_date']."</span>"; // Add the item's name to expired items
        }
      }
      return $expired_items; // Return the array of expired items
    }




}

?>


<!--
 // OLD CODE before having a Database and a repository
$jsonFile = 'database/item_database_v2.json';
//No longer need: define('INVENTORY_FILE', 'database/item_database_v2.json');

class Inventory {
  private $jsonFile;
  // private $item_details;
 // Constructor fetches the json file with the inventory automatically
 // Saves the INventory in the $item_details associative array
  public function __construct() {
    global $jsonFile;
    $this->jsonFile = $jsonFile;
        $this->item_details = $this->fetch_json($this->jsonFile);

  }

// Function to Fetch existing JSON data
private function fetch_json($jsonFile) {
  return json_decode(file_get_contents($jsonFile), true);
}


/**
 * Updates JSON data with additions or stock change.
 * @param String 
 * @param array 
 */
public function update_json($jsonFile, $data) {
  file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
}

  // Function to check if ID is unique
  public function is_unique_id($id) {
    $item_details = $this->getItemDetails();
    foreach ($item_details ['items'] as $product) {
      if ($product['Id'] === $id) {
        return false;
      }
    }
    return true;
  }


// Function to get the $item_details Array Fetched from json file into an associative array
public function getItemDetails() {
      return $this-> item_details;
}


// Function to get the $item_namelist Array  and extracting just names
public function getItemNames() {
  $item_details = $this->getItemDetails();
  $names = [];
  foreach ($item_details['items'] as $product) {
      array_push($names, $product['Name']);
  } 
  // var_dump($names);
      return $names;
}

// Teachers code:
// function getInventory() {
//   if (file_exists(INVENTORY_FILE)) {
//       $json = file_get_contents(INVENTORY_FILE);
//       return json_decode($json, true);
//   } else {
//       return 
//           "No Inventory found"
//   }
// }

public function upload($data) {
  // Iterate over the items array
  global $jsonFile;
  foreach ($data as $items) {

        if (!is_array($items)) {
          throw new Exception("Invalid item format Ugh 😕 ");     
      }

      $id = $items['Id'];
      $name = $items['Name'];
      $category = $items['Category'];
      $brand = isset($items['Brand']) ? $items['Brand'] : '';
      $price = $items['Unit Price'];
      $expiry_date = isset($items['Expiry Date']) ? $items['Expiry Date'] : date("Y-m-d");
      $stock = $items['Stock'];

      array_push($this->item_details['items'], [
        "Id" => $id,
        "Name" => $name,
        "Category" => $category,
        "Brand" => $brand,
        "Unit Price" => $price,
        "Expiry Date" => $expiry_date,
        "Stock" => $stock
      ]);
      }

  $this->update_json($jsonFile, $this->item_details);

  return count($data);
}


 //Function to popullate Dropdown Select elements with options
 public function itemDropDown() {
  $item_droplist = $this->getItemDetails();
  if (empty($item_droplist)) {
    echo '<option value="">No items found</option>'; // Display an error message
  } else {
    foreach ($item_droplist["items"] as $product) {
      echo "<option value=\"" . $product["Name"] . "\">" . $product["Name"] . "</option>";
    }
  }
}


  //Function to popullate Datalist Select elements with options
public function itemDatalist(){
  $item_datalist = $this->getItemDetails();
  foreach ($item_datalist["items"] as $product){
    echo "<option value='". $product["Name"] ."'>";
  }
  }



/**
 * Adds a new item to the inventory.
 * @param Product $item The product object representing the item to add.
 * @throws Exception  If there's an error adding the item.
 */
public function addItem(Product $item) {
  try {
    global $jsonFile;
    $item_details = $this->item_details;
    // $item_names = getItemNames();
    $newItem = [
            "Id" => $item->getId(),
            "Name" => $item->getName(),
            "Category" => $item->getCategory(),
            "Brand" => $item->getBrand(),
            "Unit Price" => $item->getUnitPrice(),
            "Expiry Date" => $item->getExpiryDate(),
            "Stock" => $item->getStock()
    ];
    array_push($item_details['items'], $newItem);
    // array_push($item_names, $newItem['Name']);
    // var_dump($item_details);
    $this->update_json($jsonFile, $item_details);
    echo "<b> Successful Product Addition 😁 </b><br>";

  } catch (Exception $e) {
    throw new Exception("Error adding item: " . $e->getMessage());
  }
}

/**
 * Checks for the stock of an item in the inventory.
 * @param $selected_item is entered by the user.
 * @throws $inventory is the instance of the class or name of the object.
 */
public function getStockOOP($selected_item, $inventory){
  foreach ($inventory->item_details['items'] as $product){
    if ($selected_item === $product['Name']){
      return $product['Stock'];
    }
  }
}



/**
* Function to change the stock of a selected item
* @param $item_details is an array created with inventory_class instantiation, it is specified by reference to alter it
* @param $selected_item is a String entered by the user from a list
* @param $new_stock is an integer entered by th euser with the new stock
*/
  public function changeStock(&$inventory, $selected_item, $new_stock) {
    global $jsonFile;
      try {
        $itemsToUpdate = &$inventory->item_details['items']; // Get reference to items array
    
        foreach ($itemsToUpdate as &$product) { // Loop through items by reference
          if ($product["Name"] === $selected_item) {
            $product["Stock"] = $new_stock;
            break; // Exit loop after finding the item
          }
        }
        $this->update_json($jsonFile, $inventory->item_details); // Use the original $inventory object
        echo "<b> Successful Stock Change 😁 </b><br>";
      } catch (Exception $e) {
        throw new Exception("Error changing stock: " . $e->getMessage());
      }
  }
              // global $current_date_obj;
              // $current_date_obj = new DateTime();  
  
  //   this funtion will run a foreach loop and a if conditional to check if dates are lesser that the current one
    public function expiry_check($item_details) {
      $current_date_obj = new DateTime();  
        // Initialize an empty array to store expired items
    $expired_items = array();
      foreach ($item_details["items"] as $product) {
      // Extracting the actual expiry date and save it to a variable
        $expiry_date = $product["Expiry Date"]; 
    
        // Convert both expiry date and current date to DateTime objects, otherwise nothing works, dont fully understand this ugh!!!
        $expiry_date_obj = new DateTime($expiry_date);
    
        //Populating the expired items array with a conditional
        if ($expiry_date_obj < $current_date_obj) {
          $expired_items[] = $product["Name"] . " - expired on: " . "<span style='background-color: pink;'>".$product['Expiry Date']."</span>"; // Add the item's name to expired items
        }
      }
      return $expired_items; // Return the array of expired items
    }




}
// $ban = new Product ("77","Banana2","XXX","Fruit",2.99,"1-1-2024",7);
// // // echo $apple->getName();
//  $inventory = new InventoryManagement();
//  $inventory->addItem($ban);



?> -->



