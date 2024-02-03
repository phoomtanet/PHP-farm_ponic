<?php
// เริ่ม session
session_start();

// ลบข้อมูล session ทั้งหมด

unset($_SESSION["user"]);
unset($_SESSION["farm_name"]);
unset($_SESSION["f_name"]);
unset($_SESSION["greenhouse_name"]);
unset($_SESSION["photo_name"]);


    // ส่งผู้ใช้ไปยังหน้าหลักหรือหน้า login หลังจากออกจากระบบ
    header("Location: loginform.php");
    exit;

?>
