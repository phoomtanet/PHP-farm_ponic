<?php 
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

if(isset($_POST['check_insert']) || isset($_POST['check_edit']) ){

if(isset($_POST['check_insert'])){
$id_user = $_POST['id_user'];
$namefarm = $_POST['farm_name'];
$location = $_POST['location'];
$greenhouse = $_POST['greenhouse'];

$sql = "INSERT INTO `tb_farm`(`id_user`, `name_farm`, `location`) 
VALUES ('$id_user','$namefarm','$location')";
mysqli_query($conn,$sql);


$last_id_farm = mysqli_insert_id($conn); // id ล่าสุดที่ถูกสร้างขึ้น
  

$sql_gh = "INSERT INTO `tb_greenhouse`( `id_farm`, `name_greenhouse`) 
VALUES ('$last_id_farm','$greenhouse')";
mysqli_query($conn,$sql_gh);

echo "<script> alert('*เพิ่มฟาร์มสำเร็จ*'); </script>";
// echo $_SESSION["farm_name"];
echo "<script> window.location='../php/ShowFarm.php'</script>";
}

if(isset($_POST['check_edit'])){
    $id_farm = $_POST['id_farm_edit'];
    $namefarm = $_POST['farm_name_edit'];
    $location = $_POST['location_edit'];
    
    $sql = "UPDATE `tb_farm` SET `name_farm`='$namefarm',`location`='$location' WHERE id_farm = '$id_farm'";
    mysqli_query($conn,$sql);

  
    $_SESSION["farm_name"] = $namefarm;
        
    $greenhouse_first = "SELECT a.name_greenhouse as first_greenhouse
    FROM `tb_greenhouse` as a
    INNER JOIN `tb_farm` AS b ON a.id_farm  = b.id_farm 
    INNER JOIN `tb_user` AS c ON b.id_user = c.id_user
    WHERE c.user_name = '$user' AND b.name_farm = '$namefarm' 
    LIMIT 1;";
   
   $result_greenhouse  = $conn->query($greenhouse_first);
   if ($result_greenhouse) {
       $row_greenhouse = $result_greenhouse->fetch_assoc();
       if ($row_greenhouse) {
           $_SESSION["greenhouse_name"] = $row_greenhouse['first_greenhouse'];

           // อาจจะมี popup แจ้งเตือนให้กดยืนยันก่อนเปลี่ยนฟาร์ม
           // echo $_SESSION["greenhouse_name"];
       } else {
        //    echo "<script>window.location = '../php/greenhouse_form.php'; </script>";
       }
       $result_greenhouse->free();
   }


    
    echo "<script> alert('*แก้ไขข้อมูลฟาร์มสำเร็จ*'); </script>";
    // echo $_SESSION["farm_name"];
    echo "<script> window.location='../php/ShowFarm.php'</script>";

}

}else{
    echo "<script> alert('*การเข้าถึงไม่ถูกต้อง*'); </script>";
    // echo $_SESSION["farm_name"];
    echo "<script> window.location='../php/ShowFarm.php'</script>";


}
?>