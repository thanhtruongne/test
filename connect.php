<?php 
    $conn = mysqli_connect('localhost','root','','assign');
    if(!$conn) throw new ErrorException('', mysqli_connect_error());
 
?>