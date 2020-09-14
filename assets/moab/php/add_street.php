
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
    $streetObj = new User($theBomb, "streets", "street_id");




   $street_name = $_POST['street_name'];
   $total_bays = $_POST['slots'];


   $assoc = array(

       "street_name"=>$street_name,
       "slots"=>$total_bays

   );
   $street_id = $theBomb->saveData("streets",$assoc);

   $sum_bays =0;
   for ($i=1; $i<=$total_bays; $i++){

       $bay_code = substr($street_name, 0,10).$i;
       $assoc = array(

           "street_id"=>$street_id,
           "bay_code"=>$bay_code

       );

       if($theBomb->saveData("bays",$assoc)>0){

           $sum_bays = $sum_bays+1;

       }




   }


   if($total_bays==$sum_bays){

       $streetObj->response['success']=true;
       $streetObj->response['street_id']=$street_id;

   }else{

       $streetObj->response['error']="Failed To Create";
   }


   echo json_encode($streetObj->response);


}

