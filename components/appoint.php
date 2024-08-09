<?php
require_once "database.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $shift = $_POST['shift'];

    // Validate and format the date
    $dateObject = DateTime::createFromFormat('m/d/Y', $date);
    if ($dateObject) {
        $formattedDate = $dateObject->format('Y-m-d');
    } else {
        die("Invalid date format.");
    }

    if (!empty($name) && !empty($email) && !empty($mobile) && !empty($service) && !empty($formattedDate) && !empty($shift)) {
        // Check if the shift count for the given date is less than 8
        $sql = "SELECT COUNT(*) AS shift_count FROM appointment WHERE date = ? AND shift = ?";
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("ss", $formattedDate, $shift);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $shiftCount = $row['shift_count'];
        $stmt->close();

        if ($shiftCount < 8) {
            // Check if the email is not repeated
            $sql = "SELECT COUNT(*) AS email_count FROM appointment WHERE email = ?";
            $stmt = $conn->prepare($sql);
            
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $emailCount = $row['email_count'];
            $stmt->close();

            if ($emailCount == 0) {
                // If shift count is less than 8 and email is not repeated, proceed with insertion
                $sql = "INSERT INTO appointment (name, email, mobile, service, date, shift) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                
                $stmt->bind_param("ssssss", $name, $email, $mobile, $service, $formattedDate, $shift);
                if ($stmt->execute()) {
                    header("Location: ../service.php");
                    exit();
                } else {
                    die('Execute failed: ' . $stmt->error);
                }
                $stmt->close();
            } else {
                echo "Email already exists!";
            }
        } else {
            echo "Shift capacity is full!";
        }
    } else {
        echo "Shift capacity is full! ";
   }
}
?>