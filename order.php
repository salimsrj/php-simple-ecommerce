<?php
include_once 'connection.php';


if (isset($_POST['order'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $price = $_POST['price'];
    $invoice = 'INV-' . time();
    $pay_id = null;

    $conn = $pdo->open();
    $stmt = $conn->prepare("INSERT INTO  orders (invoice, name, email, address, price, pay_id) VALUES (:invoice, :name, :email, :address, :price, :pay_id)");
    $stmt->execute(['invoice' => $invoice, 'name' => $name, 'email' => $email, 'address' => $address, 'price' => $price, 'pay_id' => $pay_id]);
   
    //$conn->commit();
    $orderID = $conn->lastInsertId();

    session_start();

    foreach ($_SESSION['cart'] as $key => $field) {       

        $stmt = $conn->prepare("INSERT INTO  order_items (order_id, product_id, qty) VALUES (:order_id, :product_id, :qty)");
        $stmt->execute(['order_id' => $orderID, 'product_id' => $field['productid'] , 'qty' =>  $field['quantity']]);
    }

    


    $pdo->close();
}

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
<br>
<div class="container">
<form action="payment.php" method="post">
  <div class="row">
    
        <div class="offset-md-3 col-md-6">
            <fieldset>
                <legend>Card Information</legend>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Card holder</label>
                    <div class="col-md-8">
                        <input name="card[holder]" required class="form-control"
                            placeholder="Enter your full name">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Card number</label>
                    <div class="col-md-8">
                        <input type="number" name="card[pan]" required class="form-control" placeholder="Enter credit card number">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Expiration date</label>
                    <div class="col-md-4">
                        <select name="card[exp_year]" required class="form-control">
                            <option value="">Year</option>
                            <?php for ($i = date('Y'); $i <= date('Y', strtotime('+10 years')); $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="card[exp_month]" required class="form-control">
                            <option value="">Month</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Security code</label>
                    <div class="col-md-3">
                        <input type="number" name="card[cvc]" required class="form-control" placeholder="CVV" maxlength="4">
                    </div>
                    <div class="col-md-4"><span class="cvv"><img src="img/cvv.png" alt="Secured"> What is CVV?</span></div>
                </div>
            </fieldset>

            <div class="form-group row">
            <div class="col-md-12 text-center">
                <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
                <button type="submit"  class="btn btn-success btn-lg px-5" name="payment">Pay</button>
            </div>
        </div>
        

    </div>
    </form>
  </div>





</div>

</body>
</html>
