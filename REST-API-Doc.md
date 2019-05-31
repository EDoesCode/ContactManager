# REST API Endpoints
1. Name: Register New Account \
   URL: https://cop4331.a2hosted.com/api/Register.php \
   Method: POST \
   JSON To Send: 
   ```
   curl -d '{ "FirstName" : "Mark",
              "LastName" : "Fuller",
              "AccountName" : "username",
              "Password" : "hashed-password"
            }' 
   -H 'Content-Type: application/json' 
   https://cop4331.a2hosted.com/api/Register.php
   ```
   Invalid Responses: 
   ```
   { "error" : "Missing required fields" }
   { "error" : "Duplicate entry 'mfuller' for key 'AccountName'" }
   { "error" : "Access denied for user 'copahost_dbuser1'@'localhost' (using password: YES)" }
   ```
   
   
2. Name: Login User \
   URL: https://cop4331.a2hosted.com/api/Login.php \
   Method: POST
   ```
   curl -d '{ "AccountName" : "login-name",
              "Password" : "hashed-password"
            }' 
   -H 'Content-Type: application/json' 
   https://cop4331.a2hosted.com/api/Login.php
   ```
   Invalid Responses: 
   ```
   { "error" : "Missing required fields" }
   { "error" : "Invalid user name or password" }
   ```

3. Name: Show All Contacts For User \
   URL: https://cop4331.a2hosted.com/api/ShowContacts.php \
   Method: POST
   ```
   curl -d '{ }' 
   -H 'Content-Type: application/json' 
   https://cop4331.a2hosted.com/api/ShowContacts.php
   ```
   Invalid Responses: 
   ```
   { "error" : "Authorization required" }
   { "error" : "No Records Found"}
   ```
   
   4. Name: Search for a Contact \
   URL: https://cop4331.a2hosted.com/api/FilterContacts.php \
   Method: POST
   ```
   curl -d '{ "SearchText" : "Orlando" }' 
   -H 'Content-Type: application/json' 
   https://cop4331.a2hosted.com/api/FilterContacts.php
   ```
   Invalid Responses: 
   ```
   { "error" : "Authorization required"}
   { "error" : "Missing required fields" }
   { "error" : "No Records Found" }
   ```

5. Name: Insert a Contact \
   URL: https://cop4331.a2hosted.com/api/InsertContact.php \
   Method: POST
   ```
   curl -d '{ "FirstName" : "Mark",
              "LastName" : "Fuller",
              "Address1" : "9999 Street Dr.",
              "City" : "Orlando",
              "State" : "FL",
              "Zip" : "32822",
              "Phone" : "(407) 555-1212",
              "Email" : "user@example.com"
            }' 
   -H 'Content-Type: application/json' 
   https://cop4331.a2hosted.com/api/InsertContact.php
   ```
   Invalid Responses: 
   ```
   { "error" : "Authorization required"}
   { "error" : "Missing required fields" }
   ```
   
 
6. Name: Delete a Contact \
   URL: https://cop4331.a2hosted.com/api/DeleteContact.php \
   Method: POST
   ```
   curl -d '{ "ContactID" : "3" }' 
   -H 'Content-Type: application/json' 
   https://cop4331.a2hosted.com/api/DeleteContact.php
   ```
   Invalid Responses: 
   ```
   { "error" : "Authorization required"}
   { "error" : "Missing required fields" }
   ```
 
7. Name: Update a Contact \
   URL: https://cop4331.a2hosted.com/api/UpdateContact.php \
   Method: POST
   ```
   curl -d '{ "ContactID": "7",
              "FirstName": "Alan",
               "LastName": "Fuller",
               "Address1": "555 Street Dr.",
               "Address2": "",
               "City": "Orlando",
               "State": "FL",
               "Zip": "32822",
               "Email": " ",
               "Phone": " "
            }' 
   -H 'Content-Type: application/json' 
   https://cop4331.a2hosted.com/api/UpdateContact.php
   ```
   Invalid Responses: 
   ```
   { "error" : "Authorization required"}
   { "error" : "Missing required fields" }
   ```

  
