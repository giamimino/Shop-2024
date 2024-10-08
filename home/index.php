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

function truncateText($text, $maxLength) {
    return strlen($text) > $maxLength ? substr($text, 0, $maxLength) . "..." : $text;
}

function truncateTexttitle($text, $maxLength) {
    return strlen($text) > $maxLength ? substr($text, 0, $maxLength) . "..." : $text;
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
        <br>
        <h1 id="section1">Phone</h1><hr>
        <div class="cards">
        <?php foreach($products as $i => $product) { 
                           // Check if the product category is 'phone'
    if ($product['category'] == 'phone') {
?>
        <div class="card">
            <?php if ($product['image']): ?>
            <img class="iMg" src="<?php echo '../admin/php/'.$product['image'] ?>" alt="<?php echo $product['title'] ?>" style="width: 100%;">
            <?php endif; ?>
            <div class="title"><?php echo truncateTexttitle($product['title'], 13) ?></div>
            <div id="description" class="description"><?php echo truncateText($product['description'], 60) ?></div>
            <a href="../product-main/./product.php?id=<?php echo $product['id']; ?>" class="addCart">
            <div class="price"><?php echo $product['price'].'$' ?></div>
            <i class="fa-solid fa-cart-plus"></i>
            </a>
        </div>
<?php 
    }
} 
?>
        </div>
        <br>
        <h1 id="section2">Laptop</h1><hr>
        <div class="cards">
        <?php foreach($products as $i => $product) { 
                       // Check if the product category is 'laptop'
    if ($product['category'] == 'laptop') {
?>
        <div class="card">
            <?php if ($product['image']): ?>
            <img class="iMg" src="<?php echo '../admin/php/'.$product['image'] ?>" alt="<?php echo $product['title'] ?>" style="width: 100%;">
            <?php endif; ?>
            <div class="title"><?php echo truncateTexttitle($product['title'], 13) ?></div>
            <div id="description" class="description"><?php echo truncateText($product['description'], 60) ?></div>
            <a href="../product-main/./product.php?id=<?php echo $product['id']; ?>" class="addCart">
            <div class="price"><?php echo $product['price'].'$' ?></div>
            <i class="fa-solid fa-cart-plus"></i>
            </a>
        </div>
<?php 
    }
} 
?>
        </div>
        <br>
        <h1 id="section3">KeyBoard</h1><hr>
        <div class="cards">
        <?php foreach($products as $i => $product) { 
                              // Check if the product category is 'keyboard'
    if ($product['category'] == 'keyboard') {
?>
        <div class="card">
            <?php if ($product['image']): ?>
            <img class="iMg" src="<?php echo '../admin/php/'.$product['image'] ?>" alt="<?php echo $product['title'] ?>" style="width: 100%;">
            <?php endif; ?>
            <div class="title"><?php echo truncateTexttitle($product['title'], 13) ?></div>
            <div id="description" class="description"><?php echo truncateText($product['description'], 60) ?></div>
            <a href="../product-main/./index.php?id=<?php echo $product['id']; ?>" class="addCart">
            <div class="price"><?php echo $product['price'].'$' ?></div>
            <i class="fa-solid fa-cart-plus"></i>
            </a>
        </div>
<?php 
    }
} 
?>
        </div>
        <br>
        <h1 id="section4">Mouse</h1><hr>
        <div class="cards">
        <?php foreach($products as $i => $product) { 
                           // Check if the product category is 'mousse'
    if ($product['category'] == 'mouse') {
?>
        <div class="card">
            <?php if ($product['image']): ?>
            <img class="iMg" src="<?php echo '../admin/php/'.$product['image'] ?>" alt="<?php echo $product['title'] ?>" style="width: 100%;">
            <?php endif; ?>
            <div class="title"><?php echo truncateTexttitle($product['title'], 13) ?></div>
            <div id="description" class="description"><?php echo truncateText($product['description'], 60) ?></div>
            <a href="../product-main/product.php?id=<?php echo $product['id']; ?>" class="addCart">
            <div class="price"><?php echo $product['price'].'$' ?></div>
            <i class="fa-solid fa-cart-plus"></i>
            </a>
        </div>
<?php 
    }
} 
?>
        </div>
        <br>
        <h1 id="section5">headphones</h1><hr>
        <div class="cards">
        <?php foreach($products as $i => $product) { 
                                // Check if the product category is 'aiarpods'
    if ($product['category'] == 'headphones') {
?>
        <div class="card">
            <?php if ($product['image']): ?>
            <img class="iMg" src="<?php echo '../admin/php/'.$product['image'] ?>" alt="<?php echo $product['title'] ?>" style="width: 100%;">
            <?php endif; ?>
            <div class="title"><?php echo truncateTexttitle($product['title'], 13) ?></div>
            <div id="description" class="description"><?php echo truncateText($product['description'], 60) ?></div>
            <a href="../product-main/./product.php?id=<?php echo $product['id']; ?>" class="addCart">
            <div class="price"><?php echo $product['price'].'$' ?></div>
            <i class="fa-solid fa-cart-plus"></i>
            </a>
        </div>
<?php 
    }
} 
?>
        </div>
    </main>
</body>
<style>
    <?php include('./style.css'); ?>
</style>
<script>
    <?php include('./script.js'); ?>
</script>
</html>
