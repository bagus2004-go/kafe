<?php
$serverKey = 'SB-Mid-server-C1mZajAdcG3Xxo1gwVciSFnK';
$base64 = base64_encode($serverKey . ':');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$order_id = "ORDER-" . rand(1000,9999);
$gross_amount = (int) $input['total'];

$payload = [
    'transaction_details' => [
        'order_id' => $order_id,
        'gross_amount' => $gross_amount
    ],
    'customer_details' => [
        'first_name' => $input['name'],
        'email' => $input['email'],
        'phone' => $input['number']
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://app.sandbox.midtrans.com/snap/v1/transactions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic $base64",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
