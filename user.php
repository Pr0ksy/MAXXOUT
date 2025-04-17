<?php
$conn = new mysqli("localhost", "root", "", "maxxout");

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $user['challenges_completed'] = $user['challenges_completed'] ?? 0;
        $user['is_premium'] = $user['is_premium'] ?? 0;
        $user['level'] = $user['level'] ?? 0;
    } else {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Korisnik nije pronađen</title>
            <style>
                body {
                    background-color: #121212;
                    color: #fff;
                    font-family: "Segoe UI", sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    text-align: center;
                }
                .error-box {
                    background-color: #1e1e1e;
                    padding: 40px;
                    border-radius: 12px;
                    box-shadow: 0 0 15px rgba(1, 241, 53, 0.1);
                }
                .error-box h1 {
                    font-size: 32px;
                    margin-bottom: 15px;
                    color:rgb(86, 221, 74);
                }
                .error-box p {
                    font-size: 18px;
                    color: #aaaaaa;
                }
                .error-box a {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    background: linear-gradient(135deg, #1db340, #2d9e6b);
                    color: #000;
                    border-radius: 8px;
                    text-decoration: none;
                    font-weight: bold;
                    transition: 0.3s;
                }
                .error-box a:hover {
                    background-color: #e6c200;
                }
            </style>
        </head>
        <body>
            <div class="error-box">
                <h1>Korisnik nije pronađen</h1>
                <p>Kod je neispravan ili profil ne postoji.</p>
                <a href="index.php">Nazad na početnu</a>
            </div>
        </body>
        </html>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MAXXOUT | <?php echo htmlspecialchars($user['username']); ?></title>
    <link rel="stylesheet" href="css/publicprofile.css?v=1.0">
</head>
<body>
<div class="profile-container">
        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-img">
        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
        <br>
        <p><?php echo htmlspecialchars($user['first_name']); ?> <?php echo htmlspecialchars($user['last_name']); ?></p>
        <p>User Code: <?php echo htmlspecialchars($user['user_code']); ?></p>

        <div class="info-grid">
            <div class="card">
                <h3>Level</h3>
                <p><?php echo $user['level']; ?></p>
            </div>
            <div class="card">
                <h3>Challenges</h3>
                <p><?php echo $user['challenges_completed']; ?></p>
            </div>
            <div class="card">
                <h3>Status</h3>
                <p><?php echo ($user['is_premium']) ? '<p style="color: #e6c200;">Premium</p>' : 'Free'; ?></p>
            </div>
        </div>
    </div>

    <div class="achievements-section">
        <h3>🏅 Achievements</h3>
        <div class="badges-container">
            <?php if ($user['level'] >= 1): ?>
            <div class="badge-card">
                <img src="images/maxxout-logo.png" alt="Level 1">
                <p>Beginner</p>
            </div>
            <?php endif; ?>
            <?php if ($user['challenges_completed'] >= 1): ?>
            <div class="badge-card">
                <img src="images/maxxout-logo.png" alt="First Challenge">
                <p>First Challenge</p>
            </div>
            <?php endif; ?>

            <?php if ($user['is_premium']): ?>
            <div class="badge-card">
                <img src="images/maxxout-logo.png" alt="Premium Member">
                <p>Premium</p>
            </div>
            <?php endif; ?>

            <?php if ($user['level'] >= 10): ?>
            <div class="badge-card">
                <img src="images/maxxout-logo.png" alt="Level 10 Achieved">
                <p>Level 10+</p>
            </div>
            <?php endif; ?>
            
            <?php if ($user['challenges_completed'] >= 10): ?>
            <div class="badge-card">
                <img src="images/maxxout-logo.png" alt=" 10 Challenges">
                <p>10+ Challenges</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
