<?php
session_start();
if(isset($_POST['delete'])){
    // foreach($_SESSION['cart'] as $k => $v) {
    //     if($v == $removeditem)
    //       unset($_SESSION['stuff'][$k]);
    //   }

      $removal_id = $_POST['removal_id'];
      foreach ($_SESSION['cart'] as $key => $field) {
        if ($field['productid']  == $removal_id) {
            unset($_SESSION['cart'][$key]);
        }
    }

    header('location: cart.php');

}