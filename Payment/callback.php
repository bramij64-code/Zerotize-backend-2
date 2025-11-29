<?php
session_start();
require_once 'config.php';

// Get payment_id from URL or session
$payment_id = $_GET['payment_id'] ?? ($_SESSION['payment_data']['payment_id'] ?? '');

if (empty($payment_id)) {
    header('Location: payment-failed.php?reason=invalid_payment_id');
    exit();
}

// Prepare status check data
$status_data = array(
    "account_id" => 2nCMkoit,
    "secret_key" => dUxHh7OtxSckjBYm,
    "payment_id" => $payment_id
);

// Call status API
$api_data = array('fetch_payment' => $status_data);
$response = callZerotizeAPI(ZEROTIZE_STATUS_URL, $api_data);

// Handle response
if (isset($response['error'])) {
    header('Location: payment-failed.php?reason=api_error');
    exit();
}

if ($response && isset($response['status'])) {
    switch($response['status']) {
        case 'success':
            // Payment successful
            $_SESSION['payment_success'] = true;
            $_SESSION['payment_details'] = $response['payment_data'] ?? array();
            header('Location: payment-success.php');
            break;
            
        case 'failed':
            // Payment failed
            $_SESSION['payment_error'] = $response['message'] ?? 'Payment failed';
            header('Location: payment-failed.php');
            break;
            
        case 'pending':
            // Payment pending
            $_SESSION['payment_pending'] = true;
            header('Location: payment-failed.php?reason=pending');
            break;
            
        default:
            header('Location: payment-failed.php?reason=unknown_status');
    }
} else {
    header('Location: payment-failed.php?reason=invalid_response');
}
exit();
?>
