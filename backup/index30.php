<?php
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";

if (!isset($_SESSION['user'])) {
  header('Location: loginform.php');
  exit(); // ให้แน่ใจว่าไม่มีโค้ดเพิ่มเติมที่ทำงานหลัง header
}

$sql_plot = "SELECT * FROM `tb_plot` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse
INNER JOIN tb_farm  as c  on b.id_farm = c.id_farm
INNER JOIN tb_user as d on  c.id_user = d.id_user
WHERE d.user_name = '$user' AND c.name_farm = '$farm_name' AND b.name_greenhouse ='$greenhoues_name';";

$result_plot = mysqli_query($conn, $sql_plot);
?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- เรียกใช้ ฺBootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" ></script>

    <title>Bootstrap 5</title>
  </head>
  <body>

    <!-- สร้าง Top เมนู -->
    <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top navbar-green">

      <div class="container-fluid">
        <!-- ปุ่มสำหรับเปิด เมนูด้านข้าง ( กำหนดให้ ยังไม่แสดงเป็นค่าเริ่มต้น และจะแสดงเมื่อหน้าจอเล็กกว่า หรือเท่ากับ 768 )
            เมื่อกดแล้ว จะไปทำงานที่ function show_side_menu() เพื่อแสดง Side เมนู
          -->
        <button class="btn menu-btn" type="button" style="display: none;" onclick="show_side_menu()">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand">&nbsp;หน้าแรก</a>
        <!---- เมนูที่มี ---->
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 menu-top">
            <li class="nav-item">
              <a class="nav-link top_nav_menu" href="../php/ShowVegetable.php">ข้อมูลผัก</a>
            </li>
            <li class="nav-item">
              <a class="nav-link top_nav_menu" href="uiplot.php">แบบจำลองแปลงผัก</a>
            </li>
            <li class="nav-item">
              <a class="nav-link top_nav_menu" href="../grap/grap.php">ภาพรวม</a>
            </li>
            <li class="nav-item">
              <a class="nav-link top_nav_menu" href="#">Menu 4</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
   
    <!---- เมนูด้านข้าง ( Side Menu ) ---->
    <div class="d-flex flex-column p-3 text-white bg-dark side-menu " style="width: 280px;height:100vh;position:fixed;left:-280px">
        
        <ul class="nav nav-pills flex-column mb-auto pt-5 side_nav_menu">
        
           
        </ul>
        

    </div>

    


      <div class=" pt-5 main-content-div" style="padding-left: 10px;">

        <div class="container pt-3">
            <!---- เมนูด้านข้าง ( Side Menu ) ---->
            <h1>เนื้อหาเว็บ</h1>
            <a href="https://รับเขียนโปรแกรม.net" title="รับเขียนโปรแกรม ระบบฐานข้อมูล ระบบจัดการ WebApplication" >www.รับเขียนโปรแกรม.net</a>
            www.รับเขียนโปรแกรม.net

        </div>
        
      </div>

      <script>

        function show_side_menu()//function สำหรับแสดง หรือซ่อน side เมนู
        {
            let left_pos=parseInt(document.querySelector(".side-menu").style.left.replace("px",""));

            if(left_pos==-280)//ถ้า side เมนูยังไม่แสดง ให้แสดง side เมนู แบบ animation
            {

                var menu_animation=setInterval(function(){

                    left_pos+=5;
                    document.querySelector(".side-menu").style.left=left_pos.toString()+"px";

                    var left_content=parseInt(document.querySelector(".main-content-div").style.paddingLeft.replace("px",""));
                    left_content+=5;

                    document.querySelector(".main-content-div").style.paddingLeft=left_content.toString()+"px";

                    
                    if(left_pos==0)
                    {
                        clearInterval(menu_animation);
                    }

                },1);
            }
            else
            {   //ถ้า side เมนูยังแสดงอยู่ ให้ซ่อน side เมนู แบบ  animation
                 var menu_animation=setInterval(function(){

                    left_pos-=5;
                    document.querySelector(".side-menu").style.left=left_pos.toString()+"px";

                    var left_content=parseInt(document.querySelector(".main-content-div").style.paddingLeft.replace("px",""));
                    left_content-=5;
                    
                    document.querySelector(".main-content-div").style.paddingLeft=left_content.toString()+"px";
                    
                    if(left_pos==-280)
                    {
                        clearInterval(menu_animation);
                    }

                },1);
            }
            
        }

        function responsive()//function กำหนดให้ซ่อนปุ่ม เปิดปิด เมนูข้าง หรือแสดงเมนูบน
        {
            if(window.innerWidth <= 768)//หน้าจอน้อยกว่า หรือเท่ากับ 768
            {
                document.querySelector(".menu-top").style.display="none";//ซ่อนเมนูบน
                document.querySelector(".menu-btn").style.display="";//แสดงปุ่มสำหรับเมนูข้าง
            }
            else
            {
                document.querySelector(".menu-top").style.display="";//ซ่อนเมนูบน
                document.querySelector(".menu-btn").style.display="none";//ซ่อนปุ่มสำหรับเมนูข้าง
            }
        }
        
        (function(){
          //-----เมื่อเปิดหน้าเว็บมาเราจะให้ เมนูด้านบน กับ Side เมนูด้านข้างมีเมนูแบบเดียวกัน
          var top_nav_menu=document.querySelectorAll(".top_nav_menu");
          var side_menu_html="";
          top_nav_menu.forEach(element => {
              side_menu_html+=`<li class="nav-item">
              <a href="${element.href}" class="nav-link text-white ">
                  ${element.innerHTML}
              </a>
            </li>`;
          });
          document.querySelector(".side_nav_menu").innerHTML=side_menu_html;

          responsive();

        })();
        // ถ้าหน้าเว็บมีการเปลี่ยนขนาดให้เรียก function responsive() เพื่อ ดูว่าจะซ่อน หรือ แสดงเมนูบน
        window.addEventListener("resize", function(){

            responsive();
            
        });
        //หากมีการคลิกที่เนื้อหาเว็บ แต่ Side เมนูเปิดอยู่ ให้ซ่อน Side เมนู
        document.querySelector("body").addEventListener("click", function(){

            let left_pos=parseInt(document.querySelector(".side-menu").style.left.replace("px",""));
            if(left_pos==0)
            {
                 var menu_animation=setInterval(function(){

                    left_pos-=5;
                    document.querySelector(".side-menu").style.left=left_pos.toString()+"px";

                    var left_content=parseInt(document.querySelector(".main-content-div").style.paddingLeft.replace("px",""));
                    left_content-=5;
                    
                    document.querySelector(".main-content-div").style.paddingLeft=left_content.toString()+"px";
                    
                    if(left_pos==-280)
                    {
                        clearInterval(menu_animation);
                    }

                },1);
            }
            
        });

    </script>


  </body>
</html>
