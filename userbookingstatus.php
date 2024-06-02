<?php 
use Carbon\Carbon;

require './vendor/autoload.php';
include 'connection.php';
include 'header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Booking Status</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="cssfiles/headerstatus.css">

  

    <link href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" rel="stylesheet">
</head>
<body>
  <div class="container-form">
    <form method="post">
      <div class="form-group text-center">
        <label for="exampleInputEmail1" class="text-center">Email Address</label>
        <br><br>
        <input type="email" class="form-control-sm w-auto" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter Your email">
      </div>
      <br>
      <div class="text-center">
        <button type="submit" name="submit" class="btn btn-primary">Check Status</button>
      </div>
    </form>
  </div>

  <?php
  if(isset($_POST['submit'])){
    $email=$_POST['email'];
    $query = "SELECT * FROM pending_list WHERE email='$email'";
    $res= mysqli_query($con, $query);

    ?>
    <h1 class="text-center">User Booking Status</h1>
    <div class="container-fluid">
      <div class="table-responsive">
        <table class="table table-light table-striped table-hover bookings-table">
          <thead class="table-dark">
            <tr>
              <th scope="col">NAME</th>
              <th scope="col">PHONE NO</th>
              <th scope="col">EMAIL</th>
              <th scope="col">ADDRESS</th>
              <th scope="col">DATE</th>
              <th scope="col">STATUS</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(mysqli_num_rows($res) > 0 || mysqli_num_rows($res)==0 ) {
                foreach ($res as $row) {
            ?>
                <tr>
                  <td data-label="NAME"><?php echo $row['name']; ?></td>
                  <td data-label="PHONE NO"><?php echo $row['phone']; ?></td>
                  <td data-label="EMAIL"><?php echo $row['email']; ?></td>
                  <td data-label="ADDRESS"><?php echo $row['address']; ?></td>
                  <td data-label="DATE">
                    <?php echo Carbon::parse($row['date'])->format('d M, Y h:i:s'); ?>
                  </td>
                  <td data-label="STATUS"><?php echo $row['status']; ?></td>
                </tr>
            <?php
                }
            }
          }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
        $('.bookings-table').DataTable();
      });
    </script>
   
</body>
<?php
    include 'footerstatus.php';
    ?>
</html>
