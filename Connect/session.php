<?php
include '../Connect/conn.php';
if (isset($_SESSION['user'])) {
    $user = $_SESSION["user"];
    $sql_user_session = "SELECT a.id_user FROM tb_user as a WHERE a.user_name = '$user'";
    $resultd_user_session = mysqli_query($conn, $sql_user_session);
    if ($resultd_user_session) {
        $row_user_session = mysqli_fetch_assoc($resultd_user_session);
        $id_user_session  = $row_user_session['id_user'];
    }

}

if (isset($_SESSION["farm_name"])) {
    $farm_name =  $_SESSION["farm_name"];
    $sql_farm_session = "SELECT a.id_farm FROM `tb_farm` as a WHERE a.id_user = '$id_user_session'AND a.name_farm = '$farm_name';";
    $resultd_farm_session = mysqli_query($conn, $sql_farm_session);
    if ($resultd_farm_session) {
        $row_farm_session = mysqli_fetch_assoc($resultd_farm_session);
        $id_farm_session  = $row_farm_session['id_farm'];
    }
}

if (isset($_SESSION["greenhouse_name"])) {
    $greenhouse_name =  $_SESSION["greenhouse_name"];
    $sql_id_greenhouse_session = "SELECT a.id_greenhouse 
       FROM `tb_greenhouse` as a
       WHERE a.name_greenhouse ='$greenhouse_name' AND a.id_farm ='$id_farm_session';";
    $resultd_greenhouse_session = mysqli_query($conn, $sql_id_greenhouse_session);
    if ($resultd_greenhouse_session) {
        $row_greenhouse_session = mysqli_fetch_assoc($resultd_greenhouse_session);
        $id_greenhouse_session  = $row_greenhouse_session['id_greenhouse'];
    }
}
if (isset($_SESSION["photo_name"])) {
    $photo_name = $_SESSION["photo_name"];
}
if (isset($_SESSION["num_fertilizing"])) {
    $num_fertilizing = $_SESSION["num_fertilizing"];
}
if (isset($_SESSION["f_name"])) {
    $f_name = $_SESSION["f_name"];
}

if (!isset($_SESSION['user'])) {
    // header('Location: loginform.php');

  }

 

?>
