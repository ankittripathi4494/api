<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    // Validate input
    if (!$id || !is_numeric($id)) {
        echo json_encode(['code' => 400, 'status' => 'failure', 'message' => 'Invalid or missing customer ID']);
        exit;
    }

    $query = "DELETE FROM Customers WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo json_encode(['code' => 200, 'status' => 'success', 'message' => 'Customer deleted successfully']);
            } else {
                // No customer found with the given ID
                echo json_encode(['code' => 404, 'status' => 'failure', 'message' => 'Customer not found']);
            }
        } else {
            echo json_encode(['code' => 500, 'status' => 'failure', 'message' => 'Customer deletion failed']);
        }
    } catch (PDOException $e) {
        echo json_encode(['code' => 500, 'status' => 'failure', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
