<?php
require 'vendor/autoload.php';
include 'connection.php';

use SendGrid\Mail\Mail as SendGridMail;



// Handle the form submission for updating the remaining payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gallery_image_id']) && isset($_POST['remaining_payment']) && isset($_POST['booking_id'])) {
    $galleryImageId = $_POST['gallery_image_id'];
    $remainingPayment = $_POST['remaining_payment'];
    $bookingId = $_POST['booking_id'];

    // Fetch the current booking details including the image
    $query = "SELECT cb.*, dgi.image FROM confirmedbooking cb LEFT JOIN decoration_gallery_images dgi ON cb.gallery_image_id = dgi.id WHERE cb.gallery_image_id = '$galleryImageId' AND cb.id = '$bookingId'";
    $result = mysqli_query($con, $query);
    $booking = mysqli_fetch_assoc($result);

    if ($booking) {
        if ($remainingPayment > $booking['remaining_payment']) {
            // If the entered remaining payment is more than the actual remaining payment
            $_SESSION['error_message'] = 'The entered remaining payment is more than the actual remaining payment. Please enter a value less than or equal to the actual remaining payment.';
            echo json_encode(['status' => 'error', 'message' => $_SESSION['error_message']]);
            exit;
        }

        $newAdvancePayment = $booking['advance_payment'] + $remainingPayment;
        $remainingPaymentAfterUpdate = $booking['remaining_payment'] - $remainingPayment;

        // Update the booking in the confirmedbooking table
        $updateQuery = "UPDATE confirmedbooking SET advance_payment = $newAdvancePayment, remaining_payment = $remainingPaymentAfterUpdate WHERE gallery_image_id = '$galleryImageId' AND id = '$bookingId'";
        mysqli_query($con, $updateQuery);

        // Optionally, move the booking to fully_paid table if remaining payment is 0
        if ($remainingPaymentAfterUpdate <= 0) {
            $insertQuery = "INSERT INTO fully_paid (gallery_image_id, name, phone, email, address, date, price, advance_payment, remaining_payment)
                            VALUES ('{$booking['gallery_image_id']}', '{$booking['name']}', '{$booking['phone']}', '{$booking['email']}', '{$booking['address']}', '{$booking['date']}', '{$booking['price']}', $newAdvancePayment, $remainingPaymentAfterUpdate)";
            mysqli_query($con, $insertQuery);

            // Delete the booking from the confirmedbooking table
            $deleteQuery = "DELETE FROM confirmedbooking WHERE gallery_image_id = '$galleryImageId' AND id = '$bookingId'";
            mysqli_query($con, $deleteQuery);

            // Remove the booking from the pending list table if remaining payment is 0
            $deletePendingQuery = "DELETE FROM pending_list WHERE gallery_image_id = '$galleryImageId' AND id = '$bookingId'";
            mysqli_query($con, $deletePendingQuery);

            // Return a success message with an indication that the booking was moved to fully_paid table
            $_SESSION['success_message'] = 'Payment updated successfully and booking moved to fully_paid table';
        } else {
            // Return a success message with an indication that the payment was updated
            $_SESSION['success_message'] = 'Payment updated successfully';
        }
        echo json_encode(['status' => 'success', 'message' => $_SESSION['success_message']]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Booking not found']);
        exit;
    }
}

// Fetch confirmed bookings
$query = "SELECT cb.*, dgi.image FROM confirmedbooking cb LEFT JOIN decoration_gallery_images dgi ON cb.gallery_image_id = dgi.id";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmed Booking Order Views</title>
  <link rel="stylesheet" href="cssfiles/fetch.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="cssfiles/dashboard.css">
  <link rel="stylesheet" href="cssfiles/header.css">
</head>
<body>
<?php include 'requireddashboard.php'; ?>

<!-- Main Content Section -->
<div class="container-fluid">
  <h1>CONFIRMED CLIENT BOOKINGS</h1>

  <!-- Success Alert -->
  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $_SESSION['success_message']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <!-- Error Alert -->
  <?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $_SESSION['error_message']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>

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
          <th scope="col">ADVANCE</th>
          <th scope="col">AMOUNT LEFT</th>
          <th scope="col">ACTION</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
          <td data-label="ID"><?php echo $row['id']; ?></td>
          <td data-label="IMAGE">
            <?php if (!empty($row['image'])): ?>
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
          <td data-label="ACTION">
            <button class="btn btn-primary edit-btn" data-gallery-image-id="<?php echo $row['gallery_image_id']; ?>" data-remaining="<?php echo $row['remaining_payment']; ?>" data-booking-id="<?php echo $row['id']; ?>">Edit</button>
          </td>
        </tr>
        <?php
            }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Remaining Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <div class="mb-3">
            <label for="remaining_payment" class="form-label">Remaining Payment</label>
            <input type="number" class="form-control" id="remaining_payment" name="remaining_payment" required>
          </div>
          <input type="hidden" id="gallery_image_id" name="gallery_image_id">
          <input type="hidden" id="booking_id" name="booking_id">
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF7UGAN6AZg2Zp3eKzHI1UQ4/Tc8e3C56OaR9E0rFm7" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $('.bookings-table').DataTable();

    // Open the edit modal and populate it with data
    $('.edit-btn').on('click', function () {
      var galleryImageId = $(this).data('gallery-image-id');
      var remainingPayment = $(this).data('remaining');
      var bookingId = $(this).data('booking-id');
      $('#gallery_image_id').val(galleryImageId);
      $('#remaining_payment').val(remainingPayment);
      $('#booking_id').val(bookingId);
      $('#editModal').modal('show');
    });

    // Handle the form submission for editing the remaining payment
    $('#editForm').on('submit', function (e) {
      e.preventDefault();
      var galleryImageId = $('#gallery_image_id').val();
      var remainingPayment = $('#remaining_payment').val();
      var bookingId = $('#booking_id').val();

      $.ajax({
        url: '',
        type: 'POST',
        data: {
          gallery_image_id: galleryImageId,
          remaining_payment: remainingPayment,
          booking_id: bookingId
        },
        success: function (response) {
          var res = JSON.parse(response);
          if (res.status == 'success') {
            // Show the success alert
            $('.container-fluid').prepend(
              '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
              res.message +
              '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
              '</div>'
            );
          } else {
            // Show the error alert
            $('.container-fluid').prepend(
              '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
              res.message +
              '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
              '</div>'
            );
          }
          // Close the modal
          $('#editModal').modal('hide');
          // Refresh the page to update the table
          setTimeout(function() {
            location.reload();
          }, 1500);
        }
      });
    });
  });
</script>
</body>
</html>
