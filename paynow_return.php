<!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<?php

$streets=0;

if(!isset($_SESSION)){

    session_start();
}
require_once  "assets/moab/Paynow/autoloader.php";

require_once "assets/moab/php/User.php";
require_once "assets/moab/php/theBomb.php";

$theBomb = new theBomb();
$txnObj = new User($theBomb, "transactions", "txn_id");
$walletObj = new User($theBomb, "wallet", "wallet_id");
$user_id = $_SESSION["user"]->user_id;
$paynow = new Paynow\Payments\Paynow(
    4593,
    'fd4f95c7-ee88-4814-97b0-1d82961b915e',
    'http://localhost/park/return-paynow',

    // The return url can be set at later stages. You might want to do this if you want to pass data to the return url (like the reference of the transaction)
    'http://localhost/park/result-paynow'
);

//$_SESSION["pollUrl"]= $pollUrl;

$pollUrl = $_SESSION["pollUrl"];


//var_dump($pollUrl);

try {
    $status = $paynow->pollTransaction($pollUrl);
} catch (\Paynow\Http\ConnectionException $e) {
} catch (\Paynow\Payments\HashMismatchException $e) {
}





//die;
//"data":"Paynow\Core\StatusResponse":private]=>
//  array(6) {
//    ["reference"]=>
//    string(25) "Paying For PArking top Up"
//    ["paynowreference"]=>
//    string(8) "10101589"
//    ["amount"]=>
//    string(6) "100.00"
//    ["status"]=>
//    string(4) "Paid"

$balance = $_SESSION['balance'];
$response =$_SESSION['response'];
$amount = $status->amount();




if($status->status()=="paid"){

    $_SESSION['balance']= $_SESSION['balance']+$amount;

    if(!$walletObj->isAvailable("user_id", $user_id)){


        $wallets = json_decode($walletObj->withConditions("*", "user_id='".$user_id."'"), true);

        $wallet = array_pop($wallets);


        $wallet_id = $wallet['wallet_id'];
        $balance = $wallet['balance']+$amount;

        $wallet_data = array(

            "balance"=>$balance

        );

        $walletObj->update($wallet_data, $wallet_id);

        //record the transactions


        $crdr= "CR";
        $txn_data = array(

            "wallet_id"=>$wallet_id,
            "amount"=>$amount,
            "crdr"=>$crdr,
            "pollUrl"=>$pollUrl
        );

        $txnObj->create($txn_data);

    }else{

        //lets create the wallet

        $wallet_data = array(

            "user_id"=>$user_id,
            "balance"=>$amount

        );


        $wallet_id =   $theBomb->saveData("wallet",$wallet_data);
        $crdr= "CR";
        $txn_data = array(

            "wallet_id"=>$wallet_id,
            "amount"=>$amount,
            "crdr"=>$crdr,
            "pollUrl"=>$response->pollUrl()

        );

        $txnObj->create($txn_data);
    }


}

?>
<?php  require_once  "header.php";?>

      <!-- End Navbar -->
      <div class="content">

          <div class="container-fluid">
              <h4>Transaction Report</h4>
              <div class="row">

                  <div class="col-sm-7">
                      <div class="card">
                          <div class="card-header card-header-primary">
                                <h4 class="card-title">Transaction Status Report</h4>
                              <p class="card-category">Review Transaction Status</p>

                          </div>
                          <div class="card-body">

                          </div>
                          <hr/>

                          <div id="paynow_return_response">
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                  <strong>Processing Done!</strong> Your new Balance is $<?=$_SESSION["balance"]?>.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <table class="table">

                                  <tr>
                                      <td>Transaction Amount</td>
                                      <td>$<?php echo  $status->amount();?></td>
                                  </tr>

                                  <tr>
                                      <td>Transaction Reference</td>
                                      <td><?php echo  $status->paynowReference();?></td>
                                  </tr>

                                  <tr>
                                      <td>Transaction Status</td>
                                      <td><?php echo  $status->status();?></td>
                                  </tr>

                              </table>
                          </div>


                      </div>
                  </div>


              </div>
          </div>

      </div>





<?php require_once "bottom.php";?>


<script>
    $(document).on('submit', "#top_up", function (e) {

        e.preventDefault();


        let amount = $('#amount').val();



        const  data= {

            amount:amount
        };

        $.ajax({

            type:'POST',
            url:'assets/moab/php/paynow_init.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

            console.log(data);

            if(data.response.success){

               /* swal({
                    title: "Good!! ",
                    text: "Well zvaita oo link"+data.link,
                    icon: "success",
                });*/


               const new_html = "<a href='"+data.link+"'>" +
                   "<button class='btn btn-sm btn-success'>Got to Paynow </button>" +
                   "</a>";

                $("#paynow_init_response").append(new_html);
               
            }else{

                swal({
                    title: "Failed!! ",
                    text: data.response.status,
                    icon: "error",
                });

            }

            },
            error:function (txt) {

                swal({
                    title: "Failed!! ",
                    text: txt,
                    icon: "error",
                });
            }



        });



    })
</script>