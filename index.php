<!DOCTYPE html>
<html lang="en">

<?php
include_once 'connection.php';
$conn = $pdo->open();

try {
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "There is some problem in connection: " . $e->getMessage();
}

$pdo->close();
?>
<head>
  <title>Ecommerce</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="dist/assets/css/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="dist/assets/css/style.css"> 
</head>


<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="index.php">Home</span></a>
      <a class="nav-item nav-link" href="/cart.php">Cart</a>
    </div>
  </div>
  </div>
</nav>
<div class="container">
<div class="row">
<div class="col-md-12">
  <?php
session_start();

?>
</div>
</div>
  <div class="row">
    <div class="col-md-12">
        <h1>Product List</h1>
    </div>
  </div>
  <div class="row">
  <?php foreach ($products as $product) {?>
    <div class="col-md-4">
        <div class="product-box">
            <h2><?php echo $product['title']; ?></h2>
            <div class="product_img">
                <img src="dist/assets/img/product.png" alt="<?php echo $product['title']; ?>">
            </div>
            <div class="price_box">
                <span><?php echo $product['price']; ?> EUR</span>
            </div>
            <div class="add_to_cart">
            <form action="cart.php" method="post">
                <input type="hidden" value="<?php echo $product['id']; ?>" name="id">
                <input type="hidden" value="1" name="quantity">
                <button type="submit" class="btn btn-primary"> Add to Cart</button>
            </form>
            </div>
        </div>
    </div>
  <?php }?>
  </div>
</div>

</body>
</html>