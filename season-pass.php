<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "maxxout");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, season_points, has_season_pass FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('SQL error: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Error fetching data: ' . $conn->error);
}

$user = $result->fetch_assoc();

$has_pass = $user['has_season_pass'];

$sql_pass = "SELECT * FROM season_pass_rewards ORDER BY points_required ASC";
$result_pass = $conn->query($sql_pass);

$user_id = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "maxxout");
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$conn->close();

$season_points = $user['season_points'];
$goal = 5000;
$progress_percentage = ($season_points / $goal) * 100;
$_SESSION['role'] = $user['role'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/seasonpass.css?v=2.0">
    <title>Season Pass - MAXXOUT</title>
</head>
<body>
    <header>
        <h1>MAXXOUT - Season Pass</h1>
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

        <section class="season-pass">
    <?php if ($has_pass): ?>
        <h2>Your Current Season Points</h2>
        <div class="progress-container">
            <div id="progress-bar" style="width: <?php echo $progress_percentage; ?>%;"></div>
        </div>    
        <br>
        <p>Season Points: <?php echo $season_points; ?> / <?php echo $goal; ?> points</p>
        <br>
        <h3>Available Rewards:</h3>
        <ul class="rewards-list">
            <?php 
            $result_pass->data_seek(0);
            while ($reward = $result_pass->fetch_assoc()): ?>
                <li>
                    <div class="reward">
                        <p>Reward: <?php echo $reward['reward_name']; ?></p>
                        <p>Points Required: <?php echo $reward['points_required']; ?></p>
                        <?php if ($season_points >= $reward['points_required']): ?>
                            <button class="claim-btn">Claim Reward</button>
                        <?php else: ?>
                            <br>
                            <p class="not-available">Not enough points to claim this reward.</p>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
        <br>                       
        <h3>How to Earn Points:</h3>
        <br>
        <div class="dots">
            <ul>
                <li>Complete daily challenges</li>
                <li>Earn points for workouts</li>
                <li>Engage with exclusive events</li>
            </ul>
        </div>
    <?php else: ?>
        <div class="no-pass">
            <h2>Season Pass Required</h2>
            <p>You don't have access to the Season Pass. Purchase it to unlock rewards and start earning points!</p>
            <br>
            <a href="shop.php"><button class="buy-btn">Buy Season Pass</button></a>
        </div>
    <?php endif; ?>
    </section>
    <?php if ($has_pass): ?>
    <div id="countdown">
    <span class="countdown-item">
        <span id="days">00</span>d
    </span>
    <span class="countdown-item">
        <span id="hours">00</span>h
    </span>
    <span class="countdown-item">
        <span id="minutes">00</span>m
    </span>
    <span class="countdown-item">
        <span id="seconds">00</span>s
    </span>
    </div>
    <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 MAXXOUT. All rights reserved.</p>
    </footer>

    <script src="js/season-pass.js"></script>
</body>
</html>
