
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



if(!isset($_SESSION)){

    session_start();
}
if($method=='GET'){

//    echo "WE GOT MUKATI ME GET METHOD"."<br/>";

    require_once "theBomb.php";
    require_once  "User.php";
    $theBomb = new theBomb();
    $bookingObj = new User($theBomb, "bookings", "booking_id");



   // echo  $userObj->withConditions("*", "is_admin=0");

    echo  $bookingObj->withJoins("*", "inner join vehicles on bookings.vehicle_id=vehicles.vehicle_id inner join bays on bays.bay_id=bookings.bay_id ");



}

