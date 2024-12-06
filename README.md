## MySQL Database:
Credentials used:
- Database Name: sales_db
- MySQL User: root
- Password: 12345678

## Setup Instructions for MySQL:
- Start MySQL Server (if it's not running already)
- Connect to the MySQL server via MySQL Workbench.
- Import the SQL dump using the Data Import feature in MySQL Workbench.

## Setup Instructions for Java and PHP source files:
Clone the Repository

## Libraries: 
Ensure the required .jar files are present in the lib/ directory.
- gson-2.11.0.jar 
- mysql-connector-j-9.1.0.jar


## Make the Shell Script Executable: 
Run the following command to make the RunMe.sh file executable (if necessary): 
```bash
chmod +x src/RunMe.sh 
```

## Running the Project 
Step 1: Run the Shell Script To execute the project, run the RunMe.sh script from the terminal: 
```bash
cd src
./RunMe.sh
```
## ADDITIONAL WORK (UNFINESHED)
Description: Javalin and REST in the Project
Javalin Framework
- Javalin is a lightweight and flexible web framework for Java. It simplifies the creation of REST APIs and web applications. In this project, Javalin is used to define RESTful endpoints that allow interaction between the server (Java application) and the client (e.g., PHP or browser).

In this project:
* GET /api/send-json: Retrieves a JSON file from the server.
* POST /api/receive-json: Accepts JSON data from the client and saves it to the server.

Controller in Javalin
-  In a typical web application, a controller is responsible for handling client requests and determining the appropriate response. In this project:
* The RestController class acts as the controller.
* It defines the RESTful endpoints using Javalin’s app.get and app.post methods.

Changes in the PHP File
-  The PHP file interacts with the Javalin server through RESTful API calls.

(
