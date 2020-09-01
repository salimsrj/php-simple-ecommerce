<?php
include_once('connection.php');
include('vendor/cardinity/cardinity-sdk-php/src/Client.php');



if(isset($_POST['order'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $price = $_POST['price'];
    $invoice = 'INV-'.time();
    $pay_id = NULL;


    $conn = $pdo->open();
    $stmt = $conn->prepare("INSERT INTO  orders (invoice, name, email, address, price, pay_id) VALUES (:invoice, :name, :email, :address, :price, :pay_id)");
	$stmt->execute(['invoice' => $invoice , 'name'=>$name, 'email'=>$email, 'address'=>$address, 'price'=>$price, 'pay_id'=> $pay_id]);
    $pdo->close();
}

use Cardinity\Client;
$client = Client::create([
    'consumerKey' => 'test_jhcm1kuiowcs2s9dj03vryr4v8yf4e',
    'consumerSecret' => 'uczqtwmhh2dj1m2vkulspssqisqc2qzjo8v23auqssux4opvag',
]);


use Cardinity\Method\Payment;
$method = new Payment\Create([
    'amount' => 50.00,
    'currency' => 'EUR',
    'settle' => false,
    'description' => 'some description',
    'order_id' => '12345678',
    'country' => 'LT',
    'payment_method' => Payment\Create::CARD,
    'payment_instrument' => [
        'pan' => '4111111111111111',
        'exp_year' => 2021,
        'exp_month' => 12,
        'cvc' => '456',
        'holder' => 'Mike Dough'
    ],
]);
/** @type Cardinity\Method\Payment\Payment */
$payment = $client->call($method);
$paymentId = $payment->getId();
// serializes object into string for storing in database
$serialized = serialize($payment);

?>