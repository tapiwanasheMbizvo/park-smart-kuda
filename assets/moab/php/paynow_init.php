<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 14/9/2020
 * Time: 11:09
 */


if(!isset($_SESSION)){

    session_start();
}


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With ');
$method = $_SERVER["REQUEST_METHOD"];

require_once "../Paynow/autoloader.php";
require_once "theBomb.php";
require_once  "User.php";
$theBomb = new theBomb();
$txnObj = new User($theBomb, "transactions", "txn_id");

$paynow = new Paynow\Payments\Paynow(
    4593,
    'fd4f95c7-ee88-4814-97b0-1d82961b915e',
    'http://localhost/park/return-paynow',

    // The return url can be set at later stages. You might want to do this if you want to pass data to the return url (like the reference of the transaction)
    'http://localhost/park/result-paynow'
);

if($method=='POST'){


    $amount = $_POST['amount'];
    $payment = $paynow->createPayment('Paying For PArking top Up', 'tapiwambizvo@gmail.com');
    $payment->add('Transaction Amount', $amount);

   // Save the response from paynow in a variable
    try {
        $response = $paynow->send($payment);
    } catch (\Paynow\Http\ConnectionException $e) {
    } catch (\Paynow\Payments\HashMismatchException $e) {
    } catch (\Paynow\Payments\InvalidIntegrationException $e) {
    }

    if($response->success()) {
        // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
        $link = $response->redirectUrl();

        // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
        $pollUrl = $response->pollUrl();
    }

    $txnObj->response['response']= $response;
    $txnObj->response['link']=$link;
    $txnObj->response['pollUrl']=$pollUrl;
    $txnObj->response['payment']=$payment;
    $txnObj->response['amount']=$amount;

    $_SESSION["pollUrl"]= $pollUrl;

    echo json_encode($txnObj->response);





}

