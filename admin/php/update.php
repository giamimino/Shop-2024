<?php 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=deciveDome', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

$id = $_GET['id'] ?? null;
if(!$id) {
    header('Location: admin.php');
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
    header('Location: admin.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <!--****** style ********-->
    <link rel="stylesheet" href=".././style./update.css">

    <!--****** JavaScript ********-->
    <script src="../script/update.js" defer></script>

    <!--****** Bootstrap ********-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--******** scrollbar ******-->
    <?php include('../.././assets/scrollbar/scrollbar.php'); ?>

</head>
<body>


<h1>Edit Product: <b><?php echo htmlspecialchars($title) ?></b></h1>

<p>
    <a href="admin.php" type="button" class="btn btn-sm btn-danger">Cancel</a>
</p>

<form method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product Image</label>
    <?php if ($imagePath): ?>
        <img src="<?php echo $imagePath ?>" alt="<?php echo htmlspecialchars($title) ?>" style="width: 100px; margin-bottom: 10px;">
    <?php endif; ?>
    <input type="file" name="image" class="form-control">
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product Title</label>
    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title) ?>" required>
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product Description</label>
    <textarea name="description" class="form-control"><?php echo htmlspecialchars($description) ?></textarea>
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product is sale</label>
    <input type="text" maxlength="3" placeholder="yes or no..." name="isSale" class="form-control" value="<?php echo htmlspecialchars($isSale) ?>" required>
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product category</label>
    <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($category) ?>" required>
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product Price</label>
    <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($price) ?>" required>
  </div>

  <button type="submit" style="margin-top: 10px;" class="btn btn-primary">Submit</button>
</form>

    
</body>
</html>