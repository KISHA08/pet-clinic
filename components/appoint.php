<?php
// require_once "database.php";


// if(isset($_POST['submit'])){
//     $name=$_POST['name'];
//     $email =$_POST['email'];
//     $mobile =$_POST['mobile'];
//     $pet =$_POST['pet'];
//     $date=$_POST['date'];
//     $shift =$_POST['shift'];

//     if(!empty($name) && !empty($email)&& !empty($mobile) && !empty($pet) && !empty($date) && !empty($shift)){
//          $sql ="INSERT INTO appointment (name,email,mobile,pet,date,shift) VALUES(?,?,?,?,?,?)";
//          $stmt = $conn-> prepare($sql);
//          $stmt-> bind_param("ssssss" , $name,$email,$mobile,$pet,$date,$shift);
//          $stmt->execute();
        
        
//          if(  $sql = "SELECT email, FROM appointment WHERE email = ?";
//          $stmt = $conn->prepare($sql);
//          $stmt->bind_param("s", $semail);
//          $stmt->execute();
//          $result = $stmt->get_result();){

//          }



//          exit();
//     }
// }



require_once "database.php";

if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email =$_POST['email'];
    $mobile =$_POST['mobile'];
    $pet =$_POST['pet'];
    $date=$_POST['date'];
    $shift =$_POST['shift'];

    if(!empty($name) && !empty($email)&& !empty($mobile) && !empty($pet) && !empty($date) && !empty($shift)){
        // Check if the shift count for the given date is less than 15
        $sql = "SELECT COUNT(*) AS shift_count FROM appointment WHERE date = ? AND shift = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $date, $shift);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $shiftCount = $row['shift_count'];
        
        if($shiftCount < 15) {
            // Check if the email is not repeated
            $sql = "SELECT COUNT(*) AS email_count FROM appointment WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $emailCount = $row['email_count'];
            
            if($emailCount == 0) {
                // If shift count is less than 15 and email is not repeated, proceed with insertion
                $sql ="INSERT INTO appointment (name,email,mobile,pet,date,shift) VALUES(?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss" , $name,$email,$mobile,$pet,$date,$shift);
                $stmt->execute();
            } else {
                echo "Email already exists!";
            }
        } else {
            echo "Shift capacity is full!";
        }
       
    }
    header("Location:../service.php");
    exit();
}
?>

