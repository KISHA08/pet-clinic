<?php
session_start();

if (isset($_POST["submit"])) {
    $_SESSION["user"] = $_POST["semail"];
    $_SESSION["password"] = $_POST["spassword"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $semail = $_POST["semail"];
    $spassword = $_POST["spassword"];

    if (empty($semail) || empty($spassword)) {
        $_SESSION["error"] = "All fields are required";
        header("Location: index.php");
        exit;
    } else {
        require_once "components/database.php";
        
        // Check in the adminn table
        $sql = "SELECT * FROM adminn WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $semail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($spassword === $row['password']) {
                header("Location: Admin/dashboard.php");
                exit;
            } else {
                $_SESSION["error"] = "Incorrect password";
                header("Location: index.php");
                exit;
            }
        } else {
            // Check in the signup table
            $sql = "SELECT * FROM signup WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $semail);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                if (password_verify($spassword, $row['password'])) {
                    header("Location: home.php");
                    exit;
                } else {
                    $_SESSION["error"] = "Incorrect password";
                    header("Location: index.php");
                    exit;
                }
            } else {
                $_SESSION["error"] = "User not found";
                header("Location: index.php");
                exit;
            }
        }

        $stmt->close();
        $conn->close();
     }
}
?>