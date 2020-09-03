<?php
 if (isset($_POST['MD']) && isset($_POST['PaRes']) && isset($_SESSION['cardinity'])) {
    if ($_SESSION['cardinity']['MD'] == $_POST['MD']) {
        $method = new Cardinity\Method\Payment\Finalize(
            $_SESSION['cardinity']['PaymentId'],
            $_POST['PaRes']
        );
        $orderID = $_SESSION['cardinity']['orderID'];
        




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
    unset($_SESSION['cardinity']);
}