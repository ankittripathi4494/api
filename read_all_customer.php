<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "SELECT * FROM Customers";
    $stmt = $conn->prepare($query);

    try {
        if ($stmt->execute()) {
            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($customers) {
                // Success: Customers found
                echo json_encode(['code'=>200, 'status'=>'success', 'data' => $customers]);
            } else {
                // No customers found
                echo json_encode(['code'=>404, 'status'=>'failure', 'message' => 'No customers found']);
            }
        } else {
            // Query execution failed
            echo json_encode(['code'=>500, 'status'=>'failure', 'message' => 'Query execution failed']);
        }
    } catch (PDOException $e) {
        // Database error handling
        echo json_encode(['code'=>500, 'status'=>'failure', 'message' => $e->getMessage()]);
    }
}
?>
