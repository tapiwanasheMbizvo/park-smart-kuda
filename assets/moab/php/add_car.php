
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

   $model_name = $_POST['model_name'];
   $license_number = $_POST['license_number'];


   $user_id = $_SESSION["user"]->user_id;
   $user_email = $_SESSION["user"]->email;

  $total_cars = json_decode($carObj->withConditions("*", "user_id='".$user_id."'"));

    $file_name = 'park_qr_file'.md5($license_number).'.png';
    $upload_dr = "qrCodes/";
    $path = $upload_dr.$file_name;

  if(count($total_cars)<=4){
      $assoc = array(

          "model_name"=>$model_name,
          "license_number"=>$license_number,
          "user_id"=>$_SESSION['user']->user_id,
          'qr_code'=>$file_name

      );





      // $this->isAvailable("email", $this->getEmail()) ? $this->create($assoc): $this->response["error"]="Email Already Exists";

      $carObj->isAvailable("license_number", $license_number)? $carObj->create($assoc): $carObj->response["error"]= "license Plate Already Exists";



      QRcode::png($license_number, $path);

      sendQrCode($user_email, $path,QR_ECLEVEL_L, 20, 4);


  }else{


      $carObj->response["error"]= "You can only add 5 cars";
  }


    echo  json_encode($carObj->response);
}

function sendQrCode ($user_email, $qr_code_path){

    $config = parse_ini_file("config.ini");

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";


    try{
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = $config['email_host'];
        $mail->Username   = $config['gmail_user'];
        $mail->Password   = $config['gmail_password'];                                  // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($config['gmail_user'], 'Smart City Parking');
        $mail->addAddress($user_email, $_SESSION['user']->first_name.' '.$_SESSION['user']->last_name);     // Add a recipient
       // $mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Attachments
       // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment($qr_code_path, 'Your License  QR Cde');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'QR Code for You Recently Added Car';
        $mail->Body    = 'Good day find attached QR code to use to scan when parking';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();


    }catch (\Exception $e){


    }

}