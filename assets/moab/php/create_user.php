
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
    $userObj = new User($theBomb, "users", "user_id");


   // echo $_POST['first_name']."dam";
   /*// $data = json_decode(file_get_contents('php://input'), true);

    $data =file_get_contents('php://input' );
    var_dump($data);*/


    $userObj->setFirstName($_POST['first_name']);
    $userObj->setEmail($_POST['email']);
    $userObj->setPassword($_POST['password']);
    $userObj->setLastName($_POST['last_name']);
    $userObj->setIsAdmin($_POST['is_admin']);

   echo  $userObj->makeUser();

}

