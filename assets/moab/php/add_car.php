
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
if($method=='POST'){


    require_once "theBomb.php";
    require_once  "User.php";
    $theBomb = new theBomb();
    $carObj = new User($theBomb, "vehicles", "vehicle_id");


//model_name:model_name,
//            license_number:license_number

   $model_name = $_POST['model_name'];
   $license_number = $_POST['license_number'];


   $user_id = $_SESSION["user"]->user_id;

  $total_cars = json_decode($carObj->withConditions("*", "user_id='"+$user_id+"'"));

  if(count($total_cars)<=4){
      $assoc = array(

          "model_name"=>$model_name,
          "license_number"=>$license_number,
          "user_id"=>$_SESSION['user']->user_id

      );



      // $this->isAvailable("email", $this->getEmail()) ? $this->create($assoc): $this->response["error"]="Email Already Exists";

      $carObj->isAvailable("license_number", $license_number)? $carObj->create($assoc): $carObj->response["error"]= "license Plate Already Exists";


  }else{


      $carObj->response["error"]= "You can only add 5 cars";
  }


    echo  json_encode($carObj->response);
}

