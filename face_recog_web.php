<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Amatic+SC">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<title></title>
	<style>
body, html {height: 100%}
mbody,h1,h2,h3,h4,h5,h6 {font-family: "Amatic SC", sans-serif;
font-size: 40px;}
</style>
<style>
.rect {
    border: 5px solid #a64ceb;
    left: -1000px;
    position: absolute;
    top: -1000px;
  }
#container {
    margin: 0px auto;
    width: 500px;
    height: 375px;
    border: 10px #333 solid;
}
#videoElement {
    width: 500px;
    height: 375px;
    background-color: #666;
}

</style>
<script src="tracking.js-master/build/tracking-min.js"></script>
  <script src="tracking.js-master/build/data/face-min.js"></script>
  <script src="tracking.js-master/build/data/eye-min.js"></script>
  <script src="tracking.js-master/build/data/mouth-min.js"></script>
 
  <script src="tracking.js-master/src/alignment/training/Landmarks.js"></script>
  <script src="tracking.js-master/src/alignment/training/Regressor.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkgH20KBG9MdVSLAPTnCogYdoKonKJuHk&callback=myMap"></script>-->
  
</head>

<body>
<nav class="navbar navbar-inverse" style="z-index: 2;opacity: 0.7;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="/codespace/icon_attendance.png" style="height: 110%;"></a>
    </div>
    <ul class="nav navbar-nav">
      <li ><a href="#">Home</a></li>
      <li><a href="#"></a></li>
      <li><a href="#"></a></li>
      <li><a href="#">Contact Us</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a id="login" href="#"><span class="glyphicon glyphicon-user " data-toggle="modal" data-target="#"><?php 
        
        $email= $_POST['email'];
        $pwd=$_POST['pwd'];
        if($email=='abhishek.sarkar698@gmail.com' && $pwd=="abhi123")
        	echo $email;
        else{
        	header('Location: http://localhost:8888/codespace/app.html');
        	        }
      	?></span> </a></li>
      
    </ul>
</div>
</nav>
<div id="webcam_input"class="w3-red" style="width: 30%;border-radius: 20%;padding: 5px;position: absolute;left: 20%;">	
<a href="#" onclick="slidein()" style="text-decoration: none">select webcam input</a>
</div>	
<!--<div id="image_input"class="w3-red" style="width: 30%;border-radius: 20%;padding: 5px;position: absolute;left: 20%;top:19%;">	
<a href="#" onclick="load_pics()" style="text-decoration: none">select image input</a>
</div>	-->
<div id="img_input" style="display: none">
	<form action="create_photo_gallery.php" method="post" enctype="multipart/form-data">
    <table width="100%">
        <tr>
            <td>Select Photo of person</td>
            <td><input type="file" name="files[]" multiple/></td>
        </tr>
        <tr>
            <td colspan="2" align="center">Note: Supported image format: .jpeg, .jpg, .png, .gif</td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="Search" id="selectedButton"/></td>
        </tr>
    </table>
</form>
		
	
</div>
<div id="webcam" class=" w3-blue" style="display: none;border-radius: 10%;margin: 10px;">
<center><div><h1>please keep your face close to the camera !!<br> make sure your face is lit!(demo version)</h1></div></center>
<center><div>
	<canvas id="canvas" width="500" height="375" style="position: absolute;top: 5%;display: none;border-width: 10px;border-color: white;"></canvas>
<video autoplay="true" id="videoElement" style="border: 5px;border-radius: 10%;" >
   
</video></div></center>

<center><button onclick="detect()"><span class="w3-red">click to search!!</span></button></center>
<div style="padding-left: 20%"><div id= "uploading" style="display: none;">uploading.....</div>
<div id="uploaded" style="display: none;">uploaded.</div>
<div id="demo"></div>
<!--<div id="googleMap" style="width:50%;height:300px;"></div>-->
<div id="camFeedback"></div></div>
<script type="text/javascript">

var x = document.getElementById("demo");
var lat,lan;



 function myMap() {

var mapCanvas = document.getElementById("googleMap");
  var myCenter = new google.maps.LatLng(12.9700792,79.1554796); 
  //navigator geolocation
   if (navigator.geolocation) {
    console.log('getting geolocation');
        navigator.geolocation.getCurrentPosition(function(position){
         console.log('here');
         pos={lat: position.coords.latitude,
              lng: position.coords.longitude

         };
         console.log(pos);
         var mapOptions = {center: myCenter, zoom: 5};
         var map = new google.maps.Map(mapCanvas,mapOptions);
         var marker = new google.maps.Marker({
         position: pos,
         animation: google.maps.Animation.BOUNCE
  });
  marker.setMap(map);
        },function(failure){
          console.log('fail');
        });
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }

}







function slidein(){
	$("#webcam_input").hide();
	$("#image_input").hide();
	$("#webcam").fadeIn(500);
   
    load_cam();
	
}
function load_pics(){
	$("#webcam_input").hide();
	$("#image_input").hide();
	$("#img_input").show(500);
}
function load_cam(){
var video = document.querySelector("#videoElement");
 
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
 
if (navigator.getUserMedia) {       
    navigator.getUserMedia({video: true}, handleVideo, videoError);
}
 
function handleVideo(stream) {
	console.log('got');
	console.log(stream);
    window.stream=stream;
    video.srcObject = stream;
    video.onloadedmetadata = function(e) {
           video.play();};
}
 
function videoError(e) {
    console.log('no stream');// do something
}
}

				
	
function detect() {
	
	var img=document.getElementById('videoElement');
	var canvas=document.getElementById('canvas');
    var context=canvas.getContext('2d');
	var tracker = new tracking.LandmarksTracker();
	tracker.setStepSize(2);
	tracker.setInitialScale(4);
    console.log(tracking.track('#videoElement',tracker));
    tracker.on('track', function(event) {
        event.data.faces.forEach(function(rect) {
           console.log('face found');
             
             context.drawImage(img,170,200, rect.width, rect.height);
             var track = stream.getTracks()[0];  
             track.stop();
             $("#canvas").fadeIn(500);
             //getLocation();
             //saving and uploading....//
             var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
             $("#uploading").show(); 
              $.ajax({
				type: "POST",
				url: "pic_save.php",
				data: { 
					imgBase64: dataUrl
				},
				success: function(data){
					//console.log(data);
					$('#camFeedback').html(data);
				}
			}).done(function(msg) {
				console.log("saved");
				$("#uploading").hide();
				$("#uploaded").show();
			});
           console.log(rect);
           
        });
        
      });
	}
      


</script>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJ7Za2a0hzxPJPvoLg5J_uZBerf5aPBks&callback=myMap"></script>
</body>
</html>