<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(SITE_URL);
}

// ডেটা ভ্যালিডেশন
$required = ['customer_name', 'customer_email', 'customer_phone', 'amount'];
foreach($required as $field) {
    if(empty($_POST[$field])) {
        jsonResponse(['error' => 'All fields are required']);
    }
}

$name = sanitizeInput($_POST['customer_name']);
$email = sanitizeInput($_POST['customer_email']);
$phone = sanitizeInput($_POST['customer_phone']);
$amount = floatval($_POST['amount']);
$purpose = sanitizeInput($_POST['purpose'] ?? 'Product Purchase');

// ভ্যালিডেশন
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['error' => 'Invalid email address']);
}

if ($amount < 1 || $amount > 100000) {
    jsonResponse(['error' => 'Amount must be between 1 and 100,000']);
}

// পেমেন্ট ডেটা প্রস্তুত
$payment_data = [
    "account_id" => 2nCMkoit,
    "secret_key" => dUxHh7OtxSckjBYm,
    "payment_id" => generatePaymentID(),
    "payment_purpose" => $purpose,
    "payment_amount" => $amount,
    "payment_name" => $name,
    "payment_phone" => $phone,
    "payment_email" => $email,
    "redirect_url" => SITE_URL . '/callback'
];

// API কল
$api_data = ['init_payment' => $payment_data];
$response = callZerotizeAPI(ZEROTIZE_API_URL, $api_data);

if (isset($response['error'])) {
    jsonResponse(['error' => 'Payment initiation failed: ' . $response['error']]);
}

if ($response && isset($response['status']) && $response['status'] == 'success') {
    // সেশন স্টোর
    $_SESSION['current_payment'] = $payment_data;
    jsonResponse(['success' => true, 'redirect_url' => $response['payment_url']]);
} else {
    $error_msg = $response['message'] ?? 'Unknown error occurred';
    jsonResponse(['error' => $error_msg]);
}
?>
