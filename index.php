<!DOCTYPE html>
<html lang="en">

<?php
include_once('connection.php');
$conn = $pdo->open();

	try{
        $stmt = $conn->prepare("SELECT * FROM products");	
        $stmt->execute();
		    $products = $stmt->fetchAll();
		
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	$pdo->close();
?>
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
  <?php
  session_start();
  if(isset($_SESSION['cart'])){
    print_r($_SESSION['cart']);
  }
  ?>
</div>
</div>
  <div class="row">
    <div class="col-md-12">
        <h1>Product List</h1>
    </div>
  </div>
  <div class="row">
  <?php foreach($products as $product){ ?>
    <div class="col-md-4">
        <div class="product-box">
            <h2><?php echo $product['title']; ?></h2> 
            <div class="product_img">
                <img src="https://via.placeholder.com/300x250?text=Product One" alt="">
            </div>
            <div class="price_box">
                <span>$<?php echo $product['price']; ?></span>
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
  <?php } ?>
  </div>
</div>

</body>
</html>