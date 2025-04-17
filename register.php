<?php
session_start();

function generateUserCode($conn, $length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    
    do {
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, $charactersLength - 1)];
        }

        $check = $conn->prepare("SELECT id FROM users WHERE user_code = ?");
        $check->bind_param("s", $code);
        $check->execute();
        $check_result = $check->get_result();
    } while ($check_result->num_rows > 0);

    return $code;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];

    $profile_picture = 'images/user_picture.jpg';

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'images/profile_pics/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
    
        $extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('avatar_', true) . '.' . $extension;
        $file_path = $upload_dir . $file_name;
    
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
            $profile_picture = $file_path;
        } else {
            echo "❌ Ne mogu da pomerim fajl! Proveri dozvole foldera.<br>";
        }
    } else {
        echo "⚠️ Profilna slika nije izabrana ili je došlo do greške u uploadu. Kod greške: " . $_FILES['profile_picture']['error'] . "<br>";
    }

    $conn = new mysqli("localhost", "root", "", "maxxout");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_code = generateUserCode($conn);

    $sql = "INSERT INTO users (username, email, password, first_name, last_name, birthdate, gender, profile_picture, user_code)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $username, $email, $password, $first_name, $last_name, $birthdate, $gender, $profile_picture, $user_code);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Registracija je uspešna!";
        header("Location: login.php"); 
        exit();
    } else {
        $_SESSION['message'] = "Greška prilikom registracije: " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css?v=1.0">
    <title>MAXXOUT | Register</title>
</head>
<body>
    <br>
    <br>
    <br>
    <br>
<div class="register-container">
  <form method="post" action="" enctype="multipart/form-data">
    <a href="index.php"><img src="images/maxxout-logo.png" alt="Fitness Image"></a>
    <h2>Registruj se</h2>
    <input type="text" name="username" placeholder="Korisničko ime" required><br>
    <input type="text" name="first_name" placeholder="Ime" required><br>
    <input type="text" name="last_name" placeholder="Prezime" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Lozinka" required><br>
    <label for="profile_picture">Profilna slika (opciono):</label>
    <input type="file" name="profile_picture" id="profile_picture"><br>
    <input type="date" name="birthdate" placeholder="Datum rođenja" required min="1960-01-01" max="2010-12-31"><br>
    <select name="gender" required>
      <option value="male">Muški</option>
      <option value="female">Ženski</option>
      <option value="other">Drugi</option>
    </select><br>
    <button type="submit">Registruj se</button>
  </form>
</div>
</body>
</html>

