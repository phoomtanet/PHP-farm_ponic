<?php
include '../Connect/conn.php';

if (isset($_POST['type']) && isset($_POST['input_name']) && isset($_POST['where'])) {
  $input_name = mysqli_real_escape_string($conn, $_POST['input_name']);
  $type = mysqli_real_escape_string($conn, $_POST['type']);
  $where = mysqli_real_escape_string($conn, $_POST['where']);
  
  $query = "SELECT * FROM " . $type . " WHERE " . $where . " = '" . $input_name . "'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    $rowcount = mysqli_num_rows($result);
    if ($rowcount > 0) {
      echo "<span class='status-not-available' style='color:red; font-size: 13px;'> *ชื่อนี้ถูกใช้ไปแล้ว!!* </span>";
    } else {
      echo "<span class='status-available' style='color:green; font-size: 13px;'> *ชื่อนี้ใช้งานได้* </span>";
    }
  } else {
    echo "Error in query: " . mysqli_error($conn);
  }
} else {
  echo "Invalid parameters";
}
?>
