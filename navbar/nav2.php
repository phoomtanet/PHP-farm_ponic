
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bootstrap 5</title>
</head>
<style>

</style>

<body>
<div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
      <ul class="nav nav-pills flex-column mb-auto pt-5 side_nav_menu"></ul>
    </div>
    <!-- เนื้อหาหลัก -->
    <div class="pt-5 main-content-div" style=" text-align: center;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top border  d-flex flex-wrap">
    <div class="container-fluid   mx-3 ">

      <div class="d-flex justify-content-center align-items-center ">
        <!-- Toggle Button -->
        <button class="btn menu-btn" type="button" style="display: none;" onclick="show_side_menu()">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand Logo (Home Link) -->

      </div>
      <div class=" d-flex btn-group justify-content-center align-items-center   ">

        <form class="d-flex " method="post" action="../phpsql/sreach_farm.php">
          <div class="dropdown mx-3">
            <button class="btn  btn-success  dropdown-toggle" type="button" id="farmDropdown" data-bs-toggle="dropdown" aria-expanded="false">
             ฟาร์ม
            </button>

     
          </div>
        </form>

        <!-- Dropdown 2  เพิ่ม collapse ในการย่อ-->

        <form class="d-flex" method="post" action="../phpsql/sreach_greenhouse.php">
          <div class="dropdown mx-3">
            <button class="btn btn-success dropdown-toggle" type="button" id="greenhouseDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            ฟาร์ม
            </button>
    
          </div>
        </form>
      </div>

    </div>
  </nav>


  

  <div class="collapse navbar-collapse">
    <ul class="navbar-nav  menu-top">
      <li class="nav-item">
        <a class="navbar-brand top_nav_menu" href="../php/index.php">การปลูกผัก</a>
      </li>
    
      <li class="nav-item">
        <a class="nav-link top_nav_menu" href="../php/plot_nursery.php">การอนุบาลผัก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link top_nav_menu" href="../php/show_germination.php">การเพาะเมล็ด</a>
      </li>
      <li class="nav-item">
        <a class="nav-link top_nav_menu" href="../php/ShowVegetable.php">ข้อมูลผัก</a>
      </li>
      <li class="nav-item">
        <a class="top_nav_menu" href="../grap/grap_status.php">ภาพรวม</a>
      </li>


      <li class="nav-item">

      <li class="nav-item dropdown top_nav_menu">
        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="navbar-brand" style="width: 32px;border-radius: 56px;" src="../img/pp1.png">
          ปอ
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
 <script>

    
function show_side_menu() {
  let left_pos = parseInt(document.querySelector(".side-menu").style.left.replace("px", ""));
  if (left_pos == -250) {
      moveSideMenu(5, 5);
  } else {
      moveSideMenu(-5, -5);
  }
}
function moveSideMenu(leftOffset, paddingLeftOffset) {
  var left_pos = parseInt(document.querySelector(".side-menu").style.left.replace("px", ""));
  var menu_animation = setInterval(function () {
      left_pos += leftOffset;
      document.querySelector(".side-menu").style.left = left_pos.toString() + "px";
      var left_content = parseInt(document.querySelector(".main-content-div").style.paddingLeft.replace("px", ""));
      left_content += paddingLeftOffset;
      document.querySelector(".main-content-div").style.paddingLeft = left_content.toString() + "px";
      if ((leftOffset > 0 && left_pos >= 0) || (leftOffset < 0 && left_pos <= -250)) {
          clearInterval(menu_animation);
      }
  }, 1);
}


function responsive()//function กำหนดให้ซ่อนปุ่ม เปิดปิด เมนูข้าง หรือแสดงเมนูบน
{
 
    document.querySelector(".menu-top").style.display = "none";//ซ่อนเมนูบน
    document.querySelector(".menu-btn").style.display = "";//แสดงปุ่มสำหรับเมนูข้าง

}

(function () {
  //-----เมื่อเปิดหน้าเว็บมาเราจะให้ เมนูด้านบน กับ Side เมนูด้านข้างมีเมนูแบบเดียวกัน
  var top_nav_menu = document.querySelectorAll(".top_nav_menu");
  var side_menu_html = "";
  top_nav_menu.forEach(element => {
    side_menu_html += `<li class="nav-item">
      <a href="${element.href}" class="nav-link text-white ">
          ${element.innerHTML}
      </a>
    </li>`;
  });
  document.querySelector(".side_nav_menu").innerHTML = side_menu_html;

  responsive();

})();
// ถ้าหน้าเว็บมีการเปลี่ยนขนาดให้เรียก function responsive() เพื่อ ดูว่าจะซ่อน หรือ แสดงเมนูบน
window.addEventListener("resize", function () {

  responsive();

});




 </script>
</body>

</html>


