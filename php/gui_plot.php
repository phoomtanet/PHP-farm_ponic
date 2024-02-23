<div class="d-inline-flex justify-content-center mt-4">
    <div class="d-inline-flex justify-content-around flex-wrap ">
        <!-- <div class=" border p-3"> -->
        <?php foreach ($result_plot as $col) {
            $sql_vegetable_amount = "SELECT SUM(vegetable_amount) AS total_vegetable_amount FROM tb_planting WHERE id_plot = " . $col['id_plot'];
            $result = $conn->query($sql_vegetable_amount);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $total_vegetable_amount = $row['total_vegetable_amount'];
            }
        ?>

            <?php if ($col['status'] == 0) { ?>
                <div class="mx-4 my-2 border flex-column p-1  bg-emp border border-3 border-dark Small shadow d-flex justify-content-center align-items-center" style="border-radius: 5px; ">
                    <div class="inline-flex border m-1 bg-white " style=" display: flex; justify-content: center; align-items: start;">
                        <table style="text-align: left; width:280px; height: 300px;" class="  border-primary">
                            <tr>
                                <th style="text-align: center;" scope="row">แปลง :
                                    <?php echo  ' '  . $col['plot_name']  ?>
                                    </td>
                            </tr>
                            <tr style="text-align: center;">
                                <th scope="row">ช่องว่าง :
                                    <b class="text-danger"> <?php echo  ' ' . $col['row'] * $col['column'] - $total_vegetable_amount;    ?></b><span> ช่อง</span>

                                </th>
                            </tr>
                            <td style="padding-top:100px; "> </td>
                            <tr>
                                <td scope="col" style="text-align: center;">
                                    <i class=" edit_plot btn fas fa-edit text-warning  " style='font-size:20px' data-bs-toggle="modal" data-bs-target="#edit_plot" title="แก้ไขแปลงปลูก" data-edit_plot_name="<?= $col['plot_name'] ?>" data-edit_plot_col="<?= $col['column'] ?>" data-edit_plot_row="<?= $col['row'] ?>" data-id_edit_plot="<?= $col['id_plot'] ?>"> </i>
                                    <a class="btn fa-regular fa-trash-alt text-danger " style='font-size:20px' href="../phpsql/insert_plot.php?id_plot_del=<?= $col['id_plot'] ?>" onclick="Del(this.href);return false;"> </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table class=" bg-white ">
                        <tr>
                            <?php for ($i = 0; $i < 4; $i++) {
                            ?>
                                <td style="border-right: 1px solid #000 ">
                                    <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>" style="text-decoration: none; color: #333;">

                                        <img src="../img/emp.jpg" class="m-1 " style="width: 60px;   border-radius: 50px; ">
                                </td>
                            <?php } ?>



                        </tr>

                    </table>
                </div>
                </a>
            <?php } ?>
            <?php if ($col['status'] == 1) {
                $escapedPlotName = mysqli_real_escape_string($conn, $col['plot_name']); // Escape the value to prevent SQL injection
                $sql_plan = "SELECT *FROM `tb_plot` as a 
        INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
        INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
        INNER JOIN tb_user as d on c.id_user = d.id_user 
        LEFT JOIN tb_planting as e on a.id_plot = e.id_plot
        LEFT JOIN tb_veg_farm as vf on vf.id_veg_farm = e.id_veg_farm   
        LEFT JOIN tb_vegetable  as v on v.id_vegetable  = vf.id_vegetable    
        LEFT JOIN tb_fertilizationdate as g on   g.id_plot = e.id_plot
        WHERE b.id_greenhouse = '$id_greenhouse_session' AND a.plot_name = '$escapedPlotName'
        GROUP BY e.id_planting";
                $result_plan = mysqli_query($conn, $sql_plan);
            ?>
                <?php

                foreach ($result_plan as $row) {
                    $fertilizing_everyDays = $row['fertilizing_everyDays'];
                    if (isset($row['fertilizationDate'])) {
                        $fertilization_date_str = $row['fertilizationDate']; // วันที่ให้ปุ่ยล่าสุดในรูปแบบสตริง
                        $fertilization_date = new DateTime($fertilization_date_str); // สร้าง DateTime จากสตริง

                        $today = new DateTime(); // วันที่ปัจจุบัน
                        $interval = $today->diff($fertilization_date);
                        $days_difference = $interval->days; // วันที่ผ่านมา จากวันให้ปุ๋ยล่าสุด
                        $fertilization_date_formatted = $fertilization_date->format('Y-m-d'); //วันที่ให้ปุ๋ยล่าสุด
                        //  echo "วันที่ให้ปุ๋ยล่าสุด: {$fertilization_date_formatted}";
                        //  echo "ผ่านมาทั้งหมด {$days_difference} วัน";
                    } else {
                        $days_difference = 0;
                    }
                }
                ?>
                <?php if ($days_difference >= $fertilizing_everyDays) {   ?>
                    <div data-bs-toggle="modal" data-bs-target="#add_fertilizer" class="add_fertilizer bg-fer  mx-4 my-2 border flex-column p-1  border border-3 border-dark Small shadow d-flex justify-content-center align-items-center " style="border-radius: 5px;  " data-id_fertilizationDate="<?= $row["id_fertilizationDate"] ?>" data-plot_name2="<?= $col["plot_name"] ?>">

                    <?php  } else { ?>
                        <div class="mx-4 my-2 border flex-column p-1 bg-add border border-3 border-dark Small shadow d-flex justify-content-center align-items-center" style="border-radius: 5px; ">


                        <?php  } ?>

                        <div class="inline-flex border m-1 px-4 bg-white" style=" width:280px; height: 300px; display: flex; justify-content: center; align-items: start;">
                            <table style="text-align: left;">
                                <tr style="text-align: center;">
                                    <th scope="row">แปลง :<?php echo  ' ' . $col['plot_name']  ?> </th>

                                </tr>
                              
                                <td>
                                    <?php
                                    $count = 1;
                                    foreach ($result_plan as $row) {
                                        $nurseryDate = new DateTime($row['planting_date']);
                                        $currentDate = new DateTime(); // วันที่ปัจจุบัน
                                        $diff = $nurseryDate->diff($currentDate);
                                        $age = $diff->format('%a');
                                    ?>
                                        <tr class="border-bottom"  style="text-align: center;">
                                            <td colspan="3"><?php echo '<b>' . $count . ". " . $row['vegetable_name']  ?>
                                        
                                        </td>
                                        <tr class="border-bottom">
                                    <td>
                                       <small class="text-muted "><?='อายุผัก: '. $age . ' วัน จำนวน: '.$row['vegetable_amount'] .' ต้น'?></small>
                                        </td>
                                        </tr>

                                    <?php
                                        $count++;
                                    }  ?>
                                    <tr>
                                        <!-- ถ้ามีช่องว่าง -->
                                        <?php if ($col['row'] * $col['column'] - $total_vegetable_amount > 0) { ?>
                                            <td style="text-align: center;">
                                                <b>ช่องว่าง: <span class="text-danger"> <?php echo    '' . $col['row'] * $col['column'] - $total_vegetable_amount  ?></b></span>
                                            </td>
                                        <?php  } else { ?>
                                            <th style="text-align: center;">
                                                ช่องว่าง: <span class="text-success "> <b>เต็ม</b></span>
                                            </th>
                                        <?php   } ?>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;" scope="col">ข้อมูล :
                                            <span class="text-success"> <a href="../php/information_plot.php?id_plot_data=<?= $col['id_plot'] ?>&plot_name=<?= $col['plot_name'] ?>&slot=<?= $col['row'] * $col['column'] - $total_vegetable_amount ?>">เพิ่มเติม</a></span>
                                        </th>

                                    </tr>
                            </table>
                        </div>
                        <table class="bg-white">
                            <tr>
                                <?php
                                $rowCount = 0;
                                foreach ($result_plan as $row1) {
                                    $rowCount++;
                                }
                                if (!empty($result_plan)) {
                                    foreach ($result_plan as $row1) {
                                        if ($rowCount > 0) {
                                            $nurseryDate1 = new DateTime($row1['planting_date']);
                                            $currentDate1 = new DateTime();
                                            $diff1 = $nurseryDate1->diff($currentDate1);
                                            $age1 = $diff1->format('%a');

                                            if ($row1['vegetable_age'] <=   $age1) {
                                ?>
                                                <!-- ถึงวันเก็บเกี่ยว สีเหลือง-->
                                                <td class="bg-har  add-harvest" data-bs-toggle="modal" data-bs-target="#add_harvest" data-vegetable_amount="<?= $row1["vegetable_amount"] ?>" data-vegetable_name="<?= $row1["vegetable_name"] ?>" data-plot_name="<?= $row1["plot_name"] ?>" data-id_plot="<?= $row1["id_plot"] ?>" data-id_vegetable="<?= $row1["id_veg_farm"] ?>" data-id_plan="<?= $row1["id_planting"] ?>" style="border-right: 1px solid #000;">
                                                    <img src="../img/<?php echo $row1['img_name']  ?>" class="m-1 " style="width: 60px;     border-radius: 50px; ">
                                                </td>
                                                <!-- ยังไม่ถึงวันเก็บเกี่ยว-->
                                            <?php       } else if ($rowCount <= 3) { ?>
                                                <td style="border-right: 1px solid #000;"><img src="../img/<?php echo $row1['img_name']  ?>" class="m-1 " style="width: 60px;     border-radius: 50px; "></td>

                                            <?php   } else if ($rowCount == 4) { ?>


                                                <td style="border-right: 1px solid #000;"><img src="../img/<?php echo $row1['img_name']  ?>" class="m-1 " style="width: 60px;     border-radius: 50px; "></td>


                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>

                                <!-- มี 1การ ปลูก ยังว่าง-->
                                <?php if ($rowCount == 1 &&  $col['row'] * $col['column'] - $total_vegetable_amount > 0) {

                                    for ($i = 0; $i < 3; $i++) {
                                ?>
                                        <td style="border-right: 1px solid #000">
                                            <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>">
                                                <img src="../img/emp.jpg" class="m-1 " style="width: 60px;   border-radius: 50px; ">
                                            </a>
                                        </td>
                                    <?php } ?>
                            </tr>


                            <!-- มี 1การ ปลูก แล้วเต็ม-->

                        <?php } else if ($rowCount == 1) { ?>
                            <?php for ($i = 0; $i < 3; $i++) {  ?>
                                <td style="border-right: 1px solid #000">
                                    <img src="../img/full.jpg" class="m-1 " style="width: 60px;   border-radius: 50px; ">
                                </td>
                            <?php } ?>
                        <?php } ?>
                        <!-- มี 2การ ปลูก แล้วว่าง-->
                        <?php
                        if ($rowCount == 2 &&  $col['row'] * $col['column'] - $total_vegetable_amount > 0) {  ?>

                            <?php for ($i = 0; $i < 2; $i++) {  ?>
                                <td>
                                    <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>">
                                        <img src="../img/emp.jpg" class="m-1 " style="width: 60px;   border-radius: 50px; ">
                                    </a>
                                </td>
                            <?php } ?>

                            <!-- มี 2การ ปลูก แล้วเต็ม-->

                        <?php } else if ($rowCount == 2) { ?>
                            <?php for ($i = 0; $i < 2; $i++) {  ?>
                                <td style="border-right: 1px solid #000">
                                    <img src="../img/full.jpg" class="m-1 " style="width: 60px;   border-radius: 50px; ">
                                </td>
                            <?php } ?>

                        <?php } ?>

                        <?php if ($rowCount == 3 &&  $col['row'] * $col['column'] - $total_vegetable_amount > 0) {  ?>


                            <td style="border-right: 1px solid #000">
                                <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>">
                                    <img src="../img/emp.jpg" class="m-1 " style="width: 60px;   border-radius: 50px; ">
                                </a>
                            </td>

                            <!-- มี 2การ ปลูก แล้วเต็ม-->

                        <?php } else if ($rowCount == 3) { ?>
                            <td style="border-right: 1px solid #000">
                                <img src="../img/full.jpg" class="m-1 " style="width: 60px;   border-radius: 50px; ">
                            </td>
                        <?php } ?>



                        </table>
                        </div>
                    <?php } ?>
                <?php } ?>

                    </div>
    </div>
</div>