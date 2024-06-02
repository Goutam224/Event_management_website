<?php
include 'connection.php';
include 'requireddashboard.php';

$update_alert = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM carouselimages WHERE id='$id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (isset($_POST['update'])) {
            $new_image = $_FILES['image']['name'];
            $old_image = $row['image'];

            if ($new_image != '') {
                $target_dir = "./carouselimg/";
                $target_file = $target_dir . basename($_FILES['image']['name']);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if file already exists
                if (file_exists($target_file)) {
                    $update_alert = '<div class="alert alert-danger" role="alert">Image already exists!</div>';
                } else {
                    $update_query = "UPDATE carouselimages SET image='$new_image' WHERE id='$id'";
                    $update_result = mysqli_query($con, $update_query);

                    if ($update_result) {
                        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                        unlink($target_dir . $old_image);
                        $update_alert = '<div class="alert alert-success" role="alert">Image updated successfully!</div>';
                    } else {
                        $update_alert = '<div class="alert alert-danger" role="alert">Failed to update image!</div>';
                    }
                }
            } else {
                $update_alert = '<div class="alert alert-danger" role="alert">Please select an image to update!</div>';
            }
        }
    } else {
        $update_alert = '<div class="alert alert-danger" role="alert">No data available for the specified ID!</div>';
    }
} else {
    $update_alert = '<div class="alert alert-danger" role="alert">ID parameter is missing!</div>';
}
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
<div class="container text-center mt-5">
    <h3>Select Image For Update In Carousel</h3>
    <?php echo $update_alert; ?>
    <div class="mb-2">
        <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <input class="form-control" type="file" name="image">
            <input type="submit" name="update" value="UPDATE" class="btn btn-success my-3">
        </form>
    </div>
</div>
</body>
</html>
