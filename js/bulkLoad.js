const MAX_TOTAL_SIZE = 5 * 1024 * 1024; // 5MB
let selectedFiles = [];

$(document).ready(function () {
  $("#fileInput").on("change", function (event) {
    const files = Array.from(event.target.files);

    files.forEach((file) => {
      if (
        selectedFiles.reduce((acc, f) => acc + f.size, 0) + file.size <=
        MAX_TOTAL_SIZE
      ) {
        selectedFiles.push(file);
      } else {
        alert(`File ${file.name} exceeds the total size limit of 5MB.`);
      }
    });

    renderFileList();
    updateTotalSize();
    $("#fileInput").val(""); // Clear file input to allow re-selection of the same file
  });

  $("#uploadForm").on("submit", function (event) {
    event.preventDefault();
    if (selectedFiles.length === 0) {
      alert("No files selected.");
      return;
    }

    const formData = new FormData();
    selectedFiles.forEach((file) => formData.append("files[]", file));

    // Send AJAX request to bulkdata_transferOOP.php
    $.ajax({
      url: "bulkdata_transferOOP.php",
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        // Handle success response
        console.log(response);
        //alert(response);
        $("#message").html(response);
      },
      error: function (xhr, status, error) {
        // Handle error response
        console.error(xhr.responseText);
        alert("An error occurred while uploading files.");
      },
    });
  });
});

function renderFileList() {
  $("#fileList").empty();
  selectedFiles.forEach((file, index) => {
    const fileDiv = $(
      `<div>${file.name} (${(file.size / 1024).toFixed(
        2
      )} KB) <button class="remove-btn" onclick="removeFile(${index})">Remove</button></div></br>`
    );
    $("#fileList").append(fileDiv);
  });
}

function removeFile(index) {
  selectedFiles.splice(index, 1);
  renderFileList();
  updateTotalSize();
}

function updateTotalSize() {
  const totalSize = selectedFiles.reduce((acc, file) => acc + file.size, 0);
  console.log(totalSize);
  if (totalSize > 0) {
    if (totalSize < 1024 * 1024) {
      $("#totalSize")
        .text(`Total size: ${(totalSize / 1024).toFixed(2)} KB`)
        .show();
    } else {
      $("#totalSize")
        .text(`Total size: ${(totalSize / (1024 * 1024)).toFixed(3)} MB`)
        .show();
    }
  } else {
    $("#totalSize").hide();
  }
}

/* MY VERSION THAT DIDNT WORK
// Accessing the DOM
let fileInput = document.querySelector("#fileInput");
let fileList = document.querySelector("#fileList");
let fileSize = document.querySelector("#totalSize");
let uploadForm = document.querySelector("#uploadForm");

const MAX_TOTAL_SIZE = 5 * 1024 * 1024; // 5MB
// An array to store the bulk files:
let selectedBulkFiles = [];

// Function that starts the process when a file has been chosen
function processFile() {
  const files = Array.from(event.target.files);
  //Adding the file contents to the selectedBulkFiles Array after checking the size limit of 5mb
  files.forEach((file) => {
    const totalSizeAfterAdding =
      selectedBulkFiles.reduce((acc, f) => acc + f.size, 0) + file.size;
    if (totalSizeAfterAdding <= MAX_TOTAL_SIZE) {
      selectedBulkFiles.push(file);
    } else {
      alert(
        `File "${file.name}" exceeds the size limit of ${MAX_TOTAL_SIZE}MB.`
      );
    }
  });
  displayFileSize();
  uploadFile();
}

// Function to upload the file, feturing a remove button if user wants to cncel
function uploadFile() {
  fileList.innerHTML = ""; // Clear existing content

  selectedBulkFiles.forEach((file, index) => {
    const fileDiv = document.createElement("div");
    fileDiv.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;

    const removeButton = document.createElement("button");
    //   removeButton.classList.add('remove-btn'); // Later I'll Add class for styling
    removeButton.textContent = "Remove";
    removeButton.onclick = function () {
      removeFile(index);
    }; // Function onclick event!!

    fileDiv.appendChild(removeButton); // Adds the remove button to the div
    fileList.appendChild(fileDiv); // Adds the div to the fileList
  });
}

//Function to remove the recently selected ittems to upload
function removeFile(index) {
  // Implement logic to remove the file at index from selectedBulkFiles
  selectedBulkFiles.splice(index, 1);
  // Update UI to reflect the removal (optional)
}

// Function to Updte the size of the file
function displayFileSize() {
  const totalSize = selectedBulkFiles.reduce((acc, file) => acc + file.size, 0);

  if (totalSize > 0) {
    let fileSizeText;
    if (totalSize < 1024 * 1024) {
      fileSizeText = `Total size: ${(totalSize / 1024).toFixed(2)} KB`;
    } else {
      fileSizeText = `Total size: ${(totalSize / (1024 * 1024)).toFixed(3)} MB`;
    }
    fileSize.textContent = fileSizeText;
    fileSize.style.display = "block"; //'block' will display the element
  } else {
    fileSize.textContent = ""; // empty string to clear the field if it is above 5mb
    fileSize.style.display = "none"; // Hide the element
  }
}

// Function to send an asynchronous request to the bulk_update.php file
async function uploadAjaxFiles() {
  //Creating an Object to store each item
  const formData = new FormData();
  selectedBulkFiles.forEach((file) => formData.append("files[]", file));
  //fetch works like .ajax function
  try {
    const response = await fetch("bulk_update.php", {
      method: "POST",
      body: formData,
      cache: false,
    });
    // Error Handling
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const responseText = await response.text();
    console.log(responseText);
    $("#message").html(responseText);
  } catch (error) {
    console.error("Error uploading files:", error);
    alert("An error occurred while uploading files.");
  }
}

// Event Listeners:
fileInput.addEventListener(change, processFile);

//Submit button > invokes the AJAX call
uploadForm.addEventListener("submit", function (event) {
  event.preventDefault();
  if (selectedBulkFiles.length === 0) {
    alert("No files selected.");
    return;
  }
  uploadAjaxFiles();
});

*/

/*
For Object Oriented Refactoring
Design
1. Identify Domains
2. Identify Proceses 
3. Identify Interactions
4. Identify Integrations


There are 4 domains:
Domain: Grocery Inventory (3 Classes)
  Classes (GroceryInventory, GroceryItem(abstract), Product)

    Product class
        Attributes: 
          -name, -id, -stock, -type, -price, 
        Methods: 
          Accessors: +get name, +get id, +get stock, +get type, +get price
          Mutators: +set name, +set id, +set stock, +set type, +set price
          +displayProductInfo
    InventoryItem sub class
          Attributes:
            -expiryDate, -stock
          Methods: 
            Accessors: +get expiryDate, +get stock
            Mutators: +set expiryDate, +set stock

Domain Order Management
  Classes (OrderManagementSystem, Order, Customer, SalesRecord)
    Order class
        Attributes: 
          -id -customer -subtotal -InventoryItems[]
        Methods: 
          +get id, +get id, +get id, +get subtotal
          +set id, +set id, +set id, +set subtotal
          +calculate total

Domain: Data Transfer 
  Classes (Data Transfer Component(abstract - to transfer csv, json, xml),
  ProductTransfer(extension of DTF))
      BulkDataTransferComponent class
        Methods:
        +uploadFile

Domain: Storage Management

Min 5 classes

*/
