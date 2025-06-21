<?php
// Collect form input
$amount = $_POST['amount'];
$customer = $_POST['customer'];

// Transaction info
$merchantId = "YOUR_MERCHANT_ID";
$terminalId = "YOUR_TERMINAL_ID";
$apiKey     = "YOUR_API_KEY"; // Provided by Selcom
$orderId    = uniqid("ORD_");
$timestamp  = date("YmdHis");

// Create payload
$data = [
    "merchant"       => $merchantId,
    "terminal"       => $terminalId,
    "order_id"       => $orderId,
    "amount"         => $amount,
    "customer"       => $customer,
    "currency"       => "TZS",
    "description"    => "Website Payment",
    "redirect_url"   => "https://yourdomain.com/success.php",
    "cancel_url"     => "https://yourdomain.com/cancel.php",
];

// JSON encode
$jsonData = json_encode($data);

// Calculate Signature (SHA256 of json + apiKey)
$signature = hash('sha256', $jsonData . $apiKey);

// Send to Selcom
$ch = curl_init("https://apigw.selcommobile.com/v1/payment/initiate"); // Example URL
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Signature: ' . $signature
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
$response = curl_exec($ch);
curl_close($ch);

// Handle response
$res = json_decode($response, true);
if (isset($res['payment_url'])) {
    // Redirect user to Selcom payment page
    header("Location: " . $res['payment_url']);
    exit;
} else {
    echo "Error: ";
    print_r($res);
}
?>