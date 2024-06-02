<?php

use Carbon\Carbon;

require './vendor/autoload.php';
include 'connection.php';

// Fetch booked events
$query = "SELECT * FROM bookevent";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Data</title>

    <link rel="stylesheet" href="cssfiles/fetch.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="cssfiles/dashboard.css">

    <style>
        /* Responsive table */
        @media (max-width: 767px) {
            .table-responsive-sm {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>

<body>
    <?php include 'requireddashboard.php'; ?>
    <h1>Event Data</h1>
    <div class="container-fluid table-responsive-sm">
        <table class="table table-light table-striped table-hover bookings-table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">IMAGE</th>
                    <th scope="col">NAME</th>
                    <th scope="col">PHONE NO</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">DATE</th>
                    <th scope="col">PRICE</th>
                    <th scope="col">EDIT</th>
                    <th scope="col">CONFIRM BOOKING</th>
                    <th scope="col">DELETE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $gallery_image_id = $row['gallery_image_id']; // Fetch the gallery image ID from the bookevent table

                        // Fetch the gallery image details
                        $query1 = "SELECT * FROM decoration_gallery_images WHERE id = '$gallery_image_id'";
                        $result1 = mysqli_query($con, $query1);
                        $gallery_image = mysqli_fetch_assoc($result1);

                        if ($gallery_image) {
                ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td>
                                    <img src="<?php echo $gallery_image['image']; ?>" width="100px" alt="image">
                                </td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td>
                                    <?php
                                    echo Carbon::parse($row['date'])->format('d M, Y h:i:s');
                                    ?>
                                </td>
                                <td><?php echo $row['price']; ?></td>
                                <td><a href="fetchdataedit.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-file-pen fa-2xl" style="color: blue;"></i></a></td>
                                <td><a href="confirmedbooking.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-square-check fa-2xl" style="color: green;"></i></a></td>
                                <td><a href="fetchdatadelete.php?id=<?php echo $row['id']; ?>"><i class="fa-sharp fa-solid fa-trash fa-2xl" style="color: red;"></i></a></td>
                            </tr>
                <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.bookings-table').DataTable();
        });
    </script>
</body>

</html>
