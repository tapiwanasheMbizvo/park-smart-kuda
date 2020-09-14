<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 14/4/2020
 * Time: 21:07
 */


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With ');
$method = $_SERVER["REQUEST_METHOD"];

if($method=='POST') {


    require_once "theBomb.php";
    require_once "User.php";
    $theBomb = new theBomb();
    $userObj = new User($theBomb, "users", "user_id");


    $data = json_decode(file_get_contents('php://input'), true);
    // print_r($data);
    $userObj->setEmail($_POST['email']);
    $userObj->setPassword($_POST['password']);


    echo $userObj->userLogin();


}