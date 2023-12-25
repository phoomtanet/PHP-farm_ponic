
<?php 

$servername = "localhost";
$username = "root";
$password = "";
$table = "fs_test4";//ชื่อไฟล์
// Create connection
$conn= mysqli_connect($servername, $username, $password,$table);   
$conn->set_charset("utf8");
date_default_timezone_set('Asia/Bangkok');



// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
//-----------สร้างตัวแปร conn เพื่อติดต่อกับฐานข้อมูล 



?>


