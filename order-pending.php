<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ecommerce</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="dist/assets/css/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="dist/assets/css/style.css"> 

  <script type="text/javascript">
          function OnLoadEvent()
          {
            // Make the form post as soon as it has been loaded.
            document.ThreeDForm.submit();
          }
      </script>

</head>


<body onload="OnLoadEvent();">

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
  <div class="row">
    <div class="col-md-12">
        <h1>Your order is sucessfull. Payment Status is Pending</h1>
    </div>
  </div>
</div>

<?php session_start(); ?>
<form name="ThreeDForm" method="POST" action="<?php echo $_SESSION['cardinity']['ThreeDForm']; ?>">
    <!-- <button class="btn btn-success">Click Here</button> -->
    <input type="hidden" name="PaReq" value="<?php echo $_SESSION['cardinity']['PaReq']; ?>"/>
    <input type="hidden" name="TermUrl" value="/callback.php"/>
    <input type="hidden" name="MD" value="<?php echo $_SESSION['cardinity']['MD']; ?>"/>
</form>



</div>

</body>
</html>
