<?php
include 'connection.php';


// Initialize delete_alert
$delete_alert = '';

// Delete functionality
if (isset($_GET['delete_id'])) {
  $id = $_GET['delete_id'];
  $query = "SELECT image FROM carouselimages WHERE id = '$id'";
  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($result);
  $image_path = "carouselimg/" . $row['image'];

  // Delete the image file
  if (file_exists($image_path)) {
    unlink($image_path);
  }

  // Delete the record from the database
  $delete_query = "DELETE FROM carouselimages WHERE id = '$id'";
  mysqli_query($con, $delete_query);

  // Set delete_alert
  $delete_alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Image deleted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';

  header("refresh:4;url=carouseldata.php");
  exit();
}

// Update functionality
$update_alert = '';
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $image = $_POST['oldimg'];

  // Check if a new image was uploaded
  if ($_FILES['image']['name']) {
    $image_path = 'carouselimg/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

    // Delete the old image
    if (file_exists($image)) {
      unlink($image);
    }

    $image = basename($_FILES['image']['name']);
  }

  $update_query = "UPDATE carouselimages SET image = '$image' WHERE id = '$id'";
  mysqli_query($con, $update_query);

  // Set update_alert
  $update_alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Image updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';

  header("refresh:4;url=carouseldata.php");
  exit();
}

// Fetch carousel images
$query = "SELECT * FROM carouselimages";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="cssfiles/fetch.css">
  <link rel="stylesheet" href="cssfiles/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Carousel Images</title>
</head>

<body>
  <?php
  include 'requireddashboard.php';
  ?>

  <div class="container mt-5">
    <h1>Carousel Images</h1>
    <?php echo $delete_alert; ?>
    <?php echo $update_alert; ?>
    <table class="table table-light table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">IMAGE</th>
          <th scope="col">UPDATE</th>
          <th scope="col">DELETE</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0) : ?>
          <?php foreach ($result as $row) : ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td>
                <img src="<?php echo "carouselimg/" . $row['image']; ?>" width="100px" alt="image">
              </td>
              <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-file-pen fa-2xl" style="color: blue;"></i></a>
              </td>
              <td>
                <a href="carouseldata.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa-sharp fa-solid fa-trash fa-2xl" style="color: red;"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="4">No Data Available</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>

</html>