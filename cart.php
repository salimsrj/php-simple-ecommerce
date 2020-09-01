<?php
include_once('card-add.php');
?>
<?php
include_once('connection.php');
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
<div class="container">

  <div class="row">
    <div class="col-md-12">
        <h1>Cart List</h1>
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
    $stmt->execute(['id'=>$row['productid']]);
    $product = $stmt->fetch();
    $pdo->close();

    $subtotal =$product['price'] *  $row['quantity'];
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
} ?>
    <tr>
    <td colspan="3" style="text-align: right;">Total</td>
    <td><strong>$ <?php echo $total; ?></strong></td>
    </tr>
    <tr>
    <td colspan="3"></td>
    <td>
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