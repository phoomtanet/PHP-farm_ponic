<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$id_farm = $_POST['id_farm'];
$namegreenhouse = $_POST['greenhoues_name'];

$sql = "INSERT INTO `tb_greenhouse`(`id_greenhouse`, `id_farm`, `name_greenhouse`) 
VALUES ('','$id_farm','$namegreenhouse')";
mysqli_query($conn, $sql);

$_SESSION["greenhouse_name"] = $namegreenhouse;

echo "<script> alert('*เพิ่มโรงเรือนสำเร็จ*'); </script>";
echo "<script> window.location='../php/index.php'; </script>";
