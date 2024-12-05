package myJava;

import java.sql.*;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.JsonObject;
import com.google.gson.JsonArray;

public class MySQLConnectionTest {
    // Database connection details
    private static final String DB_URL = "jdbc:mysql://localhost:3306/sales_db"; // Replace `sales_db` with your database name
    private static final String DB_USER = "root"; // Replace with your MySQL username
    private static final String DB_PASSWORD = "12345678"; // Replace with your MySQL password

    public static void main(String[] args) {
        Connection connection = null;
        try {
            // Attempt to connect to the database
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            if (connection != null) {
                System.out.println("Connection to MySQL database successful!");

                // Ensure the 'json_data' directory exists
                File jsonDir = new File("json_data");
                if (!jsonDir.exists()) {
                    if (jsonDir.mkdir()) {
                        System.out.println("Created directory: json_data");
                    } else {
                        System.err.println("Failed to create directory: json_data");
                        return;
                    }
                }

                // Export tables to JSON files in 'json_data'
                exportTableToJSON(connection, "PRODUCT", "json_data/product.json");
                exportTableToJSON(connection, "CONTINENT", "json_data/continent.json");
                exportTableToJSON(connection, "SALES", "json_data/sales.json");
                exportTableToJSON(connection, "BRIDGE", "json_data/bridge.json");

                System.out.println("Data exported to JSON files successfully.");
            }
        } catch (SQLException e) {
            // Print the error if connection fails
            System.err.println("Connection failed!");
            e.printStackTrace();
        } finally {
            // Close the connection if it was successful
            if (connection != null) {
                try {
                    connection.close();
                    System.out.println("Connection closed.");
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            }
        }
    }

    private static void exportTableToJSON(Connection connection, String tableName, String fileName) {
        String query = "SELECT * FROM " + tableName;
        try (Statement stmt = connection.createStatement(); ResultSet rs = stmt.executeQuery(query)) {
            // Convert ResultSet to JSON
            JsonArray jsonArray = new JsonArray();
            ResultSetMetaData metaData = rs.getMetaData();
            int columnCount = metaData.getColumnCount();

            while (rs.next()) {
                JsonObject rowObject = new JsonObject();
                for (int i = 1; i <= columnCount; i++) {
                    String columnName = metaData.getColumnName(i);
                    Object value = rs.getObject(i);
                    rowObject.addProperty(columnName, value != null ? value.toString() : null);
                }
                jsonArray.add(rowObject);
            }

            // Write JSON array to file with pretty printing
            try (FileWriter fileWriter = new FileWriter(fileName)) {
                Gson gson = new GsonBuilder().setPrettyPrinting().create(); // Enable pretty printing
                gson.toJson(jsonArray, fileWriter);
            }

            System.out.println("- Exported " + tableName + " to: " + fileName);
        } catch (SQLException | IOException e) {
            e.printStackTrace();
        }
    }
}
