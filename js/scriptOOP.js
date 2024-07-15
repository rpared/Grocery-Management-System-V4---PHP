//All the script in this file acts upon order_process.php

const searchInput = document.querySelector("#search-select");
let selectedDatalistValue = searchInput.value;
const resultDiv = document.getElementById("search-results");
const resultDivLabel = document.getElementById("search-results-label");

// This addEvent Listener finally works yeii, keyup is a good event for typing;
searchInput.addEventListener("keyup", () => {
  selectedDatalistValue = searchInput.value;
  console.log("addEventListener function invoked");
  console.log(selectedDatalistValue);
  select(); // Now it should contain the selected value
});

// Function that contains the fetch data AJAX function to retrieve the items stock
function select() {
  console.log("function invoked");
  console.log(selectedDatalistValue);

  async function fetchData() {
    try {
      const response = await fetch("./database/item_database_v2.json");
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const data = await response.json(); // Parse the JSON response
      // Loop through items and check for matching name
      let result = "No match found";
      for (const item of data.items) {
        if (item.Name === selectedDatalistValue) {
          result = `${item.Name} - ${item.Stock} in stock`;
          break; // Exit the loop after finding a match
        }
      }

      return result;
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  fetchData().then((data) => {
    resultDiv.innerHTML = data;
  });

  resultDivLabel.innerHTML = "Your selection:";
}

//

//Add to CaRT process for order_process.php:

let quantity = document.querySelector("#quantity");
let selectedQuantity = quantity.value;
let orderDetailsDiv = document.querySelector("#order-details");

//Creatinng an array to store the items in the cart, it will be passed to the next php file:
let orderDetail = [];

quantity.addEventListener("keyup", () => {
  console.log("add to cart triggerred");
  selectedQuantity = quantity.value;
  console.log("addEventListener function for quantity invoked");
  console.log("The Quantity value is: " + selectedQuantity);
});

//The table structure to display the cart items on the right:
orderDetailsDiv.innerHTML = `
  <table>
    <thead>
      <tr>
        <th>Item</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody id="orderDetailsTableBody"></tbody>  </table>
`;

// This funtion creates an object newItem, adds it to the array orderDetail
// and appends rows to the table on the right:
async function addToCart() {
  const newItem = {
    name: selectedDatalistValue,
    quantity: selectedQuantity,
  };

  // Include the order item newItem (object) into the array:
  orderDetail.push(newItem);

  // This is to send the entire cart to the next order_process.php step:
  document.querySelector("#order_items").value = JSON.stringify(orderDetail);

  const orderDetailsTableBody = document.getElementById(
    "orderDetailsTableBody"
  );
  const newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td>${newItem.name}</td>
    <td>${newItem.quantity}</td>
  `;
  orderDetailsTableBody.appendChild(newRow);
}
// the addToCart function will be called when the left addToCart button is clicked:
document.querySelector("#add-to-cart").addEventListener("click", addToCart);
