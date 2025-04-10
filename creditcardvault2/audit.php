<?php
require 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'auditor') {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT u.username, a.action, a.timestamp, a.details FROM auditlog a JOIN users u ON a.user_id = u.user_id");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audit Logs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Audit Logs</h1>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3">Username</th>
                    <th class="p-3">Action</th>
                    <th class="p-3">Timestamp</th>
                    <th class="p-3">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo htmlspecialchars($log['username']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($log['action']); ?></td>
                        <td class="p-3"><?php echo $log['timestamp']; ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($log['details']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="block text-center text-blue-500 mt-4">Back to Dashboard</a>
    </div>
</body>
</html>