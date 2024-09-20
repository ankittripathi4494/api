<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Input validation (simple check for now)
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $mobile = $_POST['mobile'] ?? null;
    $dob = $_POST['dob'] ?? null;
    $age = $_POST['age'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $marriage_status = $_POST['marriage_status'] ?? null;
    $country_id = $_POST['country_id'] ?? null;
    $state_id = $_POST['state_id'] ?? null;
    $city_id = $_POST['city_id'] ?? null;
    $image = null;

    // Image upload handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        }
    }

    // Check if required fields are present
    if (!$id || !$name || !$email || !$mobile || !$dob || !$age || !$gender) {
        echo json_encode(['code'=>400, 'status'=>'failure', 'message' => 'Missing required fields']);
        exit;
    }

    // Construct the query
    $query = "UPDATE Customers 
              SET name = :name, email = :email, mobile = :mobile, dob = :dob, age = :age, gender = :gender, 
                  marriage_status = :marriage_status, country_id = :country_id, state_id = :state_id, 
                  city_id = :city_id
              WHERE id = :id";
    
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':marriage_status', $marriage_status);
    $stmt->bindParam(':country_id', $country_id);
    $stmt->bindParam(':state_id', $state_id);
    $stmt->bindParam(':city_id', $city_id);
    
    // Handle image param binding separately to allow for null values
    // if ($image) {
    //     $stmt->bindParam(':image', $image);
    // } else {
    //     $stmt->bindValue(':image', null, PDO::PARAM_NULL); // Set to null if no image uploaded
    // }

    try {
        // Execute the update
        if ($stmt->execute()) {
            echo json_encode(['code'=>200, 'status'=>'success', 'message' => 'Customer updated successfully']);
        } else {
            echo json_encode(['code'=>500, 'status'=>'failure', 'message' => 'Customer update failed']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['code'=>500, 'status'=>'failure', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
