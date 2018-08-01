<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Amatic+SC">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php
$rawData = $_POST['imgBase64'];
 list($type, $rawData) = explode(';', $rawData);
 list(, $rawData)      = explode(',', $rawData);
 $unencoded = base64_decode($rawData);
 
 $output=file_put_contents('/Applications/MAMP/htdocs/face_recog/web_cam_img/img.jpg', $unencoded);
 $command='/Users/avisheksarkar/anaconda/bin/python3.6  /Applications/MAMP/htdocs/face_recog/face_rec/recog.py  /Applications/MAMP/htdocs/face_recog/web_cam_img/img.jpg' ;
 
 $output = shell_exec($command);
 
 
$username = "username";
$password = "password";
$dbname = "photosdb";
$conn = new mysqli($servername, $username, $password,$dbname);
if($conn->connect_error){
  echo "not connected";

}
else{
		
	$sql1="SELECT * FROM person_details WHERE person_id='".$output."'";
	if($conn->query($sql1)==FALSE){
	      echo "NOT FOUND!!!";
}
   else{
    echo "<div class='w3-card-4' style='width:50%;padding-left:10px;padding-right:10px;padding-top:5px;'>";
   	$res1=$conn->query($sql1);
   	echo "found in database....";
   	echo $output;
   	echo "<br>";
    echo "date:";
    echo date('Y/m/d',mktime());echo "<br>";
   	while($row1 = mysqli_fetch_array($res1)){
    echo"<div><i class='material-icons' style='font-size:20px;'>account_circle</i>";echo " :";
    $user_name=$row1['name'];
    echo $row1['name'];echo "</div>";
    echo "<br>";
    //echo "parent name :"; 
    //echo $row1['parent'];
    //echo "<br>";
    echo "<i class='material-icons' style='font-size:36px'>phone_android</i>"; 
    $phone=$row1['parent_phone'];
    echo $row1['parent_phone'];echo "</div>";
    $sql2="SELECT * FROM today";
    if($conn->query($sql2)==FALSE){
      echo "date error";
    }
    else{
      
      $res2=$conn->query($sql2);
      while($row1=mysqli_fetch_array($res2)){
        echo "<h2>Attendance status:</h2>";
        $date=$row1['date'];
        $actual_date= date('Y-m-d',mktime());
        if($date==$actual_date){
          $sql6="SELECT `attandance` FROM `person_details` WHERE person_id='".$output."'";
          $res3=$conn->query($sql6);
          while($row=mysqli_fetch_array($res3)){
            if($row['attandance']==0){
              $sql5="UPDATE `person_details` SET `attandance`=1,`Date`='".date('Y-m-d',mktime())."' WHERE person_id='".$output."'";
              $conn->query($sql5);
              echo "hello '".$user_name."' good morning! your attendance has been given.";
              $sql7="UPDATE `cumulative` SET `cumulative_attendance`=cumulative_attendance+1 WHERE person_id='".$output."'";
              $conn->query($sql7);
              $sql8="SELECT cumulative_attendance FROM cumulative WHERE person_id='".$output."'";
              $res4=$conn->query($sql8);
              echo "<br>";
              while($row=mysqli_fetch_array($res4)){
                echo "your total attendance is :";
                echo $row['cumulative_attendance'];
              }
              
            }
            else{
              echo "hey '".$user_name."' you are already marked present";
               $sql8="SELECT cumulative_attendance FROM cumulative WHERE person_id='".$output."'";
              $res4=$conn->query($sql8);
             echo "<br>";
              while($row=mysqli_fetch_array($res4)){
                echo "your total attendance is :";
                echo $row['cumulative_attendance'];
              }
            }
          }
          

        }
        else{
          echo "updating";
          $sql3="DELETE FROM today";
          $conn->query($sql3);
          $sql4="INSERT INTO `today`(`date`) VALUES ('".date('Y-m-d',mktime())."')";
          $conn->query($sql4);
          $sql_reinit="UPDATE `person_details` SET `attandance`=0";//all attendance 0
          $conn->query($sql_reinit);
          $sql5="UPDATE `person_details` SET `attandance`=1,`Date`='".date('Y-m-d',mktime())."' WHERE person_id='".$output."'";
          $conn->query($sql5);
          $sql7="UPDATE `cumulative` SET `cumulative_attendance`=cumulative_attendance+1 WHERE person_id='".$output."'";
          $conn->query($sql7);
          echo "<br>";
          echo "Hey '".$user_name."' good morning! your attendance has been given";

        }

      }
    }
   
   



}
   }
}	
 ?>
 </body>
</html>