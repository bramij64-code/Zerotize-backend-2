<?php
session_start();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পেমেন্ট সফল</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .success { color: #28a745; font-size: 24px; }
        .details { background: #f8f9fa; padding: 20px; margin: 20px auto; max-width: 500px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="success">✅ পেমেন্ট সফল হয়েছে!</div>
    
    <div class="details">
        <h3>পেমেন্ট বিবরণ</h3>
        <?php
        if (isset($_SESSION['payment_details'])) {
            $details = $_SESSION['payment_details'];
            echo "<p><strong>ট্রানজেকশন ID:</strong> " . ($details['transaction_id'] ?? 'N/A') . "</p>";
            echo "<p><strong>পরিমাণ:</strong> ₹" . ($details['amount'] ?? 'N/A') . "</p>";
            echo "<p><strong>পেমেন্ট তারিখ:</strong> " . ($details['payment_date'] ?? 'N/A') . "</p>";
            
            // Clear session data
            unset($_SESSION['payment_details']);
            unset($_SESSION['payment_success']);
        } else {
            echo "<p>পেমেন্ট বিবরণ লোড করা যাচ্ছে না</p>";
        }
        ?>
    </div>
    
    <a href="index.html">আরও পেমেন্ট করুন</a>
</body>
</html>
