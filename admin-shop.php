<?php
session_start();
$conn = new mysqli("localhost", "root", "", "maxxout");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");

if (isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image_url = $conn->real_escape_string($_POST['image_url']);

    $conn->query("INSERT INTO products (name, price, stock, image_url) VALUES ('$name', $price, $stock, '$image_url')");
    header("Location: admin-shop.php");
    exit();
}

if (isset($_POST['update_product'])) {
    $id = intval($_POST['edit_id']);
    $name = $conn->real_escape_string($_POST['edit_name']);
    $price = floatval($_POST['edit_price']);
    $stock = intval($_POST['edit_stock']);
    $image_url = $conn->real_escape_string($_POST['edit_image']);

    $conn->query("UPDATE products SET name = '$name', price = $price, stock = $stock, image_url = '$image_url' WHERE id = $id");
    header("Location: admin-shop.php");
    exit();
}

if (isset($_POST['delete_product'])) {
    $id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: admin-shop.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin | Shop Manager</title>
    <link rel="stylesheet" href="css/admin-shop.css?v=1.0">
</head>
<body>
    <div class="container">
        <a href="adashboard.php" class="back-arrow">← Nazad</a>
        <h1>🛒 Shop Manager</h1>
        <a onclick="openModal()" class="add-product-btn">➕ Dodaj novi proizvod</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Slika</th>
                <th>Naziv</th>
                <th>Cena</th>
                <th>Zaliha</th>
                <th>Akcije</th>
            </tr>
            <?php while($product = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><img src="<?php echo $product['image_url']; ?>" height="40"></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo $product['price']; ?> EUR</td>
                <td><?php echo $product['stock']; ?></td>
                <td class="action-icons">
                <a href="#" class="edit-btn" 
                    data-id="<?php echo $product['id']; ?>" 
                    data-name="<?php echo htmlspecialchars($product['name']); ?>"
                    data-price="<?php echo $product['price']; ?>"
                    data-stock="<?php echo $product['stock']; ?>"
                    data-image="<?php echo htmlspecialchars($product['image_url']); ?>">✏️</a>
                    <a href="#" class="delete-btn" data-id="<?php echo $product['id']; ?>">🗑️</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h2>➕ Dodaj proizvod</h2>
        <form method="POST">
            <label>Naziv proizvoda</label><br>
            <input type="text" name="name" required><br><br>

            <label>Cena (RSD)</label><br>
            <input type="text" name="price" required><br><br>

            <label>Zaliha</label><br>
            <input type="text" name="stock" required><br><br>

            <label>Slika (URL)</label><br>
            <input type="text" name="image_url"><br><br>

            <button type="submit" name="add_product">Dodaj</button>
        </form>
    </div>
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">×</span>
            <h2>✏️ Izmeni proizvod</h2>
            <form method="POST">
                <input type="hidden" name="edit_id" id="edit_id">

                <label>Naziv</label><br>
                <input type="text" name="edit_name" id="edit_name" required><br><br>

                <label>Cena (RSD)</label><br>
                <input type="text" name="edit_price" id="edit_price" required><br><br>

                <label>Zaliha</label><br>
                <input type="text" name="edit_stock" id="edit_stock" required><br><br>

                <label>Slika (URL)</label><br>
                <input type="text" name="edit_image" id="edit_image"><br><br>

                <button type="submit" name="update_product">Sačuvaj izmene</button>
            </form>
        </div>
    </div>
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">×</span>
            <h2>🗑️ Obrisati proizvod?</h2>
            <form method="POST">
                <input type="hidden" name="delete_id" id="delete_id">
                <button type="submit" name="delete_product" class="ban-btn">Obriši</button>
            </form>
        </div>
    </div>
    <script src="js/add-product.js"></script>
</body>
</html>