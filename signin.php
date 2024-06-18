<?php
session_start();

if(isset($_POST["submit"])){
     $_SESSION["user"]= $_POST["semail"];
     $_SESSION["password"]= $_POST["spass"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $semail = $_POST["semail"];
    $spass = $_POST["spass"];

    if (empty($semail) || empty($spass)) {
        $_SESSION["error"] = "All fields are required";
        header("Location: index.php");
        exit;
    } else {
        
        require_once "components/database.php"; 

        $sql = "SELECT * FROM signup WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $semail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($spass, $row['password'])) {
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

        $stmt->close();
        $conn->close();
    }
}
?>