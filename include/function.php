<?php
// API কল ফাংশন
function callZerotizeAPI($url, $data) {
    $ch = curl_init($url);
    $payload = json_encode($data);
    
    curl_setopt_array($ch, [
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => IS_LIVE, // লাইভে true, টেস্টে false
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        logError("cURL Error: " . $error);
        return ['error' => $error];
    }
    
    curl_close($ch);
    return json_decode($result, true);
}

// পেমেন্ট আইডি জেনারেট
function generatePaymentID() {
    return 'PAY_' . date('YmdHis') . '_' . rand(1000, 9999);
}

// লগ ফাংশন
function logError($message) {
    $logFile = __DIR__ . '/../logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

// সিকিউরিটি ফাংশন
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// রিডাইরেক্ট ফাংশন
function redirect($url) {
    header("Location: $url");
    exit();
}

// JSON রেসপন্স
function jsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
?>
