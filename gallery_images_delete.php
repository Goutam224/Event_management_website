<?php
include 'connection.php';
include 'requireddashboard.php';
?>
<?php

$decoration_id=$_GET['decoration_id'];
$query="SELECT * FROM decoration_gallery_images WHERE decoration_id='$decoration_id'";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
unlink("decorations/".$row['image']);
$sql="DELETE FROM decoration_gallery_images WHERE decoration_id='$decoration_id'";
$deleted=mysqli_query($con,$sql);

if($deleted){
    header('location:fetch_gallery_images.php');
}
else{
    echo "not deleted";
}


?>


