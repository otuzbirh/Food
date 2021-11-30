<!--  connection to database -->

<?php 

$conn = mysqli_connect('localhost', 'root', '', 'food');

//checking connection

if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}
?>