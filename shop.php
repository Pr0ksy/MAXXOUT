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

$sql = "SELECT * FROM users WHERE id = ?";
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
$_SESSION['role'] = $user['role']; 

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shop.css?v=2.0">
    <title>Shop - MAXXOUT</title>
</head>
<body>
    <header>
        <h1>MAXXOUT - Shop</h1>
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

        <section class="shop-products">
            <h2>Available Products</h2>
            <br>
            <div class="product-list">
                <?php
                $conn = new mysqli("localhost", "root", "", "maxxout");
                $sql = "SELECT * FROM products"; 
                $result = $conn->query($sql);
                
                if ($result === false) {
                    die('Error fetching products: ' . $conn->error); 
                }
                
                while($product = $result->fetch_assoc()) {
                    echo "<div class='product-item'>";
                    echo "<img src='" . htmlspecialchars($product['image_url']) . "' alt='" . htmlspecialchars($product['name']) . "'>";
                    echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
                    echo "<p>" . htmlspecialchars($product['description']) . "</p>";
                    echo "<p>$" . htmlspecialchars($product['price']) . "</p>";
                    echo "<button class='buy-button'>Buy Now</button>";
                    echo "</div>";
                }
                $conn->close();
                ?>
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
