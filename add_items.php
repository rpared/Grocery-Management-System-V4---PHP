<?php
# this adds the html head to this php file, so the code doest have to be repeated each time
 include("public/header.php");
?>

<h2>Add Individual Items</h2>
<form action="add_process.php" method="POST">

        <label for="Item">Id:</label>
        <input id="Id" type="text" name="Id" placeholder="003 (use a 5-digit number)" pattern="^\d{1,5}$" title="ID should be a 1-5 digit number" required />
        <label for="Name">Item Name:</label>
        <input id="Name" type="text" name="Name" placeholder="Product name with spaces and special chars" pattern="^[A-Za-z0-9\s\W]+$" title="Product name can include letters, numbers, spaces, and special characters" required />
        <label for="Brand">Item Brand:</label>
        <input id="Brand" type="text" name="Brand" placeholder="Brand name with spaces and special chars" pattern="^[A-Za-z0-9\s\W]+$" title="Brand name can include letters, numbers, spaces, and special characters" required />
        <label for="Category">Item Category:</label>
        <input id="Category" type="text" name="Category" placeholder="Plant-based meat" pattern="^[A-Za-z0-9\s\W]+$" title="Category can include letters, numbers, spaces, and special characters" required />
        <label for="UnitPrice">Item Unit Price:</label>
        <input style="width: 50%;" id="UnitPrice" type="text" name="UnitPrice" placeholder="99.55" pattern="^\d+(\.\d{1,2})?$" title="Unit price should be a number with up to two decimal places" required />
        <label for="Expiry">Expiry Date:</label>
        <input style="width: 50%;" id="Expiry" type="date" name="Expiry" required />
        <label for="Stock">Stock:</label>
        <input style="width: 30%;" id="Stock" type="text" name="Stock" pattern="^\d+$" title="Stock should be a positive integer" required />
        
        <button type="submit" value="submit">Add Item</button>
      </form>

      <!-- This form is dynamically handed by bulkLoad.js script -->
       <br><br>
      <h2>Add File of Items (Bulk Load)</h2>
      <form id="uploadForm" enctype="multipart/form-data">
            <input style="min-width: fit-content; grid-column: span 2;" type="file" id="fileInput" name="files[]" multiple accept=".csv, .json, .xml">
            
            <div class="file-list" id="fileList"></div>
            
            <button style="grid-column: 1;" type="submit">Upload</button>
        </form>
        <br>
        <p class="note">Files can not exceed 5MB for a single upload.</p>
        <p class="total-size" id="totalSize">Total size: <b>0 KB</b></p>
        <p id="message"></p>
        <p><?php 
        if (isset($data)) {
        var_dump($data);
        }
        ?></p>


<?php
# this adds the html footer to this php file
include("public/footer.php");
?>