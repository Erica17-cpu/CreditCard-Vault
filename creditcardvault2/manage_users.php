<?php
require 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT user_id, username, role, email, created_at FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Users</h1>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3">ID</th>
                    <th class="p-3">Username</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo $user['user_id']; ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($user['username']); ?></td>
                        <td class="p-3"><?php echo $user['role']; ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="p-3"><?php echo $user['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="block text-center text-blue-500 mt-4">Back to Dashboard</a>
    </div>
</body>
</html>