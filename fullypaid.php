<?php
use Carbon\Carbon;

require './vendor/autoload.php';
include 'connection.php';

// Fetch fully paid bookings with corresponding decoration images
$queryFullyPaid = "SELECT fp.*, dgi.image FROM fully_paid fp LEFT JOIN decoration_gallery_images dgi ON fp.gallery_image_id = dgi.id";
$resultFullyPaid = mysqli_query($con, $queryFullyPaid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmed Client Bookings</title>
  <link rel="stylesheet" href="cssfiles/fetch.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="cssfiles/dashboard.css">
  <link rel="stylesheet" href="cssfiles/header.css">
  <style>
    /* Custom CSS for responsiveness and styling */
    @media (max-width: 768px) {
      .table-responsive {
        overflow-x: auto;
      }
    }
  </style>
</head>
<body>
<?php include 'requireddashboard.php'; ?>

<!-- Main Content Section -->
<div class="container-fluid">
  
  <h1>Fully Paid Bookings</h1>
  <div class="table-responsive">
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
          <th scope="col">TOTAL PRICE</th>
          <th scope="col">AMOUNT RECIEVED</th>
          <th scope="col">AMOUNT LEFT</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($resultFullyPaid) > 0) {
            while ($row = mysqli_fetch_assoc($resultFullyPaid)) {
        ?>
        <tr>
          <td data-label="ID"><?php echo $row['id']; ?></td>
          <td data-label="IMAGE">
            <?php if (isset($row['image'])): ?>
              <img src="<?php echo $row['image']; ?>" width="250px" alt="image">
            <?php else: ?>
              <p>No image available</p>
            <?php endif; ?>
          </td>
          <td data-label="NAME"><?php echo $row['name']; ?></td>
          <td data-label="PHONE NO"><?php echo $row['phone']; ?></td>
          <td data-label="EMAIL"><?php echo $row['email']; ?></td>
          <td data-label="ADDRESS"><?php echo $row['address']; ?></td>
          <td data-label="DATE"><?php echo $row['date']; ?></td>
          <td data-label="TOTAL PRICE"><?php echo $row['price']; ?></td>
          <td data-label="ADVANCE"><?php echo $row['advance_payment']; ?></td>
          <td data-label="AMOUNT LEFT"><?php echo $row['remaining_payment']; ?></td>
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='10'>No fully paid bookings found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF7UGAN6AZg2Zp3eKzHI1UQ4/Tc8e3C56OaR9E0rFm7" crossorigin="anonymous"></script>
</body>
</html>
