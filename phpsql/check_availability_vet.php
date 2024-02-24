<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

if ($_POST['where'] == 'vegetable_name'  ) {
  $input_name = mysqli_real_escape_string($conn, $_POST['input_name']);
  $type = mysqli_real_escape_string($conn, $_POST['type']);
  $where = mysqli_real_escape_string($conn, $_POST['where']);
  
  $query = "SELECT * FROM " . $type . " as v 
  INNER JOIN tb_veg_farm as vf ON v.id_vegetable = vf.id_vegetable
  WHERE " . $where . " = '" . $input_name . "' AND vf.id_farm = $id_farm_session";

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
}



if ($_POST['where'] == 'fertilizer_name'  ) {
    $input_name = mysqli_real_escape_string($conn, $_POST['input_name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $where = mysqli_real_escape_string($conn, $_POST['where']);



    $query = "SELECT * FROM " . $type . " 
    WHERE " . $where . " = '" . $input_name . "' AND id_farm = $id_farm_session";
  
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
  }


  if ($_POST['where'] == 'user_name'  ) {
    $input_name = mysqli_real_escape_string($conn, $_POST['input_name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $where = mysqli_real_escape_string($conn, $_POST['where']);



    $query = "SELECT * FROM " . $type . " 
    WHERE " . $where . " = '" . $input_name . "'";
  
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
  }




  if ($_POST['where'] == 'size_name' ) {
    $input_name = mysqli_real_escape_string($conn, $_POST['input_name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $where = mysqli_real_escape_string($conn, $_POST['where']);
    $query = "SELECT * FROM " . $type . " 
    WHERE " . $where . " = '" . $input_name . "' AND id_farm = $id_farm_session";
  
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
  }


  if ($_POST['where'] == 'plotnursery_name' ) {
    $input_name = mysqli_real_escape_string($conn, $_POST['input_name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $where = mysqli_real_escape_string($conn, $_POST['where']);



    $query = "SELECT * FROM " . $type . " 
    WHERE " . $where . " = '" . $input_name . "' AND  id_greenhouse  = $id_greenhouse_session";
  
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
  }
  if ($_POST['where'] == 'plot_name' ) {
    $input_name = mysqli_real_escape_string($conn, $_POST['input_name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $where = mysqli_real_escape_string($conn, $_POST['where']);



    $query = "SELECT * FROM " . $type . " 
    WHERE " . $where . " = '" . $input_name . "' AND  id_greenhouse  = $id_greenhouse_session";
  
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
  }
  
    if ($_POST['where'] == 'name_greenhouse' ) {
      $input_name = mysqli_real_escape_string($conn, $_POST['input_name']);
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $where = mysqli_real_escape_string($conn, $_POST['where']);
  
  
  
      $query = "SELECT * FROM " . $type . " 
      WHERE " . $where . " = '" . $input_name . "' AND  id_farm  = $id_farm_session ";
    
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
     
  }
?>
