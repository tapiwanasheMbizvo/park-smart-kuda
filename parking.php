<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 18/4/2020
 * Time: 13:09
 */


?>

<?php require_once "header.php";?>
<style type="text/css">
    #results { padding:20px; border:1px solid; background:#ccc; }
</style>
<div class="content">

    <div class="container-fluid">
        <h4>Parking</h4>
        <div class="row">

            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Car Detection</h4>
                        <p class="card-category">Book A Bay</p>

                    </div>
                    <div class="card-body">

                        <div id="loadingMessage">🎥 Unable to access video stream (please make sure you have a webcam enabled)</div>
                        <canvas id="canvas" hidden></canvas>
                        <div id="output" hidden>

                            <div id="outputMessage">No QR code detected.</div>
                            <div hidden><b>Data:</b> <span id="outputData"></span></div>
                        </div>



                    </div>
                    <hr/>



                </div>
            </div>




        </div>
    </div>

</div>


<?php require_once "bottom.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script src='https://unpkg.com/tesseract.js@v2.1.0/dist/tesseract.min.js'></script>


<script>
    var video = document.createElement("video");
    var canvasElement = document.getElementById("canvas");
    var canvas = canvasElement.getContext("2d");
    var loadingMessage = document.getElementById("loadingMessage");
    var outputContainer = document.getElementById("output");
    var outputMessage = document.getElementById("outputMessage");
    var outputData = document.getElementById("outputData");

    function drawLine(begin, end, color) {
        canvas.beginPath();
        canvas.moveTo(begin.x, begin.y);
        canvas.lineTo(end.x, end.y);
        canvas.lineWidth = 4;
        canvas.strokeStyle = color;
        canvas.stroke();
    }

    // Use facingMode: environment to attemt to get the front camera on phones
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
        video.srcObject = stream;
        video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
        video.play();
        requestAnimationFrame(tick);
    });

    function tick() {
        loadingMessage.innerText = "⌛ Loading video..."
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            loadingMessage.hidden = true;
            canvasElement.hidden = false;
            outputContainer.hidden = false;

            canvasElement.height = video.videoHeight;
            canvasElement.width = video.videoWidth;
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
            var code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });
            if (code) {
                drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
                outputMessage.hidden = true;
                outputData.parentElement.hidden = false;
                outputData.innerText = code.data;

                if (!outputData.parentElement.hidden){

                    checkIfCarIsBookedForSpot(code.data);
                    canvasElement.hidden= true;
                    canvas.stop();



                    //get the licence plate and process shit
                }
            } else {
                outputMessage.hidden = false;
                outputData.parentElement.hidden = true;
            }
        }
        requestAnimationFrame(tick);
    }






</script>

<script>

    function checkIfCarIsBookedForSpot(licence_number) {

        const  data= {

            licence_number:licence_number,


        };

        $.ajax({

            type:'POST',
            url:'assets/moab/php/verify_booking.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

                if(data.success){

                    swal({
                        title: "Success",
                        text: "Car"+licence_number+"  is booked",
                        icon: "success",
                    });
                }else{

                    // alert(data.error);

                    swal({
                        title: "Failed!! ",
                        text: data.error,
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








    }
</script>