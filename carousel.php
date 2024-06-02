<?php
include 'connection.php';
include 'requireddashboard.php';
?>
<?php
if(isset($_POST['upload'])){
$file=$_FILES['image']['name'];


$allowed_extension=array('png','jpg','jpeg');
$filename=$_FILES['image']['name'];
$file_extension=pathinfo($filename,PATHINFO_EXTENSION);
if(!in_array($file_extension,$allowed_extension)){
    echo "You are allowed with only jpg,jpeg and png";
}
else{
    if(file_exists("carouselimg/".$_FILES['image']['name'])){
        $filename=$_FILES['image']['name'];
        echo "image already exist".$filename;

    }
    else{
$query="INSERT INTO carouselimages(image) VALUES('$file')";
$res=mysqli_query($con,$query);
if($res){
    move_uploaded_file($_FILES['image']['tmp_name'],"./carouselimg/$file");
    echo "uploaded";
}
else{
    echo "failed to upload";
}
}
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="cssfiles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>carouse</title>
</head>
<body>
<div class="container text-center ">
    <h3>Select Image For Carousel</h3>
<div class="mb-2 ">
<form  method="post" enctype="multipart/form-data">
  <input class="form-control" type="file"  name="image" required>
<input type="submit" name="upload" value="UPLOAD" class="btn btn-success my-3">
</form>
</div>
</body>
</html>