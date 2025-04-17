<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$user_id = $_SESSION['user_id'];
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
    <meta http-equiv="refresh" content="30">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css?v=2.0">
    <title>My Account - MAXXOUT</title>
</head>
<body>
    <header>
        <h1>MAXXOUT - My Account</h1>
        <nav class="top-nav">
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
            <div class="burger-menu" id="burger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="mobilemenu" id="mobilemenu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="season-pass.php">Season Pass</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="yourplan.php">Your Plan</a></li>
                <li><a href="user.php?code=<?php echo $user['user_code']; ?>" target="_blank">Public Profile</a></li>
                <li><a href="dashboard.php">Edit Profile</a></li>
            </ul>
            </div>
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
            <br>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <h3>Admin Links</h3>
            <ul>
                <li><a href="adashboard.php">Admin Dashboard</a></li>
            </ul>
        <?php endif; ?>
        </section>
        
        <section class="my-profile">
            <h2>Your Profile</h2>

            <p><strong>Your User Code:</strong> <?php echo !empty($user['user_code']) ? htmlspecialchars($user['user_code']) : 'N/A'; ?></p>

            <form method="POST" action="update-profile.php" enctype="multipart/form-data">
                <img src="<?php 
                echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/profile_pics/'; 
                ?>" alt="Profile Picture" class="profile-img">

                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

                <label for="birthdate">Birthdate</label>
                <input type="date" name="birthdate" id="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>

                <input type="hidden" name="existing_profile_picture" value="<?php echo htmlspecialchars($user['profile_picture']); ?>">

                <label for="profile_picture">Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture">

                <button type="submit">Update Profile</button>
            </form>

            <?php
            if (isset($_SESSION['message'])) {
                echo "<p>{$_SESSION['message']}</p>";
                unset($_SESSION['message']);
            }
            ?>
        </section>
    </div>
    <br>
    <footer>
        <p>&copy; 2025 MAXXOUT. All rights reserved.</p>
    </footer>

    <script src="js/dashboard.js"></script>
</body>
</html>
