# MySQL Database Dump

This repository contains the SQL dump file for the `my_database` database. The dump includes the schema and data for the `PRODUCT`, `CONTINENT`, `BRIDGE`, and `SALES` tables.

---

## Files in This Repository
- **`database_dump.sql`**: The SQL dump file containing the database schema and data.

---

## Instructions to Use the Dump

### 1. Prerequisites
Before importing the dump file, ensure you have:
- **MySQL Server** installed on your machine.
- A MySQL client like **MySQL Workbench** or access to the MySQL CLI.
- Appropriate permissions to create and modify databases on your MySQL server.

### 2. Importing the Dump

#### Using MySQL Workbench
1. Open **MySQL Workbench** and connect to your MySQL Server.
2. Create a new database to restore the dump:
   ```sql
   CREATE DATABASE my_database_name;
