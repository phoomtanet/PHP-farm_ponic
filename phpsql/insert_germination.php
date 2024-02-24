<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

if (isset($_POST["save"])) {

    $id_vegetable = $_POST['name_vegetable'];
    $name_greenhouse = $_POST['name_greenhouse'];
    $id_traysize = $_POST['name_traysize'];
    $Amount_trays = $_POST['Amount_trays'];
    $germination_date = $_POST['germination_date'];


    $sql_germination_amount = "SELECT a.row_tray ,a.column_tray 
    FROM `tb_traysize` as a  WHERE a.id_traysize ='$id_traysize'";
    $germination_amount_result = mysqli_query($conn, $sql_germination_amount);
    $germination_amount_row = mysqli_fetch_assoc($germination_amount_result);
    $row__tray = $germination_amount_row['row_tray'];
    $columne__tray = $germination_amount_row['column_tray'];


    $slq_seed_germination = "INSERT INTO `tb_seed_germination`( `id_veg_farm`, `id_greenhouse`, `id_traysize`, `Amount_trays`, `germination_amount`, `germination_date`) 
    VALUES ('$id_vegetable','$id_greenhouse_session','$id_traysize','$Amount_trays',$columne__tray*$row__tray*$Amount_trays,'$germination_date')";
    mysqli_query($conn, $slq_seed_germination);
    echo "<script> alert('*เพิ่มการเพาะสำเร็จ*'); </script>";
    echo "<script>window.location = '../php/show_germination.php'</script>";
}

if (isset($_POST['save2'])) {
    $id_farm = $_POST['id_farm1'];
    $name_size = $_POST['size_name'];
    $amount_row = $_POST['amount_row'];
    $amount_column = $_POST['amount_column'];

    $sql_tray = "INSERT INTO `tb_traysize`(`id_farm`, `size_name`, `row_tray`, `column_tray`) 
    VALUES ('$id_farm ','$name_size','$amount_row','$amount_column')";
    mysqli_query($conn, $sql_tray);
    echo "<script> alert('*เพิ่มถาดเพาะใหม่สำเร็จ*'); </script>";
    echo "<script>window.location = '../php/show_germination.php'</script>";
}

if (isset($_POST["edit"])) {

    $id_seed_germination = $_POST['id_seed_germination'];
    $id_vegetable = $_POST['name_vegetable2'];
    $name_greenhouse = $_POST['name_greenhouse2'];
  
    $germination_date = $_POST['germination_date2'];

    $Amount_germ = $_POST['am_germ'];
   



  

    $sql_edit_seed = "UPDATE `tb_seed_germination` 
    SET `id_veg_farm`='$id_vegetable',`id_greenhouse`='$name_greenhouse',
    `germination_amount`=$Amount_germ,
    `germination_date`='$germination_date' 
    WHERE `id_seed_germination`='$id_seed_germination' ";
    mysqli_query($conn, $sql_edit_seed);
    echo "<script> alert('*แก้ไขการเพาะสำเร็จ*'); </script>";
    echo "<script>window.location = '../php/show_germination.php'</script>";
}

if (isset($_POST["edit2"])) {

    $id_farm2 = $_POST['id_farm2'];
    $id_name_size = $_POST['id_name_size'];
    $name_size2 = $_POST['name_size2'];
    $amount_row2 = $_POST['amount_row2'];
    $amount_column2 = $_POST['amount_column2'];

    $sql_edit_tray = "UPDATE `tb_traysize` SET `id_farm`='$id_farm2',`id_traysize`='$id_name_size',`size_name`='$name_size2',`row_tray`='$amount_row2',`column_tray`='$amount_column2' 
    WHERE id_traysize = $id_name_size ";
    mysqli_query($conn, $sql_edit_tray);
    echo "<script> alert('*แก้ไขถาดเพาะสำเร็จ*'); </script>";
    echo "<script>window.location = '../php/show_germination.php'</script>";
}
