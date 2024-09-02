<?php 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=deciveDome', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$statement = $pdo->prepare('SELECT * FROM products');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

$title = '';
$description = '';
$price = '';
$imagePath = '';
$isSale = '';
$category = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');
    $isSale = $_POST['isSale'];
    $category = $_POST['category'];

    // Handle image upload
    $image = $_FILES['image'] ?? null;
    if ($image && $image['tmp_name']) {
        $imagePath = 'assets/image/' . time() . '-' . $image['name'];
        mkdir(dirname($imagePath));
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO products (title, description, price, image, create_date, isSale, category) 
                            VALUES (:title, :description, :price, :image, :date, :isSale, :category)");

    // Bind parameters
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':image', $imagePath);
    $stmt->bindValue(':date', $date);
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
    <link rel="stylesheet" href=".././style./create.css">

    <!--****** JavaScript ********-->
    <script src=".././script/create.js" defer></script>

    <!--****** Bootstrap ********-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--******** scrollbar ******-->
    <?php include('../.././assets/scrollbar/scrollbar.php'); ?>

</head>
<body>


<h1>Create new Product</h1>

<p>
    <a href="admin.php" type="button" class="btn btn-sm btn-danger">Cancel</a>
</p>

<form method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product Image</label>
    <input type="file" name="image" class="form-control">
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product Title</label>
    <input type="text" name="title" class="form-control" value="<?php echo $title ?>" required>
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product Description</label>
    <textarea type="text" name="description" class="form-control"><?php echo $description ?></textarea>
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product is sale</label>
    <input type="text" maxlength="3" placeholder="yes or no..." name="isSale" class="form-control" value="<?php echo $isSale ?>" required>
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product category</label>
    <input type="text" name="category" class="form-control" value="<?php echo $category ?>" required>
  </div>

  <div class="form-group">
    <label style="margin: 10px 0 5px 0;">Product Price</label>
    <input type="number" name="price" class="form-control" value="<?php echo $price ?>" required>
  </div>

  <button type="submit" style="margin-top: 10px;" class="btn btn-primary">Submit</button>
</form>

    
</body>
</html>