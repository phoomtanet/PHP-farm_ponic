<?php
include '../Connect/conn.php';
session_start();
$user = $_POST['user'];
$pass = $_POST['pass'];

if (isset($_POST['Add'])) {

    //$pass = hash('sha512', $pass);

    $usercheck = "SELECT * FROM  tb_user WHERE user_name='$user' and password ='$pass'";

    $f_name = "SELECT f_name FROM tb_user WHERE user_name = '$user'";

    $photo_name = "SELECT photo_name FROM tb_user WHERE user_name = '$user'";

    $result = mysqli_query($conn, $usercheck);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($result);

    $result_f_name = mysqli_query($conn, $f_name);
    $row_f_name = mysqli_fetch_array($result_f_name);

    $result_photo_name = mysqli_query($conn, $photo_name);
    $row_photo_name = mysqli_fetch_array($result_photo_name);

    $farm_first = "SELECT a.name_farm as first_farm FROM `tb_farm` as a 
    INNER JOIN `tb_user` AS b ON a.id_user = b.id_user
    WHERE b.user_name = '$user' LIMIT 1";

    $result_farm_first  = $conn->query($farm_first);

    if ($row > 0) {
        $_SESSION["user"] = $row['user_name'];
        $_SESSION["pass"] = $row['password'];

        if ($row_f_name > 0) {
            $_SESSION["f_name"] = $row_f_name['f_name'];
        }

        if ($row_photo_name > 0) {
            $_SESSION["photo_name"] = $row_photo_name['photo_name'];
        }

        if ($result_farm_first) {
            $row_first_farm = $result_farm_first->fetch_assoc();

            if ($row_first_farm) {

                $_SESSION["farm_name"] = $row_first_farm['first_farm'];
                $farm_name = $_SESSION["farm_name"];
                
                $greenhouse_first = "SELECT a.name_greenhouse as first_greenhouse FROM `tb_greenhouse` as a
                INNER JOIN `tb_farm` AS b ON a.id_farm  = b.id_farm 
                INNER JOIN `tb_user` AS c ON b.id_user = c.id_user
                WHERE c.user_name = '$user' AND b.name_farm = '$farm_name'
                LIMIT 1;";
                $result_greenhouse  = $conn->query($greenhouse_first);

                if ($greenhouse_first) {

                    $row_greenhouse = $result_greenhouse->fetch_assoc();

                    if ($row_greenhouse) {

                        $_SESSION["greenhouse_name"] = $row_greenhouse['first_greenhouse'];
                        //echo $_SESSION["greenhouse_name"];
                        echo "<script>window.location = '../php/index.php'</script>";

                    } else {

                        echo "<script> alert('*เนื่องจากบัญชีนี้ยังไม่มีโรงเรือนในระบบ กรุณาเพิ่มโรงเรือนก่อนใช้งาน*'); </script>";
                        echo "<script>window.location = '../php/greenhouse_form.php'; </script>";
                    }

                    $result_greenhouse->free();
                }
            } else {

                echo "<script> alert('*เนื่องจากบัญชีนี้ยังไม่มีฟาร์มในระบบ กรุณาเพิ่มฟาร์มก่อนใช้งาน*'); </script>";
                echo "<script>window.location = '../php/farm_form.php'; </script>";
            }

            $result_farm_first->free();
        }
    } else {

        echo '<div style="color: crimson"; >';
        $_SESSION["Error"] = "*รหัสผ่านหรือชื่อบัญชีไม่ถูกต้อง!!*";
        echo '</div>';
        echo "<script>window.location = '../php/loginform.php'</script>";
    }
} else {

    echo "<script>window.location = '../php/loginform.php'</script>";
}

