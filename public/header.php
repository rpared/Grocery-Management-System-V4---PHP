<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vegan Heaven Supply Management System </title>
    <link rel="stylesheet" href="styles/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/script.js" defer></script>
    <script src="./js/bulkLoad.js" defer></script>
    
  </head>

  <body>
    <nav>
    <a href="index.php"><img src="images\GroceryStoreBrand.png" alt="Vegan Heaven Supply Brand"></a>
        <h1>Item Management System <b style="color: #726658;">V4.0</b></h1>
        <div id="menu">
            <button><a href="add_items.php"> Add Items </a></button>
            <button><a href="edit_stock.php"> Edit Stock </a></button>
            <div id="drop-container">
              <button id="list_dropbtn" type="button" >List Items</button>
                <div class="list-dropdown">
                    <a href="item_names.php">Names</a>
                    <a href="item_details.php">Details</a>
                </div>
            </div>
            <button><a href="expiry_check.php"> Check Expiry Date </a></button>
            <button><a href="place_order.php"> Place Orders </a></button>
            <button><a href="sales_report.php"> Sales Report </a></button>
        </div>
    </nav>
    <main>
        
        <script>
          // Script for the dropdown button
            let dropdown = document.querySelector("#list_dropbtn");
          let listDropdown = document.querySelector(".list-dropdown");

          function displayOptions() {
            console.log("button clicked");
              listDropdown.style.display = listDropdown.style.display === "block" ? "none" : "block";
          }

          dropdown.addEventListener("click", displayOptions);

          document.addEventListener("click", function(event) {
              if (!dropdown.contains(event.target) && !listDropdown.contains(event.target)) {
                  listDropdown.style.display = "none";
              }
            });
    </script>