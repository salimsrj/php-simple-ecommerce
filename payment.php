<?php
session_start();
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
//$payment = $client->call($method);

// serializes object into string for storing in database
//$serialized = serialize($payment);





/** 
* In case payment could not be processed exception will be thrown. 
* In this example only Declined and ValidationFailed exceptions are handled. However there is more of them.
* See Error Codes section for detailed list.
*/
try {
    /** @type Cardinity\Method\Payment\Payment */
    $payment = $client->call($method);
    $status = $payment->getStatus();

        if($status == 'approved') {
        // Payment is approved
        $paymentId = $payment->getId();

        $conn = $pdo->open();
        try {
            $stmt = $conn->prepare("UPDATE orders SET pay_id=:pay_id, status=:status WHERE id=:id");
            $stmt->execute([
                'id' => $orderID, 
                'pay_id' => $paymentId,
                'status' => $status 
                ]); ;
            


        } catch (PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
        $pdo->close();

        unset($_SESSION['cart']);
    


        header('location: order-success.php');


    }

    if($status == 'pending') {
      // Retrieve information for 3D-Secure authorization
      //$url = $payment->getAuthorizationInformation()->getUrl();
      //$data = $payment->getAuthorizationInformation()->getData();


        $auth = $payment->getAuthorizationInformation();
        $pending = [
            'ThreeDForm' => $auth->getUrl(),
            'PaReq' => $auth->getData(),
            'MD' => $payment->getOrderId(),
            'PaymentId' => $payment->getId(),
            'orderID' => $orderID
        ];
        $_SESSION['cardinity'] = $pending;


      header('location: order-pending.php');
    }

} catch (Exception\Declined $exception) {
    /** @type Cardinity\Method\Payment\Payment */
    $payment = $exception->getResult();
    $status = $payment->getStatus(); // value will be 'declined'
    $errors = $exception->getErrors(); // list of errors occured

    header('location: order-declined.php');
    
} catch (Exception\ValidationFailed $exception) {
    /** @type Cardinity\Method\Payment\Payment */
    $payment = $exception->getResult();
    $status = $payment->getStatus(); // value will be 'declined'
    $errors = $exception->getErrors(); // list of errors occured

    header('location: order-declined.php');

}






   
}

//$this->view->render($render);



