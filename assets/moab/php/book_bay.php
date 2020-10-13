
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
if($method=='POST'){

//    echo "WE GOT MUKATI ME GET METHOD"."<br/>";

    require_once "theBomb.php";
    require_once  "User.php";
    $theBomb = new theBomb();
    $bookingObj = new User($theBomb, "bookings", "booking_id");
    $baysObj = new User($theBomb, "bays", "bay_id");
   // $streetObj = new User($theBomb, "street", "booking_id");

    //$userObj->setEmail($_POST['email']);


    //damn
    $street_id = $_POST['bay_id'];

    //lets gets the first bay which is free in street $street
//$carBoj->withConditions("*", "user_id='".$user_id."'");
    $bays = $baysObj->withConditions("*", " status = 'A' and street_id= '".$street_id."' ");


    $bay = array_pop(json_decode($bays));


    $user_id = $_SESSION["user"]->user_id;

    $car_id =$_POST['car_id'];
    $bay_id =$_POST['bay_id'];
    $time_in =$_POST['time_in'];
    $time_out =$_POST['time_out'];

    ///var_dump($_POST);

    $assoc = array(


        "vehicle_id"=>$car_id,
        "start_date"=>$time_in,
        "end_date"=>$time_out,
        "bay_id"=>$bay->bay_id

    );

    //var_dump($assoc);

    $newData = array(

        "status"=>'B'

    );
    $baysObj->update($newData, $bay->bay_id);
    echo  $bookingObj->create($assoc);





}

