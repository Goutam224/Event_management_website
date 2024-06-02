<?php
include 'connection.php';

$allowed_types = array('jpg', 'jpeg', 'png', 'gif'); // allowed image types

$sql = "SELECT * FROM decorations"; // query to retrieve image paths and subfolder names from database
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        // check if image file exists
        $subfolder = $row["./BirthdayDecoration/"];
        $file_path = "C:\xampp\htdocs\adornflora\decorations" . $subfolder . "/" . $row["image"]; // replace with the actual path to the root folder
        if (file_exists($file_path) && in_array(pathinfo($file_path, PATHINFO_EXTENSION), $allowed_types)) {
            echo '<img src="'.$file_path.'" alt="Image" />';
        }
    }
} else {
    echo "No images found.";
}

?>
