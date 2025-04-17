<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MAXXOUT | Leaderboard</title>
    <link rel="stylesheet" href="css/leaderboard.css?v=1.0">
</head>
<body>
    <header>
        <h1>🏆 MAXXOUT - Leaderboard</h1>
        <nav class="top-nav">
            <a href="dashboard.php">Nazad</a>
        </nav>
    </header>

    <div class="leaderboard-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Profil</th>
                    <th>Korisničko ime</th>
                    <th>Level</th>
                    <th>Challenges</th>
                    <th>Kod</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "maxxout");
                    $sql = "SELECT username, profile_picture, level, challenges_completed, user_code FROM users ORDER BY level DESC, challenges_completed DESC LIMIT 50";
                    $result = $conn->query($sql);
                    $rank = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$rank}</td>";
                        echo "<td><img src='" . htmlspecialchars($row['profile_picture']) . "' alt='Profil' class='profile-pic'></td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . $row['level'] . "</td>";
                        echo "<td>" . $row['challenges_completed'] . "</td>";
                        echo "<td>" . $row['user_code'] . "</td>";
                        echo "</tr>";
                        $rank++;
                    }
                    ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2025 MAXXOUT. All rights reserved.</p>
    </footer>
</body>
</html>
