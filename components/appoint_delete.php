<?php
require_once "../components/database.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['appointment_id'])) {
        $appointment_id = $_POST['appointment_id'];
        
        $ids = implode(',',$appointment_id);
        
        $sql = "DELETE FROM appointment WHERE id IN ($ids)";

        if ($conn->query($sql)==TRUE) {
            header('location: ../Admin/dashboard.php');
            $message[] = 'Appointment deleted successfully';
        } else {
            echo "Error deleting appointment: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "No appointment selected";
    }
}
$conn->close();

?>