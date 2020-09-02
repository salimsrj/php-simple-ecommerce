<?php

include_once 'connection.php';
require_once 'vendor/autoload.php';

use Cardinity\Client;
use Cardinity\Method\Payment;

$client = Client::create([
    'consumerKey' => 'test_jhcm1kuiowcs2s9dj03vryr4v8yf4e',
    'consumerSecret' => 'uczqtwmhh2dj1m2vkulspssqisqc2qzjo8v23auqssux4opvag',
]);


if (isset($_POST['payment']) && isset($_POST['card'])) {

    $orderID = $_POST['orderID'];
    $conn = $pdo->open();
    try {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE id=:id");
        $stmt->execute(['id' => $orderID]); ;
        $orderInfo = $stmt->fetch();
        //print_r($orderInfo);

        $invoice = $orderInfo['invoice'];
        $price = $orderInfo['price'];
        $name = $orderInfo['name'];
        $country = 'LT';


    } catch (PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }

    $pdo->close();

//     $method = new Payment\Create([
//         'amount' => (float) sprintf('%.2f', $price),
//         'currency' => 'EUR',
//         'settle' => false,
//         'description' => 'Order form Simple Ecommerce for cardinity by '.$name,
//         'order_id' => $invoice,
//         'country' => $country,
//         'payment_method' => Cardinity\Method\Payment\Create::CARD,
//         'payment_instrument' => [
//             'pan' => $_POST['card']['pan'],
//             'exp_year' => (int) $_POST['card']['exp_year'],
//             'exp_month' => (int) $_POST['card']['exp_month'],
//             'cvc' => $_POST['card']['cvc'],
//             'holder' => $_POST['card']['holder'],
//         ],
//     ]);



// $payment = $client->call($method);
// $paymentId = $payment->getId();
// // serializes object into string for storing in database
// echo $serialized = serialize($payment);




$method = new Payment\Create([
    'amount' => (float) sprintf('%.2f', $price),
    'currency' => 'EUR',
    'settle' => false,
    'description' => 'Order form Simple Ecommerce for cardinity by '.$name,
    'order_id' => $invoice,
    'country' => 'LT',
    'payment_method' => Payment\Create::CARD,
    'payment_instrument' => [
        'pan' => $_POST['card']['pan'],
        'exp_year' => (int) $_POST['card']['exp_year'],
        'exp_month' => (int) $_POST['card']['exp_month'],
        'cvc' => $_POST['card']['cvc'],
        'holder' => $_POST['card']['holder'],
    ],
]);
/** @type Cardinity\Method\Payment\Payment */
$payment = $client->call($method);
$paymentId = $payment->getId();
// serializes object into string for storing in database
echo $serialized = serialize($payment);





   
}

//$this->view->render($render);



