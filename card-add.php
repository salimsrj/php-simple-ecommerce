<?php
session_start();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];



if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}
$data = array();
$data['productid'] = $id;
$data['quantity'] = $quantity;


$exist = array();

foreach($_SESSION['cart'] as $row){
    array_push($exist, $row['productid']);
}

if(in_array($id, $exist)){
 
    foreach ($_SESSION['cart'] as $key => $field) {
        if ($field['productid']  == $id) {
            $qty =  $field["quantity"];
            if($qty >= 2){
                $_SESSION['message'] = 'You can be able to add up to 2 items of each product';
            }else{
                $_SESSION['cart'][$key]['quantity'] = $qty + 1;
            }
            
        }
    }



}else{
    array_push($_SESSION['cart'], $data);
}

}
        

// echo '<pre>';
// print_r($_SESSION['cart']);

// echo '</pre>';