<?php 
include '../Connect/conn.php';

// var for insert vegetable
$vegetable_name = $_POST['vegetable_name'];
$age_vegatable = $_POST['age_vegatable'];
$id_farm = $_POST['id_farm'];



// var for insert vegetableprice
$vegetable_price = $_POST['vegetable_price'];
$date = $date = date('Y-m-d');

// var for insert vegetableweight
$amount_tree = $_POST['amount_tree'];
$vegetableweight = $_POST['vegetableweight'];

// Upload image
if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
  $new_image_name = 'photo_' . uniqid() . "." . pathinfo(basename($_FILES['photo']['name']), PATHINFO_EXTENSION);
  $image_upload_path = "../img/" . $new_image_name;
  move_uploaded_file($_FILES['photo']['tmp_name'], $image_upload_path);
} else {
  $new_image_name = "";
}

$sql = "INSERT INTO `tb_vegetable`(`vegetable_name`, `vegetable_age`, `img_name`) 
VALUES ('$vegetable_name','$age_vegatable','$new_image_name')";


if(mysqli_query($conn, $sql) === TRUE){
  $last_id_vegetable = mysqli_insert_id($conn); // id ล่าสุดที่ถูกสร้างขึ้น
  
  $sql_veg_farm = "INSERT INTO `tb_veg_farm`(`id_farm`, `id_vegetable`)
   VALUES ('$id_farm' , '$last_id_vegetable')";
  mysqli_query($conn, $sql_veg_farm);
  $last_id_veg_farm = mysqli_insert_id($conn); // id ล่าสุดที่ถูกสร้างขึ้น

  $sql_pri ="INSERT INTO `tb_vegetableprice`(`vegetablepricedate`, `id_veg_farm`, `price`) 
  VALUES ('$date','$last_id_veg_farm','$vegetable_price')";
  mysqli_query($conn, $sql_pri);
  $sql_weight = "INSERT INTO `tb_vegetableweight`(`vegetableweightdate`, `id_veg_farm`, `amount_tree`, `vegetableweight`) 
  VALUES ('$date','$last_id_veg_farm','$amount_tree','$vegetableweight')";
  mysqli_query($conn, $sql_weight);


  echo "<script> alert('*เพิ่มข้อมูลผักสำเร็จ*'); </script>";
echo "<script> window.location='../php/ShowVegetable.php'</script>";
}

?>