VEGAN HEAVEN SUPPLY - Item Management System V3

Item Management System V3 - In Development still!!!

Roger Paredes
N016022084
July 15, 2024


// Data Structures:
- Repository Pattern to fetch items from db
- Associative Array for item details.
- Indexed Array to hold item names.

// Persistent Data
- mySQL database (local or remote, yet to be implemented for some functions)
	OLD data, but still used for certain tasks:
	- Json file to store the item list across sessions and networks.
	- Json file to store the item list across sessions and networks.
	- Json file to store the orders.

// Classes
- Database_connection
- Repository
- Product
- Inventory 
- BulkLoad
- Order
- Cart


// File Structure and sequences (OLD, to be updated):
	Root
		- database folder
			- item_database_v2.json > stores the items in json format.
		- public folder (included in every file)
			- header.php > holds the navigation menu to access each of the processes.
			- footer.php > copyright info.

		- images folder
			- GroceryStoreBrand.png

		- styles folder
			- style.css

		- js folder
			-scriptOOP.js > holds javascript that acts on order_process.php with AJAX and avoids creating more files
			-bulkLoad.js > sends AJAX call to bulkLoad class to handle loading files of items.

		- uploads folder
			- Stores the json, xml and csv files that where "bulk loaded" into the inventory.

		- files folder
			- Stores product files to test the bulk upload.

		(ADDING PROCESS)
		- add_items.php > initial form to add items to the grocery store, sends a POST request that will be used to create a Product object.
		- add_process.php > will validate the inputs and call the Inventory function to add items to the database.
		
		(BULK LOAD ADDING PROCESS)
		- add_items.php > at the lower end holds a form to add json, csv or xml files that will be handled asynchronously by bulkLoad.js
		- bulkdata_transferOOP.php > will create a BulkLoad oject that will validate and store the new items as well as the uploaded file.

		(LISTING PROCESS)
		- item_names.php > will list only item names through an Inventory class method.
		- item_details.php > will list item details through an Inventory class method.

		(NAVIGATION)
		- index.php > homepage of the system

		(EXPIRY CHECK PROCESS)
		- expiry_check.php > will load the expiration check throughout the items

		(STOCK EDITING PROCESS)
		- edit_stock.php > will start the process of editing stock
		- edit_stock2.php > will process the stock editing
		- edit_stock3.php > will finalize and update the item_database_v2.json file

		(PLACING ORDERS PROCESS)
		- place_order.php > starts a new order with customer name and order id fields with simple validation.
		- order_processOOP.php > has 2 steps
			STEP 1 
			> allows a search of items (dataList() Inventory method) and is aided by javascript AJAX (scriptOOP.js)
			> retrieves the current stock
			> populates the right column of the page with selected items with Javascript.
			> a Review Order button will send an array with the Cart items and the Order info to Step 2
			STEP 2 
			> a new Order object will be created with order info as well as a Cart object with selected items info.
			> a summary of the selected items, individual cost and total cost is displayed in a tabular format with Cart class methods.
			> a Place Order button will send a POST request with all the cart items and order info to the final file
		- order_process2OOP.php > saves the order file into the orders.json and removes the cart items from the inventory (validating stock).

		(SALES REPORT PROCESS)
		- sales_report.php > Display the orders.json file in a table format through an Order class method.