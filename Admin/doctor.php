<?php
require_once("../components/database.php");

if(isset($_POST['submit'])){
    
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);

    $image_size = $_FILES['image']['size'];
    $image_temp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'doctor_img/'.$image;

    
    $select_doctor = $conn->prepare("SELECT * FROM `doctor` WHERE name = ?");
    $select_doctor->bind_param("s", $name);
    $select_doctor->execute(); 
    $select_doctor->store_result();

    if($select_doctor->num_rows > 0){
       $message[] = 'Doctor already exists'; 
    } else {
        if($image_size > 5000000){ 
            $message[] = 'Image size exceeds the limit';
        } else {
           
            if (move_uploaded_file($image_temp_name, $image_folder)) {
                $add_doctor = $conn->prepare("INSERT INTO `doctor` (name, image) VALUES (?, ?)");
                $add_doctor->bind_param("ss", $name, $image);
                $add_doctor->execute(); 
                $message[] = 'Successfully added';
            } else {
                $message[] = 'Failed to upload image';
            }
        }
    }
}

if(isset($_GET['delete'])){
    $deleteid = $_GET['delete'];

    
    $delete_doctor_img = $conn->prepare("SELECT * FROM doctor WHERE id = ?");
    $delete_doctor_img->bind_param("i", $deleteid);
    $delete_doctor_img->execute();
    $result = $delete_doctor_img->get_result(); 
    $delete_img = $result->fetch_assoc(); 

    if ($delete_img) {
        unlink('doctor_img/'.$delete_img['image']);
        
        $delete_doctor = $conn->prepare("DELETE FROM doctor WHERE id = ?");
        $delete_doctor->bind_param("i", $deleteid);
        $delete_doctor->execute();
    }

    header('location: doctor.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body> 
    <?php include("../components/admin_header.php");?>

    <section class="add">
        <form action="" method="POST" enctype="multipart/form-data">
        <h3>Add Doctor</h3>
        <input type="text" required placeholder="enter doctor name" name="name" class="box">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        <input type="submit" value="Add Doctor" name="submit" class="btn">
        </form>
       
    </section>

    <section class="show" style="padding-top: 0;">
   <div class="box-container">
   <?php      
      $show_doctor = $conn->prepare("SELECT * FROM `doctor`");
      $show_doctor->execute();
      $result = $show_doctor->get_result();
      
      if($result->num_rows > 0){
         while($fetch_doctor = $result->fetch_assoc()){  
   ?>
   <div class="box">
      
      <img src="doctor_img/<?= htmlspecialchars($fetch_doctor['image']); ?>" alt="">     
      <div class="name"><span>Doctor:</span> <?= htmlspecialchars($fetch_doctor['name']); ?></div>
      <div class="flex-btn">
         
         <a href="update_doctor.php?update=<?= urlencode($fetch_doctor['id']); ?>" class="btn-update2">update</a>
        
         <a href="doctor.php?delete=<?= urlencode($fetch_doctor['id']); ?>" class="btn-delete2" onclick="return confirm('Delete this doctor?');">delete</a>
      </div>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no doctors added yet!</p>';
      }
   ?>
   </div>
</section>

</body>
</html>
