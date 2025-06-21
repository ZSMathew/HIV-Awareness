<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];

    $apiUrl = "https://api.azampesa.co.tz/v1/payment"; // Replace with real AzamPesa endpoint
    $apiKey = "YOUR_API_KEY";
    $merchantId = "YOUR_MERCHANT_ID";

    $payload = [
        "amount" => $amount,
        "msisdn" => $phone, // phone number
        "merchant_id" => $merchantId,
        "reference" => uniqid("TXN_"),
        "description" => "Website Payment"
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode == 200) {
        echo "Payment request sent successfully!";
        echo "<br>Response: $response";
    } else {
        echo "Failed to send payment. Status Code: $statusCode<br>";
        echo "Response: $response";
    }
}
?>