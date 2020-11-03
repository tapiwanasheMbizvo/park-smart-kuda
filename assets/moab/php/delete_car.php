
<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 20/10/2019
 * Time: 22:38
 */

error_reporting(E_ERROR | E_PARSE);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With ');
$method = $_SERVER["REQUEST_METHOD"];


if(!isset($_SESSION)){

    session_start();

}
if($method=='POST'){


    include "phpqrcode/qrlib.php";

    require_once "theBomb.php";
    require_once  "User.php";
    $theBomb = new theBomb();
    $carObj = new User($theBomb, "vehicles", "vehicle_id");


//model_name:model_name,
//            license_number:license_number

   $id = $_POST['id'];

   echo $carObj->delete($id);

}