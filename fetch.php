<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['number'])) {
    echo json_encode(["status" => "error", "message" => "Please provide a number!"]);
    exit;
}

$number = $_GET['number'];
$url = "https://simdetail.pro/";
$data = "number=" . urlencode($number);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.6723.70 Safari/537.36"
]);
curl_setopt($ch, CURLOPT_REFERER, "https://simdetail.pro/");

$response = curl_exec($ch);
curl_close($ch);

if (!$response) {
    echo json_encode(["status" => "error", "message" => "Failed to fetch data."]);
    exit;
}

// Extracting Required Data
$pattern = '/<div class="response">(.*?)<\/div>/s';
preg_match($pattern, $response, $matches);

if (isset($matches[1])) {
    echo json_encode(["status" => "success", "data" => $matches[1]]);
} else {
    echo json_encode(["status" => "error", "message" => "No data found!"]);
}
?>
