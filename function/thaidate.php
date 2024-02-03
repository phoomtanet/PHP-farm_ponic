<?php 
function thaidate(string $date, string $format = 'd MMMM yyyy'): string
{
    $thaiMonths = [
        'ม.ค',
        'ก.พ',
        'มี.ค.',
        'เม.ย',
        'พ.ค.',
        'มิ.ย',
        'ก.ค.',
        'ส.ค.',
        'ก.ย.',
        'ต.ค.',
        'พ.ย.',
        'ธ.ค.',
    ];

    $date = strtotime($date);
    $day = date('d', $date);
    $month = date('n', $date);
    $year = date('Y', $date) + 543;

    $formattedDate = str_replace(['d', 'M', 'y', 'Y'], [$day, $thaiMonths[$month - 1], $year % 100, $year], $format);

    return $formattedDate;
} ?>