<?php 
include '../Connect/conn.php';
if (isset($_GET['id_plan'])) {
    $id_plan = $_GET['id_plan'];
    $id_plot = $_GET['id_plot'];
    $plot_name = $_GET['plot_name'];
    $sql_del_plan = "DELETE FROM `tb_planting` WHERE id_planting = $id_plan";
    mysqli_query($conn,$sql_del_plan);
   

   $chack_row_plan = "SELECT COUNT(*) AS row_count FROM tb_planting WHERE id_plot='$id_plot'";
   $result_row_plan = mysqli_query($conn, $chack_row_plan);
   $row = mysqli_fetch_assoc($result_row_plan);
   $row_count = $row['row_count'];
   

   if ($row_count == 0) {
       $update = "UPDATE `tb_plot` SET `status`=0 WHERE id_plot ='$id_plot'";
       mysqli_query($conn, $update);
       $sql_del_fert = "DELETE FROM `tb_fertilizationdate` WHERE id_plot = '$id_plot'";
       mysqli_query($conn, $sql_del_fert);
echo "<script> window.location='../php/index.php'</script>";

   }else{
    echo "<script> window.location='../php/information_plot.php?id_plot_data=$id_plot&plot_name=$plot_name'</script>";

   }
} else {
    echo "ID parameter is missing or empty.";
}
 ?>
