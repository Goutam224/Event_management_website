<?php
include 'connection.php';
include 'requireddashboard.php';

// Ensure the main "decorations" directory always exists
if (!file_exists("decorations")) {
    mkdir("decorations");
}

// Function to check if decoration name already exists
function isDecorationExists($con, $decoration_type) {
    $sql = "SELECT COUNT(*) AS count FROM decorations WHERE decoration_type = '$decoration_type'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

// Function to delete gallery images of a decoration
function deleteGalleryImages($con, $decoration_id) {
    $sql = "SELECT image FROM decoration_gallery_images WHERE decoration_id = '$decoration_id'";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['image'] && file_exists($row['image'])) {
            unlink($row['image']); // delete image from directory if it exists
        }
    }
    $sql = "DELETE FROM decoration_gallery_images WHERE decoration_id = '$decoration_id'";
    mysqli_query($con, $sql);
}

// Function to delete a specific gallery image
function deleteSingleGalleryImage($con, $image_id) {
    $sql = "SELECT image FROM decoration_gallery_images WHERE id = '$image_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['image'] && file_exists($row['image'])) {
        unlink($row['image']); // delete image from directory if it exists
    }
    $sql = "DELETE FROM decoration_gallery_images WHERE id = '$image_id'";
    mysqli_query($con, $sql);
}

// Function to delete a decoration
function deleteDecoration($con, $decoration_id) {
    $sql = "SELECT image, decoration_type FROM decorations WHERE id = '$decoration_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['image'] && file_exists($row['image'])) {
        unlink($row['image']); // delete main image from directory if it exists
    }
    $decoration_type = $row['decoration_type'];

    deleteGalleryImages($con, $decoration_id); // delete gallery images

    $sql = "DELETE FROM decorations WHERE id = '$decoration_id'";
    mysqli_query($con, $sql);

    // Delete the directory if it exists
    $directory = "decorations/" . $decoration_type;
    if (is_dir($directory)) {
        $files = array_diff(scandir($directory), array('.', '..'));
        foreach ($files as $file) {
            if (is_file("$directory/$file")) {
                unlink("$directory/$file");
            }
        }
        rmdir($directory);
    }
}

if(isset($_POST['decoration_type'])) {
    $decoration_type = ucwords($_POST['decoration_type']);
    $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;

    // Check if decoration name already exists
    if(isDecorationExists($con, $decoration_type)) {
        echo '<div class="alert alert-danger" role="alert">
                  Decoration name already exists. Please choose a different name.
              </div>';
    } else {
        // create folder if not exists according to the decoration type
        if (!file_exists("decorations/" . $decoration_type)) {
            mkdir("decorations/" . $decoration_type);
        }

        if ($image) {
            $image_path = "decorations/" . $decoration_type . "/" . basename($image);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $sql = "INSERT INTO decorations (decoration_type, image, price) VALUES ('$decoration_type', '$image_path', '$price')";
                $res = mysqli_query($con, $sql);
                if ($res) {
                    // upload gallery images in decoration_gallery_images table
                    $decoration_id = mysqli_insert_id($con);
                    $gallery_images = $_FILES['gallery_images']['name'];
                    $gallery_prices = isset($_POST['gallery_prices']) ? explode(',', $_POST['gallery_prices']) : [];
                    foreach ($gallery_images as $key => $value) {
                        $gallery_image = "decorations/" . $decoration_type . "/" . basename($value);
                        $gallery_price = isset($gallery_prices[$key]) ? $gallery_prices[$key] : 0.00;
                        $sql = "INSERT INTO decoration_gallery_images (decoration_id, image, price) VALUES ('$decoration_id', '$gallery_image', '$gallery_price')";
                        mysqli_query($con, $sql);
                        move_uploaded_file($_FILES['gallery_images']['tmp_name'][$key], $gallery_image);
                    }
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> Your Image is Successfully Uploaded.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                            Something went wrong.
                        </div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        There was a problem uploading image.
                    </div>';
            }
        }
    }
}

