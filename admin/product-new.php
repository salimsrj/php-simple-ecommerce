<!DOCTYPE html>
<html lang="en">

<?php
include_once('../connection.php');


if(isset($_POST['new_product'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];


    $conn = $pdo->open();
    $stmt = $conn->prepare("INSERT INTO  products (title, description, price) VALUES (:title, :description, :price)");
	$stmt->execute(['title'=>$title, 'description'=>$description, 'price'=>$price]);
    $pdo->close();
}
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
        <h1>Add New Product</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
        <div class="new_product">
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Product Title" name="title" required>            
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Description" name="description">            
                </div>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" placeholder="Price" name="price" required>            
                </div>
                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-primary" name="new_product">Add Product</button>        	
                </div>
            </form>
       </div>
    </div>
  </div>
</div>

</body>
</html>