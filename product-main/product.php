<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=decivedome', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

$id = $_GET['id'] ?? null;
if(!$id) {
    header('Location: .././home/home.php');
    exit;
}

// Fetch the product to edit
$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found";
    exit;
}

// Initialize variables with existing product data
$title = $product['title'];
$description = $product['description'];
$price = $product['price'];
$imagePath = $product['image'];
$isSale = $product['isSale'];
$category = $product['category'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $isSale = $_POST['isSale'];
    $category = $_POST['category'];

    // Handle image upload
    $image = $_FILES['image'] ?? null;
    if ($image && $image['tmp_name']) {
        if ($imagePath) {
            unlink($imagePath); // Remove old image
        }
        $imagePath = 'assets/image/' . time() . '-' . $image['name'];
        mkdir(dirname($imagePath), 0777, true);
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    // Prepare SQL statement for update
    $stmt = $pdo->prepare("UPDATE products SET title = :title, description = :description, price = :price, isSale = :isSale, category = :category, image = :image WHERE id = :id");

    // Bind parameters
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':image', $imagePath);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':isSale', $isSale);
    $stmt->bindValue(':category', $category);

    // Execute the statement
    $stmt->execute();
    header('Location: .././home/index.php');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <!--****** style ********-->
    <link rel="stylesheet" href="./style.css">

    <!--****** JavaScript ********-->
    <script src="./script.js" defer></script>

    <!--****** Bootstrap ********-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- ******* FontAwesome ********* -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!--******** scrollbar ******-->
    <?php include('../assets/scrollbar/scrollbar.php'); ?>
</head>
<body>
    <!--*********** header ******** -->
    <?php include('../assets/header/header.html'); ?>

    <main>
        <div class="product-wrapper">
        <?php if($product['image']): ?>
        <img src="<?php echo '../admin/php/'.$product['image'] ?>" alt="" class="iMg" style="width: 400px;">
        <?php endif; ?>
        <h1 class="title"><?php echo $product['title'] ?></h1>
        <p class="description"><?php echo $product['description'] ?></p>
        <p class="price"><?php echo $product['price'].'$' ?></p>
        <a href=".././cart/cart.php?id=<?php echo $product['id']; ?>" class="addCart">Add Cart</a>
        </div>
    </main>
    
</body>
<style>
    <?php include('./style.css') ?>
</style>
</html>