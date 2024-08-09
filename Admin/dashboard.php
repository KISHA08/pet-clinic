<?php 
include '../components/admin_header.php';
require_once "../components/database.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Appointments</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
   <link rel="stylesheet" href="../css/table_style.css">
</head>
<body>

<section class="table">

<?php
// Fetch appointments
$sql = "SELECT * FROM appointment";
$result = $conn->query($sql);

// Check if appointments exist
if ($result->num_rows > 0) {
?>
   <form action="../components/appoint_delete.php" method="post">
      <table>
         <tr>
            <th>Select</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Service</th>
            <th>Date</th>
            <th>Shift</th>
         </tr>
<?php
   while($row = $result->fetch_assoc()) {
?>
         <tr>
            <td><input type="checkbox" name="appointment_id[]" value="<?php echo $row['ID']; ?>"></td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["mobile"]; ?></td>
            <td><?php echo $row["service"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo $row["shift"]; ?></td>
         </tr>
<?php
   }
?>
      </table>
      <button type="submit" class="btn-dlt" onclick="return confirm('Confirm delete this appointment?')">Delete</button>
   </form>
<?php
} else {
   echo "No appointments found";
}
?>
</section>

</body>
</html>
