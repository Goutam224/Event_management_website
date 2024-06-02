<?php
use Carbon\Carbon;

require './vendor/autoload.php';
include 'connection.php';

// Fetch confirmed bookings
$queryConfirmed = "SELECT * FROM confirmedbooking";
$resultConfirmed = mysqli_query($con, $queryConfirmed);

// Initialize variables for total, remaining, and advanced prices
$totalPriceConfirmed = 0;
$totalRemainingConfirmed = 0;
$totalAdvancedConfirmed = 0;

// Iterate through the confirmed bookings to calculate totals
while ($row = mysqli_fetch_assoc($resultConfirmed)) {
    $totalPriceConfirmed += $row['price'];
    $totalRemainingConfirmed += $row['remaining_payment'];
    $totalAdvancedConfirmed += $row['advance_payment'];
}

// Fetch total payment from the fully paid bookings
$queryFullyPaid = "SELECT SUM(price) AS total_payment FROM fully_paid";
$resultFullyPaid = mysqli_query($con, $queryFullyPaid);
$rowFullyPaid = mysqli_fetch_assoc($resultFullyPaid);
$totalPaymentFullyPaid = $rowFullyPaid['total_payment'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="cssfiles/payments.css">
  <link rel="stylesheet" href="cssfiles/dashboard.css">
</head>
<body>
  
<?php 
include 'requireddashboard.php';
?>
  <!-- Dashboard content -->
  <div class="container-fluid">
    <h1 class="text-center my-4">Payments</h1>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Price (Confirmed)</h5>
            <p class="card-text"><?php echo $totalPriceConfirmed; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Remaining (Confirmed)</h5>
            <p class="card-text"><?php echo $totalRemainingConfirmed; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Advanced (Confirmed)</h5>
            <p class="card-text"><?php echo $totalAdvancedConfirmed; ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- New section for Total Completed Order Payment Details -->
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            Total Completed Order Payment Details
          </div>
          <div class="card-body">
            <p class="card-text">Total Payment (Fully Paid): <?php echo $totalPaymentFullyPaid; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
