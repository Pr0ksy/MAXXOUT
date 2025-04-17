<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username_or_email']) && isset($_POST['password'])) {
        $username_or_email = $_POST['username_or_email'];
        $password = $_POST['password'];

        $conn = new mysqli("localhost", "root", "", "maxxout");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (filter_var($username_or_email, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM users WHERE email = ?";
        } else {
            $sql = "SELECT * FROM users WHERE username = ?";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username_or_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];

                header("Location: index.php");
                exit(); 
            } else {
                $error = "Pogrešna lozinka.";
            }
        } else {
            $error = "Korisnik nije pronađen.";
        }

        $conn->close();
    } else {
        $error = "Molimo vas da unesete korisničko ime ili email i lozinku.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css?v=1.0">
    <title>MAXXOUT | Login</title>
</head>
<body>
    
    <div class="login-container">
    <form method="post" action="login.php">
        <a href="index.php"><img src="images/maxxout-logo.png" alt="Fitness Image"></a>
        <h2>Prijavite se</h2>
        <input type="text" name="username_or_email" placeholder="Korisničko ime ili Email" required><br>
        <input type="password" name="password" placeholder="Lozinka" required><br>
        <button type="submit">Prijavi se</button>
        <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <p class="register-link">Nemate nalog? <a href="register.php">Registrujte se</a></p>
    </form>
    </div>

</body>
</html>
