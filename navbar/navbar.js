function show_side_menu() {
  let left_pos = parseInt(document.querySelector(".side-menu").style.left.replace("px", ""));
  let chartContainer = document.getElementById("Count-veg");

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



