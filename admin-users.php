<?php
session_start();
$conn = new mysqli("localhost", "root", "", "maxxout");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['ban'])) {
    $ban_id = intval($_GET['ban']);
    $conn->query("UPDATE users SET is_banned = 1 WHERE id = $ban_id");
    header("Location: admin-users.php");
    exit();
}

$search = $_GET['search'] ?? '';
$search_query = $conn->real_escape_string($search);

$sql = "SELECT id, username, email, first_name, last_name, user_code, is_premium, level, is_banned 
        FROM users 
        WHERE username LIKE '%$search_query%' OR email LIKE '%$search_query%' 
        ORDER BY id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Korisnici</title>
    <link rel="stylesheet" href="css/admin-users.css?v=2.0">
</head>
<body>
    <div class="container">
        <a href="adashboard.php" class="back-arrow">← Nazad</a>
        <h1>👤 Korisnici - Admin Pregled</h1>

        <form method="GET">
            <input type="text" name="search" placeholder="Pretraga po korisničkom imenu ili emailu" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Pretraži</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Korisničko ime</th>
                <th>Email</th>
                <th>Ime i Prezime</th>
                <th>Level</th>
                <th>Status</th>
                <th>Profil</th>
                <th>Akcije</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="<?php echo $row['is_banned'] ? 'banned-row' : ''; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                <td><?php echo $row['level']; ?></td>
                <td>
                    <?php 
                        echo $row['is_banned'] 
                            ? '<span style="color: #ff4444;">Banovan</span>' 
                            : ($row['is_premium'] ? '<span class="premium">Premium</span>' : 'Free'); 
                    ?>
                </td>
                <td>
                    <a class="link-btn" href="user.php?code=<?php echo htmlspecialchars($row['user_code']); ?>" target="_blank">Public</a>
                </td>
                <td>
                    <?php if (!$row['is_banned']): ?>
                        <a class="ban-btn" href="?ban=<?php echo $row['id']; ?>" onclick="return confirm('Da li si siguran da želiš da banuješ korisnika?')">Ban</a>
                    <?php else: ?>
                        <span>-</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
