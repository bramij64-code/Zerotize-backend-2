<?php
session_start();
$reason = $_GET['reason'] ?? '';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পেমেন্ট ব্যর্থ</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .error { color: #dc3545; font-size: 24px; }
    </style>
</head>
<body>
    <div class="error">❌ পেমেন্ট ব্যর্থ হয়েছে</div>
    
    <div style="margin: 20px;">
        <?php
        if (isset($_SESSION['payment_error'])) {
            echo "<p>" . $_SESSION['payment_error'] . "</p>";
            unset($_SESSION['payment_error']);
        } elseif ($reason == 'pending') {
            echo "<p>আপনার পেমেন্টটি পেন্ডিং অবস্থায় রয়েছে। কিছুক্ষণ পর আবার চেক করুন।</p>";
        } elseif ($reason == 'api_error') {
            echo "<p>পেমেন্ট স্ট্যাটাস চেক করতে সমস্যা হচ্ছে। অনুগ্রহ করে কিছুক্ষণ পর আবার চেষ্টা করুন।</p>";
        } else {
            echo "<p>দুঃখিত, আপনার পেমেন্ট প্রক্রিয়া সম্পন্ন হয়নি। অনুগ্রহ করে আবার চেষ্টা করুন।</p>";
        }
        ?>
    </div>
    
    <a href="index.html">পুনরায় চেষ্টা করুন</a>
    <br><br>
    <a href="mailto:support@yourcompany.com">সাপোর্টে যোগাযোগ করুন</a>
</body>
</html>
