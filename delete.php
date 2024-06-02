<?php
include 'connection.php';
include 'requireddashboard.php';
?>
<?php

$id=$_GET['id'];
$query="SELECT * FROM carouselimages WHERE id='$id'";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
print_r($row);
unlink("carouselimg/".$row['image']);
$sql="DELETE FROM carouselimages WHERE id='$id'";
$deleted=mysqli_query($con,$sql);
if($deleted){
    header('location:carouseldata.php');
}
else{
    echo "not deleted";
}

?>


