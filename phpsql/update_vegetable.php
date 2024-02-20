<?php
include '../Connect/conn.php';

// var for update vegetable
$id_vegetable = $_POST['id_vegetable_edit'];
$id_veg_farm = $_POST['id_veg_farm'];
$vegetable_name = $_POST['vegetable_name_edit'];
$age_vegatable_edit = $_POST['age_vegatable_edit'];
$fertilizer_edit = $_POST['fertilizer_edit'];
// $id_farm = $_POST['id_farm'];

// var for update vegetableprice
$vegetable_price_edit = $_POST['vegetable_price_edit'];
$date_edit =  date('d F Y');

// var for update vegetableweight
$amount_tree_edit = $_POST['amount_tree_edit'];
$vegetableweight_edit = $_POST['vegetableweight_edit'];

// Upload image
if (is_uploaded_file($_FILES['photo_edit']['tmp_name'])) {
  $new_image_name = 'photo_' . uniqid() . "." . pathinfo(basename($_FILES['photo_edit']['name']), PATHINFO_EXTENSION);
  $image_upload_path = "../img/" . $new_image_name;
  move_uploaded_file($_FILES['photo_edit']['tmp_name'], $image_upload_path);
} else {
  $new_image_name = "";
}

$chack_name = "";

if (true) {

  $sql_up1 = "UPDATE `tb_vegetable` SET `id_fertilizer`='$fertilizer_edit', `vegetable_name`='$vegetable_name',
`vegetable_age`='$age_vegatable_edit', `img_name`='$new_image_name' WHERE `id_vegetable` = '$id_vegetable'";
  mysqli_query($conn, $sql_up1);

  $sql_up2 = "UPDATE `tb_vegetableprice`
   SET `vegetablepricedate`='$date_edit', `price`='$vegetable_price_edit' 
WHERE `id_veg_farm` = '$id_veg_farm'";
  mysqli_query($conn, $sql_up2);

  $sql_up3 = "UPDATE `tb_vegetableweight` SET `vegetableweightdate`='$date_edit', `amount_tree`='$amount_tree_edit',
`vegetableweight`='$vegetableweight_edit' WHERE `id_veg_farm` = '$id_veg_farm'";
  mysqli_query($conn, $sql_up3);

  echo "<script> window.location='../php/ShowVegetable.php'</script>";
}
?>