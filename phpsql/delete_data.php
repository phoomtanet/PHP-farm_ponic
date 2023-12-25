<?php
include '../Connect/conn.php';

// if (isset($_POST['type']) != null) {

  $id = $_GET['id'];
  $idtb = $_GET['idtb'];
  $tb = $_GET['tb'];
  $location = $_GET['location'];
  $sql = "DELETE FROM `$tb` WHERE `$idtb` = '$id'";

  if(mysqli_query($conn, $sql)) {
    echo "<script> alert('ลบข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location='$location'</script>";
  } else {
    echo "Error : " . $sql . mysqli_error($conn);
    echo "<script> alert('ยกเลิกการลบข้อมูล'); </script>";
  }
// }
