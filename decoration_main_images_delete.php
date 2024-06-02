<?php
include 'connection.php';
include 'requireddashboard.php';
?>
<?php

$id=$_GET['id'];
$query="SELECT * FROM decorations WHERE id='$id'";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
$path="/decorations";
$images=glob($path);
foreach($images as $image1){
    unlink($image1);
}
// unlink("decorations/car decoration/".$row['image']);
$sql="DELETE FROM decorations WHERE id='$id'";
$deleted=mysqli_query($con,$sql);
if($deleted){
    header('location:fetchdecoration.php');
}
else{
    echo "not deleted";
}

?>


