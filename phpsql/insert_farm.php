<?php 
include '../Connect/conn.php';


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

    $sql_farm_session = "SELECT a.id_farm FROM `tb_farm` as a WHERE a.id_user = '$id_user_session'AND a.name_farm = '$namefarm';";
    $resultd_farm_session = mysqli_query($conn, $sql_farm_session);
    if ($resultd_farm_session) {
        $row_farm_session = mysqli_fetch_assoc($resultd_farm_session);
        $id_farm_session  = $row_farm_session['id_farm'];
        
    }


    
    echo "<script> alert('*แก้โรงเรือนสำเร็จ*'); </script>";
    // echo $_SESSION["farm_name"];
    echo "<script> window.location='../php/ShowFarm.php'</script>";

}

}else{
    echo "<script> alert('*การเข้าถึงไม่ถูกต้อง*'); </script>";
    // echo $_SESSION["farm_name"];
    echo "<script> window.location='../php/ShowFarm.php'</script>";


}
?>