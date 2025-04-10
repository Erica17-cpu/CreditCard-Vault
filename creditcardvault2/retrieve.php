<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$stmt = $pdo->prepare("
    SELECT c.customer_id, c.ref_id, c.full_name, c.email, c.phone, c.address,
           AES_DECRYPT(cc.cardholder_name_enc, ?) AS cardholder_name,
           AES_DECRYPT(cc.card_number_enc, ?) AS card_number,
           AES_DECRYPT(cc.expiry_date_enc, ?) AS expiry_date,
           AES_DECRYPT(cc.cvv_enc, ?) AS cvv,
           cc.last_used
    FROM customers c
    LEFT JOIN creditcards cc ON c.customer_id = cc.customer_id
    WHERE c.user_id = ? OR ? = 'admin'
");
$stmt->execute([$encryption_key, $encryption_key, $encryption_key, $encryption_key, $user_id, $role]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("INSERT INTO auditlog (user_id, action, details) VALUES (?, ?, ?)");
$stmt->execute([$user_id, 'Viewed data', 'Retrieved customer records']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Cards</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Stored Customer Cards</h1>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3">Ref ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Cardholder</th>
                    <th class="p-3">Card Number</th>
                    <th class="p-3">Expiry</th>
                    <?php if ($role != 'support') echo '<th class="p-3">CVV</th>'; ?>
                    <th class="p-3">Last Used</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo htmlspecialchars($row['ref_id']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($row['cardholder_name']); ?></td>
                        <td class="p-3">
                            <?php echo $role == 'support' ? '****-****-****-' . substr($row['card_number'], -4) : htmlspecialchars($row['card_number']); ?>
                        </td>
                        <td class="p-3"><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                        <?php if ($role != 'support'): ?>
                            <td class="p-3"><?php echo htmlspecialchars($row['cvv'] ?: 'N/A'); ?></td>
                        <?php endif; ?>
                        <td class="p-3"><?php echo $row['last_used'] ?: 'Never'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="block text-center text-blue-500 mt-4">Back to Dashboard</a>
    </div>
</body>
</html>