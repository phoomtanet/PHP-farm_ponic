<?php
include '../Connect/conn.php';
session_start();

// $errors = array();
//รับค่าตัวแปรจาก register.php

$username = $_POST['username2'];
$password = $_POST['password2'];
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];

// Upload image
if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
  $new_image_name = 'photo_' . uniqid() . "." . pathinfo(basename($_FILES['photo']['name']), PATHINFO_EXTENSION);
  $image_upload_path = "../img/" . $new_image_name;
  move_uploaded_file($_FILES['photo']['tmp_name'], $image_upload_path);
} else {
  $new_image_name = "";
}


//เข้ารหัสด้วย sha512
//$password = hash('sha512', $password);


//จะทำการเช็คว่าข้อมูลตรงกันในระบบหรือไม่
$chack_sql = "SELECT * FROM tb_user WHERE user_name = '$username' ";
$query = mysqli_query($conn, $chack_sql);
$result = mysqli_fetch_assoc($query);

//if ($result) {
if ($result['user_name'] === $username) {
  echo "<script> alert('*มีบัญชี $result[user_name] อยู่แล้ว!! กรุณา login เพื่อเข้าสู่ระบบ*'); </script>";
  $_SESSION['error_user'] = "*มีบัญชี $result[user_name] อยู่แล้ว!!  กรุณา login เพื่อเข้าสู่ระบบ*";
  echo "<script> window.location='../php/loginform.php'; </script>";
} else {
  $sql = "INSERT INTO tb_user(f_name,l_name,user_name,password,photo_name) 
  VALUES ('$fname','$lname','$username','$password','$new_image_name')";
  mysqli_query($conn, $sql);
  echo "<script> alert('*สมัครสมาชิกเรียบร้อย!! กรุณา login เข้าสู่ระบบ*'); </script>";
  echo "<script> window.location='../php/loginform.php'; </script>";
}
//}

mysqli_close($conn);
