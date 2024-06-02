<?php 
include 'connection.php';

?>
<link rel="stylesheet" href="cssfiles/fetch.css">
<link rel="stylesheet" href="cssfiles/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
$query="SELECT * FROM decoration_gallery_images";
$result=mysqli_query($con,$query);
include 'requireddashboard.php';
?>


<h1>Decoration Gallery Images</h1>
<table class="table table-light table-striped table-hover">
  <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">MAIN IMAGE</th>
     
      <th scope="col">UPDATE</th>
      <th scope="col">DELETE</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(mysqli_num_rows($result)>0){
        foreach($result as $row){
        
            ?>
        <tr>
        <td ><?php echo $row['id'];?></td>
        <td>
            <img src="<?php echo $row['image'];?>" width="100px" alt="image">
        </td>

        <td><a href="decorations.php"><i class="fa-solid fa-file-pen fa-2xl" style="color: blue;"></i></a></td>
        <td><a href="decorations.php"><i class="fa-sharp fa-solid fa-trash fa-2xl" style="color: red;"></i></a></td>

      </tr>
      <?php
        }
    }else
    {
  ?>
    <tr>
        <td>NO Data Available</td>
        <td>NO Data Available</td>
        <td>NO Data Available</td>
        <td>NO Data Available</td>
    </tr>
<?php
    }

   ?>
   
  </tbody>
</table>
