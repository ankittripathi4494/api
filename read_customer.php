<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null; // Use null coalescing to handle missing 'id'

    if ($id === null || !is_numeric($id)) {
        // Return a failure response if ID is missing or invalid
        echo json_encode(['code'=>400, 'status'=>'failure', 'message' => 'Invalid or missing customer ID']);
        exit;
    }

    $query = "SELECT * FROM Customers WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($customer) {
                // Encode the customer data to JSON format and print it
                echo json_encode(['code'=>200, 'status'=>'success', 'data' => $customer]);
            } else {
                // No customer found, return a message
                echo json_encode(['code'=>404, 'status'=>'failure', 'message' => 'No customer found']);
            }
        } else {
            echo json_encode(['code'=>500, 'status'=>'failure', 'message' => 'Query execution failed']);
        }
    } catch (PDOException $e) {
        echo json_encode(['code'=>500, 'status'=>'failure', 'message' => $e->getMessage()]);
    }
}
?>
