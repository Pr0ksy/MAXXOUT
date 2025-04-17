<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "maxxout");

$sql = "SELECT * FROM user_plans WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$plan = $result->fetch_assoc();

if (!$plan) {
    $sql_default = "INSERT INTO user_plans (user_id, plan_type) VALUES (?, 'free')";
    $stmt_default = $conn->prepare($sql_default);
    $stmt_default->bind_param("i", $user_id);
    $stmt_default->execute();
    $plan = ['plan_type' => 'free'];  
}

$conn = new mysqli("localhost", "root", "", "maxxout");
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$_SESSION['role'] = $user['role'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/yplan.css?v=2.0">
    <title>Your Plan - MAXXOUT</title>
</head>
<body>
    <header>
        <h1>MAXXOUT - Your Plan</h1>
        <nav class="top-nav">
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="main-container">
    <section class="sidebar">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="season-pass.php">Season Pass</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="yourplan.php">Your Plan</a></li>
                <li><a href="user.php?code=<?php echo $user['user_code']; ?>" target="_blank">Public Profile</a></li>
                <li><a href="dashboard.php">Edit Profile</a></li>
            </ul>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <h3>Admin Links</h3>
            <ul>
                <li><a href="adashboard.php">Admin Dashboard</a></li>
            </ul>
        <?php endif; ?>
        </section>

        <section class="your-plan">
            <h2>Your Current Plan</h2>
            <br>
            <div class="plan-info">
                <?php if ($plan): ?>
                    <?php if ($plan['plan_type'] == 'free'): ?>
                        <p>You are currently on the Free Plan.</p>
                        <p>As a Free plan member, you can:</p>
                        <ul>
                            <li>Earn points for workouts</li>
                            <li>Unlock a limited selection of rewards</li>
                            <li>Access basic training programs</li>
                        </ul>
                        <br>
                        <p><a href="upgrade.php"><button>Upgrade to Premium</button></a></p>
                    <?php else: ?>
                        <p>You are currently on the Premium Plan.</p>
                        <p>Your plan expires on: 
                            <?php
                            if ($plan['expiration_date'] != NULL) {
                                echo date("F j, Y", strtotime($plan['expiration_date']));
                            } else {
                                echo "Not set";
                            }
                            ?>
                        </p>
                        <p>With the Premium plan, you get:</p>
                        <ul>
                            <li>Access to all rewards</li>
                            <li>Exclusive training programs</li>
                            <li>Priority customer support</li>
                        </ul>
                    <?php endif; ?>
                <?php else: ?>
                    <p>You have not selected a plan yet. <a href="upgrade.php">Upgrade to Premium</a></p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <div class="ftr">
    <footer>
        <p>&copy; 2025 MAXXOUT. All rights reserved.</p>
    </footer>
    </div>
</body>
</html>