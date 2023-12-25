<?php
include '../Connect/conn.php';

$iduser_edit = $_POST['iduser_edit'];
$username_edit = $_POST['username_edit'];
$password_edit = $_POST['password_edit'];
$firstname_edit = $_POST['firstname_edit'];
$lastname_edit = $_POST['lastname_edit'];

// Upload image
if (is_uploaded_file($_FILES['photo_edit']['tmp_name'])) {
  $new_image_name = 'photo_' . uniqid() . "." . pathinfo(basename($_FILES['photo_edit']['name']), PATHINFO_EXTENSION);
  $image_upload_path = "../img/" . $new_image_name;
  move_uploaded_file($_FILES['photo_edit']['tmp_name'], $image_upload_path);
} else {
  $new_image_name = "";
}

$sql_up =  "UPDATE `tb_user` SET `f_name`='$firstname_edit',`l_name`='$lastname_edit',
`user_name`='$username_edit',`password`='$password_edit',`photo_name`='$new_image_name' WHERE id_user = '$iduser_edit' ";
mysqli_query($conn, $sql_up);

echo "<script> alert('*แก้ไขข้อมูลผู้ใช้สำเร็จ*'); </script>";
echo "<script> window.location='../php/ShowUser.php'</script>";
