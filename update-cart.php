<?php
session_start();
$update_id = $_POST['update_id'];
if(isset($_POST['plus'])){
    foreach ($_SESSION['cart'] as $key => $field) {
        if ($field['productid']  == $update_id) {
            $qty =  $field["quantity"];
            if($qty >= 2){
                $_SESSION['message'] = 'You cant able to add more than 2 items';
            }else{
                $_SESSION['cart'][$key]['quantity'] = $qty + 1;
            }
            
        }
    }
}


if(isset($_POST['minus'])){
    foreach ($_SESSION['cart'] as $key => $field) {
        if ($field['productid']  == $update_id) {
            $qty =  $field["quantity"];
            
                $_SESSION['cart'][$key]['quantity'] = $qty - 1;
         
            
        }
    }
}

header('location: cart.php');