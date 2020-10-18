
<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 20/10/2019
 * Time: 22:38
 */



header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With ');
$method = $_SERVER["REQUEST_METHOD"];

if($method=='POST'){


    require_once "theBomb.php";
    require_once  "User.php";
    $theBomb = new theBomb();
    $baysObj = new User($theBomb, "bays", "bay_id");


    $street_id = $_POST['street_id'];


    //echo  "HEY ".$street_id; GET All bays with strret id given


    //echo  $streetObj->getAll();





    echo  $baysObj->withConditions("*", "street_id=".$street_id." ");



}

