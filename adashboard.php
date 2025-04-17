<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "maxxout");
$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT role FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

if ($user['role'] !== 'admin') {
    echo "Access denied.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | MAXXOUT</title>
    <link rel="stylesheet" href="css/adashboard.css?v=2.0">
</head>
<body>
    <header>
        <h1>MAXXOUT - Admin</h1>
        <nav>
            <br>
            <a href="index.php">Back to Home</a>
            <a href="logout.php" id="logout">Logout</a>
        </nav>
    </header>

    <div class="dashboard-container">
    <a href="admin-users.php" class="card-link">
    <div class="card">
        <h2>👤 Korisnici</h2>
        <br>
        <p>Pregled svih korisnika</p>
    </div>
    </a>

    <a href="admin-challenges.php" class="card-link">
        <div class="card">
            <h2>🧪 Izazovi</h2>
            <br>
            <p>Upravljanje izazovima</p>
        </div>
    </a>

    <a href="admin-rewards.php" class="card-link">
        <div class="card">
            <h2>🎁 Nagrade</h2>
            <br>
            <p>Upravljanje nagradama</p>
        </div>
    </a>

    <a href="admin-stats.php" class="card-link">
        <div class="card">
            <h2>📈 Statistika</h2>
            <br>
            <p>Pogledaj statistiku</p>
        </div>
    </a>

    <a href="admin-shop.php" class="card-link">
        <div class="card">
            <h2>🛒 Shop Manager</h2>
            <br>
            <p>Upravljaj proizvodima</p>
        </div>
    </a>

    <a href="admin-settings.php" class="card-link">
        <div class="card">
            <h2>⚙️ Postavke</h2>
            <br>
            <p>Season kontrola, sistemske opcije</p>
        </div>
    </a>
    </div>
</body>
</html>