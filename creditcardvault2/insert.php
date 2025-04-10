<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ref_id = 'CUST' . rand(100, 999);
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $cardholder_name = $_POST['cardholder_name'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO customers (user_id, ref_id, full_name, email, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $ref_id, $full_name, $email, $phone, $address]);
    $customer_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare("
        INSERT INTO creditcards (customer_id, cardholder_name_enc, card_number_enc, expiry_date_enc, cvv_enc, last_used)
        VALUES (?, AES_ENCRYPT(?, ?), AES_ENCRYPT(?, ?), AES_ENCRYPT(?, ?), AES_ENCRYPT(?, ?), NOW())
    ");
    $stmt->execute([$customer_id, $cardholder_name, $encryption_key, $card_number, $encryption_key, $expiry_date, $encryption_key, $cvv, $encryption_key]);

    $stmt = $pdo->prepare("INSERT INTO auditlog (user_id, action, details) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, 'Inserted card', "Card ID: $customer_id"]);

    $success = "Card stored successfully! Ref ID: $ref_id";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Customer Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Add Customer Card</h1>
        <?php if (isset($success)) echo "<p class='text-green-500 text-center'>$success</p>"; ?>
        <form method="POST" class="space-y-4">
            <input type="text" name="full_name" placeholder="Full Name" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" name="phone" placeholder="Phone" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <textarea name="address" placeholder="Address" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            <input type="text" name="cardholder_name" placeholder="Cardholder Name" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" name="card_number" placeholder="Card Number" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" name="expiry_date" placeholder="Expiry (MM/YY)" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" name="cvv" placeholder="CVV" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Save Card</button>
        </form>
        <a href="dashboard.php" class="block text-center text-blue-500 mt-4">Back to Dashboard</a>
    </div>
</body>
</html>