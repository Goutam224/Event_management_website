<?php 
include 'connection.php';

// Delete functionality
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    // Fetch the image path and category directory
    $query = "SELECT image, decoration_type FROM decorations WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $image_path = $row['image'];
    $category_directory = 'decorations/' . $row['decoration_type'] . '/';

    // Delete the image file
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Delete the record from the database
    $delete_query = "DELETE FROM decorations WHERE id = '$id'";
    mysqli_query($con, $delete_query);

    // Redirect to decorations.php after deletion
    header("Location: decorations.php");
    exit();
}

// Update functionality
$update_alert = '';
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $decoration_type = $_POST['decoration_type'];
    $image = $_POST['current_image'];

    // Check if a new image was uploaded
    if ($_FILES['image']['name']) {
        $image_path = 'decorations/' . $decoration_type . '/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

        // Delete the old image
        if (file_exists($image)) {
            unlink($image);
        }

        $image = $image_path;
    }

    $update_query = "UPDATE decorations SET decoration_type = '$decoration_type', image = '$image' WHERE id = '$id'";
    mysqli_query($con, $update_query);

    // Redirect to decorations.php after update
    header("Location: decorations.php");
    exit();
}

// Fetch decorations
$query = "SELECT * FROM decorations";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Decoration Main Images</title>
  <link rel="stylesheet" href="cssfiles/fetch.css">
  <link rel="stylesheet" href="cssfiles/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <?php
  include 'requireddashboard.php';
  ?>
<div class="container mt-5">
  <h1>Decoration Main Images</h1>
  <?php echo $update_alert; ?>
  <table class="table table-light table-striped table-hover">
    <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">MAIN IMAGE</th>
        <th scope="col">CATEGORY</th>
        <th scope="col">UPDATE</th>
        <th scope="col">DELETE</th>
      </tr>
    </thead>
    <tbody>
      <?php if(mysqli_num_rows($result) > 0): ?>
        <?php foreach($result as $row): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td>
              <img src="<?php echo $row['image']; ?>" width="100px" alt="image">
            </td>
            <td><?php echo $row['decoration_type']; ?></td>
            <td>
              <a href="decorations.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-file-pen"></i> Edit</a>
            </td>
            <td>
              <a href="decorations.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm"><i class="fa-sharp fa-solid fa-trash"></i> Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">No Data Available</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
