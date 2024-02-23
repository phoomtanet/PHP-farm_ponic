<?php


include '../Connect/conn.php';
include '../Connect/session.php';

$sql_farm = "SELECT * FROM `tb_farm` as a INNER JOIN `tb_user` AS b ON a.id_user = b.id_user
WHERE b.id_user = '$id_user_session';";

$sql_greenhouse = "SELECT a.name_greenhouse 
FROM `tb_greenhouse` as a
INNER JOIN `tb_farm` AS b ON a.id_farm  = b.id_farm 
INNER JOIN `tb_user` AS c ON b.id_user = c.id_user
WHERE c.id_user = '$id_user_session' AND b.id_farm = '$id_farm_session';";

$result_farm = mysqli_query($conn, $sql_farm);
$result_greenhouse = mysqli_query($conn, $sql_greenhouse);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>

</style>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top border  d-flex flex-wrap">
    <div class="container-fluid   mx-2">

      <div class="d-flex justify-content-center align-items-center ">
        <!-- Toggle Button -->
        <button class="btn menu-btn" type="button" style="display: none;"  onclick=" show_side_menu(); toggleChart();">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand Logo (Home Link) -->

      </div>
      <div class=" d-flex btn-group justify-content-center align-items-center   ">

        <form class="d-flex " method="post" action="../phpsql/sreach_farm.php">
          <div class="dropdown mx-3">
            <button class="btn  btn-secondary  dropdown-toggle" type="button" id="farmDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo 'ฟาร์ม : ' . $farm_name; ?>
            </button>

            <ul class="dropdown-menu" aria-labelledby="farmDropdown">
              <li class="dropdown-item "> <a class="text-primary" href="../php/ShowFarm.php"> จัดการฟาร์ม</a></li>

              <?php foreach ($result_farm as $col) {
                echo '<li><button type="submit" name="farm_name" value="' . $col['name_farm'] . '" class="dropdown-item">' . $col['name_farm'] . '</button></li>';
              } ?>

            </ul>
          </div>
        </form>

        <!-- Dropdown 2  เพิ่ม collapse ในการย่อ-->

        <form class="d-flex" method="post" action="../phpsql/sreach_greenhouse.php">
          <div class="dropdown mx-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="greenhouseDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo 'โรงเรือน : ' . $greenhouse_name; ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="greenhouseDropdown">
              <li class="dropdown-item "> <a class="text-primary" href="../php/ShowGreenhouse.php"> จัดการโรงเรือน</a></li>

              <?php foreach ($result_greenhouse as $col) {
                echo '<li><button type="submit" name="greenhouse_name" value="' . $col['name_greenhouse'] . '" class="dropdown-item"> ' . $col['name_greenhouse']  . '</button></li>';
              } ?>




            </ul>

          </div>
        </form>
      </div>

    </div>
  </nav>


  

  <div class="collapse navbar-collapse">
    <ul class="navbar-nav  menu-top">
      <li class="nav-item">
      </li>
      <a class="nav-link top_nav_menu" href="../php/show_germination.php">การเพาะเมล็ด</a>
    
      <li class="nav-item">
        <a class="nav-link top_nav_menu" href="../php/plot_nursery.php">การอนุบาลผัก</a>
      </li>
      <li class="nav-item">
        <a class="navbar-brand top_nav_menu" href="../php/index.php">การปลูกผัก</a>

      </li>
      <li class="nav-item">
        <a class="nav-link top_nav_menu" href="../php/ShowHarvest.php">การเก็บเกี่ยว</a>
      </li>
      <li class="nav-item">
        <a class="nav-link top_nav_menu" href="../php/ShowVegetable.php">ข้อมูลผัก</a>
      </li>
      
      <!-- <li class="nav-item">
        <a class="top_nav_menu" href="../grap/grap_status.php">ภาพรวม</a>
      </li> -->
      <li class="nav-item">
        <a class="top_nav_menu" href="../grapnew/dashboard.php">ภาพรวม</a>
      </li>


      <li class="nav-item">

      <li class="nav-item dropdown top_nav_menu">
        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="navbar-brand" style="width: 32px;border-radius: 56px;" src="../img/<?php echo $photo_name ?>">
          <?php echo $f_name; ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
          <li><a class="dropdown-item" href="../php/ShowUser.php">จัดการบัญชี</a></li>
          <li><a class="dropdown-item" href="../php/logout.php">ออกจากระบบ</a></li>

        </ul>
      </li>
      </li>

      </li>

    </ul>
  </div>


  </nav>
</body>

</html>

