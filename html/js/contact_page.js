// Lists the various fields of a Contact in the order they are displayed
var dataMap = ["FirstName", "LastName", "Phone", "Email", "Address1", "Address2", "City", "State", "Zip"];

// Sends an XML post to the given API name using the given JS object as payload, and runs the provided function (reaction) on success
// If the XML post fails (for whatever reason) it outputs the text in the given error text field
function apiRequest(name, payload, errorField, reaction)
{
	var urlBase = "https://cop4331.a2hosted.com/api";
	var apiExtension = ".php";
	// Starting post request
	var url = urlBase + '/' + name + apiExtension;
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	
	// Defining reaction function
	xhr.onreadystatechange = reaction;
	
	// Sending JSON
	try
	{
		xhr.send(JSON.stringify(payload));
	}
	catch(err)
	{
		errorField.innerHTML = err.message;
	}
}

// Adds a contact
function addContact()
{
	// Building payload
	var payload = {
	FirstName:	document.getElementById("firstName"),
	LastName:	document.getElementById("lastName"),
	Address1:	document.getElementById("address1"),
	Address2:	document.getElementById("address2"),
	City:		document.getElementById("city"),
	State:		document.getElementById("state"),
	Zip:		document.getElementById("zip"),
	Phone:		document.getElementById("phone"),
	Email:		document.getElementById("email")
	};
	var errorField = document.getElementById("addText");
	apiRequest("InsertContact", payload, errorField, function() {
		var errorField = document.getElementById("addText");
		errorField.innerHTML = "Your contact has been added.";
	});
}


// Loads the full Contacts table
function getAllContacts()
{
	var payload = {};
	var errorField = document.getElementById("responseText");
	apiRequest("ShowContacts", payload, errorField, buildContactTable);
}
// Searches through the database for Contacts and updates the table 
function searchContacts()
{
	// Clearing error field
	var errorField = document.getElementById("responseText");
	errorField.innerHTML = "";
	var srch = document.getElementById("searchText").value;
	
	// Payload (to be JSONified later)
	var payload = {search: srch};
	apiRequest("FilterContacts", payload, errorField, buildContactTable);
}

// Builds contact table when called by a successful XML HTTP Request
function buildContactTable()
{
	if (this.readyState == 4 && this.status == 200) 
	{	
		// Reloading the contact list
		var contactList = JSON.parse( xhr.responseText );
		clearContactTable();
		var i;
		for (i=0; i<contactList.length; i++)
		{
			addContactRow(i, contactList[i]);
		}
	}
}

// Clears all rows (other than the header) from the Contact Table
function clearContactTable()
{
	var table = document.getElementById("contactTable");
	var rows = table.rows;
	var i;
	for (i = 1; i < rows; i++)
		table.removeChild(rows[i]);
}

// Transforms one Contact JSON into a row for contactTable and adds it
function addContactRow(rowNum, contact)
{
	// Creating a hashmap that holds the column of each element in the table
	
	// Adding the row to the table
	var table = document.getElementById("contactTable");
	var row = table.insertRow(rowNum);
	
	// Iterating through each of the cells
	var dataType, cell, i;
	for (i = 0; i < contact.length; i++)
	{
		dataType = dataMap[i];
		// ContactID is attached to the button and requires separate code
		if (dataType == "ContactID")
			continue;
		data = contact[dataType];
		cell = row.insertCell(i);
		cell.innerHTML = data;
		cell.dataType = dataType;
	}
	
	// The last button is a cell that links to a modification function
	cell = row.insertCell(i);
	var changeButton = document.createElement("BUTTON");
	// changeButton.contactID = contact["ContactID"];
	// changeButton.myRow = row;
	changeButton.setAttribute("contactID", contact["ContactID"]);
	changeButton.setAttribute("myRow", row);
	changeButton.innerHTML = "Change";
	changeButton.onClick = "makeChangeableRow()";
	cell.appendChild(changeButton);
}

// Transforms a row into a changeable row with input text fields
function makeChangeableRow()
{
	row = this.myRow;
	// Getting cells
	var cells = row.getElementsByTagName("td");
	var i;
	// Replacing text of cells with editable text fields
	for (i = 0; i < cells.length - 1; i++)
	{
		// Creating a text field within the cell 
		var textField = document.createElement("INPUT");
		textField.setAttribute("type", "text");
		//Gives each text field an ID that 
		textField.id = this.contactID + cells[i].dataType;
		textField.innerHTML = cells[i].innerHTML;
		cells[i].innerHTML = "";
		cells[i].appendChild(textField);
	}
	// Changing button functionality to saving changes
	this.innerHTML = "Save";
	this.onClick = "changeRow()";
}

// Modifies a contact changed in the table row
function modifyContact(row, contactID)
{
	// Building payload
	var payload = {
	FirstName:	document.getElementById(contactID+"firstName"),
	LastName:	document.getElementById(contactID+"lastName"),
	Address1:	document.getElementById(contactID+"address1"),
	Address2:	document.getElementById(contactID+"address2"),
	City:		document.getElementById(contactID+"city"),
	State:		document.getElementById(contactID+"state"),
	Zip:		document.getElementById(contactID+"zip"),
	Phone:		document.getElementById(contactID+"phone"),
	Email:		document.getElementById(contactID+"email")
	};
	var errorField = document.getElementById("responseField");
	apiRequest("UpdateContact", payload, errorField, function() {
		var errorField = document.getElementById("addText");
		errorField.innerHTML = "Your contact has been added.";
	});
}

// Swaps out the text fields in a changeable row for plaintext
function changeRow()
{
	row = this.myRow;
	modifyContact(row, this.contactID);
	// Getting cells
	var cells = row.getElementsByTagName("td");
	var i;
	// Replacing text fields with text
	for (i = 0; i < cells.length - 1; i++)
	{
		var textField = cells[i].firstChild;
		cells[i].innerHTML = textField.innerHTML;
		// Removing the text field
		cells[i].removeChild(textField);
	}
	// Returning original functionality to button
	this.innerHTML = "Change";
	this.onClick = "makeChangeableRow()";
}