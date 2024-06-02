<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmed Client Bookings</title>
  <link rel="stylesheet" href="cssfiles/table.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="cssfiles/dashboard.css">
  <link rel="stylesheet" href="cssfiles/newheader.css">
</head>
<body>
 

  <!-- Main Content Section -->
  <div class="container-fluid">
    <h1>CONFIRMED CLIENT BOOKINGS</h1>
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
          </tr>
        </thead>
        <tbody>
          <?php
          if(mysqli_num_rows($result) > 0) {
              foreach($result as $row) {
                  $decoration_type = $row['decoration_id'];
                  $query1 = "SELECT * FROM decoration_gallery_images WHERE id = '$decoration_type'";
                  $result1 = mysqli_query($con, $query1);
                  $decoration_type = mysqli_fetch_assoc($result1);
          ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td>
              <img src="<?php echo $decoration_type['image']; ?>" width="250px" alt="image">
            </td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['price']; ?></td>
          </tr>
          <?php
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.bookings-table').DataTable();
    });
  </script>
</body>
</html>
