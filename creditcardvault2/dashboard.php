<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Welcome, <?php echo $role; ?>!</h1>
        <div class="grid grid-cols-1 gap-4">
            <?php if ($role == 'admin' || $role == 'merchant'): ?>
                <a href="insert.php" class="bg-blue-600 text-white p-4 rounded hover:bg-blue-700 text-center">Add New Customer Card</a>
            <?php endif; ?>
            <a href="retrieve.php" class="bg-green-600 text-white p-4 rounded hover:bg-green-700 text-center">View Stored Cards</a>
            <?php if ($role == 'admin'): ?>
                <a href="manage_users.php" class="bg-purple-600 text-white p-4 rounded hover:bg-purple-700 text-center">Manage Users</a>
            <?php endif; ?>
            <?php if ($role == 'auditor'): ?>
                <a href="audit.php" class="bg-yellow-600 text-white p-4 rounded hover:bg-yellow-700 text-center">View Audit Logs</a>
            <?php endif; ?>
            <a href="logout.php" class="bg-red-600 text-white p-4 rounded hover:bg-red-700 text-center">Logout</a>
        </div>
    </div>
</body>
</html>