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
    <title>DeviceDome</title>

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
<div class="master-container">
  <div class="card cart">
    <label class="title">Your cart</label>
    <div class="products">
      <div class="product" id="product">
      <?php if($product['image']): ?>
        <img src="<?php echo '../admin/php/'.$product['image'] ?>" alt="" class="iMg" style="width: 70px; border-radius: 8px;">
        <?php endif; ?>
        <div>
          <span><?php echo $product['title'] ?></span>
        </div>
        <div class="quantity">
          <button class="subtrac_minus">
            <svg fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" stroke="#47484b" d="M20 12L4 12"></path>
            </svg>
          </button>
          <label class="equali">1</label>
          <button class="plus-add">
            <svg fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" stroke="#47484b" d="M12 4V20M20 12H4"></path>
            </svg>
          </button>
        </div>
        <label class="price small" id="price"><?php echo $product['price'] . '$'; ?></label>
      </div>
    </div>
  </div>

  <div class="card checkout">
    <label class="title">Checkout</label>
    <div class="details">
      <span>Your cart subtotal:</span>
      <span id="subtotal">47.99$</span>
      <span>Discount through applied coupons:</span>
      <span id="discount">3.99$</span>
      <span>Shipping fees:</span>
      <span id="fees">4.99$</span>
    </div>
    <div class="checkout--footer">
      <label class="price" id="total"><sup>$</sup><?php echo $product['price']; ?></label>
      <button class="checkout-btn">Checkout</button>
    </div>
  </div>
</div>
    </main>
</body>
<style>
    <?php include("./style.css"); ?>
</style>
<script>
    <?php include("./script.js"); ?>
</script>
</html>