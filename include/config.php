<?php
// সার্ভার কনফিগারেশন
define('SITE_URL', 'https://yourdomain.com');
define('IS_LIVE', true); // true for production, false for testing

// Zerotize API Configuration
define('ZEROTIZE_API_URL', 'https://zerotize.in/api_payment_init');
define('ZEROTIZE_STATUS_URL', 'https://zerotize.in/api_payment_status');

// লাইভ vs টেস্ট ক্রেডেনশিয়াল
if(IS_LIVE) {
    define('ACCOUNT_ID', '2nCMkoit');
    define('SECRET_KEY', 'dUxHh7OtxSckjBYm');
} else {
    define('ACCOUNT_ID', 'YOUR_TEST_ACCOUNT_ID');
    define('SECRET_KEY', 'YOUR_TEST_SECRET_KEY');
}

// ডাটাবেস কনফিগারেশন (যদি প্রয়োজন)
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Error reporting
if(IS_LIVE) {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Timezone
date_default_timezone_set('Asia/Dhaka');
?>