// If decoration_id is provided, delete the gallery images of that decoration
if(isset($_GET['delete_gallery']) && isset($_GET['decoration_id'])) {
    $decoration_id = $_GET['decoration_id'];
    deleteGalleryImages($con, $decoration_id);
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> Gallery images are Successfully Deleted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

// If image_id is provided, delete the specific gallery image
if(isset($_GET['delete_image']) && isset($_GET['image_id'])) {
    $image_id = $_GET['image_id'];
    deleteSingleGalleryImage($con, $image_id);
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> Gallery image is Successfully Deleted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

// If decoration_id is provided, delete the entire decoration
if(isset($_GET['delete_decoration']) && isset($_GET['decoration_id'])) {
    $decoration_id = $_GET['decoration_id'];
    deleteDecoration($con, $decoration_id);
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> Decoration is Successfully Deleted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

// If updating the decoration image
if(isset($_POST['update_decoration_image']) && isset($_POST['decoration_id'])) {
    $decoration_id = $_POST['decoration_id'];
    $decoration_type = $_POST['decoration_type'];
    $new_image = $_FILES['new_image']['name'];
    $new_image_path = "decorations/" . $decoration_type . "/" . basename($new_image);

    if (move_uploaded_file($_FILES['new_image']['tmp_name'], $new_image_path)) {
        // Get old image path to delete
        $sql = "SELECT image FROM decorations WHERE id='$decoration_id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['image'] && file_exists($row['image'])) {
            unlink($row['image']); // delete old image from directory if it exists

            $sql = "UPDATE decorations SET image='$new_image_path' WHERE id='$decoration_id'";
            mysqli_query($con, $sql);
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> Decoration Image is Successfully Updated.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    There was a problem updating the decoration image.
                  </div>';
        }
    }
}

// If adding new gallery images
if(isset($_POST['add_gallery_images']) && isset($_POST['decoration_id'])) {
    $decoration_id = $_POST['decoration_id'];
    $decoration_type = $_POST['decoration_type'];
    $gallery_images = $_FILES['new_gallery_images']['name'];
    $gallery_prices = isset($_POST['new_gallery_prices']) ? explode(',', $_POST['new_gallery_prices']) : [];
    foreach ($gallery_images as $key => $value) {
        $gallery_image = "decorations/" . $decoration_type . "/" . basename($value);
        $gallery_price = isset($gallery_prices[$key]) ? $gallery_prices[$key] : 0.00;
        $sql = "INSERT INTO decoration_gallery_images (decoration_id, image, price) VALUES ('$decoration_id', '$gallery_image', '$gallery_price')";
        mysqli_query($con, $sql);
        move_uploaded_file($_FILES['new_gallery_images']['tmp_name'][$key], $gallery_image);
    }
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> New Gallery Images are Successfully Added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

// If updating gallery image price
if(isset($_POST['update_gallery_price']) && isset($_POST['image_id'])) {
    $image_id = $_POST['image_id'];
    $new_price = $_POST['new_price'];
    $sql = "UPDATE decoration_gallery_images SET price='$new_price' WHERE id='$image_id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Hey!</strong> Gallery Image Price is Successfully Updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                There was a problem updating the gallery image price.
              </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Decorations</title>
    <style>
        img {
            width: 300px;
            height: 300px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Decorations</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="decoration_type" class="form-label">Decoration Type</label>
                <input type="text" class="form-control" id="decoration_type" name="decoration_type" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="mb-3">
                <label for="gallery_images" class="form-label">Gallery Images</label>
                <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" multiple>
            </div>
            <div class="mb-3">
                <label for="gallery_prices" class="form-label">Gallery Image Prices (comma separated)</label>
                <input type="text" class="form-control" id="gallery_prices" name="gallery_prices">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <hr>
        <h2>Uploaded Decorations</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Decoration Type</th>
                    <th>Price</th>
                    <th>Main Image</th>
                    <th>Gallery Images</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM decorations";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $decoration_id = $row['id'];
                    $decoration_type = $row['decoration_type'];
                    $price = $row['price'];
                    $image = $row['image'];
                    echo "<tr>
                            <td>$decoration_type</td>
                            <td>$price</td>
                            <td><img src='$image' alt='$decoration_type' class='img-thumbnail'></td>
                            <td>";
                    $sql_gallery = "SELECT * FROM decoration_gallery_images WHERE decoration_id = '$decoration_id'";
                    $result_gallery = mysqli_query($con, $sql_gallery);
                    while ($row_gallery = mysqli_fetch_assoc($result_gallery)) {
                        $gallery_image = $row_gallery['image'];
                        $gallery_image_id = $row_gallery['id'];
                        $gallery_image_price = $row_gallery['price'];
                        echo "<div style='display: flex; align-items: center;'>
                                <img src='$gallery_image' alt='$decoration_type' class='img-thumbnail' style='width: 100px; height: 100px;'>
                                <form action='' method='POST' style='display: inline;'>
                                    <input type='hidden' name='image_id' value='$gallery_image_id'>
                                    <input type='number' step='0.01' name='new_price' value='$gallery_image_price'>
                                    <button type='submit' name='update_gallery_price' class='btn btn-warning btn-sm'>Update Price</button>
                                </form>
                                <form action='' method='GET' style='display: inline; margin-left: 5px;'>
                                    <input type='hidden' name='image_id' value='$gallery_image_id'>
                                    <button type='submit' name='delete_image' class='btn btn-danger btn-sm'>Delete</button>
                                </form>
                            </div>";
                    }
                    echo "</td>
                            <td>
                                <form action='' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='decoration_id' value='$decoration_id'>
                                    <input type='hidden' name='decoration_type' value='$decoration_type'>
                                    <input type='file' name='new_image'>
                                    <button type='submit' name='update_decoration_image' class='btn btn-warning btn-sm'>Update Image</button>
                                </form>
                                <form action='' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='decoration_id' value='$decoration_id'>
                                    <input type='hidden' name='decoration_type' value='$decoration_type'>
                                    <input type='file' name='new_gallery_images[]' multiple>
                                    <input type='text' name='new_gallery_prices' placeholder='Comma separated prices'>
                                    <button type='submit' name='add_gallery_images' class='btn btn-warning btn-sm'>Add Images</button>
                                </form>
                                <form action='' method='GET' style='display: inline;'>
                                    <input type='hidden' name='decoration_id' value='$decoration_id'>
                                    <button type='submit' name='delete_decoration' class='btn btn-danger btn-sm'>Delete Decoration</button>
                                </form>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
