<?php
include 'connection.php';
include 'requireddashboard.php';
$id=$_GET['id'];
$sql="DELETE FROM bookevent WHERE id='$id'";
$deleted=mysqli_query($con,$sql);
if($deleted){
    header('location:fetchevent.php');
}
else{
    echo "not deleted";
}
?>