<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthdate'];


    $upload_dir = 'images/profile_pics/';
    $profile_picture = $_POST['existing_profile_picture'] ?? 'images/user_picture.jpg';
    
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
    
        $file_extension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    
        if (in_array($file_extension, $allowed_extensions)) {
            $new_file_name = uniqid('avatar_', true) . '.' . $file_extension;
            $file_path = $upload_dir . $new_file_name;
    
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
                $profile_picture = $file_path;
            }
        }
    }
    $conn = new mysqli("localhost", "root", "", "maxxout");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, birthdate = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $username, $email, $first_name, $last_name, $birthdate, $profile_picture, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "<br>Profil je uspešno ažuriran!";
    } else {
        $_SESSION['message'] = "Došlo je do greške prilikom ažuriranja profila.";
    }
    $_SESSION['role'] = $user['role'];

    
    $conn->close();

    header("Location: dashboard.php");
    exit();
}

?>
