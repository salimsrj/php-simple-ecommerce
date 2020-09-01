<?php
include_once 'card-add.php';

include_once 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ecommerce</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        <h1>Cart List</h1>
    </div>
    <div class="col-md-12">
        <span style="color: red;"><?php
if (isset($_SESSION['message'])) {

    echo '<div class="alert alert-danger" role="alert">
        ' . $_SESSION['message'] . '
      </div>';
    unset($_SESSION['message']);
}?>
        </span>
        <br>


    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
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
      <td>
      <form action="update-cart.php" method="post" style='display:flex;'>
      <button type="submit" class="btn btn-light" name="minus"><strong>-</strong></button>
      <input type="hidden" name="update_id" value="<?php echo $product['id']; ?>">
      <input style="width: 75px; text-align: center !important;" type="number" class="form-control" id="qty_<?php echo $i; ?>" name="name" value="<?php echo $row['quantity']; ?>">
      <button type="submit" class="btn btn-light" name="plus"><strong>+</strong></button>
      </form>

      </td>
      <td>$ <?php echo $subtotal; ?></td>
      <td>
    <form action="delete-cart.php" method="post">
      <input type="hidden" name="removal_id" value="<?php echo $product['id']; ?>">
      <button type="submit" class="btn btn-danger" name="delete">X</button>
    </form>
    </td>
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
    <td colspan="2">
        <form action="checkout.php" method="post">
        <button type="submit" class="btn btn-primary" name="checkout">Checkout</button>
        </form>
    </td>
    </tr>

  </tbody>
</table>
    </div>
  </div>
</div>

</body>
</html>