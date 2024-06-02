<?php
include 'connection.php';
include 'requireddashboard.php';
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cssfiles/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Update Image</title>
</head>
<body>
<?php
 $id=$_GET['id'];
 $query="SELECT * FROM decorations WHERE id='$id'";
 $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)>0){
        foreach($result as $row){
          ?>
<div class="container text-center ">
    <h3>select Image For Update In Decoration</h3>
<div class="mb-2 ">
<form action="fetchdecorations.php" method="post" enctype="multipart/form-data">
  <input class="form-control" type="file" name="image">
  <input type="hidden" name="oldimg" value="<?php echo $row['image'];?>" >
<input type="submit" name="update" value="UPDATE" class="btn btn-success my-3">
</form>
</div>      
<?php  
            }
        }

        else{
            echo "no data Available";
        }
        ?>
        
<?php

    $id=$_POST['id'];
    $newimag=$_FILES['newimage']['name'];
    $oldimg=$_POST['image'];
    if($newimag!=''){
        $updatefile=$_FILES['newimage']['name'];
    }else{
        $updatefile=$oldimg;
    }
    if(file_exists("./decorations/BirthdayDecoration".$_FILES['image']['name'])){
        $filename=$_FILES['image']['name'];
        echo "image already exist".$filename;
    }
    else{
        $query="UPDATE decorations SET image='$filename' WHERE id='$id'";
        $result=mysqli_query($con,$query);

        if($result){
            if($_FILES['image']['name']!=''){
            move_uploaded_file($_FILES['image']['tmp_name'],"./decorations/BirthdayDecoration".$_FILES['image']['name']);
        unlink("./decorations/BirthdayDecoration".$oldimg);
            }
        }else{
echo "not Uploaded Successfully";
        }
    }

?>
</body>
</html>