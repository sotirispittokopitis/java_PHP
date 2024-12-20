## MySQL Database:
Credentials used:
- Database Name: sales_db
- MySQL User: root
- Password: 12345678

## Setup Instructions for MySQL: (Part 1)
- Start MySQL Server (if it's not running already)
- Connect to the MySQL server via MySQL Workbench.
- Import the SQL dump file (located in the src directory and named MySQL_DumpData) using the Data Import feature in MySQL Workbench."

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

## Running the Project:
Step 1: Run the Shell Script To execute the project, run the RunMe.sh script from the terminal: 
```bash
cd src
./RunMe.sh
```
(Part 2 and 3 of the assigned tasks)

## ADDITIONAL WORK: (PART 4/ UNFINISHED)
Description: Javalin and REST in the Project
Javalin Framework
- Javalin is a lightweight and flexible web framework for Java. It simplifies the creation of REST APIs and web applications. In this project, Javalin is used to define RESTful endpoints that allow interaction between the server (Java application) and the client (e.g., PHP or browser).

In this project:
* GET /api/send-json: Retrieves a JSON file from the server.
* POST /api/receive-json: Accepts JSON data from the client and saves it to the server.

Controller in Javalin: In a typical web application, a controller is responsible for handling client requests and determining the appropriate response. In this project:
* The RestController class acts as the controller. (commented out)
* It defines the RESTful endpoints using Javalin’s app.get and app.post methods.

Changes in the PHP File
-  The PHP file interacts with the Javalin server through RESTful API calls. (commented out)

(This code establishes the interaction between the PHP application and the Javalin REST API, but it is currently unfinished. Although the connection is established, further preparation and debugging are required to ensure the proper sending and receiving of JSON between Java and PHP. Additional time is required to address the 'Not Found' issue and verify that all endpoints, file paths, and configurations are correctly set up.)
