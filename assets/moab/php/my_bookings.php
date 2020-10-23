
<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 20/10/2019
 * Time: 22:38
 */


error_reporting(E_ERROR | E_PARSE);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With ');
$method = $_SERVER["REQUEST_METHOD"];


//echo "WE GOT KUNZE"."<br/>";
if(!isset($_SESSION)){

    session_start();
}
if($method=='GET'){

//    echo "WE GOT MUKATI ME GET METHOD"."<br/>";

    require_once "theBomb.php";
    require_once  "User.php";
    $theBomb = new theBomb();
    $bookingOBj = new User($theBomb, "bookings", "booking_id");


    $user_id = $_SESSION["user"]->user_id;

    $user_id = $user_id+0;

  //  echo "user is is ".$user_id;

   // echo  $carBoj->withConditions("*", "user_id='".$user_id."'");


   // echo  $walletObj->withJoins("amount, date_txn, crdr,pollUrl", "inner join transactions on wallet.wallet_id=transactions.wallet_id  where wallet.user_id = '".$user_id."'");

    echo  $bookingOBj->withJoins("*", "inner join vehicles on bookings.vehicle_id=vehicles.vehicle_id inner join bays on bays.bay_id=bookings.bay_id WHERE vehicle.user_id='".$user_id."'");



}

