<?php


//include  "phpqrcode/qrlib.php";

include 'assets/moab/php/phpqrcode/qrlib.php';

$license_number= "AXBZ9898";

$file_name = 'park_qr_file'.md5($license_number).'.png';
$upload_dr = "qrCides/";
$path = $upload_dr.$file_name;


QRcode::png($license_number, $path, QR_ECLEVEL_L, 20, 4);