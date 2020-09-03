<?php
session_start();
include_once 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
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
        <h1>Checkout</h1>
    </div>
  </div>
  <form action="order.php" method="post">
  <div class="row">


  <div class="col-md-6">


    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Your name" name="name">
    </div>

    <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Your email" name="email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>

  <div class="form-group">
    <label for="address">Address</label>
    <textarea class="form-control" id="address" rows="3" name="address"></textarea>
  </div>



  </div>

    <div class="col-md-6">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">SL</th>
      <th scope="col">Product Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
  <?php
$i = 1;
$total = 0;
foreach ($_SESSION['cart'] as $row) {
    $conn = $pdo->open();

    $stmt = $conn->prepare("SELECT *  FROM products WHERE products.id=:id");
    $stmt->execute(['id' => $row['productid']]);
    $product = $stmt->fetch();
    $pdo->close();

    $subtotal = $product['price'] * $row['quantity'];
    $total += $subtotal;

    ?>
    <tr>
      <th scope="row"><?php echo $i; ?></th>
      <td><?php echo $product['title']; ?></td>
      <td><?php echo $row['quantity']; ?></td>
      <td>$ <?php echo $subtotal; ?></td>
    </tr>
  <?php
$i++;
}?>
    <tr>
    <td colspan="3" style="text-align: right;">Total</td>
    <td><strong>$ <?php echo $total; ?></strong></td>
    </tr>
    <tr>
    <td colspan="3"></td>
    <td>
            <input type="hidden" name="price" value="<?php echo $total; ?>">
            <button type="submit" class="btn btn-primary" name="order">Pay Now</button>


    </td>
    </tr>

  </tbody>
</table>
    </div>

  </div>
  </form>
</div>

</body>
</html>