<?php
function calculateNextFertilizerDate($planting_date, $fertilizer_day)
{
    // แปลงวันที่ปลูกเป็นวัตถุ DateTime
    $plantingDateTime = new DateTime($planting_date);
    
    // คำนวณวันที่ให้ปุ๋ยครั้งต่อไปโดยเพิ่มจำนวนวันที่ระบุใน $fertilizer_day
    $fertilizerDateTime = clone $plantingDateTime;
    $fertilizerDateTime->modify("+$fertilizer_day days");
    
    // คืนค่าวันที่ให้ปุ๋ยในรูปแบบ Y-m-d
    return $fertilizerDateTime->format('Y-m-d');
}

// ตัวอย่างการใช้งานฟังก์ชัน
$planting_date = '2023-8-1'; // วันที่ปลูก
$fertilizer_day = 40; // วันให้ปุ๋ย

$next_fertilizer_date = calculateNextFertilizerDate($planting_date, $fertilizer_day);
$today = new DateTime(); // วันที่ปัจจุบัน
$diff = $today->diff(new DateTime($next_fertilizer_date));
$days_left_for_fertilizer = $diff->days;


echo "ปลูกเมื่อ $planting_date ";
echo "<br><br>";
echo "ระยะเวลาเติบโต $fertilizer_day วัน ";
echo "<br><br>";
echo "วันที่เก็บเกี่ยว: $next_fertilizer_date";
echo "<br><br>";
echo " เหลืออีก $days_left_for_fertilizer วัน";
?>
