<?php
// Define the path to the JSON data folder
// Dynamically navigate to the project root
$jsonDataPath = __DIR__ . '/../json_data/';
//
//// Define API endpoints
//$javaApiUrl = 'http://localhost:8080/api';
//
//// Function to send JSON to Java API
//function sendJsonToJava($jsonFilePath) {
//    $jsonData = file_get_contents($jsonFilePath);
//    $javaApiUrl = 'http://localhost:8080/api';
//
//    $ch = curl_init("$javaApiUrl/receive-json");
//    curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//    $response = curl_exec($ch);
//    curl_close($ch);
//
//    return $response;
//}
//
//// Function to receive JSON from Java API
//function receiveJsonFromJava($fileName) {
//    $javaApiUrl = 'http://localhost:8080/api';
//    $ch = curl_init("$javaApiUrl/send-json");
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
//
//    $response = curl_exec($ch);
//    curl_close($ch);
//
//    file_put_contents($GLOBALS['jsonDataPath'] . $fileName, $response);
//    return json_decode($response, true);
//}
//
//// Example usage: Sending and receiving JSON
//$sendResponse = sendJsonToJava($jsonDataPath . 'sales.json');
//echo "Response from sending JSON to Java: " . $sendResponse . PHP_EOL;
//
//$receivedData = receiveJsonFromJava('received_from_java.json');
//echo "Received JSON saved as 'received_from_java.json'" . PHP_EOL;

// Load JSON files
$productData = json_decode(file_get_contents($jsonDataPath . 'product.json'), true);
$continentData = json_decode(file_get_contents($jsonDataPath . 'continent.json'), true);
$salesData = json_decode(file_get_contents($jsonDataPath . 'sales.json'), true);
$bridgeData = json_decode(file_get_contents($jsonDataPath . 'bridge.json'), true);

// Helper: Map continents by ID
$continentMap = [];
foreach ($continentData as $continent) {
    $continentMap[$continent['CONTINENT_id']] = $continent['CONTINENT_name'];
}

// Helper: Map sales data to continents and products
$salesByProduct = [];
$salesByContinent = [];

foreach ($bridgeData as $bridge) {
    $sku = $bridge['SKU_id'];
    $continentId = $bridge['CONTINENT_id'];
    $salesId = $bridge['sales_id'];

    foreach ($salesData as $sale) {
        if ($sale['sales_id'] == $salesId) {
            $quarter = $sale['QUARTER'];
            $amount = $sale['AMOUNT'];
            $year = $sale['YEAR'];

            // Group by product
            $salesByProduct[$sku][$year][$quarter][] = $amount;

            // Group by continent
            $continentName = $continentMap[$continentId];
            $salesByContinent[$continentName][$year][$quarter][] = $amount;
        }
    }
}

// Calculate averages
function calculateAverages($data) {
    $averages = [];
    foreach ($data as $key => $years) {
        foreach ($years as $year => $quarters) {
            foreach ($quarters as $quarter => $values) {
                $averages[$key][$quarter] = array_sum($values) / count($values);
            }
        }
    }
    return $averages;
}

$productAverages = calculateAverages($salesByProduct);
$continentAverages = calculateAverages($salesByContinent);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Sales Statistics</h1>
<h2>Average Product Sales Per Quarter</h2>
<canvas id="productChart"></canvas>
<h2>Average Continent Sales Per Quarter</h2>
<canvas id="continentChart"></canvas>

<script>
    // Product Averages Data
    const productAverages = <?php echo json_encode($productAverages); ?>;
    const productLabels = Object.keys(productAverages);
    const productData = productLabels.map(product =>
        Object.values(productAverages[product])
    );

    // Continent Averages Data
    const continentAverages = <?php echo json_encode($continentAverages); ?>;
    const continentLabels = Object.keys(continentAverages);
    const continentData = continentLabels.map(continent =>
        Object.values(continentAverages[continent])
    );

    // Product Chart
    new Chart(document.getElementById('productChart'), {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: productLabels.map((label, index) => ({
                label: label,
                data: productData[index],
                backgroundColor: `rgba(75, 192, 192, 0.2)`,
                borderColor: `rgba(75, 192, 192, 1)`,
                borderWidth: 1,
            }))
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Continent Chart
    new Chart(document.getElementById('continentChart'), {
        type: 'line',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: continentLabels.map((label, index) => ({
                label: label,
                data: continentData[index],
                backgroundColor: `rgba(153, 102, 255, 0.2)`,
                borderColor: `rgba(153, 102, 255, 1)`,
                borderWidth: 1,
            }))
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>
