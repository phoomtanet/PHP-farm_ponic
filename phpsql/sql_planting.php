<?php 

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = $_GET['id'];
    echo $name;
} else {
    echo "ID parameter is missing or empty.";
}
 ?>
