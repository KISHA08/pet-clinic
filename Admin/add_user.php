<?php

require_once("../components/database.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Retrieve form data
    $petname = $_POST["petname"];
    $email = $_POST["email"];
    $pet = $_POST["pet"];
    $breed = $_POST["breed"];
    $gender = $_POST["gender"];
    
    // Prepare the SQL statement
    $sql = "INSERT INTO petdetails (petname, email, pet, breed, gender) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssss", $petname, $email, $pet, $breed, $gender);

    // Execute statement
    if ($stmt->execute()) {
        $message = "User added successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    
}
if(isset($_GET['delete'])){
        $deleteid = $_GET['delete'];   
        $delete_user = $conn->prepare("DELETE FROM petdetails WHERE id = ?");
        $delete_user->bind_param("i", $deleteid);
        $delete_user->execute();
    

    header('location: add_user.php');
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
            <h3>Add User</h3>
            <input type="text" required placeholder="Enter pet name" name="petname" class="box">
            <input type="email" required placeholder="Enter user email" name="email" class="box">
            <input type="text" required placeholder="Enter pet type" name="pet" class="box">
            <input type="text" required placeholder="Enter pet breed" name="breed" class="box">
            <select name="gender" class="box" required>
                <option value="" disabled selected>Select gender --</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
            </select>
            <input type="submit" value="Add User" name="submit" class="btn">
        </form>
    </section>

    <section class="show" style="padding-top: 0;">
        <div class="box-container">
            <?php
            // Prepare a select statement
            $show_pet = $conn->prepare("SELECT * FROM `petdetails`");
            $show_pet->execute();
            $result = $show_pet->get_result();
            
            // Check if any pet details are available
            if($result->num_rows > 0){
                while($fetch_pet = $result->fetch_assoc()){  
            ?>
            <div class="box">
                <div class="pname"><span>ID :</span> <?= htmlspecialchars($fetch_pet['id']); ?></div>
                <div class="pname"><span>Email :</span> <?= htmlspecialchars($fetch_pet['email']); ?></div>
                <div class="pname"><span>Pet Name :</span> <?= htmlspecialchars($fetch_pet['petname']); ?></div>
                <div class="pname"><span>Pet Type :</span> <?= htmlspecialchars($fetch_pet['pet']); ?></div>
                <div class="pname"><span>Pet Breed :</span> <?= htmlspecialchars($fetch_pet['breed']); ?></div>
                <div class="pname"><span>Pet Gender:</span> <?= htmlspecialchars($fetch_pet['gender']); ?></div>
                
                <div class="flex-btn">
                    <a href="edit.php?update=<?= urlencode($fetch_pet['id']); ?>" class="btn-update">Edit</a>
                    <a href="add_user.php?delete=<?= urlencode($fetch_pet['id']); ?>" class="btn-delete" onclick="return confirm('Delete this doctor?');">delete</a>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">NO User</p>';
            }
            ?>
        </div>
    </section>
</body>
</html>
