//package API;
//
//import io.javalin.Javalin;
//import io.javalin.http.Context;
//
//import java.io.*;
//import java.util.HashMap;
//import java.util.Map;
//
//public class RestController {
//
//    public static void main(String[] args) {
//        // Initialize Javalin
//        Javalin app = Javalin.create(config -> {
//            config.enableCorsForAllOrigins(); // Enable CORS for all origins
//        }).start(8080); // Start server on port
//
//        // Define endpoints
//        app.get("/api/send-json", RestController::sendJsonFile); // Send JSON file data
//        app.post("/api/receive-json", RestController::receiveJsonFile); // Receive JSON file data
//
//        System.out.println("Javalin app started on http://localhost:8080/");
//    }
//
//    // Endpoint to send JSON data
//    public static void sendJsonFile(Context ctx) {
//        String filePath = "/Users/sotirispittokopitis/IdeaProjects/java_PHP/src/json_data/received_data.json";
//        File jsonFile = new File(filePath);
//
//        if (jsonFile.exists()) {
//            ctx.contentType("application/json");
//            ctx.result(readFileAsString(filePath)); // Read JSON file content and send as response
//        } else {
//            ctx.status(404).json(Map.of("status", "error", "message", "File not found"));
//        }
//    }
//
//    // Endpoint to receive JSON data
//    public static void receiveJsonFile(Context ctx) {
//        try {
//            String filePath = "json_data/received_data.json"; // Save location for received JSON
//            String jsonData = ctx.body(); // Get JSON data from request body
//
//            writeStringToFile(filePath, jsonData); // Save JSON to file
//
//            ctx.status(200).json(Map.of("status", "success", "message", "JSON received and saved successfully"));
//        } catch (Exception e) {
//            ctx.status(500).json(Map.of("status", "error", "message", "Error saving JSON"));
//            e.printStackTrace();
//        }
//    }
//
//    // Utility method to read file content as string
//    private static String readFileAsString(String filePath) {
//        try (BufferedReader br = new BufferedReader(new FileReader(filePath))) {
//            StringBuilder sb = new StringBuilder();
//            String line;
//            while ((line = br.readLine()) != null) {
//                sb.append(line).append("\n");
//            }
//            return sb.toString();
//        } catch (IOException e) {
//            e.printStackTrace();
//            return null;
//        }
//    }
//
//    // Utility method to write string content to file
//    private static void writeStringToFile(String filePath, String content) {
//        try (BufferedWriter bw = new BufferedWriter(new FileWriter(filePath))) {
//            bw.write(content);
//        } catch (IOException e) {
//            e.printStackTrace();
//        }
//    }
//}
