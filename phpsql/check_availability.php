<?php

include '../Connect/conn.php';

if (isset($_POST['type']) != null) {
  $input_name = $_POST['input_name'];
  $type=$_POST['type'];
  $where=$_POST['where'];
  $query = "SELECT * FROM ".$type." where ".$where." ='" . $input_name . "' ";
  $result = mysqli_query($conn, $query);
  $rowcount = mysqli_num_rows($result);
  if ($rowcount > 0) {
    echo "<span class='status-not-available' style='color:red; font-size: 13px;'> *ชื่อนี้ถูกใช้ไปแล้ว!!* </span>";
  } else {
    echo "<span class='status-available' style='color:green; font-size: 13px;'> *ชื่อนี้ใช้งานได้* </span>";
  }
}